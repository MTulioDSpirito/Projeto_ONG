<?php
// Conexão com o banco de dados
session_start();
$dbHost = 'autorack.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'OaytArnxmFfaxhrHFCtsiAvysmKeHVUt';
$dbName = 'bd_php';
$dbPort = '46999';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Verifica conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Inserir doador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);
    $telefone = $conexao->real_escape_string($_POST['telefone']);
    $endereco = $conexao->real_escape_string($_POST['endereco']);

    $sql = "INSERT INTO donors (name, email, phone, address) VALUES ('$nome', '$email', '$telefone', '$endereco')";
    if ($conexao->query($sql) === TRUE) {
        $mensagem = "Doador adicionado com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar doador: " . $conexao->error;
    }
}

// Deletar doador
if (isset($_GET['delete'])) {
    $id = $conexao->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM donors WHERE donor_id = $id";
    if ($conexao->query($sql) === TRUE) {
        $mensagem = "Doador deletado com sucesso!";
    } else {
        $mensagem = "Erro ao deletar doador: " . $conexao->error;
    }
}

// Buscar doadores
$sql = "SELECT * FROM donors";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <title>Gerenciar Doadores</title>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
            <h4>Gerenciar Doadores</h4>
            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert alert-info"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <!-- Formulário para adicionar doador -->
            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone">
                </div>
                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
                <button type="submit" name="add" class="btn btn-success">Adicionar Doador</button>
            </form>

            <!-- Tabela de doadores -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['donor_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td>
                                    <a href="?delete=<?php echo $row['donor_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este doador?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhum doador cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <button class="button" style="background-color: #fff; color: #000;" onclick="window.location.href='login.php';">Entrar</button>
            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='cadastro.php';">Registrar</button>
        </div>
    </div>
</body>
</html>
