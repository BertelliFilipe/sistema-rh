﻿<?php
	$id = (int) $_GET['id'];
	$sql = mysqli_query($con, "select * from usuario where id = '".$id."';");
	$row = mysqli_fetch_array($sql);
?>
<div id="main" class="container-fluid">
	<br><h3 class="page-header">Editar registro da Usuário - <?php echo $id;?></h3>
	
	<!-- Área de campos do formulário de edição-->
	
	<form action="?page=atualiza_usu&id=<?php echo $row['id']; ?>" method="post">

	<!-- 1ª LINHA -->	
	<div class="row"> 
		
		<div class="form-group col-md-1">
			<label for="id">ID</label>
			<input readonly type="text" class="form-control" name="id" value="<?php echo $row["id"]; ?>">
		</div>
		
		<div class="form-group col-md-5">
			<label for="nome">Nome de Usuário</label>
			<input type="text" class="form-control" name="nome" value="<?php echo $row["nome"]; ?>">
		</div>
		
		<div class="form-group col-md-3">
			<label for="usuario">Usuário</label>
			<input type="text" class="form-control" name="usuario" value="<?php echo $row["usuario"]; ?>">
		</div>
		
		<div class="form-group col-md-3">
			<label for="senha">Senha</label>
			<input readonly type="text" class="form-control" name="senha" value="<?php echo $row["senha"]; ?>">
		</div>
	
	</div>	
	
	<!-- 2ª LINHA -->	
	<div class="row"> 
		
		<div class="form-group col-md-4">
			<label for="email">E-mail</label>
			<input type="email" class="form-control" name="email" value="<?php echo $row["email"]; ?>">
		</div>
		
		<div class="form-group col-md-2">
			<label for="nivel">Nível</label>
			<select class="form-control" id="nivel" name="nivel">
				<option value="1"<?php if (!(strcmp(1, htmlentities($row['nivel'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Candidato</option>
				<option value="2"<?php if (!(strcmp(2, htmlentities($row['nivel'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Validador</option>
				<option value="3"<?php if (!(strcmp(3, htmlentities($row['nivel'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Administrador</option>		
			</select>
		</div>
		
		<div class="form-group col-md-3">
			<label for="dt_cadastro">Data da Edição</label>
			<input type="text" disabled="disabled" class="form-control" name="dt_cadastro" value="<?php echo date('d/m/Y'); ?>">
		</div>
		
		<div class="form-group col-md-2">
			<label for="situacao">Ativo</label><br>
			<?php
			if($row["situacao"]==1){
				echo "<label>SIM</label>";
			}else if($row["situacao"]==0){
				echo "<label>NÃO</label>";
			}
			?>
		</div>
	</div>
</div>
	
	<hr/>
	<div id="actions" class="row">
	 <div class="col-md-12">
		<a href="?page=lista_usu" class="btn btn-default">Voltar</a>
		<button type="submit" class="btn btn-primary">Salvar Alterações</button>
	 </div>
	</div>
</div>
