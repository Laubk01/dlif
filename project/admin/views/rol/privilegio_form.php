<h1 class="text-center"><?php echo ($action == 'editprivilegio') ? 'Modificar ' : 'Agregar ' ?> Privilegio:
    <?php echo $data[0]['rol']; ?>
</h1>
<form class="container-fluid" method="POST" action="rol.php?action=<?php echo $action; ?>&id=<?php echo($data[0]['id_rol']); ?>">
  <div class="mb-3">
    <label class="form-label">Nombre del Privilegio</label>
    <input type="text" name="data[privilegio]" class="form-control" placeholder="Privilegio"
      value="<?php echo isset($data_privilegio[0]['privilegio']) ? $data_privilegio[0]['privilegio'] : ''; ?>" required minlength="3" maxlength="50" />
  </div>

  <div class="mb-3">
  <input type="hidden" name="data[id_rol]" value="<?php echo($data[0]['id_rol']); ?>">
    <?php if ($action == 'edittask'): ?>
      <input type="hidden" name="data[id_privilegio]"
        value="<?php echo isset($data_tarea[0]['id_privilegio']) ? $data_tarea[0]['id_privilegio'] : ''; ?>">
    <?php endif; ?>
    <input type="submit" name="enviar" value="Guardar" class="btn btn-primary" />
  </div>
</form>

<script>
    const value = document.querySelector("#value")
    const input = document.querySelector("#por_avance")
    value.textContent = input.value
    input.addEventListener("input", (event) => {
    value.textContent = event.target.value
    })
</script>