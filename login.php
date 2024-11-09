<!DOCTYPE html>
<html lang="en">
  <head>    
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
  
    <!-- Boxiocns CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <form action="validacao.php" method="post">
      <section class="ftco-section">
        <div class="container">			
        </div>
        <div class="row justify-content-center">
          <div class="col-md-4 col-lg-4">
            <div class="login-wrap p-4 p-md-5">
              <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-user-o"></span>
              </div>
              <h3 class="text-center mb-4">Você tem uma conta?</h3>
              <div class="form-group">
                <label for="txUsuario"></label>
                <!-- Preenche o campo com o valor anteriormente enviado -->
                <input type="text" name="usuario" id="txUsuario" maxlength="25" class="form-control rounded-left" placeholder="Usuário"> 
              </div>
              <div class="form-group d-flex">
                <label for="txSenha"></label>
                <!-- Preenche o campo com o valor anteriormente enviado -->
                <input type="password" name="senha" id="txSenha" class="form-control rounded-left" placeholder="Senha">
              </div>
              <div class="form-group d-md-flex">
                <div class="w-50">
                  <label class="checkbox-wrap checkbox-primary">Lembrar-me
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                  </label>
                </div>                
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Conectar</button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Scripts -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
    </form>
  </body>
</html>
