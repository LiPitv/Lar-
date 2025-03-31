<?php
include 'conexao.php';

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    die("ID do imóvel não especificado.");
}

$id = $_GET['id'];

// Exclui o imóvel do banco de dados
$sql = "DELETE FROM imoveis WHERE id = $id";

if ($conn->query($sql)) {
    echo "<script>alert('Imóvel excluído com sucesso!'); window.location.href='admin.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir imóvel.'); window.history.back();</script>";
}

$conn->close();
?>