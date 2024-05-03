<main class="main-admin">
    <div class="asignar">
        <div class="asignar-title">
            <h2>Asignar representantes</h2>
        </div>
        <div class="asignar-body">
            <div class="asignar-proyecto">
                <?php echo icon("folder-open") ?>
                <h4><?php echo $proyecto->nombre ?></h4>
                <input type="hidden" id="id_proyecto" value="<?php echo $proyecto->id ?>">
            </div>
            <div class="asignar-listas">
                <div class="asignar-lista">
                    <h5>Representantes asignados</h5>
                    <ul class="columns" id="column1">
                        <?php
                        if ($becados_proyecto != null) :
                            foreach ($becados_proyecto as $becado) : ?>
                                <li class="card" data-id="<?php echo $becado->id ?>">
                                    <span class="circle"></span>
                                    <img src="<?php echo asset("img/becados", $becado->foto) ?>" alt="<?php echo $becado->nombre ?>">
                                    <?php echo $becado->nombre ?>
                                    <span class="status active">Asignado</span>
                                    <button class="btn-delete btn-move">
                                        Eliminar
                                    </button>
                                </li>
                        <?php endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="asignar-lista">
                    <h5>Becados</h5>
                    <ul class="columns" id="column2">
                        <?php foreach ($becados as $becado) : ?>
                            <li class="card" data-id="<?php echo $becado->id ?>">
                                <span class="circle"></span>
                                <img src="<?php echo asset("img/becados", $becado->foto) ?>" alt="<?php echo $becado->nombre ?>">
                                <?php echo $becado->nombre ?>
                                <span class="status <?php echo ($becado->id_proyecto) ? "active" : "no-active" ?>">
                                    <?php echo ($becado->id_proyecto) ? "Asignado" : "No asignado" ?>
                                </span>
                                <button class="btn-edit btn-move">
                                    Asignar
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="asignar-footer">
            <a href="<?php echo url("/proyectos") ?>" class="btn-delete">Cancelar</a>
            <button class="btn btn-primary" id="btn_asignar_becados" data-url="<?php echo url("/proyectos/asignar_becados") ?>">
                <?php echo icon("add-circle") ?>
                Asignar becados
            </button>
        </div>
    </div>
</main>