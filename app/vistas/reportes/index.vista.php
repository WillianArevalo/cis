    <?php $meses = obtenerSesión("meses");  ?>
    <main class="main-becado">
        <div class="reportes">
            <div class="reportes-title">
                <h1>REPORTES</h1>
            </div>
            <div class="reportes-meses">
                <?php
                if ($meses != null) :
                    foreach ($meses as $key => $mes) :
                        if ($mes == "enviado") :
                            $alert = "alert-success";
                            $status = "success";
                        elseif ($mes == "no enviado") :
                            $alert = "alert-warning";
                            $status = "warning";
                        else :
                            $alert = "alert-danger";
                            $status = "danger";
                        endif;
                ?>
                        <div class="mes <?php echo $status ?>">
                            <div class="mes-header">
                                <?php echo ($mes == "enviado") ? icon("calendar-favorite") : (($mes == "pendiente") ? icon("calendar-remove") : icon("calendar-lock")) ?>
                                <h5><?php echo ucfirst($key) ?></h5>
                            </div>
                            <div class="mes-body">
                                <span class="alert <?php echo $alert ?>">
                                    <?php echo ucfirst($mes) ?>
                                </span>
                            </div>
                            <div class="mes-footer">
                                <a href="<?php echo url("/reportes/enviar/" . $key) ?>" class="btn-secondary <?php echo ($mes == "enviado" || $mes == "no enviado") ? "disabled" : "" ?> ">
                                    <?php echo icon("share") ?>
                                    <?php echo ($mes == "enviado") ? "Enviado" : "Enviar reporte"  ?>
                                </a>
                                <?php
                                if ($reportes != null) :
                                    foreach ($reportes as $reporte) :
                                        if ($reporte->mes == $key) :
                                ?>
                                            <a href="<?php echo url("/reportes/ver/" . $reporte->id) ?>" class="btn-secondary">
                                                <?php echo icon("view") ?>
                                                Ver reporte
                                            </a>

                                <?php
                                        endif;
                                        break;
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </main>