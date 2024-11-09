<?php
include_once '../base/config.php';
require_once __DIR__ . '../../vendor/autoload.php'; 

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Verifica o nome da empresa
$nome = isset($_POST['nome']) ? mysqli_real_escape_string($con, $_POST['nome']) : 'Todos';


if ($nome_emp === 'Todos') {
    $sql = "SELECT * FROM vaga"; 
} else {
    $sql = "SELECT * FROM vaga WHERE nome LIKE '%$nome%'"; 
}

$result = $con->query($sql);

// Criação do objeto mPDF
$mpdf = new \Mpdf\Mpdf(['allow_output_buffering' => true]);

// Caminho da imagem (use o URL correto)
$logoPath = 'http://localhost/projeto/img/logo.png'; // URL ou caminho da imagem

// Adiciona a logo da empresa e o cabeçalho
$html1 = "
<fieldset>
    <div class='cabecalho'>
        <div class='imgcab'><img src='{$logoPath}' style='max-width: 100%; height: auto;'></div>
        <div class='titcab'>Grupo Triunfo</div>
    </div>
"; 

// Adiciona o título do relatório
$html = '<h2 style="text-align: center;">Relatório de Vagas - Nome: ' . htmlspecialchars($nome) . '</h2>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Data</th></tr></thead><tbody>';

// Adiciona os dados na tabela
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nome']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['descricao']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['data']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align: center;">Nenhuma vaga encontrada.</td></tr>';
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
$mpdf->Output('relatorio_vagas.pdf', 'I'); // 'I' para enviar para o navegador
?>
