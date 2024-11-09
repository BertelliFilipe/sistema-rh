<?php
// Inclui o arquivo de configuração de conexão com o banco de dados
include_once 'base/config.php';

// Verifica se o ID do ASO foi enviado pela URL
if (isset($_GET['idaso']) && is_numeric($_GET['idaso'])) {
    $idaso = (int) $_GET['idaso'];
} else {
    echo "ID de ASO não definido ou inválido.";
    exit;
}

// Coleta os dados enviados pelo formulário
$id_cand            = $_POST["id_cand"];
$datacadastro       = $_POST["datacadastro"];
$dataagenda         = $_POST["dataagenda"];
$status             = $_POST["status"];

// Formata as datas no padrão adequado para o banco de dados
$fdg_datacadastro = date('Y-m-d', strtotime($datacadastro));
$fdg_dataagenda = date('Y-m-d', strtotime($dataagenda));

// Verifica se um arquivo foi anexado no campo `asoimg`
$asoimg = null;
if (isset($_FILES['asoimg']) && $_FILES['asoimg']['error'] == UPLOAD_ERR_OK) {
    // Pasta onde os arquivos serão armazenados
    $targetDir = "uploads/aso/";
    $asoimg = basename($_FILES["asoimg"]["name"]);
    $targetFilePath = $targetDir . $asoimg;

    // Move o arquivo para a pasta de destino
    if (move_uploaded_file($_FILES["asoimg"]["tmp_name"], $targetFilePath)) {
        echo "Arquivo enviado com sucesso.";
    } else {
        echo "Erro ao enviar o arquivo.";
        exit;
    }
}

// Monta a query SQL de atualização para a tabela `aso`
$sql_aso = "UPDATE aso SET 
    datacadastro = '$fdg_datacadastro', 
    dataagenda = '$fdg_dataagenda', 
    status = '$status'";

// Inclui o campo `asoimg` na atualização se o arquivo foi enviado
if ($asoimg) {
    $sql_aso .= ", asoimg = '$asoimg'";
}

$sql_aso .= " WHERE idaso = '$idaso';";

// Executa a query de atualização no banco de dados
$resultado = mysqli_query($con, $sql_aso) or die(mysqli_error($con));

// Verifica o resultado da atualização
if ($resultado) {
    // Redireciona em caso de sucesso
    header('Location: /projeto/dash.php?page=lista_aso&msg=2');
    exit;
} else {
    // Redireciona em caso de erro
    header('Location: /projeto/dash.php?page=lista_aso&msg=4');
    exit;
}
?>
