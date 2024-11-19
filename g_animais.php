<?php
$dbHost = 'autorack.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'OaytArnxmFfaxhrHFCtsiAvysmKeHVUt';
$dbName = 'bd_php';
$dbPort = '46999';

// Cria a conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Verifica se a conexão foi bem sucedida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Função para atualizar o status
function updateStatus($conexao, $id_animal, $status) {
    $sql = "UPDATE cadastro SET saida = ? WHERE id_animal = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $status, $id_animal);
    $stmt->execute();
}

// Função para apagar uma linha
function deleteRow($conexao, $id_animal) {
    $sql = "DELETE FROM cadastro WHERE id_animal = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_animal);
    $stmt->execute();
}

// Verifica se o formulário de atualização de status foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["status"])) {
    updateStatus($conexao, $_POST["id_animal"], $_POST["status"]);
}

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && $_POST["delete"] == '1') {
    deleteRow($conexao, $_POST["id_animal"]);
}

// Inicializa a consulta SQL
$sql = "SELECT * FROM cadastro";

// Verifica se o formulário de busca foi submetido
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchTerm = $conexao->real_escape_string($_GET['search']);
    $sql .= " WHERE id_animal LIKE '%$searchTerm%' OR nome LIKE '%$searchTerm%'";
}

// Executa a consulta SQL
$resultado = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Animais</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href= 'login.css' >

    <style>
      .scrollable-table {
        overflow-x: auto;
        width: 370px;
      }
      .status-select {
        width: 150px; 
      }
      .table-wrapper {
        max-height: 360px; /* Defina a altura máxima para a tabela */
        overflow-y: auto; /* Adicione a barra de rolagem vertical */
    }
      .button {
  width: 140px;  
  height: 46px;  

}
    .cadastrar{
      
      max-width: 180px;
      margin:0 auto;
      display: flex;
      justify-content: center;

    }

    </style>

</head>
<body>
    <div class="container">
    <div class="header"></div>
    

    <div class="main">
    
    <h4>Gerenciar</h4>
    
    
    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
    <form class="d-flex" role="search" method="get" action="">
      <input class="form-control me-2" type="search" placeholder="Insira um nome ou Id" aria-label="Search" name="search">
      <button class="button" type="submit">Search</button>
    </form>
  </div>
  </nav>

  

  <div class="scrollable-table">

  <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Animal</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Porte</th>
                    <th>Nascimento </th>
                    <th>Castrado</th>
                    <th>Vermifugado</th>
                    <th>Doença</th>
                    <th>Descrição</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
               if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_animal'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['sexo'] . "</td>";
                    echo "<td>" . $row['porte'] . "</td>";
                    echo "<td>" . $row['idade'] . "</td>";
                    echo "<td>" . $row['castrado'] . "</td>";
                    echo "<td>" . $row['vermifugado'] . "</td>";
                    echo "<td>" . $row['doenca'] . "</td>";
                    echo "<td>" . $row['descricao'] . "</td>";
                    echo "<td>" . $row['entrada'] . "</td>";
                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='id_animal' value='" . $row['id_animal'] . "'>";
                    echo "<select name='status'>";
                    echo "<option value='obito' " . ($row['saida'] == 'obito' ? 'selected' : '') . ">Óbito</option>";
                    echo "<option value='adotado' " . ($row['saida'] == 'adotado' ? 'selected' : '') . ">Adotado</option>";
                    echo "<option value='ong' " . ($row['saida'] == 'ong' ? 'selected' : '') . ">ONG</option>";
                    echo "</select>";
                    echo "<input type='submit' class='btn btn-primary btn-sm' value='Salvar'>";
                    echo "</form>"; 
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='id_animal' value='" . $row['id_animal'] . "'>";
                    echo "<input type='hidden' name='delete' value='1'>"; 
                    echo "<button type='submit' class='btn btn-danger btn-sm'>Apagar</button>";                    
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>Nenhum registro encontrado.</td></tr>";
            }
            
  ?>

            </tbody>
        </table>
    </div>
  </div>
  </div>
</body>
<div class="cadastrar">
      <button type="button" class="btn btn-warning" onclick="window.location.href='cadastrar_pets.php'">Cadastrar Pets +</button>
</div>
     
      
      <div class="footer"> 
            <button class="button" style="background-color: #fff; color: #000;" onclick="window.location.href='tela_admin.html';">Menu</button>

            <button class="button" style="background-color:black; color:white;" onclick="window.location.href='login.php';">Sair</button>
        
      </div>
    </div>
  </body>
</html>

<?php
$conexao->close();
?>
