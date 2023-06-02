<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = $pdo->prepare("SELECT * FROM carrito WHERE nombre = :product_name AND id_usuario = :user_id");
    $check_cart_numbers->execute(array(':product_name' => $product_name, ':user_id' => $user_id));

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Ya está agregado en el carrito';
    } else {
        $insert_query = $pdo->prepare("INSERT INTO carrito (id_usuario, nombre, precio, cantidad, imagen) 
        VALUES (:user_id, :product_name, :product_price, :product_quantity, :product_image)");

$insert_query->execute(array(
':user_id' => $user_id,
':product_name' => $product_name,
':product_price' => $product_price,
':product_quantity' => $product_quantity,
':product_image' => $product_image
));

        $message[] = 'Se añadió al carrito';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilo2.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>NUESTRO MENÚ</h3>
        <p> <a href="index.php">Inicio</a> / Menú </p>
    </div>

    <section class="products">

        <h1 class="title">Especialidades</h1>

        <div class="box-container">

        <?php
      $select_products = $pdo->query("SELECT * FROM productos");
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="">
                        <div class="name">
                            <?php echo $fetch_products['nombre']; ?>
                        </div>
                        <div class="price">$
                            <?php echo $fetch_products['precio']; ?>
                        </div>
                        <input type="number" min="1" name="product_quantity" value="1" class="qty">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nombre']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['precio']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['imagen']; ?>">
                        <input type="submit" value="Añadir al carrito" name="add_to_cart" class="btn">
                    </form>
                    <?php
                    
                }
            } else {
                echo '<p class="empty">El carrito está vacío</p>';
            }
            ?>
        </div>

    </section>








    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>