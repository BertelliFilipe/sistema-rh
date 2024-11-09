<div id="main" class="container-fluid">
	<div id="top" class="row">
		<div class="col-md-10">
			<h2>Vagas</h2>
		</div>

		<div class="col-md-2">
			<!-- Chama o Formulário para adicionar Vagas -->
			<a href="?page=fadd_vaga" class="btn btn-primary pull-right h2">Nova Vaga</a> 
		</div>
	</div>
	<hr/>
	<div><?php include "mensagens.php"; ?>	</div>
	<!--top - Lista dos Campos-->
		<div id="list" class="row">
			<div class="table-responsive">
				<?php
					$quantidade = 5;

					$pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
					$inicio = ($quantidade * $pagina) - $quantidade;

					$data_all = mysqli_query($con, "select * from vaga order by id asc limit $inicio, $quantidade;") or die(mysqli_error());
					
					echo "<table class='table table-striped' cellspacing='0' cellpading='0'>";
					echo "<thead><tr>";
					echo "<td><strong>ID</strong></td>"; 
					echo "<td><strong>Nome da Vaga</strong></td>"; 
					echo "<td class='d-none d-md-table-cell'><strong>Descrição</strong></td>";					
					echo "<td class='d-none d-md-table-cell'><strong>Data</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Status</strong></td>";
					echo "<td class='actions'><strong>Ações</strong></td>"; 
					echo "</tr></thead><tbody>";

					while($info = mysqli_fetch_array($data_all)){ 
						echo "<tr>";
						echo "<td>".$info['id']."</td>";
						echo "<td>".$info['nome']."</td>";
						echo "<td class='d-none d-md-table-cell'>".$info['descricao']." </td>";
						echo "<td class='d-none d-md-table-cell'>".$info['data']."</td>";
						echo "<td>".$info['status_vaga']."</td>";						
						echo "<td><div class='btn-group btn-group-xs'>";
						echo "<a class='btn btn-info btn-xs' href=?page=view_vaga&id=".$info['id']."> Detalhar </a>";
						echo "<a class='btn btn-warning btn-xs' href=?page=fedita_vaga&id=".$info['id']."> Editar </a>";
						echo "<a class='btn btn-danger btn-xs' href=?page=excluir_vaga&id=".$info['id']."> Excluir </a>";
						
					}
					echo "</tr></tbody></table>";
				?>				
			</div><!-- Div Table -->
		</div><!--list-->

		<!-- PAGINAÇÃO -->
		<div id="bottom" class="row">
			<div class="col-md-12">
				<?php
					$sqlTotal 		= "select id from vaga;";
					$qrTotal  		= mysqli_query($con, $sqlTotal) or die (mysqli_error());
					$numTotal 		= mysqli_num_rows($qrTotal);
					$totalpagina = (ceil($numTotal/$quantidade)<=0) ? 1 : ceil($numTotal/$quantidade);

					$exibir = 3;

					$anterior = (($pagina-1) <= 0) ? 1 : $pagina - 1;
					$posterior = (($pagina+1) >= $totalpagina) ? $totalpagina : $pagina+1;

					echo "<ul class='pagination'>";
					echo "<li class='page-item'><a class='page-link' href='?page=lista_vaga&pagina=1'> Primeira</a></li> "; 
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_vaga&pagina=$anterior\"> Anterior</a></li> ";

					echo "<li class='page-item'><a class='page-link' href='?page=lista_vaga&pagina=".$pagina."'><strong>".$pagina."</strong></a></li> ";

					for($i = $pagina+1; $i < $pagina+$exibir; $i++){
						if($i <= $totalpagina)
						echo "<li class='page-item'><a class='page-link' href='?page=lista_vaga&pagina=".$i."'> ".$i." </a></li> ";
					}

					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_vaga&pagina=$posterior\"> Pr&oacute;xima</a></li> ";
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_vaga&pagina=$totalpagina\"> &Uacute;ltima</a></li></ul>";

				?>	
			</div>
		</div><!--bottom-->
</div><!--main-->