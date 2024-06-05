<?php include 'imagemperfil.php'?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .profile-avatar {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="main">
            <h1>Perfil usuário</h1>
            <div class="container">
                <div class="profile-avatar">
                    <?php echo htmlspecialchars($nome); ?>
                </div>
                <ul class="list-group" style="margin-top:2px; margin-bottom:25px;">
                    <li class="list-group-item"><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                    <li class="list-group-item"><strong>CPF:</strong> <?php echo htmlspecialchars($cpf); ?></li>
                    <li class="list-group-item"><strong>Endereço:</strong> <?php echo htmlspecialchars($endereco); ?></li>
                </ul>
                <div class="mx-auto d-block img-fluid" style="margin-bottom:25px;">
                    <a href="editardados.php?id=<?php echo $user_id; ?>" class="btn btn-success">Editar perfil</a>
                </div>
            </div>
        </div>
        <div class="footer">
        <button class="button" onclick="window.location.href='feed.php';" style="background-color: white;">
                <img src="./img/dog.gif" alt="User" width="40" height="40">
        </div>
    </div>
</body>
</html>
