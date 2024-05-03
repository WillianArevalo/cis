    <?php $usuario = obtenerSesión("usuario");  ?>
    <?php if ($usuario->rol) : ?>
    <main class="main-<?php echo $usuario->rol ?>">
        <div class="reportes">
            <div class="reportes-title">
                <h2>DETALLES DEL REPORTE</h2>
            </div>
            <div class="detalles-reporte">
                <div class="detalles-reporte__col">
                    <div class="item">
                        <div class="item-header">
                            <?php echo icon("bookmark") ?>
                            <h6>Tema:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->tema ?></p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <?php echo icon("share") ?>
                            <h6>Enviado por:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->enviado_por ?></p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <?php echo icon("folder") ?>
                            <h6>Proyecto:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->nombre_proyecto ?></p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <?php echo icon("calendar") ?>
                            <h6>Mes:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo ucfirst($reporte->mes) ?></p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <?php echo icon("user-group") ?>
                            <h6>Número de participantes:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->numero_participantes ?></p>
                        </div>
                    </div>
                </div>
                <div class="detalles-reporte__col">
                    <div class="item descripcion">
                        <div class="item-header">
                            <?php echo icon("descripcion") ?>
                            <h6>Descripción:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->descripcion ?></p>
                        </div>
                    </div>
                    <div class="item obstaculos">
                        <div class="item-header">
                            <?php echo icon("descripcion") ?>
                            <h6>Obstáculos:</h6>
                        </div>
                        <div class="item-body">
                            <p><?php echo $reporte->obstaculos ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="images-reportes-ver mt-20">
                <h6>Imágenes del reporte:</h6>
                <swiper-container class="mySwiper" navigation="true">

                    <?php foreach ($imagenes as $imagen) : ?>
                    <swiper-slide>
                        <img src="<?php echo asset("img/proyectos/" . $reporte->nombre_proyecto . "/" . $reporte->mes, $imagen->imagen) ?>"
                            alt="<?php echo $imagen->imagen ?>">
                    </swiper-slide>
                    <?php endforeach; ?>

                </swiper-container>
            </div>
            <div class="group-button mx-auto mt-30">
                <a href="<?php echo ($usuario->rol == "admin") ? url("/proyectos") : url("/reportes") ?>"
                    class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </main>
    <?php
    endif; ?>