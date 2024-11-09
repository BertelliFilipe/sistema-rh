<div id="main" class="container">
    <h2>ASO</h2>
    <hr/>

    <div id="list">
        <div class="table-container">
            <?php
                include_once '../base/config.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
                    $status = mysqli_real_escape_string($con, $_POST['status']);

                    // Consulta para obter dados das tabelas candidato e aso
                    if ($status === 'Todos') {
                        $sql = "SELECT c.id_cand, c.nome_cand, a.dataagenda, a.status 
                                FROM candidato c 
                                JOIN aso a ON c.id_cand = a.id_cand 
                                WHERE a.status IN ('apto', 'inapto')";
                    } else {
                        $sql = "SELECT c.id_cand, c.nome_cand, a.dataagenda, a.status 
                                FROM candidato c 
                                JOIN aso a ON c.id_cand = a.id_cand 
                                WHERE a.status = '$status'";
                    }

                    $result = $con->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo "<h2>Relatório ASO: " . htmlspecialchars($status) . "</h2>";
                        echo "<table class='simple-table'>";
                        echo "<thead><tr><th>Matrícula</th><th>Nome</th><th>Data de Agendamento</th><th>Status</th></tr></thead>";
                        echo "<tbody>";

                        // Exibir cada linha da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_cand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome_cand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dataagenda']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";

                        // Formulário para gerar relatório
                        echo "<form action='geraraso.php' method='POST' style='margin-top: 20px;'>";
                        echo "<input type='hidden' name='status' value='" . htmlspecialchars($status) . "'>";
                        echo "<input type='submit' value='Gerar Relatório'>";
                        echo "</form>";
                    } else {
                        echo "<p>Nenhum ASO encontrado.</p>";
                    }
                } else {
                    echo "<p>Por favor, selecione um status.</p>";
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
