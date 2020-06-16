<?php
//verificar senao esta logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

$sql = "DELETE FROM cliente 
        WHERE id = :id 
        LIMIT 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);

if (!$consulta->execute()) {
    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>alert('Registro excluído com sucesso!');history.back();</script>";