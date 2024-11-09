<div> <?php include "mensagens.php"; ?> </div>
<div id="main" class="container-fluid">
	<h3 class="page-header">Cadastrar Vaga</h3>
	<form action="?page=insere_vaga" method="post">
		
		<div id="linha01" class="row"> 
			<div class="form-group col-md-1">
				<label for="id">ID</label>
				<input type="text" disabled="disabled" value="0" class="form-control" name="id">
			</div>
			
			<div class="form-group col-md-5">
				<label for="nome">Nome da Vaga</label>
				<input type="text" class="form-control" name="nome">
			</div>
						
		</div>
	
		<div id="linha02" class="row"> 
		
			<div class="form-group col-md-4">
				<label for="descricao">Descricao</label>
				<input type="text" class="form-control" name="descricao">
			</div>			
	
			<div class="form-group col-md-3">
				<label for="data">Data do cadastro</label>
				<input type="data" disabled="disabled" class="form-control" name="data" value="<?php echo date('d/m/Y'); ?>" name="data">
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="status_vaga">Status</label>
				<select class="form-control" name="status_vaga">
					<option value="Andamento">Andamento</option>
					<option value="Pausada">Pausada</option>
					<option value="Cancelada">Cancelada</option>
				</select>
			</div>			

		</div>
		<hr />
		<div id="actions" class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary">Salvar</button>
				<a href="?page=lista_vaga" class="btn btn-default">Cancelar</a>
			</div>
		</div>

	</form> 
</div>
