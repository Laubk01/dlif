<h1 class="text-center">Privilegios</h1>
<a href="privilegio.php?action=new" class="btn btn-success">Nuevo</a>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Privilegio</th>
        </tr>
    </thead>
    <tbody>
        <?php $nReg = 0;
        foreach ($data as $key => $privilegio):
            $nReg++; ?>
            <tr>
                <th scope="row">
                    <?php echo $privilegio["id_privilegio"] ?>
                </th>
                <th scope="row">
                    <?php echo $privilegio["privilegio"] ?>
                </th>
                <th>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="privilegio.php?action=edit&id=<?php echo $privilegio["id_privilegio"] ?>"
                            type="button" class="btn btn-primary">Modificar</a>
                        <a href="privilegio.php?action=delete&id=<?php echo $privilegio["id_privilegio"] ?>"
                            type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                </th>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th>
                Se encontraron
                <?php echo $nReg ?> privilegios.
            </th>
        </tr>
    </tbody>
</table>