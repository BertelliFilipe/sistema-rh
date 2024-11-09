<?php
$id = (int) $_GET['id'];

$sql = "update usuario set ";
$sql .= "situacao='0' ";
$sql .= "where id = '".$id."';";

$resultado = mysqli_query($con, $sql)or die(mysqli_error($con));

if($resultado){
	header('Location: \projeto/dash.php?page=lista_usu&msg=3');
	mysqli_close($con);
}else{
	header('Location: \projeto/dash.php?page=lista_usu&msg=6');
	mysqli_close($con);
}

?>
