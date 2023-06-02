<h1>Privilegios del rol: <?php echo $data[0]['rol']; ?></h1>
<a href="rol.php?action=newprivilegio&id=<?php echo $data[0]['id_rol']; ?>" class="btn btn-success">Nuevo</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col" class="col-md-2">Id</th>
      <th scope="col" class="col-md-3">privilegio</th>
      <th scope="col" class="col-md-2">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data_privilegio as $key => $privilegio): ?>
    <tr>
        <th scope="row"><?php echo $privilegio['id_privilegio']; ?></th>
        <td><?php echo $privilegio['privilegio']; ?></td>
     
        <td>
            <div class="btn-group" role="group" aria-label="Menu Renglon">
            <a href="rol.php?action=editprivilegio&id=<?php echo $data[0]["id_rol"]; ?>&id_privilegio=<?php echo $privilegio["id_privilegio"];?>" type="button" class="btn btn-secondary">Modificar</a>
              <a href="rol.php?action=deleteprivilegio&id=<?php echo $data[0]["id_rol"]; ?>&id_privilegio=<?php echo $privilegio["id_privilegio"];?>" type="button" class="btn btn-danger">Eliminar</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tr>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col">Se encontraron <?php echo sizeof($data_privilegio); ?> registros.</th>
    </tr>
</table>