<?php
// Verifica se houve POST e se o usuário ou a senha estão vazios
if (!empty($_POST) and (empty($_POST['usuario']) or empty($_POST['senha']))) {
    header("Location: login.php");
    exit;
}

// Tenta se conectar ao servidor MySQL e ao DB
$con = mysqli_connect('localhost', 'root', '', 'projeto');

// Checa a conexão
if (!$con) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$usuario = mysqli_real_escape_string($con, $_POST['usuario']);
$senha = mysqli_real_escape_string($con, $_POST['senha']);

// Validação do usuário/senha digitados
$sql  = "SELECT u.id, u.nome, u.nivel, c.id_cand FROM usuario u 
         LEFT JOIN candidato c ON u.id = c.id
         WHERE (u.usuario = '". $usuario ."') AND (u.senha = '". sha1($senha) ."') AND (u.situacao = 1) LIMIT 1";

$query = mysqli_query($con, $sql);

if (mysqli_num_rows($query) != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
    header('Content-Type: text/html; charset=utf-8');
    echo "Login inválido!";
    exit;
} else {
    // Salva os dados encontrados na variável $resultado
    $resultado = mysqli_fetch_assoc($query);
    
    // Se a sessão não existir, inicia uma
    if (!isset($_SESSION)) session_start();

    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioNome'] = $resultado['nome'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];
    
    // Se for um candidato, salva o id_cand na sessão
    if ($resultado['id_cand']) {
        $_SESSION['id_cand'] = $resultado['id_cand'];
    }

    // Redireciona para a página principal (ou dashboard)
    header("Location: dash.php");
    exit;
}
?>
