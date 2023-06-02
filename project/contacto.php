<?php

include 'configprueba.php';

session_start();

$user_id = $_SESSION['id_usuario'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

    $name = $_POST['nombre'];
    $email = $_POST['correo'];
    $number = $_POST['numero'];
    $msg = $_POST['mensaje'];
 
    $select_message = $pdo->prepare("SELECT * FROM mensaje WHERE nombre = :nombre AND correo = :correo AND numero = :numero AND mensaje = :mensaje");
    $select_message->execute(array(':nombre' => $name, ':correo' => $email, ':numero' => $number, ':mensaje' => $msg));
 
    if($select_message->rowCount() > 0){
       $message[] = 'Ya se envió antes ese mensaje';
    }else{
       $insert_query = $pdo->prepare("INSERT INTO mensaje (id_usuario, nombre, correo, numero, mensaje) VALUES(:id_usuario, :nombre, :correo, :numero, :mensaje)");
       $insert_query->execute(array(':id_usuario' => $user_id, ':nombre' => $name, ':correo' => $email, ':numero' => $number, ':mensaje' => $msg));
 
       $message[] = 'Mensaje enviado';
    }
 
 }
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contacto</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/estilo2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>CONTACTANOS</h3>
   <p> <a href="index.php">Inicio</a> / contacto </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>¿Tienes algún comentario?</h3>
      <input type="text" name="nombre" required placeholder="Ingresa tu nombre" class="box">
      <input type="email" name="correo" required placeholder="Ingresa tu correo" class="box">
      <input type="number" name="numero" required placeholder="Ingresa tu número" class="box">
      <textarea name="mensaje" class="box" placeholder="Ingresa tu comntario" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Enviar" name="send" class="btn">
   </form>

</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>