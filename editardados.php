<?php
session_start();

$dbHost = 'roundhouse.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'QdbpuYyKwRQBndhIfSlCsLHlZrbiIGbe';
$dbName = 'railway';
$dbPort = '44161';

$conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);



// Verifique se o usuário está logado (você pode usar a mesma lógica de validação que usou para o login)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecione para a página de login se não estiver logado
    exit;
}

// Recupere os dados do usuário do banco de dados (substitua pelos campos reais do seu banco)
$usuarioId = $_SESSION['user_id'];
$query = "SELECT * FROM usuarios WHERE id = $usuarioId";
$resultado = mysqli_query($conexao, $query);
$dadosUsuario = mysqli_fetch_assoc($resultado);

// Processamento do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupere os dados do formulário
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];
    $novoCpf = $_POST['cpf'];
    $novoEndereco = $_POST['endereco'];

    // Atualize os dados no banco de dados (substitua pelos campos reais do seu banco)
    $updateQuery = "UPDATE usuarios SET nome = '$novoNome', email = '$novoEmail', cpf = '$novoCpf',endereco ='$novoEndereco' WHERE id = $usuarioId";
    mysqli_query($conexao, $updateQuery);

    // Redirecione para a página de perfil ou outra página após a atualização
    header("Location: usuario_logado.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="cadastro.css">
    <style>
        /* Estilos para manter os labels acima dos inputs */
        label {
            font-size: 16px; /* Diminui o tamanho da fonte das labels */
            display: block; /* Faz com que cada label ocupe uma linha inteira */
            margin-bottom: 5px; /* Espaçamento inferior entre as labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%; /* Define a largura do input como 100% */
            padding: 8px; /* Diminui o preenchimento interno */
            font-size: 14px; /* Diminui o tamanho da fonte */
            margin-bottom: 10px; /* Espaçamento inferior entre os inputs */
        }

        /* Alinhamento centralizado do botão "Cadastrar" */
        .footer {
            text-align: center; /* Centraliza o conteúdo do rodapé */
        }

        .button {
            font-size: 14px; /* Diminui o tamanho da fonte dos botões */
        }
    </style>
</head>
   
<body>


<div class="container">
    <div class="header"></div>
    <div class="main">

        <h1>Editar cadastro</h1>
        <form action="editardados.php" method="POST" id="editarForm">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required  value="<?= $dadosUsuario['nome'] ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?= $dadosUsuario['email'] ?>"><br>
          <!--  <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>-->
            <label for="cpf">CPF:</label> <!-- Novo campo -->
            <input type="text" id="cpf" name="cpf" required value="<?= $dadosUsuario['cpf'] ?>"><br>
            <label for="endereco">Endereço:</label> <!-- Novo campo -->
            <input type="text" id="endereco" name="endereco" required value="<?= $dadosUsuario['endereco'] ?>"><br>
            <br><br>
            <div class="row">
                <div class="col">
                    <input class="btn btn-success" type="submit" name="submit" value="Salvar">
                </div>
                <div class="col">
                   <a href="feed.php"><button type="button" class="btn btn-danger">Cancelar</button></a> 
                </div>
            </div>
            
    </div>
    <div class="footer">
    
        
    </div>
</div>
</body>
</html>
