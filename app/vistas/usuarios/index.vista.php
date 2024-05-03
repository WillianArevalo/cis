<main class="main-admin">
    <div class="usuarios">
        <div class="usuarios-title">
            <h1>Usuarios</h1>
        </div>
        <div class="usuarios-body">
            <div class="search-container">
                <div class="search">
                    <input type="text" placeholder="Buscar usuario" class="search-input" data-id-table="tabla-usuarios">
                    <span><?php echo icon("search") ?></span>
                </div>
                <div class="buttons">
                    <button type="button" class="btn-primary" id="button-add-usuario" data-url="<?php echo url("/usuarios/obtenerForm") ?>">
                        <?php echo icon("user-add") ?>
                        Agregar usuario
                    </button>
                </div>
            </div>
            <div class="table">
                <table id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($usuarios != null) :
                            $num = 0;
                            foreach ($usuarios as $usuario) :
                                $num++;  ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $usuario->usuario ?></td>
                                    <td><?php echo $usuario->email ?></td>
                                    <td><?php echo ($usuario->rol == "admin") ? "Administrador" : "Usuario" ?></td>
                                    <td>
                                        <div class="group-button">
                                            <button data-url="<?php echo url("/usuarios/obtenerFormEdit/") ?>" data-id="<?php echo $usuario->id ?>" class="edit-usuario btn-edit"><?php echo icon("user-edit") ?>
                                            </button>
                                            <button class="delete-usuario btn-delete" data-id="<?php echo $usuario->id ?>" data-url="<?php echo url("/usuarios/eliminar") ?>"><?php echo icon("user-remove") ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>