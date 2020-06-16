<?php
    session_start();
    
    if (!isset($_SESSION["hqs"]["id"])) {
        exit;
    }

    include "config/conexao.php";

    $quadrinho_id = $_GET["quadrinho_id"] ?? "";

    if ($_POST) {
        //inserir um quadrinho
        $personagem_id = $_POST["personagem_id"] ?? "";
        $quadrinho_id = $_POST["quadrinho_id"] ?? "";

        if ((empty ($personagem_id)) or (empty ($quadrinho_id))) {
            echo "<script>alert('Erro ao adicionar personagem');</script>";
        } else {
            //inserir dentro do quadrinho_personagem
            $sql = "INSERT INTO quadrinho_personagem
                    VALUES (:quadrinho_id, :personagem_id)";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":quadrinho_id", $quadrinho_id);
            $consulta->bindParam(":personagem_id", $personagem_id);

            if (!$consulta->execute()) {
                echo "<script>alert('Não foi possível inserir o personagem neste quadrinho');</script>";
            
                //echo $consulta->errorInfo()[2];
            }
        }
    }
?>

<html>

<head>
	<title></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

	<script src="vendor/jquery/jquery.min.js"></script>
	
</head>
<body>
    <h4>Personagens deste quadrinho</h4>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <td>Personagem</td>
                <td>Opções</td>
            </tr>
        </thead>
        <?php
            $sql = "SELECT q.id qid, p.id pid, p.nome
                    FROM quadrinho_personagem qp
                    INNER JOIN personagem p ON (p.id = qp.personagem_id)
                    INNER JOIN quadrinho q ON (q.id = qp.quadrinho_id)
                    WHERE qp.quadrinho_id = :quadrinho_id
                    ORDER BY p.nome";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":quadrinho_id", $quadrinho_id);
            $consulta->execute();

            foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) :
        ?>

        <tr>
            <td><?=$dados->nome;?></td>
            <td>
                <a href="javascript:excluir(<?=$dados->pid;?>,<?=$dados->qid;?>)" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>

    <script>
        function excluir(personagem_id, quadrinho_id) {
            if (confirm("Deseja realmente excluir este personagem?")) {
                //direcionar para uma pagina que exclui o personagem e depois retorna para listagem
                location.href="excluirPersonagem.php?personagem_id="+personagem_id+"&quadrinho_id="+quadrinho_id;
            }
        }
    </script>
</body>
</html>