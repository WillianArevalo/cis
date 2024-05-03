<?php

require_once "app/basedatos/conexion.php";

class ProyectosControlador
{
    private $id;
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function index()
    {
        verificarSesion();
        verificarRol("admin");
        $proyecto = new Proyecto($this->conn);
        $comunidad = new Comunidad($this->conn);
        $comunidades = $comunidad->obtener_comunidades();
        $proyectos = $proyecto->obtener_proyectos();
        cargar_vista("proyectos", "index", ["proyectos" => $proyectos, "comunidades" => $comunidades]);
    }

    public function agregar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token inválido"]);
            return;
        }

        $proyecto = new Proyecto($this->conn);
        $nombre = $_POST["nombre_proyecto"];
        $comunidad = $_POST["comunidad"];

        $nombreCarpeta = "app/vistas/assets/img/proyectos/" . $nombre;

        if (!file_exists($nombreCarpeta) && !is_dir($nombreCarpeta) && !empty($nombre) && !empty($nombreCarpeta)) {
            mkdir($nombreCarpeta, 0777, true);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El proyecto ya existe (no se pudo crear la carpeta)"]);
            return;
        }

        $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

        foreach ($meses as $mes) {
            $carpeta = $nombreCarpeta . "/" . $mes;
            if (!file_exists($carpeta) && !is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            } else {
                echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El proyecto ya existe (no se pudo crear la carpeta)"]);
                return;
            }
        }

        $search = $proyecto->obtener_proyecto_por_nombre($nombre);
        if ($search) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El proyecto ya existe"]);
            return;
        }

        $insert = $proyecto->agregar_proyecto($nombre, $comunidad);
        if ($insert) {
            echo json_encode(["title" => "EXITO", "status" => "success", "message" => "Proyecto agregado correctamente"]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al agregar el proyecto"]);
        }
    }

    public function eliminar()
    {
        verificarSesion();
        verificarRol("admin");
        $proyecto_modelo = new Proyecto($this->conn);
        $becado_modelo = new Becado($this->conn);
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $id = $_POST["id"];
        $proyecto = $becado_modelo->obtener_integrantes_proyecto($id);
        if ($proyecto) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se puede eliminar el proyecto porque tiene becados asignados", "redirect" => url("/proyectos")]);
            return;
        }

        $delete = $proyecto_modelo->eliminar_proyecto($id);
        if ($delete) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Proyecto eliminado correctamente", "redirect" => url("/proyectos")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo eliminar el proyecto", "redirect" => url("/proyectos")]);
        }
    }


    public function obtenerForm()
    {
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }
        $comunidad = new Comunidad($this->conn);
        $comunidades = $comunidad->obtener_comunidades();
        $html = formAgregarProyecto($comunidades);
        if (!$html) echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo obtener el formulario"]);
        echo json_encode(["status" => "success", "html" => $html]);
    }

    public function obtenerFormEdit()
    {
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }
        $proyecto = new Proyecto($this->conn);
        $comunidad = new Comunidad($this->conn);
        $id = $_POST["id"];
        $proyecto = $proyecto->obtener_proyecto_por_id($id);
        $comunidades = $comunidad->obtener_comunidades();
        $html = formEditarProyecto($proyecto, $comunidades);
        if (!$html) echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo obtener el formulario"]);
        echo json_encode(["status" => "success", "html" => $html]);
    }

    public function actualizar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $proyecto_modelo = new Proyecto($this->conn);
        $id = $_POST["id"];
        $nombre_proyecto = $_POST["nombre_proyecto"];
        $comunidad = $_POST["comunidad"];
        $update = $proyecto_modelo->actualizar_proyecto($id, $nombre_proyecto, $comunidad);
        if ($update) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Proyecto actualizado correctamente"]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo actualizar el proyecto"]);
        }
    }

    public function asignar()
    {
        verificarSesion();
        verificarRol("admin");
        $proyecto = new Proyecto($this->conn);
        $becado = new Becado($this->conn);
        $id = $this->id;
        $proyecto = $proyecto->obtener_proyecto_por_id($id);
        $becados_proyecto = $becado->obtener_integrantes($id);
        $becados = $becado->obtener_becados_proyecto($id);
        cargar_vista("proyectos", "asignar", ["proyecto" => $proyecto, "becados_proyecto" => $becados_proyecto, "becados" => $becados]);
    }

    public function asignar_becados()
    {
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $becado_modelo = new Becado($this->conn);
        $id_proyecto = $_POST["id_proyecto"];
        if (isset($_POST["ids"])) {
            $becados = $_POST["ids"];
            $becado_modelo->eliminar_becados_proyecto($id_proyecto);
            foreach ($becados as $becado) {
                $insert = $becado_modelo->asignar_becado_a_proyecto($id_proyecto, $becado);
            }
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Becados asignados correctamente", "redirect" => url("/proyectos")]);
        } elseif (!isset($_POST["ids"]) && isset($_POST["id_proyecto"])) {
            $becado_modelo->eliminar_becados_proyecto($id_proyecto);
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Becedos actualizados correctamente", "redirect" => url("/proyectos")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo asignar los becados", "redirect" => url("/proyectos")]);
        }
    }

    public function reportes()
    {
        verificarSesion();
        verificarRol("admin");
        $proyecto = new Proyecto($this->conn);
        $reporte = new Reporte($this->conn);
        $id = $this->id;
        $proyecto = $proyecto->obtener_proyecto_por_id($id);
        $reportes = $reporte->obtener_reportes($id);
        cargar_vista("proyectos", "reportes", ["proyecto" => $proyecto, "reportes" => $reportes]);
    }
}