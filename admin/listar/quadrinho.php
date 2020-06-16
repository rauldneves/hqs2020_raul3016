<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}
?>
<div class="container">
    <h1 class="float-left">Listar Quadrinho</h1>
    <div class="float-right">
        <a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
        <a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <td>ID</td>
                <td>Foto</td>
                <td>Título do Quadrinho</td>
                <td>Data</td>
                <td>Valor</td>
                <td>Editora</td>
                <td>Opções</td>
            </tr>
        </thead>
        <tbody>

            <?php
            $sql = "SELECT q.id, q.titulo, q.capa, q.valor, q.numero, DATE_FORMAT(q.data, '%d/%m/%Y') data, e.nome editora
                    FROM quadrinho q
                    INNER JOIN editora e
                    ON (e.id = q.editora_id)
                    ORDER BY q.titulo
            ";

            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) :

                $imagem = "../fotos/" . $dados->capa . "p.jpg";
            ?>

                <tr>
                    <td><?= $dados->id ?></td>
                    <td>
                        <img src="<?= $imagem ?>" alt="<?= $dados->titulo ?>" width="50">
                    </td>
                    <td><?= $dados->titulo . ' / ' . $dados->numero ?></td>
                    <td><?= $dados->data ?></td>
                    <td><?= number_format($dados->valor, 2, ",", ".") ?></td>
                    <td><?= $dados->editora ?></td>
                    <td>
                        <a href="cadastro/quadrinho/<?= $dados->id ?>" title="Editar Quadrinho <?= $dados->id ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm" title="Deletar Quadrinho <?= $dados->id ?>" onclick="excluir(<?= $dados->id ?>)"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<script>
    // função para excluir o quadrinho
    const excluir = (id) => {
        if (confirm(`Deseja excluir o quadrinho ${id}?`)) {
            location.href = `excluir/quadrinho/${id}`;
        }
    }

    $(document).ready(function() {
        $('#tabela').DataTable({
            "language": {
                "lengthMenu": "Exibindo _MENU_ registros por página",
                "zeroRecords": "Nenhuma informação encontrada...",
                "info": "Exibindo página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhuma informação disponível",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar"
            }
        })
    })
</script>