<div id="main" class="container-fluid">
    <div id="top" class="row">
        <div class="col-md-10">
            <h2>Ficha Cadastral</h2>
        </div>
    </div>
    <hr/>
    <div><?php include "mensagens.php"; ?></div>
    
    <!-- Lista dos Campos -->
    <div id="list" class="row">
        <div class="table-responsive">
            <?php
                $quantidade = 5;
                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                $inicio = ($quantidade * $pagina) - $quantidade;

                // Consulta para buscar candidatos
                $data_all = mysqli_query($con, "SELECT * FROM candidato ORDER BY id_cand ASC LIMIT $inicio, $quantidade;") or die(mysqli_error($con));

                echo "<table class='table table-striped' cellspacing='0' cellpadding='0'>";
                echo "<thead><tr>";
                echo "<td><strong>Matrícula</strong></td>";
                echo "<td><strong>Nome do candidato</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Cadastro</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>E-mail</strong></td>";
                echo "<td class='d-none d-md-table-cell'><strong>Status</strong></td>";
                echo "<td class='actions'><strong>Ações</strong></td>";
                echo "</tr></thead><tbody>";

                // Exibe os dados dos candidatos
                while($info = mysqli_fetch_array($data_all)){
                    echo "<tr>";
                    echo "<td>".$info['id_cand']."</td>";
                    echo "<td>".$info['nome_cand']."</td>";
                    echo "<td class='d-none d-md-table-cell'>".date('d/m/Y', strtotime($info['data_cad_cand']))."</td>";
                    echo "<td class='d-none d-md-table-cell'>".$info['email_cand']."</td>";
                    echo "<td class='d-none d-md-table-cell'>".$info['status_cand']."</td>";
                    echo "<td><div class='btn-group btn-group-xs'>";
                    echo "<a class='btn btn-success' href='javascript:void(0);' onclick='confirmValidar(" . $info['id_cand'] . ")'>Validar</a>";
                    echo "<a class='btn btn-secondary btn-xs' href='?page=foradd_ficha&id_cand=".$info['id_cand']."'>Ficha</a>";
                    echo "<a class='btn btn-warning btn-xs' href='?page=foradd_aso&id_cand=".$info['id_cand']."&nome_cand=".urlencode($info['nome_cand'])."'>ASO</a>";
                    echo "<a class='btn btn-danger' href='javascript:void(0);' onclick='confirmDesistir(" . $info['id_cand'] . ")'>Desistir</a>";
                    echo "</div></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            ?>
        </div><!-- Table -->
    </div><!-- List -->

    <script>
        // Função para confirmar validação
        function confirmValidar(id_cand) {
            console.log("id_cand: " + id_cand);  // Verificando o ID do candidato
            if (confirm("Tem certeza de que deseja validar esta ficha?")) {
                // Redirecionando para a página de validação no PHP
                window.location.href = "sis/ficha/validar_ficha.php?id_cand=" + id_cand;
            }
        }
    </script>

    <script>
        // Função para confirmar desistência
        function confirmDesistir(id_cand) {
            console.log("id_cand: " + id_cand);  // Verificando o ID do candidato
            if (confirm("Tem certeza de que deseja desistir da vaga?")) {
                window.location.href = "sis/ficha/desistir_ficha.php?id_cand=" + id_cand;
            }
        }
    </script>

    <!-- PAGINAÇÃO -->
    <div id="bottom" class="row">
        <div class="col-md-12">
            <?php
                $sqlTotal = "SELECT id_cand FROM candidato;";
                $qrTotal = mysqli_query($con, $sqlTotal) or die (mysqli_error($con));
                $numTotal = mysqli_num_rows($qrTotal);
                $totalpagina = (ceil($numTotal / $quantidade) <= 0) ? 1 : ceil($numTotal / $quantidade);

                $exibir = 3;
                $anterior = (($pagina - 1) <= 0) ? 1 : $pagina - 1;
                $posterior = (($pagina + 1) >= $totalpagina) ? $totalpagina : $pagina + 1;

                echo "<ul class='pagination'>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=1'> Primeira</a></li>";
                echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$anterior\"> Anterior</a></li>";
                echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=".$pagina."'><strong>".$pagina."</strong></a></li>";

                for($i = $pagina + 1; $i < $pagina + $exibir; $i++){
                    if($i <= $totalpagina)
                        echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=".$i."'> ".$i." </a></li>";
                }

                echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$posterior\"> Próxima</a></li>";
                echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$totalpagina\"> Última</a></li></ul>";
            ?>
        </div>
    </div><!-- bottom -->
</div><!-- main -->
