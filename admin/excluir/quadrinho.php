<?php
//verificar se nao esta logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

$sql = "DELETE FROM quadrinho WHERE id = ? LIMIT 1";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(1, $id);

if (!$consulta->execute()) {

    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>alert('Registro excluído com sucesso!');history.back();</script>";
