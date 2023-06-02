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

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-youtube"></a>
         </div>
         <p><a href="login.php">Iniciar sesión</a> | <a href="register.php">Registrarse</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="index.php" class="logo">D'LIF CAFETERÍA</a>

         <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="about.php">Acerca de Nosotros</a>
            <a href="menu.php">Menu</a>
            <a href="contacto.php">Contacto</a>
            <a href="ordenes.php">Ordenes</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $query = $pdo->prepare("SELECT COUNT(*) as count FROM carrito WHERE id_usuario = :id_usuario");
               $query->bindParam(':id_usuario', $user_id);
               $query->execute();
               $cart_rows_number = $query->fetch(PDO::FETCH_ASSOC)['count']; 
            ?>
            <a href="carrito.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>correo : <span><?php echo $_SESSION['correo']; ?></span></p>
            <a href="logout.php" class="delete-btn">Salir</a>
         </div>
      </div>
   </div>


</header>