
<?php

include '../../../configprueba.php';

session_start();

$admin_id = $_SESSION['id_usuario'];

if(!isset($admin_id)){
   header('location:../../../login.php');
};


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
   $stmt->execute(['id_usuario' => $delete_id]);
   header('location:usuario.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Usuarios</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../../../css/admin_estilo.css">
 
 </head>
 <body>
    
 <?php include '../../../admin_header.php'; ?>

<section class="users">

   <h1 class="title"> Cuentas Usuario </h1>

   <div class="box-container">
    <?php
    $stmt = $pdo->query("SELECT * FROM usuario u 
                            left join rol_usuario ur on ur.id_usuario=u.id_usuario
                            left join rol r on ur.id_rol = r.id_rol ");
    while ($fetch_users = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div class="box">
            <p> id : <span><?php echo $fetch_users['id_usuario']; ?></span> </p>
            <p> correo <span><?php echo $fetch_users['correo']; ?></span> </p>
            <p> rol : <span style="color:<?php if ($fetch_users['rol'] == 'Aministrador') {
                                                    echo 'var(--red)';
                                                } ?>"><?php echo $fetch_users['rol']; ?></span> </p>
            <a href="usuario.php?delete=<?php echo $fetch_users['id_usuario']; ?>" onclick="return confirm('¿Desea elminar este usuario?');" class="delete-btn">Eliminar Usuario</a>
        </div>
    <?php
    };
    ?>
</div>

</section>
<script src="../js/admin_script.js"></script>

</body>
</html>