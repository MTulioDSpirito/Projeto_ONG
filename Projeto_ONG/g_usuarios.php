<?php
$dbHost = '34.95.244.237';
$dbUsername = 'turma3';
$dbPassword = '123456';
$dbName = 'bd_php';

// Cria a conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verifica se a conexão foi bem sucedida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Função para atualizar o status
function updateStatus($conexao, $ID, $status) {
    $sql = "UPDATE usuarios SET saida = ? WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $status, $ID);
    $stmt->execute();
}

// Função para apagar uma linha
function deleteRow($conexao, $ID) {
    $sql = "DELETE FROM usuarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
}

// Verifica se o formulário de atualização de status foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["status"])) {
    updateStatus($conexao, $_POST["ID"], $_POST["status"]);
}

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && $_POST["delete"] == '1') {
  deleteRow($conexao, $_POST["ID"]);
}

// Executa a consulta SQL
$sql = "SELECT * FROM usuarios";
$resultado = $conexao->query($sql);
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

    <script>
        function confirmDelete() {
            return confirm('Deseja apagar esse usuário?');
        }
    </script>

</head>
<body>
    <div class="container">
    <div class="header"></div>
      
    <div class="main">

    <h4>Gerenciar Usuários</h4>
      
      
    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="button" type="submit" >Search</button>
    </form>
  </div>
  </nav>

  

  <div class="scrollable-table">

        
        <table class="table">
            <thead>
                <tr>
                    <th>ID </th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                </tr>
            </thead>
            <tbody>
                <?php
               if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['cpf'] . "</td>";
                    echo "<td>" . $row['endereco'] . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='' onsubmit='return confirmDelete()'>";
                    echo "<input type='hidden' name='ID' value='" . $row['ID'] . "'>";
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
