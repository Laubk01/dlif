<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>REGISTRATE</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



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
   
<div class="form-container">

   <form action="" method="post">
      <h3>REGISTRATE AHORA</h3>
      <input type="email" name="email" placeholder="ingresa correo" required class="box">
      <input type="password" name="password" placeholder="Ingresa contraseña" required class="box">
      <input type="password" name="cpassword" placeholder="Confirma tu contraseña" required class="box">
    

      <select name="data[id_rol]" class="box">
      <?php
        foreach ($datarol as $key => $rol2): 
          $selected = " ";
          if ($rol2['id_rol']==$data[0]['id_rol']):
            $selected = " selected";
          endif;?>
      <option value="<?php echo $rol2['id_rol']; ?>" <?php echo $selected; ?>><?php echo $rol2['rol']; ?></option>
      <?php endforeach; ?>
    </select>



      <input type="submit" name="submit" value="register now" class="btn">
      <p>¿Ya estás registrado? <a href="login.php">Inicia sesión</a></p>
   </form>

</div>

</body>
</html>