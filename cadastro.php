<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <?php
    if(isset($_POST['submit'])) {
        include_once('config.php');

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $cpf = $_POST['cpf']; // Novo campo
        $endereco = $_POST['endereco']; // Novo campo

        // Verificar se o email já existe
        $check = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email='$email'");
        if(mysqli_num_rows($check) > 0) {
            echo "<span style='color:red;'>Usuário já cadastrado</span>";
        } else {
            // Inserir novo usuário
            $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha, cpf, endereco) VALUES ('$nome','$email','$senha', '$cpf', '$endereco')");
            if($result) {
                echo "<span style='color:green;'>Usuário cadastrado com sucesso</span>";
                // Redirecionar para a tela de login
                header("Location: login.php");
            } else {
                echo "<span style='color:red;'>Erro ao cadastrar usuário</span>";
            }
        }
    }
    ?>

        <h1>Cadastro</h1>
        <form action="cadastro.php" method="POST" id="cadastroForm">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <label for="cpf">CPF:</label> <!-- Novo campo -->
            <input type="text" id="cpf" name="cpf" required>
            <label for="endereco">Endereço:</label> <!-- Novo campo -->
            <input type="text" id="endereco" name="endereco" required>
            <br><br>
            <input class="button" type="submit" name="submit" value="Cadastrar">
        </form>
    </div>
    <div class="footer">
        <button class="button" onclick="window.location.href='index.html';" style="background-color: #fff; color: #000;">Home</button>
        <button class="button" onclick="window.location.href='about.html';" style="background-color:black; color:white;">Sobre nós</button>
    </div>
</div>
</body>
</html>
