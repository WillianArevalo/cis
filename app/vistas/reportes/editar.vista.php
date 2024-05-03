<?php $fechaActual = date("Y-m-d"); ?>
<main class="main-admin">
    <div class="reportes-proyectos">
        <div class="reportes-title">
            <h1>Editar reporte</h1>
        </div>
        <div class="reportes-body">
            <div>
                <form action="<?php echo url("/reportes/actualizar") ?>" method="POST" class="form" id="form-report" data-form="editar">
                    <input type="hidden" name="_token" value="<?php echo obtenerToken() ?>">
                    <input type="hidden" name="id" value="<?php echo $reporte->id ?>">
                    <input type="hidden" name="mes" value="<?php echo $reporte->mes ?>">
                    <div class="row form-report-1">
                        <div class="form-input">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("folder") ?>
                                </span>
                                <input type="text" value="<?php echo $reporte->nombre_proyecto ?>" name="proyecto" id="proyecto" placeholder="Proyecto" readonly>
                            </div>
                        </div>
                        <div class="form-input">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("calendar") ?>
                                </span>
                                <input type="date" value="<?php echo $fechaActual ?>" name="fecha" id="fecha" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row form-report-2">
                        <div class="form-input tema">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("bookmark") ?>
                                </span>
                                <input type="text" value="<?php echo $reporte->tema ?>" data-min-lenght="10" name="tema" id="tema" placeholder="Tema de la actividad">
                            </div>
                            <span class="message"></span>
                        </div>
                        <div class="form-input participantes">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("user-group") ?>
                                </span>
                                <input type="number" value="<?php echo $reporte->numero_participantes ?>" name="participantes" id="participantes" placeholder="Ingrese el # de participantes" min=1>
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>
                    <div class="row form-report-3">
                        <div class="form-input">
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea rows="5" data-min-lenght="50" id="descripcion" name="descripcion"><?php echo $reporte->descripcion ?>
                                </textarea>
                            </div>
                            <span class="message"></span>
                        </div>
                        <div class="form-input">
                            <div class="form-group">
                                <label for="obstaculos">Obstáculos:</label>
                                <textarea rows="5" data-min-lenght="20" id="obstaculos" name="obstaculos"><?php echo $reporte->obstaculos ?></textarea>
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>
                    <div class="row form-report-4">
                        <div class="form-input">
                            <div class="form-group">
                                <label for="image-report">Imágenes nuevas:</label>
                                <input type="file" id="image-report" multiple accept=".jpeg, .png, .jpg, .webp">
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>

                    <div class="images-reportes" id="images-reportes">
                        <?php
                        if ($imagenes) :
                            foreach ($imagenes as $imagen) : ?>
                                <div class="image">
                                    <img src="<?php echo asset("img/proyectos/" . $reporte->nombre_proyecto . "/" . $reporte->mes, $imagen->imagen) ?>" alt="<?php echo $imagen->imagen ?>" class="main-image">
                                    <button type="button" class="btn-delete delete-imagen" data-id-reporte="<?php echo $reporte->id ?>" data-id="<?php echo $imagen->id ?>" data-url="<?php echo url("/reportes/eliminar_imagen") ?>">
                                        <?php echo icon("delete") ?>
                                    </button>
                                </div>
                            <?php endforeach;
                            ?>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="row mt-20">
                        <div class="group-button mx-auto">
                            <button type="submit" class="btn-edit">
                                <?php echo icon("pencil-edit") ?>
                                Editar reporte
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="modal-image" class="modal">
        <span class="close" id="close-modal">
            <?php echo icon("cancel") ?>
        </span>
        <div class="image-container-modal" id="container-modal-image">
            <img class="modal-contenido" id="image-modal" />
        </div>
    </div>

</main>