<?php
include_once '../base/config.php';
require_once __DIR__ . '../../vendor/autoload.php'; 

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Verifica o status do candidato
$status_cand = isset($_POST['status_cand']) ? mysqli_real_escape_string($con, $_POST['status_cand']) : 'Todos';

// Lógica para obter os dados dos candidatos
if ($status_cand === 'Todos') {
    $sql = "SELECT * FROM candidato WHERE status_cand IN ('pendente', 'validado')";
} else {
    $sql = "SELECT * FROM candidato WHERE status_cand = '$status_cand'";
}

$result = $con->query($sql);

// Criação do objeto mPDF
$mpdf = new \Mpdf\Mpdf(['allow_output_buffering' => true]);

// Caminho da imagem
$logoPath = 'http://localhost/projeto/img/logo.png'; // URL absoluto

// Adiciona a logo da empresa e o cabeçalho
$html1 = "
<fieldset>
    <div class='cabecalho'>
        <div class='imgcab'><img src='{$logoPath}'></div>
        <div class='titcab'>Grupo Triunfo</div>
    </div>
"; 

// Adiciona o título do relatório
$html = '<h2 style="text-align: center;">Relatório de Candidatos - Status: ' . htmlspecialchars($status_cand) . '</h2>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead><tr><th>Matrícula</th><th>Nome</th><th>Email</th><th>Status</th></tr></thead><tbody>';

// Adiciona os dados na tabela
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['id_cand']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['nome_cand']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['email_cand']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['status_cand']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Escreve o cabeçalho e o conteúdo no PDF
$mpdf->WriteHTML($html1); // Adiciona cabeçalho
$css = file_get_contents('css/stylerel.css'); 
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);   // Adiciona a tabela

// Adiciona rodapé com a data de emissão
$htmlfooter = "
    <hr>
    <div class='rodape'>Emissão: " . date('d/m/Y - H:i:s') . "</div>
</fieldset>
"; 
$mpdf->WriteHTML($htmlfooter); // Adiciona rodapé

// Adiciona paginação
$mpdf->SetFooter('Página {PAGENO} de {nbpg}');

// Saída do PDF
$mpdf->Output('relatorio_candidatos.pdf', 'I'); // 'I' para enviar para o navegador
?>
