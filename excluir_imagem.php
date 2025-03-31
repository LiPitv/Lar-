<?php
include 'conexao.php';

// Verifica se o ID da imagem e o ID do imóvel foram passados na URL
if (!isset($_GET['id']) || !isset($_GET['imovel_id'])) {
    die("ID da imagem ou ID do imóvel não especificado.");
}

$imagem_id = $_GET['id'];
$imovel_id = $_GET['imovel_id'];

// Busca o caminho da imagem no banco de dados
$sql = "SELECT caminho FROM imagens1 WHERE id = $imagem_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $imagem = $result->fetch_assoc();
    $caminho_imagem = $imagem['caminho'];

    // Exclui a imagem do banco de dados
    $sql_delete = "DELETE FROM imagens1 WHERE id = $imagem_id";
    if ($conn->query($sql_delete)) {
        // Exclui o arquivo da imagem do servidor
        if (file_exists($caminho_imagem)) {
            unlink($caminho_imagem);
        }
        echo "<script>alert('Imagem excluída com sucesso!'); window.location.href='editar_imovel.php?id=$imovel_id';</script>";
    } else {
        echo "<script>alert('Erro ao excluir imagem.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Imagem não encontrada.'); window.history.back();</script>";
}

$conn->close();
?>