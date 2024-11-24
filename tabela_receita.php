<?php
// Inclui configuração
require_once "config.php";

// Inserir receita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $descricao = $conexao->real_escape_string($_POST['descricao']);
    $valor = $conexao->real_escape_string($_POST['valor']);
    $categoria = $conexao->real_escape_string($_POST['categoria']);
    $data = $conexao->real_escape_string($_POST['data']);

    $sql = "INSERT INTO revenues (description, amount, category, revenue_date) 
            VALUES ('$descricao', '$valor', '$categoria', '$data')";
    if ($conexao->query($sql)) {
        $mensagem = "Receita adicionada com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar receita: " . $conexao->error;
    }
}

// Deletar receita
if (isset($_GET['delete'])) {
    $id = $conexao->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM revenues WHERE revenue_id = $id";
    if ($conexao->query($sql)) {
        $mensagem = "Receita deletada com sucesso!";
    } else {
        $mensagem = "Erro ao deletar receita: " . $conexao->error;
    }
}

// Buscar receitas
$sql = "SELECT * FROM revenues";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Receitas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .scrollable-table {
            overflow-x: auto;
        }

        .button {
            width: 120px;
            height: 45px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="text-center mb-4">Gerenciar Receita</h4>

        <!-- Mensagem de feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="alert alert-info"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar receita -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" class="form-control" id="data" name="data" required>
            </div>
            <button type="submit" name="add" class="btn btn-success w-100">Adicionar Receita</button>
        </form>

        <!-- Tabela de receitas -->
        <div class="scrollable-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['revenue_id']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['revenue_date']; ?></td>
                                <td>
                                    <a href="?delete=<?php echo $row['revenue_id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Tem certeza que deseja deletar esta receita?');">
                                       Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhuma receita cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conexao->close(); ?>
