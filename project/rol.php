<?php
    require_once("admin/controllers/rol.php");
   // require_once("controllers/privi.php");
    include_once('admin/views/header.php');
    include_once('admin/views/menu.php');

    $rol->validateRol('Lider');

    $action = (isset($_GET['action'])) ? $_GET['action'] : null;
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $id_privilegio = (isset($_GET['id_privilegio'])) ? $_GET['id_privilegio'] : null;

    switch ($action) {
        case 'new':
            $rol->validatePrivilegio('Proyecto Crear');
        //    $data_privilegio = $privilegio->get(null);
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $cantidad = $rol->new($data);
                if ($cantidad) {
                    $rol->flash('success', "Registro dado de alta con  éxito");
                    $data = $rol->get(null);
                    include('admin/views/rol/index.php');
                }else {
                    $rol->flash('danger', "Algo fallo");
                    include('admin/views/rol/form.php');
                }
            }else {
                include('admin/views/rol/form.php');
            }
        break;
        case 'delete':
            $rol->validatePrivilegio('Proyecto Eliminar');
            $cantidad = $rol->delete($id);
            if ($cantidad) {
                $rol->flash('success', "Registro eliminado con éxito");
                $data = $rol->get(null);
                include('admin/views/rol/index.php');
            }else {
                $rol->flash('danger', "Algo fallo");
                $data = $rol->get(null);
                include('admin/views/rol/index.php');
            }
        break;
        case 'edit':
            $rol->validatePrivilegio('Proyecto Actualizar');
         //   $datadepartamentos = $departamento->get(null);
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $id = $_POST['data']['id_rol'];
                $cantidad = $rol->edit($id, $data);
                if ($cantidad) {
                    $rol->flash('success', "Registro actualizado con  éxito");
                    $data = $rol->get(null);
                    include('admin/views/rol/index.php');
                }else {
                    $rol->flash('warning', "Algo fallo o no hubo cambios");
                    $data = $rol->get();
                    include('admin/views/rol/index.php');
                }
            }else {
                $data = $rol->get($id);
                include('admin/views/rol/form.php');
            }
        break;

        case 'privilegio':
            $rol->validatePrivilegio('Proyecto Leer');
            $data = $rol->get($id);
            $data_privilegio = $rol->getPrivilegio($id);
            include('admin/views/rol/privilegio.php'); 
        break;

        case 'deleteprivilegio':
            $rol->validatePrivilegio('Proyecto Eliminar');
            $cantidad = $rol->deletePrivilegio($id_privilegio);
            if ($cantidad) {
                $rol->flash('success', "Registro eliminado con éxito");
                $data = $rol->get($id);
                $data_privilegio = $rol->getPrivilegio($id);
                include('admin/views/rol/privilegio.php');
            }else {
                $rol->flash('danger', "Algo fallo");
                $data = $rol->get($id);
                $data_privilegio = $rol->getPrivilegio($id);
                include('admin/views/rol/privilegio.php');
            }     
        break;
        
        case 'newprivilegio':
            $rol->validatePrivilegio('Proyecto Crear');
            $data = $rol->get($id);
            if (isset($_POST['enviar'])) {
                $data2 = $_POST['data'];
                $cantidad = $rol->newPrivilegio($id, $data2);
                if ($cantidad) {
                    $rol->flash('success', "Registro dado de alta con éxito");
                } else {
                   // $departamento->flash('danger', "Algo fallo");
                }
                $data_privilegio = $rol->getPrivilegio($id);
                include('admin/views/rol/privilegio.php');
            }else {
                include('admin/views/rol/privilegio_form.php');   
            }
        break;
        
        case 'editprivilegio':
            $rol->validatePrivilegio('Proyecto Actualizar');
            $data = $rol->get($id); 
            if (isset($_POST['enviar'])) {
                $data2 = $_POST['data'];
                $id_privilegio = $_POST['data']['id_privilegio'];
                $cantidad = $rol->editPrivilegio($id, $id_privilegio, $data2);
                if ($cantidad) {
                    $rol->flash('success', "Registro actualizado con  éxito");
                }else {
                    $rol->flash('warning', "Algo fallo o no hubo cambios");
                }
                $data_privilegio = $rol->getPrivilegio($id);
                include('admin/views/rol/privilegio.php');
            }else{
                $data_privilegio = $rol->getPrivilegioOne($id_privilegio);
                include('admin/views/rol/privilegio_form.php');
            }
        break;
        case 'get':
            default:
                $rol->validatePrivilegio('Proyecto Leer');
                $data = $rol->get(null);
                include("admin/views/rol/index.php");

    }
?>
