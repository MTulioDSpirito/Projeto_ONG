
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <script>
        function enableEditing() {
            document.getElementById('nome').disabled = false;
            document.getElementById('email').disabled = false;
            document.getElementById('senha').disabled = false;
            document.getElementById('endereco').disabled = false;
            document.getElementById('salvarBtn').disabled = false;
            document.getElementById('editarBtn').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
        <?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Conexão com o banco de dados 
$dbHost = 'roundhouse.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'QdbpuYyKwRQBndhIfSlCsLHlZrbiIGbe';
$dbName = 'bd_php';
$dbPort = '44161';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Verificar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $endereco = $_POST['endereco'];

    // Atualizar dados do usuário
    $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha', endereco='$endereco' WHERE id='$user_id'";

    if ($conexao->query($sql) === TRUE) {
        echo "Perfil atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o perfil: " . $conexao->error;
    }
}

// Consulta para obter dados do usuário
$sql = "SELECT nome, email, senha, endereco FROM usuarios WHERE id='$user_id'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $nome_usuario = $row['nome'];
    $email_usuario = $row['email'];
    $senha_usuario = $row['senha'];
    $endereco_usuario = $row['endereco'];
} else {
    $nome_usuario = '';
    $email_usuario = '';
    $senha_usuario = '';
    $endereco_usuario = '';
}

$conexao->close();
?>

            <div class="container">
                <h1>Editar Perfil</h1>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_usuario); ?>" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email_usuario); ?>" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($senha_usuario); ?>" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($endereco_usuario); ?>" disabled required>
                    </div>
                    <button type="button" class="btn btn-secondary" id="editarBtn" onclick="enableEditing()">Editar</button>
                    <button type="submit" class="btn btn-primary" id="salvarBtn" disabled>Salvar</button>
                </form>
            </div>
        </div>
        <div class="footer">
            <button class="button" style="background-color: #fff; color: #000;" onclick="window.location.href='index.html';">Home</button>
            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='feed.php';">Voltar</button>
        </div>
    </div>
</body>
</html>
