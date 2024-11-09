<?php
include_once("C:/xampp/htdocs/projeto/base/config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Certifique-se de incluir o autoload do PHPMailer se necessário
require_once(__DIR__ . "/../../libs/PHPMailer/src/Exception.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/PHPMailer.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/SMTP.php");

// Verificar se o ID foi passado pela URL
if (isset($_GET['id_cand']) && !empty($_GET['id_cand'])) {
    $id_cand = $_GET['id_cand'];

    // Verificar se o ID existe na tabela candidato
    $query = "SELECT * FROM candidato WHERE id_cand = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id_cand);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o ID for válido, atualize o status da ficha
        $updateQuery = "UPDATE candidato SET status_cand = 'validado' WHERE id_cand = ?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->bind_param("i", $id_cand);
        
        if ($updateStmt->execute()) {
            // Enviar um e-mail notificando sobre a validação
            $candidato = $result->fetch_assoc();
            $nome_candidato = $candidato['nome_cand'];
            $email_candidato = $candidato['email_cand'];

            // Configuração do e-mail
            $destinatario = "alegomes.160591@gmail.com"; // Altere para o e-mail do responsável
            $assunto = "Candidato Validado - ID: $id_cand";
            $mensagem = "O candidato com ID $id_cand e nome $nome_candidato foi validado. Detalhes:\n";
            $mensagem .= "Nome: $nome_candidato\n";
            $mensagem .= "E-mail: $email_candidato\n";
            $mensagem .= "ID do Candidato: $id_cand\n";

            // Criar uma instância do PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configurações do MailHog (SMTP)
                $mail->isSMTP();                                      // Ativa o envio via SMTP
                $mail->Host = '127.0.0.1';                             // Host do MailHog (local)
                $mail->SMTPAuth = false;                               // Sem autenticação
                $mail->Port = 1025;                                    // Porta do MailHog (1025 para SMTP local)

                // Definindo remetente
                $mail->setFrom('no-reply@seusite.com', 'Sistema de Validação de Candidatos');
                $mail->addAddress($destinatario);                       // Destinatário
                
                // Definindo o assunto e corpo do e-mail
                $mail->Subject = $assunto;
                $mail->Body    = $mensagem;

                // Enviar o e-mail
                if ($mail->send()) {
                    // Mensagem de sucesso
                    $message = "Validação registrada. Um e-mail foi enviado ao setor responsável.";
                } else {
                    // Caso falhe o envio do e-mail
                    $message = "Falha ao enviar o e-mail.";
                }
                
                // Redirecionar após a validação e envio do e-mail
                header("Location: \projeto/dash.php?page=lista_ficha&message=" . urlencode($message));
                exit(); // Garantir que o script pare aqui após o redirecionamento

            } catch (Exception $e) {
                echo "Erro ao enviar o e-mail: " . $mail->ErrorInfo;
            }
        } else {
            echo 'Erro ao atualizar status do candidato.';
        }
    }
}
// Fechando a conexão
$con->close();
?>
