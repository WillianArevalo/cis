<?php

require_once "app/basedatos/conexion.php";

class UsuariosControlador
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
        $usuario = new Usuario($this->conn);
        $usuarios = $usuario->obtener_usuarios();
        cargar_vista("usuarios", "index", ["usuarios" => $usuarios]);
    }


    public function agregar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];
        $usuario_modelo = new Usuario($this->conn);
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido", "url" => null]);
            return;
        }

        $usuario = $_POST["usuario"];
        $email = $_POST["email"];
        $clave = $_POST["password"];
        $rol = $_POST["rol"];

        $search = $usuario_modelo->buscar_por_email($email);
        if ($search) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "El usuario ya existe."]);
            return;
        }

        $data = array(
            "email" => $email,
            "clave" => password_hash($clave, PASSWORD_DEFAULT),
            "usuario" => $usuario,
            "rol" => $rol
        );

        $id = $usuario_modelo->agregar_usuario($data);
        if ($id) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Usuario agregado correctamente."]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al agregar el usuario."]);
        }
    }

    public function editar()
    {
        verificarSesion();
        verificarRol("admin");
        $usuario_modelo = new Usuario($this->conn);
        $id = $_POST["id"];
        $usuario = $usuario_modelo->obtener_usuario_por_id($id);
        if ($usuario) {
            echo json_encode(["status" => "success", "usuario" => $usuario]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Usuario no encontrado.", "url" => "usuarios"]);
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

        $usuario_modelo = new Usuario($this->conn);
        $id = $_POST["id"];
        $becado = $usuario_modelo->obtener_becado_por_usuario($id);
        if ($becado) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "No se puede eliminar el usuario, tiene un becado asociado.", "url" => "usuarios"]);
            return;
        }

        $delete = $usuario_modelo->eliminar_usuario($id);
        if ($delete) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Usuario eliminado correctamente."]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al eliminar el usuario."]);
        }
    }

    public function obtenerForm()
    {
        verificarSesion();
        verificarRol("admin");
        $html = formAgregarUsuario();
        echo json_encode(["status" => "success", "html" => $html]);
    }

    public function obtenerFormEdit()
    {
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }
        $usuario = new Usuario($this->conn);
        $id = $_POST["id"];
        $usuario = $usuario->obtener_usuario_por_id($id);
        $html = formEditarUsuario($usuario);
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

        $usuario_modelo = new Usuario($this->conn);
        $id = $_POST["id"];
        $usuario = $usuario_modelo->obtener_usuario_por_id($id);
        if (!$usuario) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Usuario no encontrado."]);
            return;
        }

        $usuario = $_POST["usuario"];
        $email = $_POST["email"];
        $rol = $_POST["rol"];

        $data = array(
            "id" => $id,
            "email" => $email,
            "usuario" => $usuario,
            "rol" => $rol
        );

        $update = $usuario_modelo->actualizar_usuario($data);
        if ($update) {
            echo json_encode(["title" => "¡ÉXITO!", "status" => "success", "message" => "Usuario actualizado correctamente."]);
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Error al actualizar el usuario."]);
        }
    }
}