<?php

require_once "app/basedatos/conexion.php";

class BecadosControlador
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
        $becado = new Becado($this->conn);
        $becados = $becado->obtener_becados();
        cargar_vista("becados", "index", ["becados" => $becados], true, true);
    }

    public function nuevo()
    {
        verificarSesion();
        verificarRol("admin");
        $usuario = new Usuario($this->conn);
        $comunidad = new Comunidad($this->conn);
        $usuarios = $usuario->obtener_usuarios_disponibles();
        $comunidades = $comunidad->obtener_comunidades();
        cargar_vista("becados", "nuevo", ["comunidades" => $comunidades, "usuarios" => $usuarios], true, true);
    }

    public function agregar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["estado" => "error", "mensaje" => "Token inválido", "token" => $token]);
            return;
        }
        $nombre = $_POST["nombre"];
        $comunidad = $_POST["comunidad"];
        $institucion = $_POST["institucion"];
        $nivel_academico = $_POST["nivel_academico"];
        $carrera = $_POST["carrera"];
        $nivel_estudio = $_POST["nivel_estudio"];
        $usuario = $_POST["usuario"];

        $becado = new Becado($this->conn);
        if ($becado->obtener_becado_por_nombre($nombre)) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El becado ya existe"]);
            return;
        }

        if (isset($_FILES["imagen_becado"])) {
            $imagen = subirImagen("imagen_becado", "becados");
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se ha enviado ninguna imagen"]);
        }

        $data = [
            "nombre" => $nombre,
            "foto" => $imagen,
            "id_comunidad" => $comunidad,
            "institucion" => $institucion,
            "nivel_academico" => $nivel_academico,
            "carrera" => $carrera,
            "nivel_estudio" => $nivel_estudio,
            "id_usuario" => $usuario
        ];
        $agregar = $becado->agregar($data);
        if ($agregar) {
            echo json_encode(["title" => "Éxito", "status" => "success", "message" => "Becado agregado correctamente", "redirect" => url("/becados")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al agregar el becado"]);
        }
    }

    public function eliminar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token inválido"]);
            return;
        }

        $id = $_POST["id"];
        $becado_modelo = new Becado($this->conn);
        $becado = $becado_modelo->obtener_becado($id);
        if (!$becado) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El becado no existe"]);
            return;
        }

        if (!eliminarImagen("becados", $becado->foto) == true) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al eliminar la imagen del becado"]);
            return;
        }

        $eliminar = $becado_modelo->eliminar($id);
        if ($eliminar) {
            echo json_encode(["title" => "Éxito", "status" => "success", "message" => "Becado eliminado correctamente", "redirect" => url("/becados")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al eliminar el becado"]);
        }
    }

    public function editar()
    {
        verificarSesion();
        verificarRol("admin");
        $usuario_modelo = new Usuario($this->conn);
        $comunidad_modelo = new Comunidad($this->conn);
        $becado_modelo = new Becado($this->conn);
        if (!validarId($this->id)) {
            cargar_vista("error", "404", [], true, false);
            return;
        }
        $usuarios = $usuario_modelo->obtener_usuarios();
        $comunidades = $comunidad_modelo->obtener_comunidades();
        $becado = $becado_modelo->obtener_becado($this->id);

        if (!$becado) {
            cargar_vista("error", "404", ["title" => "ERROR", "status" => "error", "message" => "Becado no encontrado", "redirect" => url("/becados")], true, false);
            return;
        }
        cargar_vista("becados", "editar", ["comunidades" => $comunidades, "usuarios" => $usuarios, "becado" => $becado], true, true);
    }

    public function actualizar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token inválido"]);
            return;
        }

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $comunidad = $_POST["comunidad"];
        $institucion = $_POST["institucion"];
        $nivel_academico = $_POST["nivel_academico"];
        $carrera = $_POST["carrera"];
        $nivel_estudio = $_POST["nivel_estudio"];
        $usuario = $_POST["usuario"];
        $becado_modelo = new Becado($this->conn);
        $becado = $becado_modelo->obtener_becado($id);
        if (!$becado) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El becado no existe"]);
            return;
        }
        if (isset($_FILES["imagen_becado"]) && $_FILES["imagen_becado"]["error"] == 0) {
            $imagen = subirImagen("imagen_becado", "becados");
            if (!eliminarImagen("becados", $becado->foto) == true) {
                echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al eliminar la imagen del becado"]);
                return;
            }
        } else {
            $imagen = $becado->foto;
        }

        $data = [
            "id_becado" => $id,
            "nombre" => $nombre,
            "foto" => $imagen,
            "id_comunidad" => $comunidad,
            "institucion" => $institucion,
            "nivel_academico" => $nivel_academico,
            "carrera" => $carrera,
            "nivel_estudio" => $nivel_estudio,
            "id_usuario" => $usuario
        ];
        $actualizar = $becado_modelo->actualizar($data);
        if ($actualizar) {
            echo json_encode(["title" => "Éxito", "status" => "success", "message" => "Becado actualizado correctamente", "redirect" => url("/becados")]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al actualizar el becado"]);
        }
    }
}