<?php

//verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";

    $id = $nome = $cpf = $datanascimento = $telefone = $celular = $email = $senha = $cep = $cidade_id = $endereco = $bairro = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    // validar inputs
    if (empty ($nome)) {
        echo "<script>alert('Preencha o nome');history.back();</script>";
        exit;
    } else if (empty ($cpf)) {
        echo "<script>alert('Preencha o cpf');history.back();</script>";
        exit;
    } else if (empty ($datanascimento)) {
        echo "<script>alert('Preencha a data de nascimento');history.back();</script>";
        exit;
    } else if (empty ($celular)) {
        echo "<script>alert('Preencha o celular');history.back();</script>";
        exit;
    } else if (empty ($email)) {
        echo "<script>alert('Preencha o email');history.back();</script>";
        exit;
    } else if (empty ($senha)) {
        echo "<script>alert('Preencha a senha');history.back();</script>";
        exit;
    } else if (empty ($cep)) {
        echo "<script>alert('Preencha o cep');history.back();</script>";
        exit;
    } else if (empty ($cidade_id)) {
        echo "<script>alert('Preencha a cidade');history.back();</script>";
        exit;
    } else if (empty ($endereco)) {
        echo "<script>alert('Preencha o endereço');history.back();</script>";
        exit;
    } else if (empty ($bairro)) {
        echo "<script>alert('Preencha o bairro');history.back();</script>";
        exit;
    }

    //iniciar uma transação
    $pdo->beginTransaction();

    //formatando os valores nascimento
    $datanascimento = formatar($datanascimento);

    // nome do arquivo de foto
    $arquivo = time() . "-" . $_SESSION["hqs"]["id"];

    // Cadastro novo
    if (empty ($id)) {
        $sql = "INSERT INTO cliente
            (nome, cpf, datanascimento, email, senha, cep, endereco, complemento, bairro, cidade_id, foto, telefone, celular)
            VALUES 
            (:nome, :cpf, :datanascimento, :email, :senha, :cep, :endereco, :complemento, :bairro, :cidade_id, :foto, :telefone, :celular)";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":cpf", $cpf);
            $consulta->bindParam(":datanascimento", $datanascimento);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":cep", $cep);
            $consulta->bindParam(":endereco", $endereco);
            $consulta->bindParam(":complemento", $complemento);
            $consulta->bindParam(":bairro", $bairro);
            $consulta->bindParam(":cidade_id", $cidade_id);
            $consulta->bindParam(":foto", $foto);
            $consulta->bindParam(":telefone", $telefone);
            $consulta->bindParam(":celular", $celular);
    } else {
        // Editar cadastro
        if (!empty($_FILES["foto"]["name"])) {
            $foto  = $arquivo;
        }

        $sql = "UPDATE cliente
                SET
                nome = :nome,
                cpf = :cpf,
                datanascimento = :datanascimento,
                email = :email,
                senha = :senha,
                cep = :cep,
                endereco = :endereco,
                complemento = :complemento,
                bairro = :bairro,
                cidade_id = :cidade_id,
                foto = :foto,
                telefone = :telefone,
                celular = :celular
                WHERE id = :id 
                LIMIT 1";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":endereco", $endereco);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":bairro", $bairro);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":celular", $celular);
        
        $consulta->bindParam(":id", $id);
    }

    // executar o sql
    if ($consulta->execute()) {

        if ((empty($_FILES["foto"]["type"])) && (!empty($id))) {
            $pdo->commit();
            echo "<script>alert('Salvo com sucesso!');location.href='listar/cliente';</script>";
            exit;
        }

        //verificar tipo da imagem é jpg
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
            exit;
        }

        //copiar a foto para  servidor
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/" . $_FILES["foto"]["name"])) {
            //redimensionar a imagem
            $pastaFotos = "../fotos/";
            $imagem = $_FILES["foto"]["name"];
            $nome = $arquivo;

            redimensionarImagem($pastaFotos, $imagem, $nome);

            //gravar no banco
            $pdo->commit();

            echo "<script>alert('Salvo com sucesso!');location.href='listar/cliente';</script>";
            exit;
        }

        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>";
        exit;
    }

    exit;
}

echo "<p class='alert alert-danger'>Requisição inválida</p>";