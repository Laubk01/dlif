<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

    $name = $_POST['nombre'];
    $number = $_POST['numero'];
    $email = $_POST['correo'];
    $method = $_POST['metodo'];
    $address = 'flat no. '.$_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['country'].' - '.$_POST['pin_code'];
    $placed_on = date('d-M-Y');
   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $pdo->prepare("SELECT * FROM carrito WHERE id_usuario = :id_usuario");
   $cart_query->bindParam(':id_usuario', $user_id);
   $cart_query->execute();
   
   
   if($cart_query->rowCount() > 0){
      $cart_products = array();
      $cart_total = 0;
   
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['nombre'].' ('.$cart_item['cantidad'].')';
         $sub_total = ($cart_item['precio'] * $cart_item['cantidad']);
         $cart_total += $sub_total;
      }
   }
   

   $total_products = implode(', ', $cart_products);

   $order_query = $pdo->prepare("SELECT * FROM ordenes WHERE nombre = :nombre AND numero = :numero AND correo = :correo AND metodo = :metodo AND direccion = :direccion AND total_productos = :total_productos AND total_precio = :cart_total");
   $order_query->bindParam(':nombre', $name);
   $order_query->bindParam(':numero', $number);
   $order_query->bindParam(':correo', $email);
   $order_query->bindParam(':metodo', $method);
   $order_query->bindParam(':direccion', $address);
   $order_query->bindParam(':total_productos', $total_products);
   $order_query->bindParam(':cart_total', $cart_total);
   $order_query->execute();
   
   
   if ($cart_total == 0) {
      $message[] = 'Su carrito está vacío';
   } else {
      if ($order_query->rowCount() > 0) {
         $message[] = 'Pedido ya realizado';
      } else {
         $insert_query = $pdo->prepare("INSERT INTO ordenes (id_usuario, nombre, numero, correo, metodo, direccion, total_productos, total_precio, pedido)
                                        VALUES(:id_usuario, :nombre, :numero, :correo, :metodo, :direccion, :total_productos, :cart_total, :pedido)");
         $insert_query->bindParam(':id_usuario', $user_id);
         $insert_query->bindParam(':nombre', $name);
         $insert_query->bindParam(':numero', $number);
         $insert_query->bindParam(':correo', $email);
         $insert_query->bindParam(':metodo', $method);
         $insert_query->bindParam(':direccion', $address);
         $insert_query->bindParam(':total_productos', $total_products);
         $insert_query->bindParam(':cart_total', $cart_total);
         $insert_query->bindParam(':pedido', $placed_on);
         $insert_query->execute();
         
   
         $message[] = 'Pedido realizado exitosamente';
         $delete_query = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = :id_usuario");
         $delete_query->bindParam(':id_usuario', $user_id);
         $delete_query->execute();
      }
   }
   
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PAGO</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/estilo2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>FINALIZAR COMPRA</h3>
   <p> <a href="index.php">Inicio</a> / Realizar Pago </p>
</div>

<section class="display-order">

   <?php  
 $grand_total = 0;
 $select_cart = $pdo->prepare("SELECT * FROM carrito WHERE id_usuario = :id_usuario");
 $select_cart->bindParam('id_usuario', $user_id);
 $select_cart->execute();
 
   
     if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
           $total_price = ($fetch_cart['precio'] * $fetch_cart['cantidad']);
           $grand_total += $total_price;   
   ?>
   <p> <?php echo $fetch_cart['nombre']; ?> <span>(<?php echo '$'.$fetch_cart['precio'].' x '. $fetch_cart['cantidad']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Su carrito está vacío</p>';
   }
   ?>
   <div class="grand-total"> Total : <span>$<?php echo $grand_total; ?></span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Realiza tu pedido</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Ingresa tu nombre :</span>
            <input type="text" name="nombre" required placeholder="nombre">
         </div>
         <div class="inputBox">
            <span>Ingresa tu número :</span>
            <input type="number" name="numero" required placeholder="numero">
         </div>
         <div class="inputBox">
            <span>Ingresa tu correo :</span>
            <input type="email" name="correo" required placeholder="correo">
         </div>
         <div class="inputBox">
            <span>Metodo de pago</span>
            <select name="metodo">
               <option value="Pago en efectivo">Pagar en efectivo</option>
               <option value="Tarjeta de crédito">Tarjeta de credito</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Número de calle :</span>
            <input type="number" min="0" name="flat" required placeholder=" Calle #111">
         </div>
         <div class="inputBox">
            <span>Nombre de la calle</span>
            <input type="text" name="street" required placeholder="Benito Juarez">
         </div>
         <div class="inputBox">
            <span>Ciudad</span>
            <input type="text" name="city" value="La Piedad">
         </div>
         <div class="inputBox">
            <span>Estado</span>
            <input type="text" name="state" value="Michoacan">
         </div>
         <div class="inputBox">
            <span>País</span>
            <input type="text" name="country" required placeholder="México">
         </div>
         <div class="inputBox">
            <span>Código postal</span>
            <input type="number" min="0" name="pin_code" required placeholder="59374">
         </div>
      </div>
      <input type="submit" value="Realiza tu pedido" class="btn" name="order_btn">
   </form>

</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>