<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Coleta de dados do formulário
$nome     = $_POST["nome"];
$usuario  = $_POST["usuario"];
$senha    = $_POST["senha"];
$email    = $_POST["email"];
$nivel    = $_POST["nivel"];    

// Inserção de usuário no banco de dados
$sql = "INSERT INTO usuario (nome, usuario, senha, email, nivel, situacao, dt_cadastro) VALUES ";
$sql .= "('$nome', '$usuario', '" . sha1($senha) . "', '$email', '$nivel', '1', '" . date('Y-m-d H:i:s') . "');";

$resultado = mysqli_query($con, $sql) or die(mysqli_error($con));

if ($resultado) {
    // Gerar token para criação de senha
    $token = bin2hex(random_bytes(50)); // Gera um token aleatório
    $expiracao_token = date("Y-m-d H:i:s", strtotime('+1 hour')); // O token expira em 1 hora
    
    // Pegar o ID do usuário recém-criado
    $user_id = mysqli_insert_id($con);
    
    // Atualizar a tabela de usuários com o token e a data de expiração
    $update_token_sql = "UPDATE usuario SET reset_token = '$token', token_expiracao = '$expiracao_token' WHERE id = '$user_id'";
    mysqli_query($con, $update_token_sql);
    
    // Montar o link para criação de senha
    $base_url = "http://localhost/projeto/sis/usuario/redefinir.php"; // URL local para teste
    $link = $base_url . "?token=" . $token;
    
    // Incluir o PHPMailer
    require 'libs/PHPMailer/src/Exception.php';
    require 'libs/PHPMailer/src/PHPMailer.php';
    require 'libs/PHPMailer/src/SMTP.php';
    
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'localhost'; // Host local do MailHog
        $mail->SMTPAuth   = false; // Não precisa de autenticação
        $mail->Port       = 1025; // Porta padrão do MailHog

        // Destinatários
        $mail->setFrom('no-reply@seusite.com', 'Grupo Triunfo');
        $mail->addAddress($email); // Adicione o endereço do destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Criação de Senha';
        $mail->Body    = "<p>Olá, $nome</p><p>Seu usuário de acesso é: $usuario</><p>Clique no link abaixo para criar sua senha:</p><p><a href='$link'>$link</a></p>";

        // Enviar o e-mail
        $mail->send();

        // Redirecionar após enviar
        header('Location: /projeto/dash.php?page=lista_usu&msg=1');
    } catch (Exception $e) {
        // E-mail não pôde ser enviado
        error_log("Erro ao enviar e-mail: " . $mail->ErrorInfo); // Log do erro
        header('Location: /projeto/dash.php?page=lista_usu&msg=5');
    }

    mysqli_close($con);
} else {
    // Erro na criação do usuário
    header('Location: /projeto/dash.php?page=lista_usu&msg=6');
    mysqli_close($con);
}
?>