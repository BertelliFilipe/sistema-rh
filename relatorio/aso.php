<?php
    include_once 'base/config.php';

    // Consulta para obter os status disponíveis na tabela "aso"
    $sql = "SELECT DISTINCT status FROM aso";
    $result = $con->query($sql);

    // Inicializa o array de situações com a opção "Todos"
    $situacoes = ['Todos'];

    // Verifica se a consulta foi bem-sucedida
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $situacoes[] = $row['status']; // Armazena cada status em um array
        }
    } else {
        echo "Erro na consulta: " . $con->error; // Exibe erro, se houver
    }
?>

<div id="main" class="container-fluid">
    <div id="top" class="row">
        <div class="col-md-11">
            <h2>Relatório de ASO</h2>
        </div>
    </div>
    <hr>
    <div class="col-md-4">
    <form action="relatorio/listaraso.php" method="POST">
            <label for="status"><b>Selecione o Status:</label></b>
            <select name="status" id="status">
                <?php foreach ($situacoes as $status): ?>
                    <option value="<?= htmlspecialchars($status) ?>"><?= htmlspecialchars($status) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" class="btn btn-primary" value="Listar">
        </form>
    </div>
</div>
