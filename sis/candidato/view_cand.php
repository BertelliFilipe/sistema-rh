<?php
// Garantir que o ID seja passado corretamente na URL
$id_cand = (int) $_GET['id_cand'];

// Verifica se o ID está sendo passado corretamente
if ($id_cand > 0) {
    // A consulta correta usando a variável id_cand
    $sql = "SELECT candidato.*, usuario.usuario 
            FROM candidato 
            LEFT JOIN usuario ON candidato.id = usuario.id
            WHERE candidato.id_cand = '$id_cand'";

    // Executar a consulta SQL
    $result = mysqli_query($con, $sql);

    // Verificar se há resultados
    if ($result) {
        $row = mysqli_fetch_array($result);
    } else {
        // Caso não encontre dados
        echo "Candidato não encontrado.";
        exit;
    }
} else {
    echo "ID inválido.";
    exit;
}
?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Visualizar registro do Candidato - <?php echo $id_cand; ?> </h3>
    <div class="row">
        <div class="col-md-2">
            <p><strong>Matrícula</strong></p>
            <p><?php echo $row['id_cand']; ?></p>
        </div>
        <div class="col-md-5">
            <p><strong>Nome Completo</strong></p>
            <p><?php echo $row['nome_cand']; ?></p>
        </div>
        <div class="col-md-5">
            <p><strong>Usuário</strong></p>
            <p><?php echo isset($row['usuario']) ? $row['usuario'] : 'Não associado'; ?></p> <!-- Nome do usuário associado -->
        </div>
        <div class="col-md-5">
            <p><strong>Data Cadastro</strong></p>
            <p><?php echo date('d-m-Y', strtotime($row['data_cad_cand'])); ?></p>
        </div>
        <div class="col-md-3">
            <p><strong>Data Nascimento</strong></p>
            <p><?php echo date('d-m-Y', strtotime($row['data_nasc_cand'])); ?></p>
        </div>
        <div class="col-md-2">
            <p><strong>Sexo</strong></p>
            <p><?php echo $row['sexo_cand']; ?></p>
        </div>
        <div class="col-md-3">
            <p><strong>Celular</strong></p>
            <p><?php echo $row['celular_cand']; ?></p>
        </div>
        <div class="col-md-3">
            <p><strong>E-mail</strong></p>
            <p><?php echo $row['email_cand']; ?></p>
        </div>
    </div>  

    <hr/>
    <div id="actions" class="row">
        <div class="col-md-12">
            <a href="?page=lista_cand" class="btn btn-default">Voltar</a>
            <a href="?page=fedit_cand&id_cand=<?php echo $row['id_cand']; ?>" class="btn btn-primary">Editar</a>
            <a href="?page=excluir_cand&id_cand=<?php echo $row['id_cand']; ?>" class="btn btn-danger">Excluir</a>
        </div>
    </div>
</div>
