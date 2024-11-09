<?php
	$id = (int) $_GET['id'];
	$sql = mysqli_query($con, "select * from vaga where id = '".$id."';");
	$row = mysqli_fetch_array($sql);
?>
<div id="main" class="container-fluid">
	<br><h3 class="page-header">Editar registro da Vaga - <?php echo $id;?></h3>
	
	<!-- Área de campos do formulário de edição-->
	
	<form action="?page=atualiza_vaga&id=<?php echo $row['id']; ?>" method="post">

	<!-- 1ª LINHA -->	
	<div class="row"> 
		
		<div class="form-group col-md-1">
			<label for="id">ID</label>
			<input readonly type="text" class="form-control" name="id" value="<?php echo $row["id"]; ?>">
		</div>
		
		<div class="form-group col-md-5">
			<label for="nome">Nome da Vaga</label>
			<input type="text" class="form-control" name="nome" value="<?php echo $row["nome"]; ?>">
		</div>

		<div class="form-group col-md-2">
    		<label for="status_vaga">Status</label>  
    		<select class="form-control" name="status_vaga">
        		<?php 
        		// Verifica o status atual e marca a opção correspondente como selecionada
        			if ($row["status_vaga"] == "Andamento") {
            			echo '<option selected="selected" value="Andamento">Andamento</option>';
            			echo '<option value="Pausada">Pausada</option>';
            			echo '<option value="Cancelada">Cancelada</option>';
        			} elseif ($row["status_vaga"] == "Pausada") {
            			echo '<option value="Andamento">Andamento</option>';
            			echo '<option selected="selected" value="Pausada">Pausada</option>';
            			echo '<option value="Cancelada">Cancelada</option>';
        			} else {
            			echo '<option value="Andamento">Andamento</option>';
            			echo '<option value="Pausada">Pausada</option>';
            			echo '<option selected="selected" value="Cancelada">Cancelada</option>';
        			}
        		?>
    		</select>
		</div>
	
	</div>	
	
	<!-- 2ª LINHA -->	
	<div class="row"> 
		
		<div class="form-group col-md-4">
			<label for="descricao">Descricao</label>
			<input type="text" class="form-control" name="descricao" value="<?php echo $row["descricao"]; ?>">
		</div>
		
		<div class="form-group col-md-2">
			<label for="data">Data</label>
			<input type="date" class="form-control" name="data" value="<?php echo $row["data"]; ?>">
		</div>		
		
	</div>
</div>
	
	<hr/>
	<div id="actions" class="row">
	 <div class="col-md-12">
		<a href="?page=lista_vaga" class="btn btn-default">Voltar</a>
		<button type="submit" class="btn btn-primary">Salvar Alterações</button>
	 </div>
	</div>
</div>
