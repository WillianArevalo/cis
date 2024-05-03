<?php

require_once "app/basedatos/conexion.php";

class InicioControlador
{
    private $id;
    private $conn;
    private $becadoSession;


    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        $this->becadoSession = obtenerSesión("becado");
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function index()
    {
        verificarSesion();
        verificarRol("becado");
        $mesActual = intval(date("m"));
        $mesNombre = obtenerNombreMes($mesActual);
        $becado_modelo = new Becado($this->conn);
        $reporte_modelo = new Reporte($this->conn);

        if ($this->becadoSession == null || $this->becadoSession == "") {
            $proyecto = null;
        } else {
            @$proyecto = $becado_modelo->obtener_proyecto_del_becado($this->becadoSession->id);
            if ($proyecto) {
                $reporte = $reporte_modelo->obtener_reporte_mes($proyecto->id, $mesNombre);
                $integrantes = $becado_modelo->obtener_integrantes_proyecto($proyecto->id);
                $cantidad_integrantes = $becado_modelo->obtener_cantidad_de_integrantes_proyecto($proyecto->id);
            } else {
                $proyecto = null;
                $reporte = null;
                $integrantes = null;
                $cantidad_integrantes = null;
            }
        }

        cargar_vista("inicio", "index", ["proyecto" => $proyecto, "reporte" => $reporte, "integrantes" => $integrantes, "total" => ($proyecto) ? $cantidad_integrantes->cantidad : 0, "mes" => $mesNombre]);
    }
}
