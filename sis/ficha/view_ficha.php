<?php
	$id = (int) $_GET['idficha'];
	$sql = mysqli_query($con, "select * from ficha where idficha= '".$id."';");
	$row = mysqli_fetch_array($sql);
?>
<div id="main" class="container-fluid">
	<h3 class="page-header">Visualizar Ficha de Cdastro - <?php echo $id; ?> </h3>
	<div class="row">
		<div class="col-md-2">
			<p><strong>ID</strong></p>
			<p><?php echo $row['idficha'];?></p>
		</div>
		<div class="col-md-5">
			<p><strong>CPF</strong></p>
			<p><?php echo $row['cpf'];?></p>
		</div>
		<div class="col-md-5">
			<p><strong>RG</strong></p>
			<p><?php echo date('d-m-Y',strtotime($row['data_cad_cand'])); ?></p>
		</div>
		<div class="col-md-3">
			<p><strong>Data Nascimento</strong></p>
			<p><?php echo date('d-m-Y',strtotime($row['data_nasc_cand'])); ?></p>
		</div>
		<div class="col-md-2">
			<p><strong>Sexo</strong></p>
			<p><?php echo $row['sexo_cand'];?></p>
		</div>
		<div class="col-md-3">
			<p><strong>Celular</strong></p>
			<p><?php echo $row['celular_cand'];?></p>
		</div>
		<div class="col-md-3">
			<p><strong>E-mail</strong></p>
			<p><?php echo $row['email_cand'];?></p>
		</div>
    </div>	
	
	<hr/>
	<div id="actions" class="row">
		<div class="col-md-12">
			<a href="?page=lista_cand" class="btn btn-default">Voltar</a>
				<?php echo "<a href=?page=fedit_cand&id_cand=".$row['id_cand']." class='btn btn-primary'>Editar</a>";?>
				<?php echo "<a href=?page=excluir_cand&id_cand=".$row['id_cand']." class='btn btn-danger'>Excluir</a>";?>
		</div>
	</div>
</div>
