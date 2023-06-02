
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="css/admin_estilo.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<div class="form-container">

   <form action="" method="post">
      <h3>Iniciar Sesión</h3>
      <input type="email" name="correo" placeholder="Ingresa tu correo" required class="box">
      <input type="password" name="contrasena" placeholder="Contraseña" required class="box">
      <input type="submit" name="enviar" value="Iniciar sesión" class="btn">
      <p>¿No tienes una cuenta? <a href="login.php?action=register">Registrate ahora</a></p>
      <a href="login.php?action=forgot">¿Olvidaste tu contraseña?</a>
   </form>

</div>

</body>
</html>