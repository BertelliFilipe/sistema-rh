<?php
// Recebendo os dados do formulário via POST
$id_cand        = $_POST["id_cand"];
$datacadastro   = $_POST["datacadastro"];
$dataagenda     = $_POST["dataagenda"];
$status         = $_POST["status"];
$asoimg         = $_FILES["asoimg"];

// Formatando as datas do formato dd/mm/yyyy para yyyy-mm-dd
$fdatacadastro = implode("-", array_reverse(explode("/", $datacadastro)));
$fdataagenda = implode("-", array_reverse(explode("/", $dataagenda)));

// Conexão com o banco de dados
include '../base/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluindo o autoload do PHPMailer
require_once(__DIR__ . "/../../libs/PHPMailer/src/Exception.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/PHPMailer.php");
require_once(__DIR__ . "/../../libs/PHPMailer/src/SMTP.php");

// Consultando a tabela candidato para obter o nome e o e-mail do candidato
$sql_cand = "SELECT nome_cand, email_cand FROM candidato WHERE id_cand = '$id_cand'";
$result_cand = mysqli_query($con, $sql_cand);

if ($result_cand && mysqli_num_rows($result_cand) > 0) {
    $row_cand = mysqli_fetch_assoc($result_cand);
    $nome_cand = $row_cand["nome_cand"];
    $email_cand = $row_cand["email_cand"];

    // Tratamento condicional do upload da imagem, caso ela exista
    $asoimgName = null; // Inicializa como nulo

    if (!empty($asoimg["name"])) {
        $uploadDir = 'uploads/'; // Diretório para salvar a imagem
        $asoimgName = basename($asoimg["name"]);
        $asoimgPath = $uploadDir . $asoimgName;

        if (!move_uploaded_file($asoimg["tmp_name"], $asoimgPath)) {
            echo "Erro no upload da imagem.";
            exit();
        }
    }

    // Inserindo os dados na tabela aso
    $sql_aso = "INSERT INTO aso (id_cand, datacadastro, dataagenda, status, asoimg) 
                VALUES ('$id_cand', '$fdatacadastro', '$fdataagenda', '$status', " . ($asoimgName ? "'$asoimgName'" : "NULL") . ")";

    if (mysqli_query($con, $sql_aso)) {
        // Configuração do e-mail com PHPMailer
        $mail = new PHPMailer;

        // Configurações do servidor de e-mail
        $mail->isSMTP();
        $mail->Host = 'localhost'; // MailHog escuta em localhost
        $mail->Port = 1025;        // Porta padrão do MailHog
        $mail->SMTPAuth = false;   // MailHog não requer autenticação

        // Configurações do remetente e destinatário
        $mail->setFrom('noreply@exemplo.com', 'Agendamento ASO');
        $mail->addAddress($email_cand, $nome_cand); // E-mail do candidato

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Agendamento de ASO';
        $mail->Body = "Olá, $nome_cand,<br><br>
                       Seu exame ASO foi agendado para o dia <strong>$dataagenda</strong>.<br>
                       Por favor, esteja presente na data e horário agendados.<br><br>
                       Atenciosamente,<br>Grupo Triunfo";

        // Tentativa de envio de e-mail
        if ($mail->send()) {
            header('Location: /projeto/dash.php?page=lista_aso&msg=1');
        } else {
            echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
        }
    } else {
        echo "Erro ao inserir no banco de dados: " . mysqli_error($con);
    }
} else {
    echo "Erro ao recuperar dados do candidato: " . mysqli_error($con);
}

// Fecha a conexão com o banco de dados
mysqli_close($con);
?>
