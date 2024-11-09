<div id="main" class="container-fluid">
	<div id="top" class="row">
		<div class="col-md-10">
			<h2>Usuários</h2>
		</div>

		<div class="col-md-2">
			
			<a href="?page=foradd_usu" class="btn btn-primary pull-right h2">Novo Usuário</a> 
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

					$data_all = mysqli_query($con, "select * from usuario order by id asc limit $inicio, $quantidade;") or die(mysqli_error());

					echo "<table class='table table-striped' cellspacing='0' cellpading='0'>";
					echo "<thead><tr>";
					echo "<td><strong>ID</strong></td>"; 
					echo "<td><strong>Nome do usuário</strong></td>"; 
					echo "<td><strong>Usuário</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Senha</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>E-mail</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Nível</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Situação</strong></td>";
					echo "<td class='d-none d-md-table-cell'><strong>Data cadastro</strong></td>";
					echo "<td class='actions'><strong>Ações</strong></td>"; 
					echo "</tr></thead><tbody>";

					while($info = mysqli_fetch_array($data_all)){ 
						echo "<tr>";
						echo "<td>".$info['id']."</td>";
						echo "<td>".$info['nome']."</td>";
						echo "<td>".$info['usuario']."</td>";
						echo "<td class='d-none d-md-table-cell'>".$info['senha']."</td>";
						echo "<td class='d-none d-md-table-cell'>".$info['email']." </td>";
						echo "<td class='d-none d-md-table-cell'>".$info['nivel']."</td>";
						if($info['situacao'] == 1){
							echo "<td class='d-none d-md-table-cell'>SIM</td>";
						}else if($info['situacao'] == 0){
							echo "<td class='d-none d-md-table-cell'>NÃO</td>";
						}
						echo "<td class='d-none d-md-table-cell'>".date('d/m/Y',strtotime($info['dt_cadastro']))."</td>";
						echo "<td><div class='btn-group btn-group-xs'>";
						echo "<a class='btn btn-info btn-xs' href=?page=view_usu&id=".$info['id']."> Detalhar </a>";
						echo "<a class='btn btn-warning btn-xs' href=?page=fedit_usu&id=".$info['id']."> Editar </a>";
						if($info['situacao'] == 1){
							echo "<a class='btn btn-danger btn-xs'  href=?page=block_usu&id=".$info['id']."> Bloquear </a>";
						}else if($info['situacao'] == 0){
							echo "<a class='btn btn-success btn-xs'  href=?page=ativa_usu&id=".$info['id'].">&nbsp;&nbsp;&nbsp;Ativar&nbsp;&nbsp;</a></div></td>";
						}
					}
					echo "</tr></tbody></table>";
				?>				
			</div><!-- Div Table -->
		</div><!--list-->

		<!-- PAGINAÇÃO -->
		<div id="bottom" class="row">
			<div class="col-md-12">
				<?php
					$sqlTotal 		= "select id from usuario;";
					$qrTotal  		= mysqli_query($con, $sqlTotal) or die (mysqli_error());
					$numTotal 		= mysqli_num_rows($qrTotal);
					$totalpagina = (ceil($numTotal/$quantidade)<=0) ? 1 : ceil($numTotal/$quantidade);

					$exibir = 3;

					$anterior = (($pagina-1) <= 0) ? 1 : $pagina - 1;
					$posterior = (($pagina+1) >= $totalpagina) ? $totalpagina : $pagina+1;

					echo "<ul class='pagination'>";
					echo "<li class='page-item'><a class='page-link' href='?page=lista_usu&pagina=1'> Primeira</a></li> "; 
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_usu&pagina=$anterior\"> Anterior</a></li> ";

					echo "<li class='page-item'><a class='page-link' href='?page=lista_usu&pagina=".$pagina."'><strong>".$pagina."</strong></a></li> ";

					for($i = $pagina+1; $i < $pagina+$exibir; $i++){
						if($i <= $totalpagina)
						echo "<li class='page-item'><a class='page-link' href='?page=lista_usu&pagina=".$i."'> ".$i." </a></li> ";
					}

					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_usu&pagina=$posterior\"> Pr&oacute;xima</a></li> ";
					echo "<li class='page-item'><a class='page-link' href=\"?page=lista_usu&pagina=$totalpagina\"> &Uacute;ltima</a></li></ul>";

				?>	
			</div>
		</div><!--bottom-->
</div><!--main-->