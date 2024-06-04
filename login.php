

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <style>
        /* Adicionando estilo para aumentar as fontes da label, caixas do input e botões */
        label {
            font-size: 1.2em;
        }
        input[type="email"],
        input[type="password"],
        input[type="submit"],
        button {
            font-size: 1em;
            
        }
        input[type="email"],
        input[type="password"] {
            font-size: 1.2em;
            width: 100%;
        }
        /* Alinhando o botão 'Entrar' ao centro */
        input[type="submit"] {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header"></div>
    <div class="main">




    <?php
session_start();
if(isset($_POST['submit'])) {
    include_once('config.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se é o admin
    if($email == 'admin@gmail.com' && $senha == '123456') {
        header("Location: tela_admin.html");
        exit();
    }

    $result = mysqli_query($conexao, "SELECT id FROM usuarios WHERE email='$email' AND senha='$senha'");

    if(mysqli_num_rows($result) > 0) {
        // O usuário está logado com sucesso
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email'] = $email; // Adicionando a sessão do email
        header("Location: feed.php");
        exit();
    } else {
        // Email ou senha inválidos
        echo "<span style='color:red;'>Email ou senha inválidos</span>";
    }
}
?>
        <h1>Entrar</h1>
        <form action="login.php" method="POST" id="loginForm">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required><br><br>
            <input class="button" type="submit" name="submit" value="Entrar">
        </form>
    </div>
    <div class="footer">
        <a href="cadastro.php">
            <button class="button" style="background-color: #fff; color: #000;">Registrar</button>
        </a>
        
        <a href="index.html">
         <button class="button" style="background-color:black; color:white;">Home</button></a>
    </div>
</div>
</body>
</html>
