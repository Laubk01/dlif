<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ACERCA DE NOSOTROS</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/estilo2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>ACERCA DE NOSOTROS</h3>
   <p> <a href="home.php">Inicio</a> / Acerca de Nosotros </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/acerca2.jpg" alt="">
      </div>

      <div class="content">
         <h3>¿POR QUÉ VENIR CON NOSOTROS?</h3>
         <p>Somos un restaurante establecido en La Piedad Michoacán desde 1998. <br> Nuestro enfoque es hacer que nuestros clientes vivan una experiencia agradable estando en compañía de sus seres queridos mientras disfrutan una comida deliciosa en un ambiente cálido y confortable </p>
         <p>Ven y pasa un día excelente con una comida deliciosa y compañía perfecta<br> 
         Tenemos menú para niños y un área para que puedan jugar
         En nuestra cafetería, nos dedicamos a ofrecer productos de la más alta calidad y a brindar una experiencia culinaria única. Nuestro equipo de expertos baristas se esfuerza por preparar el café perfecto para cada cliente, utilizando granos cuidadosamente seleccionados y técnicas de preparación excepcionales.

Pero eso no es todo, nuestra especialidad son los molletes, esos deliciosos bocadillos hechos con pan tierno y rellenos irresistibles. Desde los tradicionales molletes con frijoles y queso, hasta nuestras creaciones únicas con ingredientes frescos y sabrosos, ofrecemos una amplia variedad de opciones para satisfacer todos los gustos y antojos.
</p>
         <a href="contact.php" class="btn">Contáctanos</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">RESEÑAS DE CLIENTES</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/adriana.jpg" alt="">
         <p>¡Amo esta cafetería! Siempre encuentro un sabor delicioso en cada bocado. El café es excelente y el ambiente es acogedor. Definitivamente mi lugar favorito para disfrutar de un desayuno.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Adriana Jiménez </h3>
      </div>

      <div class="box">
         <img src="images/ariadna.jpg" alt="">
         <p>¡Los molletes de esta cafetería son simplemente increíbles! La combinación de pan tierno y sabrosos ingredientes es perfecta. Además, el café que sirven es de alta calidad.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ariadna Castillo</h3>
      </div>

      <div class="box">
         <img src="images/vicente.jpg" alt="">
         <p>El personal es amable y siempre dispuesto a ayudar. Definitivamente, un lugar que vale la pena visitar si eres amante de un desayuno delicioso con un buen café.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Vicente López</h3>
      </div>

      
   </div>

</section>


<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>