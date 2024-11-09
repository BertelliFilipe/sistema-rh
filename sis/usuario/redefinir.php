<?php
include 'C:\xampp\htdocs\projeto\base/config.php';

// Verifica se a conexão foi estabelecida
if (!$con) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$token = $_GET['token'] ?? null;

// Verificar se o token é válido
if ($token) {
    // Consultar o banco de dados para verificar o token
    $stmt = $con->prepare("SELECT * FROM usuario WHERE reset_token = ? AND token_expiracao > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        // Exibir formulário para redefinição de senha
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nova_senha = $_POST['nova_senha'];

            // Hash da nova senha
            $senha_hash = sha1($nova_senha); // ou password_hash($nova_senha, PASSWORD_DEFAULT) se você preferir

            // Atualizar a senha no banco de dados
            $stmt_update = $con->prepare("UPDATE usuario SET senha = ?, reset_token = NULL, token_expiracao = NULL WHERE reset_token = ?");
            $stmt_update->bind_param("ss", $senha_hash, $token);
            $stmt_update->execute();

            // Verificar se a atualização foi bem-sucedida
            if ($stmt_update->affected_rows > 0) {
                header('Location: /projeto/login.php?msg=Senha atualizada com sucesso!');
                exit();
            } else {
                echo "Erro ao atualizar a senha.";
            }
        }
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    echo "Nenhum token fornecido.";
}
?>


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
  <form method="post">
  <section class="ftco-section">
    <div class="container">			
    </div>
    <div class="row justify-content-center">
      <div class="col-md-4 col-lg-4">
        <div class="login-wrap p-4 p-md-5">
          <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-user-o"></span>
          </div>
          <h3 class="text-center mb-4">Redefinir Senha</h3>
          <div class="form-group">
            <label for="nova_senha">Nova Senha: </label>
            <input type="password" id="nova_senha" name="nova_senha" required class="form-control">
          </div>
          <br>
          
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-align">Redefinir Senha</button>
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


