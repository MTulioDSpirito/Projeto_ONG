<?php
// Configurações do banco de dados
$dbHost = 'roundhouse.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'QdbpuYyKwRQBndhIfSlCsLHlZrbiIGbe';
$dbName = 'bd_php';
$dbPort = '44161';

// Conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

// Verificar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if(isset($_POST['submit'])) {
    include_once('config.php');
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $porte = $_POST['porte'];
    $castrado = $_POST['castrado'];
    $vermifugado = $_POST['vermifugado'];
    $doenca = $_POST['doenca'];
    $idade = $_POST['idade'];
    $descricao = nl2br($conexao->real_escape_string($_POST['descricao'])); // Adicionando nl2br
    $entrada = $_POST['entrada'];
    $saida = $_POST['saida'];
    $foto_link = $_POST['foto_link'];

    // Verificar se todos os campos estão preenchidos
    if (empty($nome) || empty($sexo) || empty($porte) || empty($castrado) || empty($vermifugado) || empty($doenca) || empty($idade) || empty($descricao) || empty($entrada) || empty($saida) || empty($foto_link)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        $result = mysqli_query($conexao, "INSERT INTO cadastro(nome, sexo, porte, castrado, vermifugado, doenca, idade, descricao, entrada, saida, foto_link) VALUES ('$nome', '$sexo', '$porte', '$castrado', '$vermifugado', '$doenca', '$idade', '$descricao', '$entrada', '$saida', '$foto_link')");

        if($result) {
            $mensagem = "Pet cadastrado com sucesso.";
        } else {
            $erro = "Erro ao cadastrar usuário.";
        }
    }
}

$conexao->close();
?>


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
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
    <script>
        function validateForm() {
            var nome = document.getElementById('nome').value;
            var sexo = document.getElementById('sexo').value;
            var porte = document.getElementById('porte').value;
            var castrado = document.getElementById('castrado').value;
            var vermifugado = document.getElementById('vermifugado').value;
            var doenca = document.getElementById('doenca').value;
            var idade = document.getElementById('idade').value;
            var descricao = document.getElementById('descricao').value;
            var entrada = document.getElementById('entrada').value;
            var saida = document.getElementById('saida').value;
            var foto_link = document.getElementById('foto_link').value;

            if (nome == "" || sexo == "" || porte == "" || castrado == "" || vermifugado == "" || doenca == "" || idade == "" || descricao == "" || entrada == "" || saida == "" || foto_link == "") {
                alert("Por favor, preencha todos os campos.");
                return false;
            }
            return true;
        }

        // Função para prevenir Enter no campo de descrição
        document.addEventListener('DOMContentLoaded', function() {
            var descricaoField = document.getElementById('descricao');
            descricaoField.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
            <?php if (isset($erro)): ?>
                <p class="error-message"><?php echo $erro; ?></p>
            <?php endif; ?>
            <?php if (isset($mensagem)): ?>
                <p class="success-message"><?php echo $mensagem; ?></p>
            <?php endif; ?>
            <h4>Cadastrar Pets</h4>
            <div class="scrollable-form">
                <form action="cadastrar_pets.php" method="POST" onsubmit="return validateForm()">
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
