<?php $fechaActual = date("Y-m-d"); ?>
<main class="main-becado">
    <div class="reportes">
        <div class="reportes-title">
            <h1>Enviar reporte</h1>
        </div>
        <div class="reportes-body">
            <div class="reportes-body-title">
                <?php echo icon("information-circle") ?>
                <h5>Datos del reporte</h5>
            </div>
            <div>
                <form action="<?php echo url("/reportes/agregar") ?>" method="POST" class="form" id="form-report" data-form="enviar" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo obtenerToken() ?>">
                    <input type="hidden" name="id" value="<?php echo $proyecto->id ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes ?>">
                    <div class="row form-report-1">
                        <div class="form-input">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("folder") ?>
                                </span>
                                <input type="text" value="<?php echo $proyecto->nombre ?>" name="proyecto" id="proyecto" placeholder="Nombre becado" readonly>
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
                                <input type="text" data-min-lenght="10" name="tema" id="tema" placeholder="Tema de la actividad">
                            </div>
                            <span class="message"></span>
                        </div>
                        <div class="form-input participantes">
                            <div class="form-group-icon">
                                <span>
                                    <?php echo icon("user-group") ?>
                                </span>
                                <input type="number" name="participantes" id="participantes" placeholder="Ingrese el # de participantes" min=1>
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>
                    <div class="row form-report-3">
                        <div class="form-input">
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea rows="5" data-min-lenght="90" id="descripcion" name="descripcion"></textarea>
                            </div>
                            <span class="message"></span>
                        </div>
                        <div class="form-input">
                            <div class="form-group">
                                <label for="obstaculos">Obstáculos:</label>
                                <textarea rows="5" data-min-lenght="20" id="obstaculos" name="obstaculos"></textarea>
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>
                    <div class="row form-report-4">
                        <div class="form-input">
                            <div class="form-group">
                                <label for="image-report">Imágenes:</label>
                                <input type="file" id="image-report" multiple accept=".jpeg, .png, .jpg, .webp">
                            </div>
                            <span class="message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="group-button mx-auto">
                            <a href="<?php echo url("/reportes") ?>" class="btn-delete">
                                <?php echo icon("cancel") ?>
                                Cancelar
                            </a>
                            <button type="submit" class="btn-secondary">
                                <?php echo icon("share") ?>
                                Enviar reporte
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<div class="load" id="load">
    <div class="spinner"></div>
</div>