<div id="main" class="container">
    <h2>Empresas</h2>
    <hr/>

    <div id="list">
        <div class="table-container">
            <?php
                include_once '../base/config.php';

                // Verifica se o formulário foi enviado
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
                    $nome = mysqli_real_escape_string($con, $_POST['nome']);

                    // Consulta de acordo com a empresa selecionada
                    $sql = "SELECT * FROM vaga WHERE nome LIKE '%$nome%'";
                    $result = $con->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo "<h2>Vagas Encontradas: " . htmlspecialchars($nome) . "</h2>";
                        echo "<table class='simple-table'>";
                        echo "<thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Data</th></tr></thead>";
                        echo "<tbody>";

                        // Exibir cada linha da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['data']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";

                        // Formulário para gerar relatório (opcional, se aplicável)
                        echo "<form action='gerarvaga.php' method='POST' style='margin-top: 20px;'>";
                        echo "<input type='hidden' name='nome' value='" . htmlspecialchars($nome) . "'>";
                        echo "<input type='submit' value='Gerar Relatório'>";
                        echo "</form>";
                    } else {
                        echo "<p>Nenhuma vaga encontrada.</p>";
                    }
                } else {
                    echo "<p>Por favor, busque uma vaga.</p>";
                }
            ?>
        </div><!-- Div Table -->
    </div><!-- list -->
</div><!-- main -->

<!-- Estilo CSS Simples -->
<style>
    .container {
        width: 80%;
        margin: auto;
    }
    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }
    .simple-table th, .simple-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .simple-table th {
        background-color: #f2f2f2;
        text-align: left;
    }
    .simple-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .simple-table tr:hover {
        background-color: #f1f1f1;
    }
    h2 {
        margin-bottom: 10px;
    }
    form {
        margin-top: 20px;
    }
</style>
