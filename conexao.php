<?php
// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$usuario = 'root'; // Nome de usuário do MySQL
$senha = ''; // Senha do MySQL
$banco = 'imobiliaria'; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Definir o charset para utf8 (opcional, mas recomendado)
$conn->set_charset("utf8");

// Mensagem de sucesso (opcional, para depuração)
// echo "Conexão com o banco de dados estabelecida com sucesso!";
?>