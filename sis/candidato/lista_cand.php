<div id="main" class="container-fluid">
	<div id="top" class="row">
		<div class="col-md-10">
			<h2>Candidatos</h2>
		</div>

		<div class="col-md-2">
			<!-- Chama o Formulário para adicionar alunos -->
			<a href="?page=foradd" class="btn btn-primary pull-right h2">Novo Candidato</a> 
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

					$data_all = mysqli_query($con, "select * from candidato order by id_cand asc limit $inicio, $quantidade;") or die(mysqli_error());

					echo "<table class='table table-striped' cellspacing='0' cellpading='0'>";
					echo "<thead><tr>";
					echo "<td><strong>Matrícula</strong></td>"; 
					echo "<td><strong>Nome do candidato</strong></td>"; 
					echo "<td class='d-none d-md-table-cell'><strong>Cadastro</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Nascimento</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Sexo</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>E-mail</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Status</strong></td>";
					echo "<td class='actions'><strong>Ações</strong></td>"; 
					echo "</tr></thead><tbody>";

					while($info = mysqli_fetch_array($data_all)){ 
						echo "<tr>";
						echo "<td>".$info['id_cand']."</td>";
						echo "<td>".$info['nome_cand']."</td>";
						echo "<td class='d-none d-md-table-cell'>".date('d/m/Y',strtotime($info['data_cad_cand']))."</td>";
						echo "<td class='d-none d-md-table-cell'>".date('d/m/Y',strtotime($info['data_nasc_cand']))."</td>";
						echo "<td class='d-none d-md-table-cell'>".$info['sexo_cand']." </td>";
						echo "<td class='d-none d-md-table-cell'>".$info['email_cand']." </td>";
						echo "<td class='d-none d-md-table-cell'>".$info['status_cand']." </td>";								
						echo "<td><div class='btn-group btn-group-xs'>";
						echo "<a class='btn btn-info btn-success' href=?page=view_cand&id_cand=".$info['id_cand']."> Detalhar </a>";
						echo "<a class='btn btn-warning btn-xs' href=?page=fedit_cand&id_cand=".$info['id_cand']."> Editar </a>";
						echo "<a class='btn btn-danger btn-danger' href=?page=excluir_cand&id_cand=".$info['id_cand']."> Excluir </a>";
						echo "<a class='btn btn-secondary btn-secondary' href=?page=foradd_ficha&id_cand=".$info['id_cand']."> Ficha </a>";
						
					}
					
					echo "</tr></tbody></table>";
				?>				
			</div><!-- Div Table -->
		</div><!--list-->

		<!-- PAGINAÇÃO -->
		<div id="bottom" class="row">
			<div class="col-md-12">
				<?php
					$sqlTotal 		= "select id_cand from candidato;";
					$qrTotal  		= mysqli_query($con, $sqlTotal) or die (mysqli_error());
					$numTotal 		= mysqli_num_rows($qrTotal);
					$totalpagina = (ceil($numTotal/$quantidade)<=0) ? 1 : ceil($numTotal/$quantidade);

					$exibir = 3;

					$anterior = (($pagina-1) <= 0) ? 1 : $pagina - 1;
					$posterior = (($pagina+1) >= $totalpagina) ? $totalpagina : $pagina+1;

					echo "<ul class='pagination'>";
					echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=1'> Primeira</a></li> "; 
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$anterior\"> Anterior</a></li> ";

					echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=".$pagina."'><strong>".$pagina."</strong></a></li> ";

					for($i = $pagina+1; $i < $pagina+$exibir; $i++){
						if($i <= $totalpagina)
						echo "<li class='page-item'><a class='page-link' href='?page=lista_cand&pagina=".$i."'> ".$i." </a></li> ";
					}

					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$posterior\"> Pr&oacute;xima</a></li> ";
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_cand&pagina=$totalpagina\"> &Uacute;ltima</a></li></ul>";

				?>	
			</div>
		</div><!--bottom-->
</div><!--main-->