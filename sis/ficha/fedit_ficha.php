<?php
	$id = (int) $_GET['idficha'];
	$sql = mysqli_query($con, "select * from ficha where idficha = '".$id."';");
	$row = mysqli_fetch_array($sql);
?>
<div id="main" class="container-fluid">
    <br><h3 class="page-header">Editar Ficha Cadastral- <?php echo $id;?></h3>

    <!-- Área de campos do formulário de edição-->
    <form action="?page=atualiza_ficha&id_cand=<?php echo $row['id_ficha']; ?>" method="post">

    <!-- 1ª LINHA -->    
    <div class="row"> 
        <div class="form-group col-md-2">
            <label for="id_cand">ID</label>
            <input type="text" class="form-control" name="id_cand" value="<?php echo $row["id_cand"]; ?>">
        </div>
        
        <div class="form-group col-xs-12 col-sm-6 col-md-8">    	
    		 <input type="hidden" name="cpf" value="30000 <?php echo $row["cfp"]; ?> "/>Envie seu CPF: <input name="cpf" type="file" /><br>
		</div>

    <hr/>

    <div id="actions" class="row">
        <div class="col-md-12">
            <a href="?page=lista_ficha" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </div>

	
</div>

