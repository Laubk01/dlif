<h1>Roles</h1>
<a href="rol.php?action=new" class="btn btn-success">Nuevo</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col" class="col-md-1">Id</th>
      <th scope="col" class="col-md-3">Rol</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($data as $key => $rol): ?>
    <tr>
      <th scope="row"><?php echo $rol['id_rol']; ?></th>
      <td><?php echo $rol['rol']; ?></td>
      <td>
          <div class="btn-group" role="group" aria-label="Menu Renglon">
          <a class="btn btn-dark" href="rol.php?action=privilegio&id=<?php echo $rol['id_rol']?>">Privilegios</a>
            <a class="btn btn-primary" href="rol.php?action=edit&id=<?php echo $rol['id_rol']?>">Modificar</a>
            <a class="btn btn-danger" href="rol.php?action=delete&id=<?php echo $rol['id_rol']?>">Eliminar</a>
          </div>
      </td> 
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tr>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col">Se encontraron <?php echo sizeof($data); ?> registros.</th>
    </tr>
</table>