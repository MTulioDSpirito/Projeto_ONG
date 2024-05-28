<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="cadastrar_pets.css">
    <style>
        .scrollable-form {
            padding: 20px; /* Adicionando padding */
            overflow-y: auto;
            max-height: 500px;
            max-width: 500px;
        }
        .button {
            width: 220px;
            background-color: green;
            justify-content: center;
            align-items: center;
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
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
                $sexo = $_POST['sexo'];
                $porte = $_POST['porte'];
                $castrado = $_POST['castrado'];
                $vermifugado = $_POST['vermifugado'];
                $doenca = $_POST['doenca'];
                $idade = $_POST['idade'];
                $descricao = $_POST['descricao'];
                $entrada = $_POST['entrada'];
                $saida = $_POST['saida'];
                $foto_link = $_POST['foto_link'];

                $result = mysqli_query($conexao, "INSERT INTO cadastro(nome, sexo, porte, castrado, vermifugado, doenca, idade, descricao, entrada, saida, foto_link) VALUES ('$nome', '$sexo', '$porte', '$castrado', '$vermifugado', '$doenca', '$idade', '$descricao', '$entrada', '$saida', '$foto_link')");

                if($result) {
                    echo "<span style='color:green;'>Pet cadastrado com sucesso</span>";
                } else {
                    echo "<span style='color:red;'>Erro ao cadastrar usuário</span>";
                }
            }
            ?>
            <h4>Cadastrar Pets</h4>
            <div class="scrollable-form">
                <form action="cadastrar_pets.php" method="POST">
                    <label for="nome">Nome:</label><br>
                    <input type="text" id="nome" name="nome"><br>
                    <br><label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="femea">Fêmea</option>
                        <option value="macho">Macho</option>
                    </select><br>
                    <br><label for="porte">Porte:</label>
                    <select id="porte" name="porte">
                        <option value="pequeno">Pequeno</option>
                        <option value="medio">Médio</option>
                        <option value="grande">Grande</option>
                    </select><br>
                    <br><label for="castrado">Castrado:</label>
                    <select id="castrado" name="castrado">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select><br>
                    <br><label for="vermifugado">Vermifugado:</label>
                    <select id="vermifugado" name="vermifugado">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select><br>
                    <br><label for="doenca">Doença:</label>
                    <select id="doenca" name="doenca">
                        <option value="leishmaniose">Leishmaniose</option>
                        <option value="luv">Luv</option>
                        <option value="outros">Outros</option>
                        <option value="nenhum">Nenhum</option>
                    </select><br>
                    <br><label for="idade">Idade Estimada:</label>
                    <input type="date" id="idade" name="idade"><br>
                    <label for="descricao">Descrição:</label><br>
                    <textarea id="descricao" name="descricao" rows="2" cols="35"></textarea><br>
                    <label for="entrada">Entrada:</label>
                    <select id="entrada" name="entrada">
                        <option value="resgate">Resgate</option>
                        <option value="nascimento">Nascimento</option>
                        <option value="acolhido">Acolhido</option>
                    </select><br>
                    <label for="saida">Saída:</label>
                    <select id="saida" name="saida">
                        <option value="adotado">Adotado</option>
                        <option value="obito">Óbito</option>
                        <option value="ong">ONG</option>
                    </select><br>
                    <label for="foto_link">
                    <label for="foto_link">Link da Foto:</label>
<input type="text" id="foto_link" name="foto_link"><br>
<br>
<div class="button-container">
    <input type="submit" class="button" name="submit" value="Clique aqui para Salvar">
</div>
</form>
</div>
</div>
<div class="footer">
    <button class="btn btn-primary" onclick="window.location.href='home.html';" type="button">Home</button>
    <button class="btn btn-secondary" type="button" onclick="window.location.href='g_animais.php';">Voltar</button>
</div>
</div>
</body>
</html>
