<?php

require_once "app/basedatos/conexion.php";

class ComunidadesControlador
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
        $comunidad = new Comunidad($this->conn);
        $comunidades = $comunidad->obtener_comunidades();
        cargar_vista("comunidades", "index", ["comunidades" => $comunidades]);
    }

    public function agregar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $comunidad = new Comunidad($this->conn);
        $nombre = $_POST["nombre_comunidad"];
        $buscar = $comunidad->obtener_comunidad_por_nombre($nombre);
        if ($buscar) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "La comunidad ya existe", "url" => "comunidades"]);
            exit;
        }

        $insert = $comunidad->agregar_comunidad($nombre);
        if ($insert) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Comunidad agregada correctamente"]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al agregar la comunidad"]);
        }
    }

    public function eliminar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $id = $id = $_POST["id"];
        if (validarId($id) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "ID no válido", "url" => null]);
            return;
        }

        $comunidad_modelo = new Comunidad($this->conn);
        $becado_modelo = new Becado($this->conn);
        $proyecto_modelo = new Proyecto($this->conn);
        $becados = $becado_modelo->obtener_becados_por_comunidad($id);
        $proyecto = $proyecto_modelo->obtener_proyectos_por_comunidad($id);

        if ($proyecto) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se puede eliminar la comunidad porque tiene proyectos asociados", "redirect" => url("/comunidades")]);
            exit;
        }

        if ($becados) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se puede eliminar la comunidad porque tiene becados asociados", "redirect" => url("/comunidades")]);
            exit;
        }

        $delete = $comunidad_modelo->eliminar($id);
        if ($delete) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Comunidad eliminada correctamente", "redirect" => url("/comunidades")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al eliminar la comunidad", "redirect" => url("/comunidades")]);
        }
    }


    public function obtenerForm()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }
        $html = formAgregarComunidad();
        if (!$html) echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo obtener el formulario"]);
        echo json_encode(["status" => "success", "html" => $html]);
    }

    public function obtenerFormEdit()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }
        $id = $_POST["id"];
        $comunidad = new Comunidad($this->conn);
        $comunidad = $comunidad->obtener_comunidad_por_id($id);
        if (!$comunidad) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo obtener la comunidad"]);
            return;
        }
        $html = formEditComunidad($comunidad);
        if (!$html) echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se pudo obtener el formulario"]);
        echo json_encode(["status" => "success", "html" => $html]);
    }

    public function actualizar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }

        $comunidad = new Comunidad($this->conn);
        $id = $_POST["id"];
        $nombre = $_POST["nombre_comunidad"];

        $update = $comunidad->actualizar_comunidad($id, $nombre);
        if ($update) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Comunidad actualizada correctamente"]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al actualizar la comunidad"]);
        }
    }
}