<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tipo_negocio = $_POST['tipo_negocio'];
    $preco = $_POST['preco'];
    $pais = $_POST['pais'];
    $distrito = $_POST['distrito'];
    $pisos = $_POST['pisos'];
    $quartos = $_POST['quartos'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $descricao = $_POST['descricao'];

    // Atualiza os dados do imóvel
    $sql = "UPDATE imoveis SET tipo_negocio=?, preco=?, pais=?, distrito=?, pisos=?, quartos=?, email=?, telefone=?, descricao=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiissi", $tipo_negocio, $preco, $pais, $distrito, $pisos, $quartos, $email, $telefone, $descricao, $id);

    if ($stmt->execute()) {
        // Se houver novas imagens, adiciona ao banco e salva no diretório
        if (!empty($_FILES['imagens']['name'][0])) {
            foreach ($_FILES['imagens']['name'] as $key => $nome_arquivo) {
                $caminho_temp = $_FILES['imagens']['tmp_name'][$key];
                $caminho_destino = "uploads/" . basename($nome_arquivo);
                
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                if (move_uploaded_file($caminho_temp, $caminho_destino)) {
                    $sql_img = "INSERT INTO imagens_imoveis (id_imovel, caminho_imagem) VALUES (?, ?)";
                    $stmt_img = $conn->prepare($sql_img);
                    $stmt_img->bind_param("is", $id, $caminho_destino);
                    $stmt_img->execute();
                }
            }
        }

        echo "<script>alert('Imóvel atualizado com sucesso!'); window.location.href='ADM.php';</script>";
    } else {
        echo "<script>alert('Erro: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
