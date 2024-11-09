<?php
include_once '../base/config.php';
require_once __DIR__ . '../../vendor/autoload.php'; 

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Obtém o status do ASO do formulário
$status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 'Todos';

// Consulta para buscar dados da tabela candidato e aso
if ($status === 'Todos') {
    $sql = "SELECT candidato.id_cand, candidato.nome_cand, aso.dataagenda, aso.status
            FROM candidato
            JOIN aso ON candidato.id_cand = aso.id_cand
            WHERE aso.status IN ('apto', 'inapto')";
} else {
    $sql = "SELECT candidato.id_cand, candidato.nome_cand, aso.dataagenda, aso.status
            FROM candidato
            JOIN aso ON candidato.id_cand = aso.id_cand
            WHERE aso.status = '$status'";
}

$result = $con->query($sql);

// Criação do objeto mPDF
$mpdf = new \Mpdf\Mpdf(['allow_output_buffering' => true]);

// Caminho da imagem (ajuste conforme o ambiente)
$logoPath = 'http://localhost/projeto/img/logo.png'; // Alterar para o caminho do servidor, se necessário

// Cabeçalho do PDF com a logo
$html1 = "
<fieldset>
    <div style='text-align: center; margin-bottom: 20px;'>
        <img src='{$logoPath}' alt='Logo' style='width: 150px; height: auto;'>
        <h1 style='margin: 0; font-size: 24px;'>Grupo Triunfo</h1>
    </div>
";

// Título do relatório
$html = '<h2 style="text-align: center;">Relatório de ASO - Status: ' . htmlspecialchars($status) . '</h2>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead><tr><th>Matrícula</th><th>Nome</th><th>Data de Agendamento</th><th>Status</th></tr></thead><tbody>';

// Adiciona os dados na tabela
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id_cand']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nome_cand']) . '</td>';
        $html .= '<td>' . htmlspecialchars(date('d/m/Y', strtotime($row['dataagenda']))) . '</td>'; // Formata a data
        $html .= '<td>' . htmlspecialchars($row['status']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align: center;">Nenhum registro encontrado.</td></tr>';
}

$html .= '</tbody></table>';

// Escreve o cabeçalho e o conteúdo no PDF
$mpdf->WriteHTML($html1); // Adiciona cabeçalho
$mpdf->WriteHTML($html);   // Adiciona a tabela
$css = file_get_contents('css/stylerel.css'); 
$mpdf->WriteHTML($css,1);

// Adiciona rodapé com a data de emissão
$htmlfooter = "
    <hr>
    <div style='text-align: center;'>Emissão: " . date('d/m/Y - H:i:s') . "</div>
</fieldset>
"; 
$mpdf->WriteHTML($htmlfooter); // Adiciona rodapé

// Adiciona paginação
$mpdf->SetFooter('Página {PAGENO} de {nbpg}');

// Saída do PDF
$mpdf->Output('relatorio_aso.pdf', 'I'); // 'I' para enviar para o navegador
?>
