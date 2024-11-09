<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['figura']) && $_FILES['figura']['error'] == UPLOAD_ERR_OK) {
        // Define o diretório de destino
        $diretorioDestino = 'uploads/'; // Certifique-se de que este diretório exista e tem permissões de escrita
        
        // Obtém informações sobre o arquivo
        $nomeArquivo = basename($_FILES['figura']['name']);
        $caminhoArquivo = $diretorioDestino . $nomeArquivo;

        // Verifica o tamanho do arquivo
        if ($_FILES['figura']['size'] > 30000) {
            echo "O arquivo excede o tamanho máximo permitido.";
            exit;
        }

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($_FILES['figura']['tmp_name'], $caminhoArquivo)) {
            echo "O arquivo foi enviado com sucesso: " . htmlspecialchars($nomeArquivo);
        } else {
            echo "Ocorreu um erro ao enviar o arquivo.";
        }
    } else {
        echo "Nenhum arquivo selecionado ou ocorreu um erro.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>