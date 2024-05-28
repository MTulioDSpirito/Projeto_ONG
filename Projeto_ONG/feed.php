<?php include 'imagemperfil.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .card img {
            width: 100%;
            height: 280px;
            object-fit: contain; /* Alterado de cover para contain */
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .card {
            width: 360px;
            margin: 10px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-body {
            max-height: 200px; /* Definindo a altura máxima da área de texto do card */
            overflow-y: auto; /* Adicionando rolagem vertical para a área de texto do card */
            text-align: center; /* Centralizando o texto no card */
        }
        .card-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            height: 110px;
            background-color: #B61F43;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
        }
        .footer .button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90px;
            height: 55px;
            border: none;
            background-color: white;
        }
        .footer .button img {
            width: 38px;
            height: 30px;
        }
        .perfil {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
            <div id="card-container" class="card-container">
                <!-- Cards serão inseridos aqui via JavaScript -->
            </div>
            <div class="pagination">
                <button id="prevBtn" class="btn btn-primary" onclick="showPrevCard()">Anterior</button>
                <button id="nextBtn" class="btn btn-primary" onclick="showNextCard()">Próximo</button>
            </div>
        </div>
        <div class="footer">
            <button class="button" onclick="window.location.href='login.php';">
                <img class="2" src="./img/home.png" alt="Home">
            </button>
            <button class="button" onclick="window.location.href='usuario_relatorio.html';">
                <img src="./img/search-file.gif" alt="Search">
            </button>
            <button class="button" onclick="window.location.href='usuario_logado.php';">
                <img class="perfil" src="<?php echo $nomeArquivo; ?>" alt="Avatar">
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="adoptionModal" tabindex="-1" aria-labelledby="adoptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adoptionModalLabel">Solicitação de Adoção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adoptionForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensagem</label>
                            <textarea class="form-control" id="message" name="message" rows="3" readonly></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Obtenha os dados dos cartões via PHP e passe-os para o JavaScript
        const cards = [];

        <?php
        $dbHost = '34.95.244.237';
        $dbUsername = 'turma3';
        $dbPassword = '123456';
        $dbName = 'bd_php';

        // Conexão com o banco de dados
        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Verificar conexão
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Consulta para obter todos os dados
        $sql = "SELECT DISTINCT id_animal, nome, sexo, porte, idade, castrado, vermifugado, descricao, foto_link FROM cadastro";
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {
            while($row = $resultado->fetch_assoc()) {
                echo "cards.push({
                    id_animal: '". $row["id_animal"] ."',
                    nome: '". $row["nome"] ."',
                    sexo: '". $row["sexo"] ."',
                    porte: '". $row["porte"] ."',
                    idade: '". $row["idade"] ."',
                    castrado: ". ($row["castrado"] ? 'true' : 'false') .",
                    vermifugado: ". ($row["vermifugado"] ? 'true' : 'false') .",
                    descricao: '". $row["descricao"] ."',
                    foto_link: '". $row["foto_link"] ."'
                });\n";
            }
        }

        $conexao->close();
        ?>

        let currentCardIndex = 0;

        function showCard(index) {
            const cardContainer = document.getElementById('card-container');
            const card = cards[index];
            cardContainer.innerHTML = `
                <div class="card">
                    <img src="${card.foto_link}" class="card-img-top" alt="Imagem do pet">
                    <div class="card-body">
                        <h5 class="card-title">Informações do Animal</h5>
                        <p class="card-text">
                            Nome: ${card.nome}<br>
                            Sexo: ${card.sexo}<br>
                            Porte: ${card.porte}<br>
                            Idade: ${card.idade}<br>
                            Castrado: ${card.castrado ? 'Sim' : 'Não'}<br>
                            Vermifugado: ${card.vermifugado ? 'Sim' : 'Não'}<br>
                            Descrição: ${card.descricao}<br>
                        </p>
                        <button class="btn btn-danger" onclick="openAdoptionModal('${card.nome}', '${card.id_animal}')">Quero Adotar!</button>
                    </div>
                </div>
            `;
        }

        function showPrevCard() {
            if (currentCardIndex > 0) {
                currentCardIndex--;
                showCard(currentCardIndex);
            }
        }

        function showNextCard() {
            if (currentCardIndex < cards.length - 1) {
                currentCardIndex++;
                showCard(currentCardIndex);
            }
        }

        // Inicialize com o primeiro card
        if (cards.length > 0) {
            showCard(currentCardIndex);
        }

        // Função para abrir o modal de adoção
        function openAdoptionModal(nome, id_animal) {
            const message = `Tenho interesse em adotar o animal ${nome} (ID: ${id_animal})`;
            document.getElementById('message').value = message;
            const adoptionModal = new bootstrap.Modal(document.getElementById('adoptionModal'));
            adoptionModal.show();
        }

        // Função para processar e salvar os dados do formulário
        document.getElementById('adoptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('process_adoption.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Solicitação enviada com sucesso!');
                // Fechar o modal após enviar
                alert('Solicitação enviada com sucesso!');
                // Fechar o modal após enviar a solicitação
                const adoptionModal = bootstrap.Modal.getInstance(document.getElementById('adoptionModal'));
                adoptionModal.hide();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Houve um erro ao enviar a solicitação.');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
