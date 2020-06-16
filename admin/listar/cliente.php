<?php

    //verificar se não está logado
    if (!isset($_SESSION['hqs']['id'])) {
        exit;
    }

?>

<div class="container">
    <h1 class="float-left">Listar Clientes</h1>
    <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
        <a href="listar/cliente" class="btn btn-info">Listar Clientes</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>E-mail</td>
                <td>Celular</td>
                <td>Endereço</td>
                <td>Cidade</td>
                <td>Opções</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT c.id, c.nome, c.cpf, c.email, c.celular, c.endereco, ci.cidade FROM cliente AS c
                        INNER JOIN cidade AS ci
                        ON ci.id = c.cidade_id
                        ORDER BY c.nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) :
            ?>

            <tr>
                <td><?= $dados->id ?></td>
                <td><?= $dados->nome ?></td>
                <td><?= $dados->email ?></td>
                <td><?= $dados->celular ?></td>
                <td><?= $dados->endereco ?></td>
                <td><?= $dados->cidade ?></td>
                <td>
                    <a href="cadastro/cliente/<?= $dados->id ?>" title="Editar Cliente <?= $dados->id ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-danger btn-sm" title="Deletar Cliente <?= $dados->id ?>" onclick="excluir(<?= $dados->id ?>)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

                <?php endforeach; ?>

        </tbody>
    </table>
</div>

<script>
    const excluir = (id) => {
        if (confirm(`Deseja mesmo excluir o cliente ${id}?`)) {
            // Direcionar para a exclusão do id
            location.href = `excluir/cliente/${id}`
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