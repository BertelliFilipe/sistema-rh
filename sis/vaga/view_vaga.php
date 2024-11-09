<?php
	$id = (int) $_GET['id'];
	$sql = mysqli_query($con, "select * from vaga where id = '".$id."';");
	$row = mysqli_fetch_array($sql);
?>

<div id="main" class="container-fluid">
	<br>
		<h3 class="page-header">Visualizar registro de Vagas - <?php echo $id;?></h3>
	
	<!-- 1ª LINHA -->
	
	<div class="row">
		<div class="col-md-1">
			<p><strong>ID</strong></p>
			<p><?php echo $row['id'];?></p>
		</div>

		<div class="col-md-5">
			<p><strong>Nome da Vaga</strong></p>
			<p><?php echo $row['nome'];?></p>
		</div>

		<div class="col-md-3">
			<p><strong>Descrição</strong></p>
			<p><?php echo $row['descricao']; ?></p>
		</div>

		<div class="col-md-3">
			<p><strong>Status</strong></p>
			<p><?php echo $row['status_vaga']; ?></p>
		</div>
		
	</div>
	<hr/>
	
	<div id="actions" class="row">
		<div class="col-md-12">
			<a href="?page=lista_vaga" class="btn btn-default">Voltar</a>
			<?php echo "<a href=?page=fedita_vaga&id=".$row['id']." class='btn btn-primary'>Editar</a>";?>
			<?php echo "<a href=?page=excluir_vaga&id=".$row['id']." class='btn btn-primary'>Excluir</a>";?>
			
		</div>
	</div>
</div>
