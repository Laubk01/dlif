<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];

   $update_query = $pdo->prepare("UPDATE carrito SET cantidad = :cantidad WHERE id = :id");
   $update_query->execute(array(':cantidad' => $cart_quantity, ':id' => $cart_id));

   $message[] = 'Se actualizó el carrito';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];

   $delete_query = $pdo->prepare("DELETE FROM carrito WHERE id = :id");
   $delete_query->execute(array(':id' => $delete_id));

   header('location:carrito.php');
}

if(isset($_GET['delete_all'])){

   $delete_all_query = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = :id_usuario");
   $delete_all_query->execute(array(':id_usuario' => $user_id));

   header('location:carrito.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrito</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/estilo2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>CARRITO DE COMPRAS</h3>
   <p> <a href="index.php">Inicio</a> / carrito </p>
</div>

<section class="shopping-cart">

   <h1 class="title">Se añadieron los productos</h1>

<div class="box-container">
      <?php
         $grand_total = 0;
         $stmt = $pdo->prepare("SELECT * FROM carrito WHERE id_usuario = :id_usuario");
         $stmt->bindParam(":id_usuario", $user_id);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
         if(count($result) > 0){
            foreach($result as $fetch_cart){   
      ?>
      <div class="box">
         <a href="carrito.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('¿Desea eliminar este artículo?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['imagen']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['nombre']; ?></div>
         <div class="price">$<?php echo $fetch_cart['precio']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['cantidad']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> Subtotal : <span>$<?php echo $sub_total = ($fetch_cart['cantidad'] * $fetch_cart['precio']); ?></span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Está vacío su carrito</p>';
      }
      ?>
   </div>


   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('¿Desea vaciar su carrito?');">Vaciar</a>
   </div>

   <div class="cart-total">
      <p>TOTAL : <span>$<?php echo $grand_total; ?></span></p>
      <div class="flex">
         <a href="menu.php" class="option-btn">Continue comprando</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceder a pagar</a>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>