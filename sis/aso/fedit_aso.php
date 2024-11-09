<?php
// Verifica se o parâmetro 'id' (id_aso) existe no array $_GET e é válido
if (isset($_GET['idaso']) && is_numeric($_GET['idaso'])) {
    $idaso = (int) $_GET['idaso']; // Obtém o id_aso da URL
    
    // Conexão com o banco de dados
    include_once 'base/config.php';
    
    // Consulta o ASO pelo seu ID para obter os dados, incluindo o ID do candidato e outros detalhes
    $sql = mysqli_query($con, "SELECT aso.*, candidato.nome_cand FROM aso 
                               JOIN candidato ON aso.id_cand = candidato.id_cand 
                               WHERE aso.idaso = '$idaso'");
    $row = mysqli_fetch_array($sql);

    // Verifica se o ASO foi encontrado
    if ($row) {
        $id_cand = $row['id_cand'];        // Matrícula do candidato associada
        $datacadastro = $row['datacadastro']; // Data de cadastro
        $dataagenda = $row['dataagenda'];   // Data de agendamento
        $status = $row['status'];           // Status do ASO
        $nome_cand = $row['nome_cand'];     // Nome do candidato
    } else {
        echo "Registro de ASO não encontrado.";
        exit;
    }
} else {
    echo "ID de ASO não definido ou inválido.";
    exit;
}
?>

<div id="main" class="container-fluid">
    <br><h3 class="page-header">Editar ASO do Candidato: <?php echo $id_cand; ?></h3>

    <!-- Área de campos do formulário de edição-->
    <form action="?page=atualiza_aso&idaso=<?php echo $idaso; ?>" method="post" enctype="multipart/form-data">
    
    <!-- 1ª LINHA -->    
    <div class="row"> 
        <div class="form-group col-md-2">
            <label for="id_cand">Matrícula</label>
            <input type="text" class="form-control" name="id_cand" value="<?php echo $id_cand; ?>" readonly>
        </div>

        <div class="form-group col-md-4">
            <label for="nome_cand">Nome do Candidato</label>
            <input type="text" class="form-control" name="nome_cand" value="<?php echo $nome_cand; ?>" readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="datacadastro">Data de Cadastro</label>
            <input type="date" class="form-control" name="datacadastro" value="<?php echo $datacadastro; ?>" readonly>
        </div>
        
        <div class="form-group col-md-3">
            <label for="dataagenda">Data de Agendamento</label>
            <input type="date" class="form-control" name="dataagenda" value="<?php echo $dataagenda; ?>">
        </div>
    </div>

    <!-- 2ª LINHA -->
    <div class="row">
        <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select class="form-control" name="status">
                <option value="AG" <?php echo ($status === 'AG') ? 'selected' : ''; ?>>Aguardando</option>
                <option value="A" <?php echo ($status === 'A') ? 'selected' : ''; ?>>Apto</option>
                <option value="I" <?php echo ($status ==='I') ? 'selected' : ''; ?>>Inapto</option>
            </select>
        </div>

        <div class="form-group col-md-2">    	
            <input type="hidden" name="asoimg" value="30000 <?php echo $row["asoimg"]; ?>" />
            Anexar o ASO: <input name="asoimg" type="file" /><br>
        </div>
    </div>

    <hr/>

    <div id="actions" class="row">
        <div class="col-md-12">
            <a href="?page=lista_aso" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </div>
</div>
