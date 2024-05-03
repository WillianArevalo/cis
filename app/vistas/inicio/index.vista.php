<main class="main-becado">
    <div class="inicio">
        <div class="inicio-header">
            <div class="inicio-header__image">
                <img src="<?php echo asset("img", "tree.svg") ?>" alt="Imagen proyecto head" />
            </div>
            <div class="inicio-header__body">
                <h1>Proyecto asignado: </h1>
                <h3><?php echo ($proyecto) ? $proyecto->nombre : "No ha sido asignado" ?></h3>
            </div>
        </div>
        <div class="inicio-body">
            <div class="inicio-body__card">
                <div class="card-header">
                    <h5>Reportes mensuales</h5>
                    <span>
                        <?php echo icon("report") ?>
                    </span>
                </div>
                <div class="card-body">
                    <img src="<?php echo asset("img", "undraw_folder_files.svg") ?>" alt="Reports files">
                    <p>Rerporte de este mes:</p>
                    <span class="alert  <?php echo ($reporte != null) ? "alert-success" : "alert-warning" ?>">
                        <?php echo ($proyecto) ? (($reporte != null) ? "Enviado" : "Sin enviar") : "Sin proyecto" ?>
                    </span>
                </div>
                <div class="card-footer">
                    <a href="<?php echo url("/reportes") ?>"
                        class="btn-secondary <?php echo (!$proyecto) ? "disabled":"" ?>">
                        <?php echo icon("view") ?>
                        Ver reportes
                    </a>
                    <a href="<?php echo ($reporte) ? "#" : url("/reportes/enviar/" . $mes) ?>"
                        class="btn-info <?php echo  ($proyecto) ? (($reporte) ? "disabled" : ""):"disabled" ?>">
                        <?php echo icon("share") ?>
                        Enviar reporte
                    </a>
                </div>
            </div>
            <div class="inicio-body__card">
                <div class="card-header">
                    <h5>Integrantes</h5>
                    <span>
                        <?php echo $total ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="list-integrantes">
                        <?php
                        if ($integrantes != null) :
                            foreach ($integrantes as $integrante) : ?>
                        <div class="integrante">
                            <span></span>
                            <img src="<?php echo asset("img/becados", $integrante->foto) ?>"
                                alt="Imagen <?php echo $integrante->nombre ?>" />
                            <p><?php echo $integrante->nombre ?></p>
                        </div>
                        <?php endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>