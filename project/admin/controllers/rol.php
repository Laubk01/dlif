<?php
require_once(__DIR__."/sistema.php");
class Rol extends Sistema
{
    public function get($id = null)
    {
        $this->db();
        if (is_null($id)) {
            $sql = "SELECT * FROM rol";
            $st = $this->db->prepare($sql);
            $st->execute();
            $data = $st->fetchAll();
        } else {
            $sql = "SELECT * FROM rol where id_rol=:id";
            $st = $this->db->prepare($sql);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function new ($data)
    {
        $this->db();
        $sql = "INSERT INTO rol (rol) VALUES (:rol)";
        $st = $this->db->prepare($sql);
        $st->bindParam(":rol", $data['rol'], PDO::PARAM_STR);
        $st->execute();

        $rc = $st->rowCount();
        return $rc;
    }
    public function edit($id, $data)
    {
        $this->db();
        $sql = "UPDATE rol SET rol = :rol where id_rol= :id";
        $st = $this->db->prepare($sql);
        $st->bindParam(":id", $id, PDO::PARAM_INT);
        $st->bindParam(":rol", $data['rol'], PDO::PARAM_STR);
        $st->execute();

        $rc = $st->rowCount();
        return $rc;
    }

    public function delete($id){
        $this->db();
        
        try {
            $this->db->beginTransaction();
            $sql = "delete from rol_privilegio where id_rol = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            
            $sql = "delete from rol where id_rol = :id";
            $st = $this->db->prepare($sql);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            $st->execute();
            $rc = $st->rowCount();
            $this->db->commit();
        } catch (PDOException $exception) {
            $rc=0;
            $this->db->rollback();
        }
        return $rc;
    }





//PRIVILEGIOS
public function getPrivilegio($id = null){
    $this->db();
    if (is_null($id)) {
        $sql = "select * from privilegio p 
                left join rol_privilegio rp  on p.id_privilegio = rp.id_privilegio
                left join rol r on r.id_rol = rp.id_rol";
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
    }else {
        $sql = "select * from privilegio p 
                 left join rol_privilegio rp  on p.id_privilegio = rp.id_privilegio
                 left join rol r on r.id_rol = rp.id_rol
                  where rp.id_rol = :id";
        $st = $this->db->prepare($sql);
        $st->bindParam(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
}

public function deletePrivilegio($id){
    $this->db();
    $sql = "delete from privilegio where id_privilegio=:id";
    $st = $this->db->prepare($sql);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();

    $sql = "DELETE FROM rol_privilegio WHERE id_privilegio = :id";
    $st = $this->db->prepare($sql);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();


    $rc = $st->rowCount();
    return $rc;
}



public function getPrivilegioOne($id){
    $data=null;
    $this->db();
    if (is_null($id)) {
        die("Ocurrio un error");
    }else {
        $sql = "select * from privilegio p left join rol_privilegio rp on p.id_privilegio = rp.id_privilegio where p.id_privilegio = :id";
        $st = $this->db->prepare($sql);
        $st->bindParam(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $data = $st->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
}
public function newPrivilegio ($id, $data)
{
    $this->db();
    $sql = "insert into privilegio ( privilegio) values (:privilegio)";
    $st = $this->db->prepare($sql);
    $st->bindParam(":privilegio", $data['privilegio'], PDO::PARAM_STR);
    $st->execute();

    $id_privilegio = $this->db->lastInsertId();
    
    $sql = "INSERT INTO rol_privilegio ( id_rol,id_privilegio) VALUES (:id_rol,:id_privilegio)";
    $st = $this->db->prepare($sql);
    $st->bindParam(":id_rol", $id, PDO::PARAM_INT);   
    $st->bindParam(":id_privilegio", $id_privilegio, PDO::PARAM_INT); 
    $st->execute();
    
    


    $rc = $st->rowCount();
    return $rc;
}

public function editPrivilegio($id, $id_privilegio, $data)
{
    echo $id_privilegio;
    $this->db();
    echo $id_privilegio;
   
}

}


$rol = new Rol;
?>