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

<header class="header">

   <div class="flex">
    <a href="qr.php" class="logo">ADMINISTRADOR</a>

      <nav class="navbar">
         <a href="admin_index.php">Inicio</a>
         <a href="admin/views/productos/productos.php">Menú</a>
         <a href="admin/views/productos/ordenes.php">Ordenes</a>
         <a href="admin/views/productos/usuario.php">Usuarios</a>
         <a href="admin/views/productos/contactos.php">Comentarios</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
      <p>correo: <span><?php echo $_SESSION['correo']; ?></span></p>
         <a href="logout.php" class="delete-btn">Salir</a>
         <div>login <a href="login.php">Ingresar</a> | <a href="register.php">Registrarse</a></div>
      </div>

   </div>

</header>