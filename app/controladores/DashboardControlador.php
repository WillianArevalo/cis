<?php

require_once "app/basedatos/conexion.php";

class DashboardControlador
{

    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function index()
    {
        verificarSesion();
        verificarRol("admin");
        $proyecto_modelo = new Proyecto($this->conn);
        $becado_modelo = new Becado($this->conn);
        $reporte_modelo = new Reporte($this->conn);
        $comunidad_modelo = new Comunidad($this->conn);
        $total_proyectos = $proyecto_modelo->cantidad_proyectos();
        $total_becados = $becado_modelo->cantidad_becados();
        $total_comunidades = $comunidad_modelo->cantidad_comunidades();
        $reportes = $reporte_modelo->ultimos_reportes();
        cargar_vista("dashboard", "index", ["total_proyectos" => $total_proyectos->total, "total_becados" => $total_becados->total, "total_comunidades" => $total_comunidades->total, "reportes" => $reportes]);
    }
}