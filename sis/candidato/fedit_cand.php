<?php
// Recupera o ID do candidato
    $id = (int) $_GET['id_cand'];

// Consulta o candidato e endereço
    $sql = mysqli_query($con, "SELECT c.*, e.* 
                           FROM candidato c 
                           LEFT JOIN endereco e ON c.id_cand = e.id_cand
                           WHERE c.id_cand = '".$id."'");
    $row = mysqli_fetch_array($sql);

// Consulta para listar usuários de nível 1
    $usuarios_nivel1_sql = mysqli_query($con, "SELECT id, usuario FROM usuario WHERE nivel = 1");
    $usuarios_nivel1 = mysqli_fetch_all($usuarios_nivel1_sql, MYSQLI_ASSOC);
?>
<div id="main" class="container-fluid">
    <br><h3 class="page-header">Editar registro do Candidato - <?php echo $id;?></h3>

    <!-- Área de campos do formulário de edição-->
    <form action="?page=atualiza_cand&id_cand=<?php echo $row['id_cand']; ?>" method="post">

    <!-- 1ª LINHA -->    
    <div class="row"> 
        <div class="form-group col-md-2">
            <label for="id_cand">Matrícula</label>
            <input type="text" class="form-control" name="id_cand" value="<?php echo $row["id_cand"]; ?>">
        </div>
        <div class="form-group col-md-5">
            <label for="nome_cand">Nome Completo</label>
            <input type="text" class="form-control" name="nome_cand" value="<?php echo $row["nome_cand"]; ?>">
        </div>
        <div class="form-group col-xs-12 col-sm-6 col-md-2">
            <label for="id">Usuário Associado</label>
            <select class="form-control" name="id">
                <option value="">Selecione o Usuário</option>
                <?php foreach ($usuarios_nivel1 as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>" <?php echo (isset($row['id']) && $row['id'] == $usuario['id']) ? 'selected' : ''; ?>>
                        <?php echo $usuario['usuario']; ?>
                    </opt>
                <?php endforeach; ?>
            </select>
        </div>
       
        <div class="form-group col-md-3">
            <label for="data_cad_cand">Data Cadastro</label>
            <input type="date" class="form-control" name="data_cad_cand" value="<?php echo date('Y-m-d',strtotime($row["data_cad_cand"])); ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="data_nasc_cand">Data Nascimento</label>
            <input type="date" class="form-control" name="data_nasc_cand" value="<?php echo date('Y-m-d',strtotime($row["data_nasc_cand"])); ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="sexo_cand">Sexo</label>
            <select class="form-control" name="sexo_cand">
                <?php 
                if($row["sexo_cand"]=="M") 
                    echo '<option selected="selected" value="M">Masculino</option><option value="F">Feminino</option>'; 
                else 
                    echo '<option value="M">Masculino</option><option selected="selected" value="F">Feminino</option>'; 
                ?>
            </select>
		</div>
		<div class="form-group col-md-2">
            <label for="status_cand">Status</label>	
			<select class="form-control" name="status_cand">
                <?php 
                if($row["status_cand"]=="Pendente") 
                    echo '<option selected="selected" value="Pendente">Pendente</option><option value="Validado">Validado</option>'; 
                else 
                    echo '<option value="Pendente">Pendente</option><option selected="selected" value="Validado">Validado</option>'; 
                ?>
            </select>
        </div>
    </div>

    <!-- 3ª LINHA -->
    <div class="row"> 
        <div class="form-group col-md-2">
            <label for="telefone_cand">Telefone</label>
            <input type="text" id="telefone_cand" class="form-control" name="telefone_cand" value="<?php echo $row["telefone_cand"]; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="celular_cand">Celular</label>
            <input type="text" id="celular_cand" class="form-control" name="celular_cand" value="<?php echo $row["celular_cand"]; ?>">
        </div>
        <div class="form-group col-md-4">
            <label for="email_cand">E-mail</label>
            <input type="text" class="form-control" name="email_cand" value="<?php echo $row["email_cand"]; ?>">
        </div>
    </div>

    <!-- Campos de Endereço -->
    <div class="row">
        <div class="form-group col-md-2">
            <label for="cep">CEP</label>
            <input type="text" id="cep" class="form-control" id="cep" name="cep" value="<?php echo $row['cep']; ?>" onblur="consultarViaCEP(this.value)">
        </div>
        <div class="form-group col-md-5">
            <label for="logradouro">Logradouro</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?php echo $row['logradouro']; ?>">
        </div>
		<div class="form-group col-md-1">
            <label for="numero">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $row['numero']; ?>">
        </div>
		<div class="form-group col-md-5">
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $row['complemento']; ?>">
        </div>
        <div class="form-group col-md-2">
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $row['bairro']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-2">
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $row['cidade']; ?>">
        </div>
        <div class="form-group col-md-1">
            <label for="uf">UF</label>
            <input type="text" class="form-control" id="uf" name="uf" value="<?php echo $row['uf']; ?>">
        </div>
    </div>

    <hr/>

    <div id="actions" class="row">
        <div class="col-md-12">
            <a href="?page=lista_cand" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </div>

	<script>
		function consultarViaCEP(cep) {
		cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
		if (cep.length !== 8) {
			alert('CEP inválido!');
			return;
		}

		// Faz a consulta na API do ViaCEP
		fetch(`https://viacep.com.br/ws/${cep}/json/`)
			.then(response => response.json())
			.then(data => {
				console.log(data); // Para depuração
				if (!data.erro) {
					// Preenche os campos do endereço com os dados retornados
					document.getElementById('logradouro').value = data.logradouro;
					document.getElementById('bairro').value = data.bairro;
					document.getElementById('cidade').value = data.localidade; // corrigido para localidade
					document.getElementById('uf').value = data.uf;
				} else {
					alert('CEP não encontrado!');
				}
			})
			.catch(error => console.error('Erro:', error));
		}
	</script>

</div>

