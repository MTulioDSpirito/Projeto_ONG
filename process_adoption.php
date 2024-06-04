<?php
$dbHost = 'roundhouse.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'QdbpuYyKwRQBndhIfSlCsLHlZrbiIGbe';
$dbName = 'railway';
$dbPort = '44161';

// Conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verificar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Obter dados do formulário
$nome = $_POST['name'];
$email = $_POST['email'];
$telefone = $_POST['phone'];
$mensagem = $_POST['message'];

// Inserir dados na tabela 'mensagem'
$sql = "INSERT INTO mensagem (nome, email, telefone, mensagem) VALUES ('$nome', '$email', '$telefone', '$mensagem')";

if ($conexao->query($sql) === TRUE) {
    echo "Solicitação enviada com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conexao->error;
}

$conexao->close();
?>
