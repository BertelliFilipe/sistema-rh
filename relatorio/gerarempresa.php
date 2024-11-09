<?php
include_once '../base/config.php';
require_once __DIR__ . '../../vendor/autoload.php'; 

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Verifica o nome da empresa
$nome_emp = isset($_POST['nome_emp']) ? mysqli_real_escape_string($con, $_POST['nome_emp']) : 'Todos';

// Lógica para obter os dados das empresas
if ($nome_emp === 'Todos') {
    $sql = "SELECT * FROM empresa"; // Busca todas as empresas
} else {
    $sql = "SELECT * FROM empresa WHERE nome_emp LIKE '%$nome_emp%'"; // Busca empresa pelo nome
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
$html = '<h2 style="text-align: center;">Empresas Contratantes - Nome: ' . htmlspecialchars($nome_emp) . '</h2>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th></tr></thead><tbody>';

// Adiciona os dados na tabela
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id_emp']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nome_emp']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email_emp']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['telefone_emp']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align: center;">Nenhuma empresa encontrada.</td></tr>';
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
$mpdf->Output('relatorio_empresas.pdf', 'I'); // 'I' para enviar para o navegador
?>
