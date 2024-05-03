<main class="main-admin">
    <div class="comunidades">
        <div class="comunidades-title">
            <h1>Comunidades</h1>
        </div>
        <div class="comunidades-body">
            <div class="search-container">
                <div class="search">
                    <input type="text" placeholder="Buscar comunidad" class="search-input" data-id-table="tabla-comunidades">
                    <span><?php echo icon("search") ?></span>
                </div>
                <div class="buttons">
                    <button type="button" class="btn-primary" id="button-add-comunidad" data-url="<?php echo url("/comunidades/obtenerForm") ?>">
                        <?php echo icon("add-circle") ?>
                        Agregar comunidad
                    </button>
                </div>
            </div>
            <div class="table">
                <table id="tabla-comunidades">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($comunidades != null) :
                            $num = 0;
                            foreach ($comunidades as $comunidad) :
                                $num++;  ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $comunidad->nombre ?></td>
                                    <td>
                                        <div class="group-button">
                                            <button data-url="<?php echo url("/comunidades/obtenerFormEdit/") ?>" data-id="<?php echo $comunidad->id ?>" class="edit-comunidad btn-edit"><?php echo icon("pencil-edit") ?>
                                            </button>
                                            <button class="delete-comunidad btn-delete" data-id="<?php echo $comunidad->id ?>" data-url="<?php echo url("/comunidades/eliminar") ?>"><?php echo icon("delete") ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        else : ?>
                            <tr>
                                <td colspan="3">No hay comunidades registradas</td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>