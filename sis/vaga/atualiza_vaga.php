<?php
$id		  		= $_POST["id"];
$nome 			= $_POST["nome"];
$descricao		= $_POST["descricao"];
$data			= $_POST["data"];
$status_vaga    = $_POST["status_vaga"];

$sql = "update vaga set ";
$sql .= "nome='".$nome."', descricao='".$descricao."', data='".$data."', status_vaga='".$status_vaga."' ";
$sql .= "where id = '".$id."';";

$resultado = mysqli_query($con, $sql)or die(mysqli_error());

if($resultado){
	header('Location: \projeto/dash.php?page=lista_vaga&msg=2');
    mysqli_close($con);
}else{
	header('Location: \projeto/dash.php?page=lista_vaga&msg=6');
    mysqli_close($con);
}

?>
