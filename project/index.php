<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $stmt = $pdo->prepare("SELECT * FROM carrito WHERE nombre = :nombre AND id_usuario = :id_usuario");
   $stmt->execute(['nombre' => $product_name, 'id_usuario' => $user_id]);

   if($stmt->rowCount() > 0){
      $message[] = 'Ya está en el carrito';
   }else{
      $stmt = $pdo->prepare("INSERT INTO carrito (id_usuario, nombre, precio, cantidad, imagen)
                             VALUES(:id_usuario, :nombre, :precio, :cantidad, :imagen)");
      $stmt->execute(['id_usuario' => $user_id, 'nombre' => $product_name, 'precio' => $product_price, 'cantidad' => $product_quantity, 'imagen' => $product_image]);
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
   <title>Inicio</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/estilo2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>¡Bienvenidos a nuestro encantador café</h3>
      <p>En nuestro establecimiento, fusionamos 
         la pasión por la buena comida y la hospitalidad para ofrecerte una experiencia gastronómica única.</p>
      <a href="reporte/index.php" class="white-btn">Escanea nuestro Menú</a>
   </div>

</section>

<section class="products">

   <h1 class="title">ESPECIALIDADES</h1>

   <div class="box-container">

  <?php
  $select_products = $conn->query("SELECT * FROM productos LIMIT 6");
  if ($select_products->rowCount() > 0) {
    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
  ?>
      <form action="" method="post" class="box">
        <img class="image" src="uploaded_img/<?php echo $fetch_products['imagen']; ?>" alt="">
        <div class="name"><?php echo $fetch_products['nombre']; ?></div>
        <div class="price">$<?php echo $fetch_products['precio']; ?></div>
        <input type="number" min="1" name="product_quantity" value="1" class="qty">
        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nombre']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_products['precio']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_products['imagen']; ?>">
        <input type="submit" value="Añadir al carrito" name="add_to_cart" class="btn">
      </form>
  <?php
    }
  } else {
    echo '<p class="empty">No hay nada en el carrito todavía</p>';
  }
  ?>
</div>


   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="menu.php" class="option-btn">Cargar más</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about1.jpg" alt="">
      </div>

      <div class="content">
         <h3>Acerca de nosotros</h3>
         <p>¡Bienvenidos a nuestro encantadora cafetería! En nuestro establecimiento, fusionamos la pasión por la buena comida
             y la hospitalidad para ofrecerte una experiencia gastronómica única.
            En nuestra cocina, nos esforzamos por utilizar los ingredientes más frescos y de la más alta calidad.
            Trabajamos estrechamente con proveedores locales y agricultores para asegurarnos de que nuestros platos
            sean sabrosos, saludables y sostenibles. Desde los desayunos energéticos hasta los almuerzos reconfortantes y las cenas elegantes, 
            cada plato está cuidadosamente preparado por nuestro talentoso equipo de chefs.

            Nuestra cafetería está diseñado para brindarte un ambiente acogedor y relajado. Ya sea que estés disfrutando de una taza de
             café por la mañana, reuniéndote con amigos para un almuerzo casual o disfrutando de una cena romántica, nuestro personal amable y 
             atento se asegurará de que te sientas como en casa.
            Nos enorgullece ofrecer una amplia selección de bebidas, desde deliciosos cafés y tés hasta refrescantes jugos y cócteles artesanales. 
            Nuestro objetivo es complacer a todos los gustos y ofrecer una experiencia gastronómica completa.
            En nuestra cafetería, creemos en la importancia de la comunidad y nos esforzamos por ser un lugar donde las personas se reúnan, compartan momentos especiales y creen recuerdos duraderos. Valoramos a nuestros clientes y nos esforzamos por brindar un servicio excepcional en cada visita.
            Te invitamos a que vengas y disfrutes de nuestra cafetería. Ya sea que busques un lugar tranquilo para trabajar, una comida deliciosa con amigos o una velada romántica, estamos seguros de que encontrarás algo que te encante. ¡Esperamos darte la bienvenida pronto a nuestra cafetería!


         </p>
         <a href="about.php" class="btn">Leer más...</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>¿Tiene alguna pregunta?</h3>
      <p>Estamos aquí para ayudarlo. Si tiene alguna duda, inquietud o simplemente desea obtener más
          información sobre nuestros productos o servicios, no dude en contactarnos.
           Nuestro equipo de atención al cliente está listo para brindarle respuestas y asistencia
            personalizada. ¡Estamos comprometidos con su satisfacción y esperamos poder resolver cualquier
             consulta que pueda tener!</p>
      <a href="contact.php" class="white-btn">Contactenos</a>
   </div>

</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>