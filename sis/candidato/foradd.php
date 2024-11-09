<?php
// Incluindo o arquivo de conexão com o banco de dados
include_once 'base/config.php';

// Consulta para obter o candidato com base no ID, se existir
$candidato = null;
if (isset($_GET['id_cand'])) {
    $id_cand = $_GET['id_cand'];
    $query = "SELECT * FROM candidato WHERE id_cand = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_cand);
    $stmt->execute();
    $result = $stmt->get_result();
    $candidato = $result->fetch_assoc();
    $stmt->close();
}

// Consulta para obter os usuários de nível 1
$usuarios_nivel1 = [];
$query_usuarios = "SELECT id, usuario FROM usuario WHERE nivel = 1";
$result_usuarios = $con->query($query_usuarios);
while ($usuario = $result_usuarios->fetch_assoc()) {
    $usuarios_nivel1[] = $usuario;
}
?>
<div id="main" class="container-fluid">
 	<div id="top" class="row">
		<div class="col-md-11">
			<h2>Candidatos</h2>
		</div>

		<div class="col-md-1">
			<!-- Chama o Formulário para adicionar candidato -->
			<a href="?page=foradd" class="btn btn-primary pull-right h2">Novo Candidato</a> 
		</div>
	</div>
    <form action="?page=inserir_cand" method="post">
		<!-- 1ª LINHA -->	
		<div class="row"> 
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="id_cand">Matrícula</label>
				<input type="text" class="form-control" name="id_cand" value="<?php echo isset($candidato['id_cand']) ? $candidato['id_cand'] : ''; ?>" readonly>
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-8">
				<label for="nome_cand">Nome Completo</label>
				<input type="text" class="form-control" name="nome_cand" value="<?php echo isset($candidato['nome_cand']) ? $candidato['nome_cand'] : ''; ?>">
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
                <label for="id">Usuário Associado</label>
                <select class="form-control" name="id">
                    <option value="">Selecione o Usuário</option>
                    <?php foreach ($usuarios_nivel1 as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>" <?php echo (isset($candidato['id']) && $candidato['id'] == $usuario['id']) ? 'selected' : ''; ?>>
                            <?php echo $usuario['usuario']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="data_cad_cand">Data Cadastro</label>
				<input type="date" class="form-control" name="data_cad_cand" >
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="data_nasc_cand">Data Nascimento</label>
				<input type="date" class="form-control" name="data_nasc_cand">
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="sexo_cand">Sexo</label>
				<select class="form-control" name="sexo_cand">
					<option> --------- </option>
					<option value="M">Masculino</option>
					<option value="F">Feminino</option>
				</select>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="status_cand">Status</label>
				<select class="form-control" name="status_cand">
					<option> --------- </option>
					<option value="Pendente">Pendente</option>
					<option value="Validado">Validado</option>
				</select>
			</div>			
        </div>		   
        <div class="row"> 
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="telefone_cand">Telefone</label>
				<input type="text" id="telefone_cand" class="form-control" name="telefone_cand">
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="celular_cand">Celular</label>
				<input type="text" id="celular_cand" class="form-control" name="celular_cand">
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
				<label for="email_cand">E-mail</label>
				<input type="email" class="form-control" name="email_cand">
			</div>
		</div>  
        
        <div class="row"> 
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="cep">CEP</label>
				<input type="text" id="cep" class="form-control" name="cep" onblur="consultarViaCEP()">
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-6">
				<label for="logradouro">Logradouro</label>
				<input type="text" class="form-control" name="logradouro">
			</div>
           
			<div class="form-group col-xs-12 col-sm-6 col-md-1">
				<label for="numero">Número</label>
				<input type="text" class="form-control" name="numero">
			</div>

            <div class="form-group col-xs-12 col-sm-6 col-md-4">
				<label for="complemento">Complemento</label>
				<input type="text" class="form-control" name="complemento">
			</div>

            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="bairro">Bairro</label>
				<input type="text" class="form-control" name="bairro">
			</div>

            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="cidade">Cidade</label>
				<input type="text" class="form-control" name="cidade">
			</div>

            <div class="form-group col-xs-12 col-sm-6 col-md-1">
				<label for="uf">UF</label>
				<input type="text" class="form-control" name="uf">
			</div>
		</div>
		
        
        <hr />
		<div id="actions" class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-success">Salvar</button>
				<a href="?page=lista_cand" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
	</form> 

	  <!-- Script para consultar o ViaCEP -->
	<script>
    	function consultarViaCEP() {
        	const cep = document.querySelector('input[name="cep"]').value.replace(/\D/g, '');
        	const url = `https://viacep.com.br/ws/${cep}/json/`;

        	if (cep.length !== 8) {
            alert('CEP inválido!');
            return;
        	}

        	fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado!');
                    return;
                }

                // Preencher os campos do formulário
                document.querySelector('input[name="logradouro"]').value = data.logradouro;
                document.querySelector('input[name="bairro"]').value = data.bairro;
                document.querySelector('input[name="cidade"]').value = data.localidade;
                document.querySelector('input[name="uf"]').value = data.uf;
            })
            .catch(error => {
                console.error('Erro ao consultar o CEP:', error);
                alert('Erro ao consultar o CEP. Tente novamente.');
            });
    	}

    // Adicionar um evento ao campo CEP para chamar a função
    	document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.querySelector('input[name="cep"]');
        cepInput.addEventListener('blur', consultarViaCEP);
    });
</script>
</div>
           
            
           
            
           
    