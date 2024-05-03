<main class="main-admin">
    <div class="becados">
        <div class="becados-title">
            <h1>Becados</h1>
        </div>
        <div class="becados-body">
            <div class="search-container">
                <div class="search">
                    <input type="text" id="buscar-becado" placeholder="Buscar becado" class="search-input"
                        data-id-table="tabla-becados">
                    <span><?php echo icon("search") ?></span>
                </div>
                <div class="buttons">
                    <a href="<?php echo url("/becados/nuevo") ?>" class="btn-primary"><?php echo icon("user-add") ?>
                        Agregar becado
                    </a>
                </div>
            </div>
            <div class="table">
                <table id="tabla-becados">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Comunidad</th>
                            <th>Institución</th>
                            <th>Nivel</th>
                            <th>Estudiando</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($becados != null) :
                            foreach ($becados as $becado) : ?>
                        <tr>
                            <td><img src="<?php echo asset("img/becados", $becado->foto) ?>" alt="Imagen becado"></td>
                            <td><?php echo $becado->nombre_becado ?></td>
                            <td><?php echo $becado->comunidad ?></td>
                            <td><?php echo $becado->institucion ?></td>
                            <td><?php echo $becado->nivel_academico ?></td>
                            <td><?php echo $becado->nivel_estudio ?></td>
                            <td>
                                <div class="group-button">
                                    <a href="<?php echo url("/becados/editar/" . $becado->id_becado) ?>"
                                        class="editar-becado-btn btn-edit"><?php echo icon("user-edit") ?></a>
                                    <button class="delete-becado btn-delete" data-id="<?php echo $becado->id_becado ?>"
                                        data-url="<?php echo url("/becados/eliminar") ?>"><?php echo icon("user-remove") ?></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;
                        else : ?>
                        <tr>
                            <td colspan="7">No hay becados registrados</td>
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