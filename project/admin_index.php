<?php

include 'configprueba.php';

session_start();

$admin_id = $_SESSION['id_usuario'];

if(!isset($admin_id)){
   header('location: /login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ADMINISTRADOR</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_estilo.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- Dashboard de ADMINISTRADOR  -->

<section class="dashboard">

   <h1 class="title">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $ordenes_pendientes = 0;
            $pendiente = $pdo->query("SELECT total_precio FROM `ordenes` WHERE estado = 'pendiente'");
            while($fetch_pendings = $pendiente->fetch()){
               $total_precio = $fetch_pendings['total_precio'];
               $ordenes_pendientes += $total_precio;
            };
         ?>
         <h3>$<?php echo $ordenes_pendientes; ?>/-</h3>
         <p>Ordenes pendientes</p>
      </div>

      <div class="box">
         <?php
            $total_completed = 0;
            $select_completed = $pdo->query("SELECT total_precio FROM `ordenes` WHERE estado = 'completado'");
            while($fetch_completed = $select_completed->fetch()){
               $total_precio = $fetch_completed['total_precio'];
               $total_completed += $total_precio;
            };
         ?>
         <h3>$<?php echo $total_completed; ?>/-</h3>
         <p>Pagos realizados</p>
      </div>

      <div class="box">
         <?php 
            $select_orders = $pdo->query("SELECT * FROM `ordenes`");
            $number_of_orders = $select_orders->rowCount();
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Pedido realizado</p>
      </div>

      <div class="box">
         <?php 
            $select_products = $pdo->query("SELECT * FROM `productos`");
            $number_of_products = $select_products->rowCount();
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>Platillos</p>
      </div>

      <div class="box">
         <?php 
            $select_users = $pdo->query("SELECT * FROM usuario u  left join
                                        rol_usuario ru on ru.id_usuario = u.id_usuario
                                        left join rol r on r.id_rol = ru.id_rol
                                         WHERE r.rol= 'Usuario'");
            $number_of_users = $select_users->rowCount();
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>Clientes</p>
      </div>

      <div class="box">
         <?php 
            $select_admins = $pdo->query("SELECT * FROM usuario u  left join
                                         rol_usuario ru on ru.id_usuario = u.id_usuario
                                          left join rol r on r.id_rol = ru.id_rol
                                          WHERE r.rol= 'Lider'");
            $number_of_admins = $select_admins->rowCount();
         ?>
         <h3><?php echo $number_of_admins; ?></h3>

         <p> Administradores</p>
      </div>

      <div class="box">
         <?php 
            $select_account = $pdo->query("SELECT * FROM `usuario`");
            $number_of_account = $select_account->rowCount();
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p>Usuarios</p>
      </div>

   
      <div class="box">
         <?php 
            $select_messages = $pdo->query("SELECT * FROM mensaje");
            $number_of_messages = $select_messages->rowCount();
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>Mensajes</p>
      </div>

   </div>

</section>
<script src="js/admin_script.js"></script>

</body>
</html>