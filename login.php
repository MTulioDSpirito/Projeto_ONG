<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href= 'login.css' >
</head>


<body>

<div class="container">
  
        <div class="header"></div>
    <div class="main">

<?php
        if(isset($_POST['submit'])) {
        include_once('config.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Verifica se é o admin
    if($email == 'admin@gmail.com' && $senha == '123456') {
        header("Location: tela_admin.html");
        exit();
    }




        $result = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'");

        if(mysqli_num_rows($result) > 0) {
        // O usuário está logado com sucesso
            echo "O usuário está logado com sucesso";
            header("Location: feed.php");
        
        } else {
        // Email ou senha inválidos
            echo "<span style='color:red;'>Email ou senha inválidos</span>";
        // Mostre uma mensagem de erro ou redirecione de volta para a página de login
        }
        }
        ?>
        
            <h1>Entrar</h1>
            <form action="login.php" method="POST" id="loginForm">
                
                
                <label for="username">Email:</label><br>
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
                
                <button class="button"  style="background-color:black; color:white;">Home</button>
                
            
            </div>
</div>
</body>
</html>
