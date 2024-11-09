<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("C:/xampp/htdocs/projeto/base/config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . "/../../libs/PHPMailer/src/Exception.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/PHPMailer.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/SMTP.php");

// Verifica se o id_cand foi passado pela URL
if (isset($_GET['id_cand']) && is_numeric($_GET['id_cand'])) {
    $id_cand = $_GET['id_cand'];

    // Consulta ao banco de dados para verificar o candidato
    $sql = "SELECT nome_cand, email_cand FROM candidato WHERE id_cand = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id_cand);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Candidato encontrado
        $candidato = $result->fetch_assoc();
        $nome_candidato = $candidato['nome_cand'];
        $email_candidato = $candidato['email_cand'];

        // Envio do e-mail de desistência
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = '127.0.0.1'; // Configuração do servidor de SMTP (MailHog)
            $mail->SMTPAuth = false;
            $mail->Port = 1025;

            $mail->setFrom('no-reply@seusite.com', 'Sistema de Desistência de Vaga');
            $mail->addAddress('alegomes.160591@gmail.com'); // Destinatário do e-mail

            $assunto = "Desistência da Vaga - Candidato ID: $id_cand";
            $mensagem = "O candidato com ID $id_cand e nome $nome_candidato desistiu da vaga.\n";
            $mensagem .= "E-mail: $email_candidato\n";
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;

            if ($mail->send()) {
                // Mensagem de sucesso
                $message = "Desistência registrada. Um e-mail foi enviado ao setor responsável.";
            } else {
                // Caso falhe o envio do e-mail
                $message = "Falha ao enviar o e-mail.";
            }
            
            // Redirecionar após a validação e envio do e-mail
            header("Location: \projeto/dash.php");
            exit(); // Garantir que o script pare aqui após o redirecionamento

        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: " . $mail->ErrorInfo;
        }

        
    } 
} 
$con->close();
?>   



