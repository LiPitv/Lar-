<?php
// Inclui o arquivo de conexão
include 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $tipo_negocio = $_POST['tipo_negocio'];
    $preco = $_POST['preco'];
    $pais = $_POST['pais'];
    $distrito = $_POST['distrito'];
    $pisos = $_POST['pisos'];
    $quartos = $_POST['quartos'];
    $estado = $_POST['estado'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $descricao = $_POST['descricao'];

    // Insere os dados do imóvel no banco de dados
    $sql = "INSERT INTO imoveis (tipo_negocio, preco, pais, distrito, pisos, quartos, estado, email, telefone, descricao)
            VALUES ('$tipo_negocio', '$preco', '$pais', '$distrito', '$pisos', '$quartos', '$estado', '$email', '$telefone', '$descricao')";

    if ($conn->query($sql)) {
        $imovel_id = $conn->insert_id; // Obtém o ID do imóvel recém-inserido

        // Processa o upload das imagens
        if (!empty($_FILES['imagens']['name'][0])) {
            $uploadDir = "uploads/imoveis/";

            foreach ($_FILES['imagens']['tmp_name'] as $key => $tmp_name) {
                $fileName = basename($_FILES['imagens']['name'][$key]);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($tmp_name, $filePath)) {
                    $conn->query("INSERT INTO imagens1 (imovel_id, caminho) VALUES ('$imovel_id', '$filePath')");
                }
            }
        }

        // Processa o upload do comprovante
        if (!empty($_FILES['comprovante']['name'])) {
            $comprovantePath = "uploads/comprovantes/" . basename($_FILES['comprovante']['name']);

            if (move_uploaded_file($_FILES['comprovante']['tmp_name'], $comprovantePath)) {
                $conn->query("UPDATE imoveis SET comprovante='$comprovantePath' WHERE id = $imovel_id");
            }
        }

        // Redireciona para a página de administração
        echo "<script>alert('Imóvel cadastrado com sucesso!'); window.location.href='Obrigado.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar imóvel.'); window.history.back();</script>";
    }
}

// Fecha a conexão
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Imóvel</title>
    <link rel="stylesheet" href="./assets/css/PAR2-2.css">
    <style>
        textarea {
            width: 100%;
            height: 200px;
        }
        input[type="file"] {
            width: 100%;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .input-box {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .column {
            display: flex;
            gap: 15px;
        }
        .column .input-box {
            flex: 1;
        }
        .select-box {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <header>Cadastro de Imóvel</header>
    <form action="cadastro_processa.php" method="POST" enctype="multipart/form-data" class="form">
        
        <div class="input-box">
            <label for="tipo_negocio">Tipo de Negócio:</label>
            <select name="tipo_negocio" id="tipo_negocio" class="select-box" required>
                <option value="venda">Venda</option>
                <option value="arrendamento">Arrendamento</option>
            </select>
        </div>

        <div class="input-box">
            <label for="preco">Preço:</label>
            <input type="number" name="preco" id="preco" required>
        </div>

        <div class="input-box">
            <label for="pais">País:</label>
            <input type="text" name="pais" id="pais" value="Angola" readonly required>
        </div>

        <div class="column">
            <div class="input-box">
                <label for="distrito">Distrito:</label>
                <input type="text" name="distrito" id="distrito" required>
            </div>
            <div class="input-box">
                <label for="pisos">Pisos:</label>
                <input type="number" name="pisos" id="pisos">
            </div>
        </div>

        <div class="column">
            <div class="input-box">
                <label for="quartos">Quartos:</label>
                <input type="number" name="quartos" id="quartos">
            </div>
            <div class="input-box">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="select-box" required>
                    <option value="novo">Novo</option>
                    <option value="usado">Usado</option>
                </select>
            </div>
        </div>

        <div class="column">
            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-box">
                <label for="telefone">Telefone:</label>
                <input type="tel" name="telefone" id="telefone" required>
            </div>
        </div>

        <div class="input-box">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao"></textarea>
        </div>

        <div class="input-box">
            <label for="imagens">Imagens do Imóvel:</label>
            <input type="file" name="imagens[]" id="imagens" multiple accept="image/*">
        </div>

        <p><strong>Dados para pagamento:</strong></p>
        <p>Conta Bancária: <strong>0000 4443 3333</strong></p>

        <div class="input-box">
            <label for="comprovante">Comprovante de Pagamento:</label>
            <input type="file" name="comprovante" id="comprovante" required accept="image/*, .pdf">
        </div>

        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>