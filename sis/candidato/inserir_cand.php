<?php

$nome_cand          = $_POST["nome_cand"];
$data_cad_cand      = $_POST["data_cad_cand"];
$data_nasc_cand     = $_POST["data_nasc_cand"];
$sexo_cand          = $_POST["sexo_cand"];
$status_cand        = $_POST["status_cand"];
$telefone_cand      = $_POST["telefone_cand"];
$celular_cand       = $_POST["celular_cand"];
$email_cand         = $_POST["email_cand"];

$fdata_cad_cand 	= implode("-", array_reverse(explode("/", $data_cad_cand)));
$fdata_nasc_cand 	= implode("-", array_reverse(explode("/", $data_nasc_cand)));

// Obter o id do usuário associado
$id = $_POST["id"];  // Certifique-se de que o campo 'id' foi enviado corretamente via POST

// Verifique se o campo 'id' está preenchido
if (empty($id)) {
    die("Erro: O id do usuário associado não foi fornecido.");
}

$cep                = $_POST['cep'];
$logradouro         = $_POST['logradouro'];
$numero             = $_POST['numero'];
$complemento        = $_POST['complemento'];
$bairro             = $_POST['bairro'];
$cidade             = $_POST['cidade'];
$uf                 = $_POST['uf'];

// Inserindo o candidato na tabela
$sql_candidato = "INSERT INTO candidato (nome_cand, data_cad_cand, data_nasc_cand, sexo_cand, status_cand, telefone_cand, celular_cand, email_cand, id)
    VALUES ('$nome_cand', '$fdata_cad_cand', '$fdata_nasc_cand', '$sexo_cand', '$status_cand', '$telefone_cand', '$celular_cand', '$email_cand', '$id')";

if (mysqli_query($con, $sql_candidato)) {
    // Obter o ID do candidato inserido
    $id_cand = mysqli_insert_id($con);

    // Inserindo o endereço associado ao candidato
    $sql_endereco = "INSERT INTO endereco (cep, logradouro, numero, complemento, bairro, cidade, uf, id_cand) 
        VALUES ('$cep', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$uf', '$id_cand')";

    // Executa a query de inserção do endereço
    if (mysqli_query($con, $sql_endereco)) {
        header('Location: /projeto/dash.php?page=lista_cand&msg=1');  // Sucesso na inserção
        exit();
    } else {
        // Caso a inserção do endereço falhe
        header('Location: /projeto/dash.php?page=lista_cand&msg=4');  // Erro na inserção do endereço
        exit();
    }
} else {
    // Caso a inserção do candidato falhe
    header('Location: /projeto/dash.php?page=lista_cand&msg=4');  // Erro na inserção do candidato
    exit();
}

// Fecha a conexão com o banco de dados
mysqli_close($con);
?>
