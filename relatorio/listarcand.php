<div id="main" class="container">
    <h2>Candidatos</h2>
    <hr/>

    <div id="list">
        <div class="table-container">
            <?php
                include_once '../base/config.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status_cand'])) {
                    $status_cand = mysqli_real_escape_string($con, $_POST['status_cand']);

                    // Consulta de acordo com o status selecionado
                    if ($status_cand === 'Todos') {
                        $sql = "SELECT * FROM candidato WHERE status_cand IN ('Pendente', 'Validado')";
                    } else {
                        $sql = "SELECT * FROM candidato WHERE status_cand = '$status_cand'";
                    }

                    $result = $con->query($sql);

                    if ($result && $result->num_rows > 0) {
                        echo "<h2>Relatório Candidatos: " . htmlspecialchars($status_cand) . "</h2>";
                        echo "<table class='simple-table'>";
                        echo "<thead><tr><th>Matrícula</th><th>Nome</th><th>Email</th><th>Status</th></tr></thead>";
                        echo "<tbody>";

                        // Exibir cada linha da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_cand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome_cand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email_cand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status_cand']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";

                        // Formulário para gerar relatório
                        echo "<form action='gerarcandidato.php' method='POST' style='margin-top: 20px;'>";
                        echo "<input type='hidden' name='status_cand' value='" . htmlspecialchars($status_cand) . "'>";
                        echo "<input type='submit' value='Gerar Relatório'>";
                        echo "</form>";
                    } else {
                        echo "<p>Nenhum candidato encontrado.</p>";
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
