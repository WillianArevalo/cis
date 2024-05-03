<main class="main-admin">
    <div class="proyectos">
        <div class="proyectos-title">
            <h1>Proyectos</h1>
        </div>
        <div class="proyectos-body">
            <div class="search-container">
                <div class="search">
                    <input type="text" placeholder="Buscar proyecto" class="search-input"
                        data-id-table="tabla-proyectos">
                    <span><?php echo icon("search") ?></span>
                </div>
                <div class="buttons">
                    <button type="button" class="btn-primary" id="button-add-proyecto"
                        data-url="<?php echo url("/proyectos/obtenerForm") ?>">
                        <?php echo icon("folder-add") ?>
                        Agregar proyecto
                    </button>
                </div>
            </div>
            <div class="table">
                <table id="tabla-proyectos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Comunidad</th>
                            <th class="th-list-becados">Encargados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $proyecto) : ?>
                        <tr>
                            <td><?php echo $proyecto->nombre ?></td>
                            <td><?php echo $proyecto->comunidad ?></td>
                            <td class="td-list-becados">
                                <ul class="list-becados">
                                    <?php foreach ($proyecto->becados as $becado) : ?>
                                    <li>
                                        <span class="circle"></span>
                                        <?php echo ($becado->nombre_becado !== null) ? $becado->nombre_becado : "No hay ningún encargado asignado" ?>
                                    </li>
                                    <?php endforeach;  ?>
                                </ul>
                            </td>
                            <td>
                                <div class="group-button">
                                    <button data-url="<?php echo url("/proyectos/obtenerFormEdit/") ?>"
                                        data-id="<?php echo $proyecto->id ?>"
                                        class="edit-proyecto btn-edit"><?php echo icon("folder-edit") ?>
                                    </button>
                                    <button class="delete-proyecto btn-delete" data-id="<?php echo $proyecto->id ?>"
                                        data-url="<?php echo url("/proyectos/eliminar") ?>"><?php echo icon("folder-remove") ?>
                                    </button>
                                    <a href="<?php echo url("/proyectos/asignar/" . $proyecto->id) ?>" class="btn-info">
                                        <?php echo icon("folder-shared") ?>
                                    </a>
                                    <a href="<?php echo url("/proyectos/reportes/" . $proyecto->id) ?>"
                                        class="btn-primary">
                                        <?php echo icon("folder-file") ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>