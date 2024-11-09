<?php
	$nome 			= $_POST["nome"];
	$descricao		= $_POST["descricao"];	
	$data			= $_POST["data"];
	$status_vaga	= $_POST["status_vaga"];

	$sql = "insert into vaga values ";
	$sql .= "('0','$nome', '$descricao', '$data' '".date('Y-m-d')."'), '$status_vaga';";

	$resultado = mysqli_query($con, $sql) or die(mysqli_error($con));

	if($resultado){
		header('Location: \projeto/dash.php?page=lista_vaga&msg=1');
		mysqli_close($con);
	}else{
		header('Location: \projeto/dash.php?page=lista_vaga&msg=6');
		mysqli_close($con);
	}
?>