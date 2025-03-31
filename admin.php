<?php
include 'conexao.php';

// Busca todos os imóveis cadastrados
$sql = "SELECT * FROM imoveis";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Imóveis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }
        .actions .edit {
            background-color: #007bff;
        }
        .actions .delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Administração de Imóveis</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Negócio</th>
                    <th>Preço</th>
                    <th>Distrito</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["tipo_negocio"] . "</td>";
                        echo "<td>" . $row["preco"] . "</td>";
                        echo "<td>" . $row["distrito"] . "</td>";
                        echo "<td>" . $row["estado"] . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='editar_imovel.php?id=" . $row["id"] . "' class='edit'>Editar</a>";
                        echo "<a href='excluir_imovel.php?id=" . $row["id"] . "' class='delete' onclick='return confirm(\"Tem certeza que deseja excluir este imóvel?\");'>Excluir</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum imóvel cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>