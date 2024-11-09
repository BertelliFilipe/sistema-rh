<div id="main" class="container-fluid">
    <div id="top" class="row">
        <div class="col-md-10">
            <h2>Agendamento ASO</h2>
        </div>        
    </div>
    <hr/>
    <div><?php include "mensagens.php"; ?></div>
    
    <!-- Lista dos Campos -->
    <div id="list" class="row">
        <div class="table-responsive">
            <?php
               include_once 'base/config.php'; 

                $quantidade = 5;
                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                $inicio = ($quantidade * $pagina) - $quantidade;

                // Consulta para buscar agendamentos de ASO e o nome do candidato
                $data_all = mysqli_query($con, "
                    SELECT aso.idaso, aso.datacadastro, aso.dataagenda, aso.status, aso.asoimg, candidato.id_cand, candidato.nome_cand
                    FROM aso
                    INNER JOIN candidato ON aso.id_cand = candidato.id_cand
                    ORDER BY aso.idaso ASC
                    LIMIT $inicio, $quantidade;
                ") or die(mysqli_error($con));

                echo "<table class='table table-striped' cellspacing='0' cellpadding='0'>";
                echo "<thead><tr>";
                echo "<td><strong>Matrícula</strong></td>";
                echo "<td><strong>Candidato</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Cadastro</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Agendamento</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Situação</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Documento ASO</strong></td>";
                echo "<td class='actions'><strong>Ações</strong></td>";
                echo "</tr></thead><tbody>";

                // Exibe os dados dos agendamentos de ASO
                while ($info = mysqli_fetch_array($data_all)) {
                    echo "<tr>";
                    echo "<td>" . $info['id_cand'] . "</td>";
                    echo "<td>" . $info['nome_cand'] . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . date('d/m/Y', strtotime($info['datacadastro'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . date('d/m/Y', strtotime($info['dataagenda'])) . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . ($info['status'] == 'A' ? 'Apto' : ($info['status'] == 'I' ? 'Inapto' : 'Aguardando')) . "</td>";
                    echo "<td class='d-none d-md-table-cell'><a href='uploads/" . $info['asoimg'] . "' target='_blank'>Ver Documento</a></td>";
                    echo "<td><div class='btn-group btn-group-xs'>";
                    echo "<a class='btn btn-primary btn-xs' href='?page=fedit_aso&idaso=" . $info['idaso'] . "'>Editar</a>";
                    echo "<a class='btn btn-danger btn-xs' href='?page=excluir_aso&idaso=" . $info['idaso'] . "'>Excluir</a>";
                    echo "</div></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            ?>
        </div><!-- Table -->
    </div><!-- List -->

    <!-- Paginação -->
    <div id="bottom" class="row">
        <div class="col-md-12">
            <?php
                $sqlTotal = "SELECT idaso FROM aso;";
                $qrTotal = mysqli_query($con, $sqlTotal) or die (mysqli_error($con));
                $numTotal = mysqli_num_rows($qrTotal);
                $totalpagina = (ceil($numTotal / $quantidade) <= 0) ? 1 : ceil($numTotal / $quantidade);

                $exibir = 3;
                $anterior = (($pagina - 1) <= 0) ? 1 : $pagina - 1;
                $posterior = (($pagina + 1) >= $totalpagina) ? $totalpagina : $pagina + 1;

                echo "<ul class='pagination'>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=1'>Primeira</a></li>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=$anterior'>Anterior</a></li>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=$pagina'><strong>$pagina</strong></a></li>";

                for ($i = $pagina + 1; $i < $pagina + $exibir; $i++) {
                    if ($i <= $totalpagina)
                        echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=$i'>$i</a></li>";
                }

                echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=$posterior'>Próxima</a></li>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_aso&pagina=$totalpagina'>Última</a></li>";
                echo "</ul>";
            ?>
        </div>
    </div><!-- bottom -->
</div><!-- main -->
