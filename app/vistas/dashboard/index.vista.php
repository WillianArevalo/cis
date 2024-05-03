<main class="main-admin">
    <div class="dashboard">
        <div class="dashboard-title">
            <?php echo icon("dashboard") ?>
            <h1>Dashboard</h1>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <span><?php echo $total_becados ?></span>
                    <h5>Becados</h5>
                </div>
                <div class="dashboard-card__body">
                    <img src="<?php echo asset("img", "user-group-monochromatic.svg") ?>" alt="Imagen becados icon">
                </div>
                <div class="dashboard-card__footer">
                    <a href="<?php echo url("/becados") ?>" class="btn-primary">
                        <?php echo icon("view") ?>
                        Ver más
                    </a>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <span><?php echo $total_proyectos ?></span>
                    <h5>Proyectos sociales</h5>
                </div>
                <div class="dashboard-card__body">
                    <img src="<?php echo asset("img", "knowledge-isometric.svg") ?>" alt="Imagen proyectos icon">
                </div>
                <div class="dashboard-card__footer">
                    <a href="<?php echo url("/proyectos") ?>" class="btn-primary">
                        <?php echo icon("view") ?>
                        Ver más
                    </a>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <span><?php echo $total_comunidades ?></span>
                    <h5>Comunidades</h5>
                </div>
                <div class="dashboard-card__body">
                    <img src="<?php echo asset("img", "home.svg") ?>" alt="Imagen comunidades icon">
                </div>
                <div class="dashboard-card__footer">
                    <a href="<?php echo url("/comunidades") ?>" class="btn-primary">
                        <?php echo icon("view") ?>
                        Ver más
                    </a>
                </div>
            </div>
        </div>
        <div class="dashboard-footer">
            <h3>Ultimos reportes enviados:</h3>
            <div class="ultimos-reportes">
                <?php
                if ($reportes != null) :
                    foreach ($reportes as $reporte) :
                ?>
                <div class="reporte">
                    <div class="reporte-header">
                        <h6><?php echo $reporte->nombre_proyecto ?></h6>
                    </div>
                    <div class="reporte-body">
                        <p><?php echo ucfirst($reporte->mes) ?></p>
                        <p><?php echo $reporte->enviado_por ?></p>
                    </div>
                    <div class="reporte-footer">
                        <a href="<?php echo url("/reportes/ver/" . $reporte->id) ?>" class="btn-info">
                            <?php echo icon("view") ?>
                            Ver más
                        </a>
                    </div>
                </div>
                <?php
                    endforeach;
                else : ?>
                <div class="reporte">
                    <div class="reporte-header">
                        <p>No hay reportes enviados</p>
                    </div>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</main>