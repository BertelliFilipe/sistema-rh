<?php
// Verificar se a conexão com o banco de dados está disponível
include '../../base/config.php'; // Certifique-se de incluir a conexão com o banco

// Obter o ID do ASO da URL e garantir que seja um número inteiro
$id = (int) $_GET['idaso'];

// Consultar a tabela ASO e unir com a tabela candidato para obter o nome
$sql = mysqli_query($con, "
    SELECT aso.*, candidato.nome_cand, candidato.id_cand 
    FROM aso 
    INNER JOIN candidato ON aso.id_cand = candidato.id_cand 
    WHERE aso.idaso = '$id'
");

$row = mysqli_fetch_array($sql);
?>
<div id="main" class="container-fluid">
    <h3 class="page-header">Visualizar ASO - <?php echo $id; ?></h3>
    <div class="row">
		<div class="col-md-3">
            <p><strong>Matrícula</strong></p>
            <p><?php echo $row['id_cand']; ?></p>
        </div>    
		<div class="col-md-3">
            <p><strong>Candidato</strong></p>
            <p><?php echo $row['nome_cand']; ?></p>
        </div>        
        <div class="col-md-5">
            <p><strong>Cadastro</strong></p>
            <p><?php echo date('d-m-Y', strtotime($row['datacadastro'])); ?></p>
        </div>
        <div class="col-md-3">
            <p><strong>Agendamento</strong></p>
            <p><?php echo date('d-m-Y', strtotime($row['dataagenda'])); ?></p>
        </div>
        <div class="col-md-2">
            <p><strong>Situação</strong></p>
            <p><?php echo $row['status']; ?></p>
        </div>
        <div class="col-md-5">
            <p><strong>ASO (Arquivo)</strong></p>
            <p>
                <?php
                // Exibir o link para download do arquivo ASO
                if (!empty($row['asoimg'])) {
                    echo "<a href='uploads/{$row['asoimg']}' target='_blank'>Visualizar ASO</a>";
                } else {
                    echo "Arquivo não disponível.";
                }
                ?>
            </p>
        </div>
    </div>    
    
    <hr/>
    <div id="actions" class="row">
        <div class="col-md-12">
            <a href="?page=lista_aso" class="btn btn-default">Voltar</a>
            <?php echo "<a href='?page=fedit_aso&id_cand={$row['id_cand']}' class='btn btn-primary'>Editar</a>"; ?>
            <?php echo "<a href='?page=excluir_aso&id_cand={$row['id_cand']}' class='btn btn-danger'>Excluir</a>"; ?>
        </div>
    </div>
</div>
