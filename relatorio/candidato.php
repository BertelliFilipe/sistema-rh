<?php

    include_once 'base/config.php';

    // Consulta para obter os status dos candidatos
    $sql = "SELECT DISTINCT status_cand FROM candidato"; 
    $result = $con->query($sql);
    $situacoes = [];
    $situacoes[] = 'Todos'; 

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $situacoes[] = $row['status_cand']; // Armazena cada status em um array
        }
    } else {
        echo "Erro na consulta: " . $con->error; // Exibe erro, se houver
    }
?>

<div id="main" class="container-fluid">
 	<div id="top" class="row">
		<div class="col-md-11">
			<h2>Relatório</h2>
		</div>
	</div>
    <hr>
    <div class="col-md-4">
        <form action="relatorio/listarcand.php" method="POST">
            <label for="status_cand"><b>Selecione o Status:</label></b>
            <select name="status_cand" id="status_cand">
                <?php foreach ($situacoes as $status_cand): ?>
                    <option value="<?= htmlspecialchars($status_cand) ?>"><?= htmlspecialchars($status_cand) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" class="btn btn-primary" value="Listar">
        </form>
    </div>
</div>

