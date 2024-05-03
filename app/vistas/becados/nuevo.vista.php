<main class="main-admin">
    <div class="becados">
        <div class="becados-title">
            <h1>Nuevo becado</h1>
        </div>
        <div class="becados-body">
            <form action="<?php echo url("/becados/agregar") ?>" method="POST" id="form-add-becado" class="form"
                enctype="multipart/form-data" novalidate>
                <input type="hidden" name="_token" value="<?php echo obtenerToken() ?>">
                <div class="row form-becado-1">
                    <div class="form-input nombre-becado">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("user") ?>
                            </span>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre becado" required>
                        </div>
                        <span class="message">Campo de nombre requerido.</span>
                    </div>
                    <div class="form-input usuario">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("user") ?>
                            </span>
                            <select name="usuario" id="usuario">
                                <option value="">Elije un usuario</option>
                                <?php
                                if ($usuarios != null) :
                                    foreach ($usuarios as $usuario) :
                                ?>
                                <option value="<?php echo $usuario->id ?>">
                                    <?php echo $usuario->usuario . "(" . $usuario->rol . ")" ?></option>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <span class="message">Elije un usuario válido.</span>
                    </div>
                </div>
                <div class="row form-becado-2">
                    <div class="form-input institucion">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("school") ?>
                            </span>
                            <input type="text" name="institucion" id="institucion" placeholder="Institución">
                        </div>
                        <span class="message">Campo de la institución requerido.</span>
                    </div>
                    <div class="form-input nivel-acedemico">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("elearning-exchange") ?>
                            </span>
                            <input type="text" name="nivel_academico" id="nivel-academico"
                                placeholder="Nivel academico">
                        </div>
                        <span class="message">Campo del nivel academico requerido.</span>
                    </div>
                    <div class="form-input nivel-estudio">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("elearning-exchange") ?>
                            </span>
                            <input type="text" name="nivel_estudio" id="nivel-estudio" placeholder="Estudiando">
                        </div>
                        <span class="message">Campo del nivel de estudio requerido.</span>
                    </div>
                </div>
                <div class="row form-becado-3">
                    <div class="form-input carrera">
                        <div class="form-group-icon">
                            <span>
                                <?php echo icon("school") ?>
                            </span>
                            <input type="text" name="carrera" id="carrera" placeholder="Carrera">
                        </div>
                        <span class="message">Campo de la carrera requerido.</span>
                    </div>
                </div>
                <div class="row form-becado-4">
                    <div class="form-input">
                        <div class="form-group-icon comunidad">
                            <span>
                                <?php echo icon("location") ?>
                            </span>
                            <select name="comunidad" id="comunidad">
                                <option value="">Elije una comunidad</option>
                                <?php
                                if ($comunidades != null) :
                                    foreach ($comunidades as $comunidad) :
                                ?>
                                <option value="<?php echo $comunidad->id ?>"><?php echo $comunidad->nombre ?></option>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <span class="message">Elije una comunidad válida.</span>
                    </div>
                </div>
                <div class="row form-becado-5">
                    <div class="form-input">
                        <div>
                            <input type="file" class="hidden" id="imagen_becado" name="imagen_becado"
                                accept=".jpg, .jpeg, .png" />
                            <button type="button" class="btn-primary"
                                onclick="document.getElementById('imagen_becado').click()">
                                <?php echo icon("image-add") ?>
                                Seleccionar imagen
                            </button>
                        </div>
                        <span class="message">Imagen requerida</span>
                    </div>
                </div>
                <div class="row form-becado-6">
                    <div class="preview-image" id="container-preview-image">
                        <img src="<?php echo asset("img", "not-found-image.png") ?>" alt="Sin imagen"
                            id="preview-image" />
                    </div>
                </div>
                <div class="row">
                    <div class="group-button mx-auto mt-20">
                        <a href="<?php echo url("/becados") ?>" class="btn-delete">Cancelar</a>
                        <button type="submit" class="btn-primary button-add-becado">
                            <?php echo icon("user-add") ?>
                            Agregar becado
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>