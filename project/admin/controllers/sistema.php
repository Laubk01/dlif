<?php
  session_start();
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  
  require_once('config.php');
  class Sistema
  {
    var $db = null;
    public function db()
    {
        $dsn = DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME . ';port=' . DBPORT;
        $this->db = new PDO($dsn, DBUSER, DBPASS);
    }
    
    public function flash($color, $msg)
    {
        include('admin/views/flash.php');
    }

    public function uploadfile($tipo, $ruta, $archivo)
    {
        $name = false;
        $uploads['archivo'] = array("application/gzip", "application/zip", "application/x-zip-compressed","image/jpeg", "image/jpg", "image/gif", "image/png");
        if ($_FILES[$tipo]['error'] == 4) {
            return $name;
        }
        if ($_FILES[$tipo]['error'] == 0) {
            if (in_array($_FILES[$tipo]['type'], $uploads['archivo'])) {
                if ($_FILES[$tipo]['size'] <= 2 * 1048 * 1048) {
                    $origen = $_FILES[$tipo]['tmp_name'];
                    $ext = explode(".", $_FILES[$tipo]['name']);
                    $ext = $ext[sizeof($ext) - 1];
                    $destino = $ruta . $archivo . "." . $ext;
                    if (move_uploaded_file($origen, $destino)) {
                        $name = $destino;
                    }
                }
            }
        }
        return $name;
    }
 

    public function login($correo, $contrasena)
    {
        if (!is_null($contrasena)) {
            if (strlen($contrasena)>0) {
                if ($this->validateEmail($correo)) {
                    $contrasena = md5($contrasena);
                    $this->db();
                    $sql = 'select id_usuario, correo from usuario where correo = :correo and contrasena = :contrasena';
                    $st = $this->db->prepare($sql);
                    $st->bindParam(":correo", $correo, PDO::PARAM_STR);
                    $st->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
                    $st->execute();
                    $data = $st->fetchAll(PDO::FETCH_ASSOC);
                    if (isset($data[0])) {
                        $data = $data[0];
                        $_SESSION=$data;
                        $_SESSION['roles'] = $this->getRoles($correo);
                        $_SESSION['privilegios'] = $this->getPrivilegios($correo);
                        $_SESSION['validado']=true;
                        return true;
                    }
                }   
            }
        }
        return false;
    }
//REGISTRO DE USUARIO
public function register($correo, $contrasena)
{
    if (!is_null($contrasena)) {
        if(isset($_POST['submit'])){

            $correo = $_POST['correo'];
            $contrasena = md5($_POST['contrasena']);
            $ccontrasena = md5($_POST['ccontrasena']);
        
            $this->db();
            $sql = 'select id_usuario, correo from usuario where correo = :correo and contrasena = :contrasena';
            $st = $this->db->prepare($sql);
            $st->bindParam(":correo", $correo, PDO::PARAM_STR);
            $st->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);

            if($st->rowCount() > 0){
               $message[] = 'Ya está registrado ese usuario';
            }else{
               if($contrasena != $ccontrasena){
                  $message[] = 'No coinciden las contraseñas';
               }else {
                
                $token = $this->generarToken($correo);
                  $insert_user ="INSERT INTO `usuario`(correo,contrasena) VALUES(:correo, :ccontrasena)";
                  $insert_user = $this->db->prepare($insert_user);
                  $insert_user->bindParam(':correo', $correo);
                  $insert_user->bindParam(':ccontrasena', $ccontrasena);
                  $insert_user->execute();
                  $message[] = 'Usuario registrado con éxito';
                  header('location:login.php');
                $this->forgot($correo, $token);
               }
            }
         
         }
    }
    return false;
}




    public function logout(){
        unset($_SESSION['loggeado']);
        session_destroy();
    }

    public function getRoles($correo){
        $roles = array();
        if ($this->validateEmail($correo)) {
            $this->db();
            $sql = 'select r.rol from usuario u join rol_usuario ur on u.id_usuario = ur.id_usuario 
            join rol r on ur.id_rol = r.id_rol where u.correo = :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(":correo", $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $key => $rol) {
                array_push($roles, $rol['rol']);
            }
        } 
        return $roles;
    }

    public function getPrivilegios($correo){
        $privilegios = array();
        if ($this->validateEmail($correo)) {
            $this->db();
            $sql = 'select p.privilegio from usuario u join rol_usuario ur on u.id_usuario = ur.id_usuario 
            join rol r on ur.id_rol = r.id_rol join rol_privilegio rp on r.id_rol = rp.id_rol 
            join privilegio p on rp.id_privilegio = p.id_privilegio where u.correo = :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(":correo", $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $key => $privilegio) {
                array_push($privilegios, $privilegio['privilegio']);
            }
        } 
        return $privilegios;
    }

    public function validateEmail($correo){
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function validateRol($rol)
    {
        if (isset($_SESSION['validado'])) {
            if ($_SESSION['validado']) {
                if (isset($_SESSION['roles'])) {
                    if (!in_array($rol, $_SESSION['roles'])) {
                        $this->killApp('No tienes el rol adecuado');
                    }
                } else {
                    $this->killApp('No tienes roles asignados');
                }
            } else {
                $this->killApp('No estas validado');
            }
        } else {
            $this->killApp('No te has logueado');
        }
    }

    public function validatePrivilegio($privilegio)
    {
        if (isset($_SESSION['validado'])) {
            if ($_SESSION['validado']) {
                if (isset($_SESSION['privilegios'])) {
                    if (!in_array($privilegio, $_SESSION['privilegios'])) {
                        $this->killApp('No tienes el privilegio adecuado');
                    }
                } else {
                    $this->killApp('No tienes privilegios asignados');
                }
            } else {
                $this->killApp('No estas validado');
            }
        } else {
            $this->killApp('No te has logueado');
        }
    }

    public function killApp($mensaje)
    {
        ob_end_clean();
        include('admin/views/header_error.php');
        $this->flash('danger', $mensaje);
        include('admin/views/footer_error.php');
        die();
    }

    public function forgot($destinatario, $token)
    {
        if ($this->validateEmail($destinatario)) {
            require './vendor/autoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = '19030418@itcelaya.edu.mx';
            $mail->Password = 'jmacxlcdpkjegfpw';
            $mail->setFrom('19030418@itcelaya.edu.mx', 'Laura Guzman');
            $mail->addAddress($destinatario, 'Sistema Constructora');
            $mail->Subject = 'PASSWORD RECOVERY';
            $mensaje = "Estimado usuario <br> <a href=\"http://localhost/dlif/project/login.php?action=recovery&token=$token&correo=$destinatario\">Presione aqui para recuperar la contaseña.</a> <br>
            Atentamente. Constructora";
            $mensaje = utf8_decode($mensaje);
            $mail->msgHTML($mensaje);
            if (!$mail->send()) {
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                //echo 'Message sent!';
            }
            function save_email($mail){
                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                $imapStream = imap_open($path, $mail->Username, $mail->Password);
                $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);

                return $result;
            }
        }
    }

    public function generarToken($correo){
        $token = "papaschicas";
        $n=rand(1,1000000);
        $x = md5(md5($token));
        $y = md5($x . $n);
        $token = md5($y);
        $token= md5($token . 'calamardo');
        $token = md5('patricio'). md5($token . $correo);
        return $token;
    }

    public function loginSend($correo){
        $rc=0;
        if($this->validateEmail($correo)){
            $this->db();
            $sql = 'select correo from usuario where correo = :correo';
            $st = $this->db->prepare($sql);
            $st->bindParam(":correo", $correo, PDO::PARAM_STR);
            $st->execute();
            $data = $st->fetchAll(PDO::FETCH_ASSOC);
            if (isset($data[0])) {
                $token = $this->generarToken($correo);
                $sql2 = 'update usuario set token = :token where correo = :correo';
                $st2 = $this->db->prepare($sql2);
                $st2->bindParam(":token", $token, PDO::PARAM_STR);
                $st2->bindParam(":correo", $correo, PDO::PARAM_STR);
                $st2->execute();
                $rc = $st2->rowCount();
                $this->forgot($correo, $token);
            }
        }
        return $rc;
    }

    function validateToken($correo, $token){
        if(strlen($token)==64){
            if($this->validateEmail($correo)){
                $this->db();
                $sql = "SELECT correo FROM usuario where correo=:correo and token=:token";
                $st = $this->db->prepare($sql);
                $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                $st->bindParam(':token', $token, PDO::PARAM_STR);
                $st->execute();
                $data = $st->fetchAll(PDO::FETCH_ASSOC);
                if(isset($data[0])){
                    return true;
                }
            }
        }
        return false;
    }

    public function resetPassword($correo, $token, $contrasena){
        $cantidad=0;
        if(strlen($token)==64 and strlen($contrasena)>0){
            if($this->validateEmail($correo)){
                $contrasena=md5($contrasena);
                $this->db();
                $sql = "UPDATE usuario set contrasena=:contrasena,token=null 
                        where correo=:correo and token=:token";
                $st = $this->db->prepare($sql);
                $st->bindParam(':correo', $correo, PDO::PARAM_STR);
                $st->bindParam(':token', $token, PDO::PARAM_STR);
                $st->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
                $st->execute();
                $cantidad = $st->rowCount();
            }
        }
        return $cantidad;
    }


  }
  $sistema = new Sistema;
?>