<?php
    require_once("sistema.php");
    include '../configprueba.php';
  
    
    $admin_id = $_SESSION['id_usuario'];
    
    if(!isset($admin_id)){
       header('location:../../../login.php');
    };
    class Producto extends Sistema
    {
        public function get($id=null){
            $this->db();
            if (is_null($id)) {
                $sql = "select * from productos";
                $st = $this->db->prepare($sql);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "select * from productos where id = :id";
                $st = $this->db->prepare($sql);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }



            public function new($data){
                $this->db();
                if(isset($_POST['add_product'])){
                    $nombre = $_POST['nombre'];
                    $precio = $_POST['precio'];
                    $imagen = $_FILES['imagen']['name'];
                    $image_size = $_FILES['imagen']['size'];
                    $image_tmp_name = $_FILES['imagen']['tmp_name'];
                    $image_folder = '../../../uploaded_img/'.$imagen;
                 
                    $select_product_name = $this->db->prepare("SELECT nombre FROM productos WHERE nombre = :nombre");
                    $select_product_name->bindParam(':nombre', $nombre);
                    $select_product_name->execute();
                 
                    if($select_product_name->rowCount() > 0){
                       $message[] = 'Ese platillo ya existe';
                    }else{
                       $add_product_query = $this->db->prepare("INSERT INTO productos(nombre, precio, imagen) VALUES(:nombre, :precio, :imagen)");
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


            }









        /*public function get($id = null)
        {
            $this->db();
            if (is_null($id)) {
                $sql = "select * from productos";
                $st = $this->db->prepare($sql);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "select * from productos where id = :id";
                $st = $this->db->prepare($sql);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }*/

       /* public function new ($data)
        {
            $this->db();
            $sql = "INSERT INTO productos(nombre, precio, imagen) VALUES(:nombre, :precio, :imagen)";
            $st = $this->db->prepare($sql);
            $st->bindParam(":departamento", $data['departamento'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            return $rc;
        }*/

        public function edit($id, $data)
        {
            $this->db();
            $sql = "update departamento set departamento = :departamento where id_departamento = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->bindParam(":departamento", $data['departamento'], PDO::PARAM_STR);
            $st->execute();
            $rc = $st->rowCount();
            return $rc;
        }
        
        public function delete($id)
        {
            $this->db();
            $sql = "delete from departamento where id_departamento = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            $rc = $st->rowCount();
            return $rc;
        }
        public function chartProyecto(){
            $this->db();
                $sql= "select month(o.pedido) as fecha, count(o.id) as cantidad from ordenes o order by 1 asc";
                $st = $this->db->prepare($sql);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

    }
    $producto = new Producto;
?>