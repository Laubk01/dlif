
<?php

include '../../../configprueba.php';

session_start();

$admin_id = $_SESSION['id_usuario'];

if(!isset($admin_id)){
   header('location:../../../login.php');
};

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   
   $stmt = $pdo->prepare("UPDATE ordenes SET estado = :estado WHERE id = :id");
   $stmt->bindParam(':estado', $update_payment);
   $stmt->bindParam(':id', $order_update_id);
   $stmt->execute();
   
   $message[] = 'El estado de pago se ha actualizado';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   
   $stmt = $pdo->prepare("DELETE FROM ordenes WHERE id = :delete_id");
   $stmt->bindParam(':delete_id', $delete_id);
   $stmt->execute();
   
   header('location:ordenes.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ORDENES</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../../../css/admin_estilo.css">

</head>
<body>
   
 <?php include '../../../admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Pedidos realizados</h1>

   <div class="box-container">
    <?php
        $select_orders = $conn->query("SELECT * FROM ordenes");
        if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch()){
    ?>
    <div class="box">
        <p> Id usuario : <span><?php echo $fetch_orders['id_usuario']; ?></span> </p>
        <p> Pedido en : <span><?php echo $fetch_orders['pedido']; ?></span> </p>
        <p> Nombre : <span><?php echo $fetch_orders['nombre']; ?></span> </p>
        <p> Número : <span><?php echo $fetch_orders['numero']; ?></span> </p>
        <p> Correo : <span><?php echo $fetch_orders['correo']; ?></span> </p>
        <p> address : <span><?php echo $fetch_orders['direccion']; ?></span> </p>
        <p> Total de productos : <span><?php echo $fetch_orders['total_productos']; ?></span> </p>
        <p> Precio total: : <span>$<?php echo $fetch_orders['total_precio']; ?>/-</span> </p>
        <p> Método de pago : <span><?php echo $fetch_orders['metodo']; ?></span> </p>
        <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
                <option value="" selected disabled><?php echo $fetch_orders['estado']; ?></option>
                <option value="pendiente">pendiente</option>
                <option value="completado">completado</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="ordenes.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('¿Desea eliminar este pedido?');" class="delete-btn">Eliminar</a>
        </form>
    </div>
    <?php
            }
        }else{
            echo '<p class="empty">No hay pedidos realizados todavía</p>';
        }
    ?>
</div>

<?php
$message = array(); // Inicializa la variable $message como un array vacío

if(isset($_POST['update_order'])){
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    $update_order = $conn->prepare("UPDATE ordenes SET estado = :estado WHERE id = :order_id");
    $update_order->bindParam(":estado", $update_payment);
    $update_order->bindParam(":order_id", $order_update_id);
    $update_order->execute();

    $message[] = 'El estado de pago ha sido actualizado'; // Agrega el mensaje al array $message
}


if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM ordenes WHERE id = :order_id");
    $delete_order->bindParam(":order_id", $delete_id);
    $delete_order->execute();
    header('location:ordenes.php');
}
else{
         echo '<p class="empty">No hay pedidos realizados todavía</p>';
      }
      ?>
   </div>

</section>
<script src="js/admin_script.js"></script>

</body>
</html>