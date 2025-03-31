<?php
include 'conexao.php';

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    die("ID do imóvel não especificado.");
}

$id = $_GET['id'];

// Busca os dados do imóvel
$sql = "SELECT * FROM imoveis WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Imóvel não encontrado.");
}

$imovel = $result->fetch_assoc();

// Busca as imagens do imóvel
$sql_imagens = "SELECT * FROM imagens1 WHERE imovel_id = $id";
$result_imagens = $conn->query($sql_imagens);
$imagens = [];
while ($row = $result_imagens->fetch_assoc()) {
    $imagens[] = $row;
}

// Atualiza os dados do imóvel se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_negocio = $_POST['tipo_negocio'];
    $preco = $_POST['preco'];
    $distrito = $_POST['distrito'];
    $pisos = $_POST['pisos'];
    $quartos = $_POST['quartos'];
    $estado = $_POST['estado'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $descricao = $_POST['descricao'];

    // Atualiza os dados do imóvel
    $sql_update = "UPDATE imoveis SET 
        tipo_negocio='$tipo_negocio',
        preco='$preco',
        distrito='$distrito',
        pisos='$pisos',
        quartos='$quartos',
        estado='$estado',
        email='$email',
        telefone='$telefone',
        descricao='$descricao'
        WHERE id = $id";

    if ($conn->query($sql_update)) {
        echo "<script>alert('Dados do imóvel atualizados com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao atualizar dados do imóvel.');</script>";
    }

    // Atualizar imagens (se novas imagens forem enviadas)
    if (!empty($_FILES['imagens']['name'][0])) {
        $uploadDir = "uploads/imoveis/";

        foreach ($_FILES['imagens']['tmp_name'] as $key => $tmp_name) {
            $fileName = basename($_FILES['imagens']['name'][$key]);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmp_name, $filePath)) {
                $conn->query("INSERT INTO imagens1 (imovel_id, caminho) VALUES ('$id', '$filePath')");
            }
        }
    }

    // Atualizar comprovante de pagamento (se um novo comprovante for enviado)
    if (!empty($_FILES['comprovante']['name'])) {
        $comprovantePath = "uploads/comprovantes/" . basename($_FILES['comprovante']['name']);

        if (move_uploaded_file($_FILES['comprovante']['tmp_name'], $comprovantePath)) {
            $conn->query("UPDATE imoveis SET comprovante='$comprovantePath' WHERE id = $id");
        }
    }

    echo "<script>window.location.href='admin.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóvel</title>
    <link rel="stylesheet" href="./assets/css/editar.css">
    <style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .image-container img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .image-container a {
            display: block;
            text-align: center;
            margin-top: 5px;
            color: #dc3545;
            text-decoration: none;
        }
        .image-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Imóvel</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="tipo_negocio">Tipo de Negócio:</label>
            <select name="tipo_negocio" required>
                <option value="venda" <?= ($imovel['tipo_negocio'] == 'venda') ? 'selected' : '' ?>>Venda</option>
                <option value="arrendamento" <?= ($imovel['tipo_negocio'] == 'arrendamento') ? 'selected' : '' ?>>Arrendamento</option>
            </select>

            <label for="preco">Preço:</label>
            <input type="number" name="preco" value="<?= $imovel['preco'] ?>" required>

            <label for="distrito">Distrito:</label>
            <input type="text" name="distrito" value="<?= $imovel['distrito'] ?>" required>

            <label for="pisos">Pisos:</label>
            <input type="number" name="pisos" value="<?= $imovel['pisos'] ?>">

            <label for="quartos">Quartos:</label>
            <input type="number" name="quartos" value="<?= $imovel['quartos'] ?>">

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="novo" <?= ($imovel['estado'] == 'novo') ? 'selected' : '' ?>>Novo</option>
                <option value="usado" <?= ($imovel['estado'] == 'usado') ? 'selected' : '' ?>>Usado</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $imovel['email'] ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" name="telefone" value="<?= $imovel['telefone'] ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao"><?= $imovel['descricao'] ?></textarea>

            <h3>Imagens Atuais</h3>
            <div class="image-container">
                <?php foreach ($imagens as $img): ?>
                    <div>
                        <img src="<?= $img['caminho'] ?>" alt="Imagem do Imóvel">
                        <a href="excluir_imagem.php?id=<?= $img['id'] ?>&imovel_id=<?= $id ?>" onclick="return confirm('Tem certeza que deseja excluir esta imagem?');">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <label for="imagens">Adicionar Novas Imagens:</label>
            <input type="file" name="imagens[]" multiple accept="image/*">

            <h3>Comprovante de Pagamento Atual</h3>
            <?php if (!empty($imovel['comprovante'])): ?>
                <p><a href="<?= $imovel['comprovante'] ?>" target="_blank">Ver Comprovante</a></p>
            <?php else: ?>
                <p>Nenhum comprovante cadastrado.</p>
            <?php endif; ?>

            <label for="comprovante">Novo Comprovante:</label>
            <input type="file" name="comprovante" accept="image/*, .pdf">

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>