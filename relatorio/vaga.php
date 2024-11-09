<?php
include_once 'base/config.php';

// Inicializa a variável para armazenar empresas
$vagas = [];

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['nome']) ? mysqli_real_escape_string($con, $_POST['nome']) : '';
    
    // Verifica se o nome da empresa foi fornecido
    if (empty($nome)) {
        // Se o campo estiver vazio, seleciona todas as empresas
        $sql = "SELECT DISTINCT nome FROM vaga";
    } else {
        // Caso contrário, seleciona empresas que correspondam ao texto fornecido
        $sql = "SELECT DISTINCT nome FROM vaga WHERE nome LIKE '%$nome%'";
    }

    $result = $con->query($sql);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $vagas[] = $row['nome'];
        }
    } else {
        echo "Erro na consulta: " . $con->error; // Exibe erro, se houver
    }
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
        <form action="relatorio/listarvaga.php" method="POST">
            <label for="nome"><b>Buscar Vaga:</b></label>
            <input type="text" name="nome" id="nome" placeholder="Digite o nome">
            <input type="submit" class="btn btn-primary" value="Listar">
        </form>
    </div>
    
    <!-- Exibe as empresas encontradas -->
    <?php if (!empty($vagas)): ?>
        <div class="col-md-12">
            <h3>Vagas Encontradas:</h3>
            <ul>
                <?php foreach ($vagas as $vaga): ?>
                    <li><?= htmlspecialchars($vaga) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
