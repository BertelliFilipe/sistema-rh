<?php
include_once 'base/config.php';

// Inicializa a variável para armazenar empresas
$empresas = [];

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_emp = isset($_POST['nome_emp']) ? mysqli_real_escape_string($con, $_POST['nome_emp']) : '';
    
    // Verifica se o nome da empresa foi fornecido
    if (empty($nome_emp)) {
        // Se o campo estiver vazio, seleciona todas as empresas
        $sql = "SELECT DISTINCT nome_emp FROM empresa";
    } else {
        // Caso contrário, seleciona empresas que correspondam ao texto fornecido
        $sql = "SELECT DISTINCT nome_emp FROM empresa WHERE nome_emp LIKE '%$nome_emp%'";
    }

    $result = $con->query($sql);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row['nome_emp'];
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
        <form action="relatorio/listaremp.php" method="POST">
            <label for="nome_emp"><b>Buscar Empresa:</b></label>
            <input type="text" name="nome_emp" id="nome_emp" placeholder="Digite o nome">
            <input type="submit" class="btn btn-primary" value="Listar">
        </form>
    </div>
    
    <!-- Exibe as empresas encontradas -->
    <?php if (!empty($empresas)): ?>
        <div class="col-md-12">
            <h3>Empresas Encontradas:</h3>
            <ul>
                <?php foreach ($empresas as $empresa): ?>
                    <li><?= htmlspecialchars($empresa) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
