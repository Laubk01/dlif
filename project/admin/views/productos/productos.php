
<?php

include '../../../configprueba.php';

session_start();

$admin_id = $_SESSION['id_usuario'];

if(!isset($admin_id)){
   header('location:../../../login.php');
};



if(isset($_POST['add_product'])){
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $image_size = $_FILES['imagen']['size'];
    $image_tmp_name = $_FILES['imagen']['tmp_name'];
    $image_folder = '../../../uploaded_img/'.$imagen;
 
    $select_product_name = $pdo->prepare("SELECT nombre FROM productos WHERE nombre = :nombre");
    $select_product_name->bindParam(':nombre', $nombre);
    $select_product_name->execute();
 
    if($select_product_name->rowCount() > 0){
       $message[] = 'Ese platillo ya existe';
    }else{
       $add_product_query = $pdo->prepare("INSERT INTO productos(nombre, precio, imagen) VALUES(:nombre, :precio, :imagen)");
       $add_product_query->bindParam(':nombre', $nombre);
       $add_product_query->bindParam(':precio', $precio);
       $add_product_query->bindParam(':imagen', $imagen);
 
       if($add_product_query->execute()){
          if($image_size > 2000000){
             $message[] = 'La imagen es muy pesada';
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);
             $message[] = 'El platillo se ha agregado';
          }
       }else{
          $message[] = 'No se pudo agregar el platillo';
       }
    }
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT imagen FROM productos WHERE id = :delete_id");
    $stmt->execute(array(':delete_id' => $delete_id));
    $fetch_delete_image = $stmt->fetch();
    unlink('../../../uploaded_img/'.$fetch_delete_image['imagen']);
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :delete_id");
    $stmt->execute(array(':delete_id' => $delete_id));
    header('productos.php');
 }
 
 
 if(isset($_POST['update_product'])){
 
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
 
    $stmt = $conn->prepare("UPDATE productos SET nombre = :nombre, precio = :precio WHERE id = :id");
    $stmt->bindParam(':nombre', $update_name);
    $stmt->bindParam(':precio', $update_price);
    $stmt->bindParam(':id', $update_p_id);
    $stmt->execute();
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = '../../../uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image file size is too large';
       }else{
          $stmt = $conn->prepare("UPDATE `productos` SET imagen = :imagen WHERE id = :id");
          $stmt->bindParam(':imagen', $update_image);
          $stmt->bindParam(':id', $update_p_id);
          $stmt->execute();
 
          move_uploaded_file($update_image_tmp_name, $update_folder);
          unlink('../../../uploaded_img/'.$update_old_image);
       }
    }
 
    header('location:productos.php');
 
 }
 
 
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../css/admin_estilo.css">
 
 </head>
 <body>
    
 <?php include '../../../admin_header.php'; ?>
 
 
 <section class="add-products">
 
    <h1 class="title">MENÚ</h1>
 
    <form action="" method="post" enctype="multipart/form-data">
       <h3>AGREGAR PLATILLOS</h3>
       <input type="text" name="nombre" class="box" placeholder="nombre del platillo" required>
       <input type="number" min="0" name="precio" class="box" placeholder="precio del platillo" required>
       <input type="file" name="imagen" accept="image/jpg, image/jpeg, image/png" class="box" required>
       <input type="submit" value="añadir platillo" name="add_product" class="btn">
    </form>
 
 </section>

 
 <section class="show-products">
 
    <div class="box-container">
 
    <?php
      $select_products = $pdo->query("SELECT * FROM productos");
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <img src="../../../uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['nombre']; ?></div>
      <div class="price">$<?php echo $fetch_products['precio']; ?></div>
      <a href="productos.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Modificar</a>
      <a href="productos.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea eliminar este producto?');">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay platillos todavía</p>';
      }
   ?>
 
    </div>
 
 </section>
 
 <section class="edit-product-form">
    <?php
       if(isset($_GET['update'])){
          $update_id = $_GET['update'];
          $update_query = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
          $update_query->execute(['id' => $update_id]);
          if($update_query->rowCount() > 0){
             $fetch_update = $update_query->fetch();
    ?>
    <form action="" method="post" enctype="multipart/form-data">
       <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
       <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['imagen']; ?>">
       <img src="../../../uploaded_img/<?php echo $fetch_update['imagen']; ?>" alt="">
       <input type="text" name="update_name" value="<?php echo $fetch_update['nombre']; ?>" class="box" required placeholder="nombre del platillo">
       <input type="number" name="update_price" value="<?php echo $fetch_update['precio']; ?>" min="0" class="box" required placeholder="precio del platillo">
       <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
       <input type="submit" value="guardar" name="update_product" class="btn">
       <input type="reset" value="cancelar" id="close-update" class="option-btn">
    </form>
    <?php
          }
       }else{
          echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
       }
    ?>
 </section>
 <script src="../js/admin_script.js"></script>
 
 </body>
 </html>