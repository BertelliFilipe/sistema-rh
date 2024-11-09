<div id="main" class="container">
    <h2>Empresas</h2>
    <hr/>

    <div id="list">
        <div class="table-container">
            <?php
                include_once '../base/config.php';

                // Verifica se o formulário foi enviado
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome_emp'])) {
                    $nome_emp = mysqli_real_escape_string($con, $_POST['nome_emp']);

                    // Consulta de acordo com a empresa selecionada
                    $sql = "SELECT * FROM empresa WHERE nome_emp LIKE '%$nome_emp%'";
                    $result = $con->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo "<h2>Empresas Encontradas: " . htmlspecialchars($nome_emp) . "</h2>";
                        echo "<table class='simple-table'>";
                        echo "<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th></tr></thead>";
                        echo "<tbody>";

                        // Exibir cada linha da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_emp']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome_emp']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email_emp']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telefone_emp']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";

                        // Formulário para gerar relatório (opcional, se aplicável)
                        echo "<form action='gerarempresa.php' method='POST' style='margin-top: 20px;'>";
                        echo "<input type='hidden' name='nome_emp' value='" . htmlspecialchars($nome_emp) . "'>";
                        echo "<input type='submit' value='Gerar Relatório'>";
                        echo "</form>";
                    } else {
                        echo "<p>Nenhuma empresa encontrada.</p>";
                    }
                } else {
                    echo "<p>Por favor, busque uma empresa.</p>";
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
