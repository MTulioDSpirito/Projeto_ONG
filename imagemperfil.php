<?php
session_start();

$dbHost = 'roundhouse.proxy.rlwy.net';
$dbUsername = 'root';
$dbPassword = 'QdbpuYyKwRQBndhIfSlCsLHlZrbiIGbe';
$dbName = 'bd_php';
$dbPort = '44161';

// Conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName,$dbPort);

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Usuário não está logado.");
}

// Obtém o ID do usuário logado da sessão
$user_id = $_SESSION['user_id'];

// Query para obter os dados do perfil do usuário
$sql = "SELECT nome, email, cpf, endereco FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome, $email, $cpf, $endereco);
$stmt->fetch();
$stmt->close();
$conexao->close();

// Supondo que o nome do usuário foi recuperado corretamente
$primeiraLetra = strtoupper(substr($nome, 0, 1));

// Crie uma imagem com a primeira letra do nome
$largura = 120;
$altura = 120;
$imagem = imagecreate($largura, $altura);
$corFundo = imagecolorallocate($imagem, 81, 45, 168); // Cor de fundo (pode ser ajustada)
$corTexto = imagecolorallocate($imagem, 255, 255, 255); // Cor do texto (branco)

// Defina a fonte (você pode ajustar a fonte e o tamanho conforme necessário)
$fonte = 'fonts/Lato-Black.ttf'; // Substitua pelo caminho correto da fonte TTF
$tamanhoFonte = 35;

// Escreva a primeira letra no centro da imagem
imagettftext($imagem, $tamanhoFonte, 0, 50, 90, $corTexto, $fonte, $primeiraLetra);

// Crie uma máscara circular
$mask = imagecreatetruecolor($largura, $altura);
$corTransparente = imagecolorallocate($mask, 0, 0, 0);
imagecolortransparent($mask, $corTransparente);
imagefilledellipse($mask, $largura / 2, $altura / 2, $largura, $altura, $corTransparente);

// Aplique a máscara à imagem
imagecopymerge($imagem, $mask, 0, 0, 0, 0, $largura, $altura, 100);

// Diretório para salvar as imagens
$diretorio = 'avatars/';
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

// Nome do arquivo baseado no ID do usuário
$nomeArquivo = $diretorio . 'avatar_' . $user_id . '.png';
imagepng($imagem, $nomeArquivo);

// Libere a memória
imagedestroy($imagem);
imagedestroy($mask);
?>