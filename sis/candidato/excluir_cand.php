<?php
$id = (int) $_GET['id_cand'];
 
$sql_endereco = "delete from endereco where id_cand = $id;";
$resultado_endereco = mysqli_query($con, $sql_endereco);

$sql = "delete from candidato where id_cand = '$id';"; 
$resultado = mysqli_query($con, $sql)or die(mysqli_error());



if ($resultado) {
    header('Location: \projeto/dash.php?page=lista_cand&msg=3');
    mysqli_close($con);
}else{
    header('Location: \projeto/dash.php?page=lista_cand&msg=4');
    mysqli_close($con);
}
?>
