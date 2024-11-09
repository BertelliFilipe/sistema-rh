<?php
	$nivel_necessario = 1;
	include "base/testa_nivel.php";
?>
<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxiocns CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <!-- sidebar -->
  <div class="sidebar close">
    <?php
      switch($_SESSION['UsuarioNivel']){
		  case 1: include "base/sidebarcand.php"; break;
		  case 2: include "base/sidebarvalid.php"; break;
		  case 3: include "base/sidebaradm.php"; break;
	  }	
    ?>
  </div>
  
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
      <span class="text">Bem-vindo, <?php echo $_SESSION['UsuarioNome']; ?>!</span>
        <!-- Link de Logout -->
        <span style="margin-left: 20px;"></span> <!-- Espaço -->   
      <a href="logout.php" class="btn btn-danger float-right">Desconectar</a>
    </div>

    <?php
      include "base/config.php";
      include "base/ch_pages.php";
    ?>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
  <script src="js/mascara.js"></script>
  <script src="js/dash.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
<?php ob_end_flush(); ?>