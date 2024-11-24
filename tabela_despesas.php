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

// Inserir despesa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $descricao = $conexao->real_escape_string($_POST['descricao']);
    $valor = $conexao->real_escape_string($_POST['valor']);
    $data = $conexao->real_escape_string($_POST['data']);
    $animal_id = $conexao->real_escape_string($_POST['animal_id']);
    $categoria = $conexao->real_escape_string($_POST['categoria']);

    $sql = "INSERT INTO expenses (description, amount, expense_date, animal_id, category) 
            VALUES ('$descricao', '$valor', '$data', '$animal_id', '$categoria')";
    if ($conexao->query($sql) === TRUE) {
        $mensagem = "Despesa adicionada com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar despesa: " . $conexao->error;
    }
}

// Buscar despesas
$sql = "SELECT * FROM expenses";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela Despesas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
        .main {
            min-height: 650px;
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .button {
            width: 120px;
            height: 45px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
        <div class="scrollable-table">
        <table class="table">
            <h4>Gerenciar Despesas</h4>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)): ?>
                <div class="alert alert-info"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <!-- Formulário para adicionar despesa -->
            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                </div>
                <div class="mb-3">
                    <label for="data" class="form-label">Data</label>
                    <input type="date" class="form-control" id="data" name="data" required>
                </div>
                <div class="mb-3">
                    <label for="animal_id" class="form-label">ID do Animal</label>
                    <input type="number" class="form-control" id="animal_id" name="animal_id">
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required>
                </div>
                <button type="submit" name="add" class="btn btn-success">Adicionar Despesa</button>
            </form>

            <!-- Tabela de despesas -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>ID do Animal</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['expense_id']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['expense_date']; ?></td>
                                <td><?php echo $row['animal_id']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhuma despesa cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
        <div class="footer">
            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='login.php';">Sair</button>
        </div>
    </div>
</body>
</html>

<?php $conexao->close(); ?>
