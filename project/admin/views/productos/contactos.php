
<?php

include '../../../configprueba.php';

session_start();

$admin_id = $_SESSION['id_usuario'];

if(!isset($admin_id)){
   header('location:../../../login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $query = "DELETE FROM mensaje WHERE id = ?";
   $stmt = $pdo->prepare($query);
   $stmt->execute([$delete_id]);
   header('location:contactos.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mensajes</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../../../css/admin_estilo.css">
 
 </head>
 <body>
    
 <?php include '../../../admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> COMENTARIOS </h1>

   <div class="box-container">
   <?php
      $select_message = $pdo->query("SELECT * FROM mensaje");
      if($select_message->rowCount() > 0){
         while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
      
   ?>
   <div class="box">
      <p> id: <span><?php echo $fetch_message['id_usuario']; ?></span> </p>
      <p> nombre : <span><?php echo $fetch_message['nombre']; ?></span> </p>
      <p> numero : <span><?php echo $fetch_message['numero']; ?></span> </p>
      <p> correo : <span><?php echo $fetch_message['correo']; ?></span> </p>
      <p> mensaje : <span><?php echo $fetch_message['mensaje']; ?></span> </p>
      <a href="contactos.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('¿Desea eliminar este comentario?');" class="delete-btn">Eliminar comentario</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="empty">No tiene comentarios todavía</p>';
   }
   ?>
</div>
</section>
<script src="../js/admin_script.js"></script>

</body>
</html>