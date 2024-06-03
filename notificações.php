<?php
// Configurações do banco de dados
$dbHost = '34.95.244.237';
$dbUsername = 'turma3';
$dbPassword = '123456';
$dbName = 'bd_php';

// Conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verificar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Deletar mensagem se o formulário for submetido
if (isset($_POST['email'])) {
    $email = $conexao->real_escape_string($_POST['email']);
    
    // Consulta para deletar a mensagem com base no email
    $sql = "DELETE FROM mensagem WHERE email='$email'";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Mensagem deletada com sucesso.";
    } else {
        echo "Erro ao deletar a mensagem: " . $conexao->error;
    }
    exit(); // Saia do script para que apenas a mensagem seja retornada
}

// Consulta para obter os dados da tabela 'mensagem'
$sql = "SELECT email, nome, telefone, mensagem FROM mensagem";
$resultado = $conexao->query($sql);

$mensagens = [];
if ($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $mensagens[] = $row;
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="home.css">
    <style>
        .main {
            max-height: 65vh; /* Define a altura máxima como 65% da altura da viewport */
            overflow-y: auto; /* Adiciona a barra de rolagem vertical */
           
            display: block;
        }
        .list-group-item {
            margin-bottom: 5px; /* Espaçamento entre as mensagens */
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
    <script>
        function deleteMessage(email) {
            if (confirm('Tem certeza de que deseja excluir esta mensagem?')) {
                const formData = new FormData();
                formData.append('email', email);

                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    window.location.reload();
                })
                .catch(error => console.error('Erro:', error));
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
            <h4>Notificações</h4>
            <div class="list-group">
                <?php if (!empty($mensagens)): ?>
                    <?php foreach ($mensagens as $mensagem): ?>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><strong><?php echo htmlspecialchars($mensagem['email']); ?></strong></h6>
                                <small><?php echo date("d/m/Y H:i:s"); ?></small>
                            </div>
                            <small class="mb-1">
                                Nome: <?php echo htmlspecialchars($mensagem['nome']); ?><br>
                                Telefone: <?php echo htmlspecialchars($mensagem['telefone']); ?><br>
                                Mensagem: <?php echo nl2br(htmlspecialchars($mensagem['mensagem'])); ?>
                            </small><br>
                            <small>clique aqui para envio do formulário triagem</small><br>
                            <button class="delete-btn" onclick="deleteMessage('<?php echo $mensagem['email']; ?>')">Apagar</button>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma mensagem encontrada.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer">
            <button class="button" style="background-color: #fff; color: #000;" onclick="window.location.href='tela_admin.html';">Menu</button>
            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='login.php';">Sair</button>
        </div>
    </div>
</body>
</html>

