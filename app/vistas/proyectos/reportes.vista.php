<main class="main-admin">
    <div class="reportes-proyectos">
        <div class="reportes-title">
            <h1>Reportes</h1>
        </div>
        <div class="reportes-body">
            <div class="reportes-body-title mt-10">
                <?php echo icon("bookmark") ?>
                <h5><?php echo $proyecto->nombre ?></h5>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Tema</th>
                            <th>Enviado por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($reportes != null) :
                            foreach ($reportes as $reporte) : ?>
                        <tr>
                            <td><?php echo ucfirst($reporte->mes) ?></td>
                            <td><?php echo $reporte->tema ?></td>
                            <td><?php echo $reporte->enviado_por ?></td>
                            <td>
                                <div class="group-button">
                                    <button class="delete-reporte btn-delete" data-id="<?php echo $reporte->id ?>"
                                        data-url="<?php echo url("/reportes/eliminar") ?>"><?php echo icon("file-remove") ?>
                                    </button>
                                    <a href="<?php echo url("/reportes/ver/" . $reporte->id) ?>" class="btn-primary">
                                        <?php echo icon("file-view") ?>
                                    </a>
                                    <a href="<?php echo url("/reportes/editar/" . $reporte->id) ?>" class="btn-edit">
                                        <?php echo icon("file-edit") ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;
                        else :
                            ?>
                        <tr>
                            <td colspan="4">No hay reportes de este proyecto</td>
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