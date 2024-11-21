<?php
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

// Inserir receita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $descricao = $conexao->real_escape_string($_POST['descricao']);
    $valor = $conexao->real_escape_string($_POST['valor']);
    $categoria = $conexao->real_escape_string($_POST['categoria']);
    $data = $conexao->real_escape_string($_POST['data']);

    $sql = "INSERT INTO revenues (description, amount, category, revenue_date) VALUES ('$descricao', '$valor', '$categoria', '$data')";
    if ($conexao->query($sql) === TRUE) {
        $mensagem = "Receita adicionada com sucesso!";
    } else {
        $mensagem = "Erro ao adicionar receita: " . $conexao->error;
    }
}

// Deletar receita
if (isset($_GET['delete'])) {
    $id = $conexao->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM revenues WHERE revenue_id = $id";
    if ($conexao->query($sql) === TRUE) {
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
    <title>Tabela usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href= 'login.css' >

    <style>
      .scrollable-table {
        overflow-x: auto!important;
        width: 380px;
      }
      .status-select {
        width: 150px; /* Ajuste este valor conforme necessário */
      }

      .button {
  width: 120px;  /* Ajuste este valor conforme necessário */
  height: 45px;  /* Ajuste este valor conforme necessário */
}
    
  
    </style>

    

</head>
<body>
    <div class="container">
    <div class="header"></div>
      
    <div class="main">

    <h4>Gerenciar Usuários</h4>
    <?php

    $pesquisa = $_POST['busca'] ?? '';

    include "config.php";

    $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$pesquisa%'";

    $dados = mysqli_query($conexao, $sql);

?>
      
      
    

  

  <div class="scrollable-table">
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
                                        <a href="?delete=<?php echo $row['revenue_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar esta receita?');">Excluir</a>
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
</body>
</html>
      

      </div>
      <div class="footer"> 
        
      <button class="button" style="background-color: #fff; color: #000;" onclick="window.location.href='tela_admin.html';">Menu</button>

            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='login.php';">Sair</button>
          
        </div>
        
      </div>
    </div>
  </body>
</html>

<?php
$conexao->close();
?>
