<?php
include_once 'base/config.php';

// Inicia a sessão, se ainda não tiver sido iniciada
if (!isset($_SESSION)) session_start();

// Verifica se o usuário tem o nível 3
if (!isset($_SESSION['UsuarioNivel']) || $_SESSION['UsuarioNivel'] != 3) { 
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este formulário.</div>";
    exit(); // Interrompe a execução para impedir o acesso
}
// Verifica se um ID de candidato foi passado
if (isset($_GET['id_cand'])) {
    $id_cand = $_GET['id_cand'];

    // Recupera os dados do candidato a partir do banco de dados
    $query = "SELECT id_cand, nome_cand FROM candidato WHERE id_cand = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id_cand);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $candidato = $result->fetch_assoc(); // Armazena os dados do candidato
    } else {
        echo "Candidato não encontrado.";
        exit();
    }

    $stmt->close();
}
?>

<div id="main" class="container-fluid">
 	<div id="top" class="row">
		<div class="col-md-11">
			<h2>ASO</h2>
		</div>

		<div class="col-md-1">
			<!-- Chama o Formulário para adicionar candidato -->
			<a href="?page=foradd_aso&id_cand=<?php echo isset($candidato['id_cand']) ? $candidato['id_cand'] : ''; ?>" class="btn btn-primary pull-right h2">Novo Agendamento</a> 
		</div>
	</div>
    <form action="?page=inserir_aso" method="post" enctype="multipart/form-data">
		<!-- 1ª LINHA -->	
		<div class="row"> 
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="id_cand">Matrícula</label>
				<input type="text" class="form-control" name="id_cand" value="<?php echo isset($candidato['id_cand']) ? $candidato['id_cand'] : ''; ?>" readonly>
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
				<label for="nome_cand">Candidato</label>
				<input type="text" class="form-control" name="nome_cand" value="<?php echo isset($candidato['nome_cand']) ? $candidato['nome_cand'] : ''; ?>">
			</div>			
			<div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="datacadastro">Cadastro</label>
				<input type="date" class="form-control" name="datacadastro" >
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="dataagenda">Agendamento</label>
				<input type="date" class="form-control" name="dataagenda">
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-2">
				<label for="status">Situação</label>
				<select class="form-control" name="status">
					<option value="AG">Aguardando</option>
					<option value="A">Apto</option>
					<option value="I">Inapto</option>
				</select>
			</div>
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
				<label for="asoimg"><b>ASO</b></label>
                <input type="file" name="asoimg" class="form-control" />
			</div>
		</div>	

        <hr />
		<div id="actions" class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-success" name="agendar">Agendar</button>
				<a href="?page=lista_aso" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
	</form>
</div>
