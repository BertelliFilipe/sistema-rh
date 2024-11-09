<?php
    $id = (int) $_GET['id'];
 
    $sql = "delete from vaga where id = '$id';"; 

    $resultado = mysqli_query($con, $sql)or die(mysqli_error());

    if ($resultado) {
        header('Location: \projeto/dash.php?page=lista_vaga&msg=3');
        mysqli_close($con);
    }else{
        header('Location: \projeto/dash.php?page=lista_vaga&msg=4');
        mysqli_close($con);
    }
?>
