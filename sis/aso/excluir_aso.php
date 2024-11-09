<?php
$id = (int) $_GET['idaso'];
 
$sql_ficha = "delete from aso where idaso= $id;";
$resultado_ficha = mysqli_query($con, $sql_ficha);

$sql = "delete from candidato where id_cand = '$id';"; 
$resultado = mysqli_query($con, $sql)or die(mysqli_error());



if ($resultado) {
    header('Location: \projeto/dash.php?page=lista_aso&msg=3');
    mysqli_close($con);
}else{
    header('Location: \projeto/dash.php?page=lista_aso&msg=4');
    mysqli_close($con);
}
?>
