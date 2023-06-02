<?php
require_once(__DIR__."/admin/controllers/usuario.php");
require_once(__DIR__."/admin/controllers/rol.php");
require_once(__DIR__."/admin/controllers/privilegio.php");
include_once("header.php");
include_once("admin/views/menu.php");

$usuario -> validateRol('Lider');
$action = (isset($_GET['action'])) ? $_GET['action'] : "getAll";
$id = (isset($_GET['id'])) ? $_GET['id'] : null;

switch ($action) {
    case 'new':
        $usuario -> validatePrivilegio('Proyecto Crear');
        $datarol = $rol->get(null);
        $dataprivilegio = $privilegio->get(null);
        if (isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $cantidad = $usuario->new($data);
            if ($cantidad) {
                $usuario->flash('success', 'Usuario dado de alta con éxito');
                $data = $usuario->get(null);
                include('admin/views/usuario/index.php');
            } else {
                $usuario->flash('danger', 'Algo fallo');
                include('admin/views/usuario/form.php');
            }
        } else {
            include('admin/views/usuario/form.php');
        }
        break;

    case 'edit':
        $usuario -> validatePrivilegio('Proyecto Actualizar');
        $datarol = $rol->get(null);
        $dataprivilegio = $privilegio->get(null);
        if(isset($_POST['enviar'])) {
            $data = $_POST['data'];
            $id = $_POST['data']['id_usuario'];
            $cantidad = $usuario->edit($id, $data);
            if($cantidad){
                $usuario->flash('success', "Registro actualizado con éxito");
                $data = $usuario->get(null);
                include('admin/views/usuario/index.php');
            } else {
                $usuario->flash('danger', "Algo fallo o no hubo cambios");
                $data = $usuario->get(null);
                include('admin/views/usuario/index.php');
            }
        } else {
            $data = $usuario->get($id);
            include('admin/views/usuario/form.php');
        }
        break;

    case 'delete':
        $usuario -> validatePrivilegio('Proyecto Eliminar');
        $datarol = $rol->get(null);
        $dataprivilegio = $privilegio->get(null);
        $cantidad = $usuario->delete($id);
        if ($cantidad) {
            $usuario->flash('success', "Registro eliminado con éxito");
            $data = $usuario->get(null);
            include('admin/views/usuario/index.php');
        } else {
            $usuario->flash('danger', "Algo fallo");
            $data = $usuario->get(null);
            include('admin/views/usuario/index.php');
        }
        break;

    case 'get':
        default:
        $usuario -> validatePrivilegio('Proyecto Leer');
            $data = $usuario->get($id);
            include('admin/views/usuario/index.php');
}
?>