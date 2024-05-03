<?php

require_once "app/basedatos/conexion.php";

class PerfilControlador
{
    private $conn;
    private $usuarioSession;
    private $becadoSession;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        $this->usuarioSession = obtenerSesión("usuario");
        $this->becadoSession = obtenerSesión("becado");
    }

    public function index()
    {
        verificarSesion();
        $becado_modelo = new Becado($this->conn);
        $comunidad_modelo = new Comunidad($this->conn);
        $proyecto_modelo = new Proyecto($this->conn);

        if (isset($this->becadoSession)) {
            @$becado = $becado_modelo->obtener_becado($this->becadoSession->id);
            if ($becado) {
                $comunidad = $comunidad_modelo->obtener_comunidad_por_id($becado->id_comunidad);
                $proyecto = $proyecto_modelo->obtener_proyecto_por_id($becado->id_proyecto);
                $this->becadoSession = $becado;
            } else {
                $comunidad = null;
                $proyecto = null;
            }
        }
        cargar_vista("perfil", "index", ["becado" => $this->becadoSession, "usuario" => $this->usuarioSession, "comunidad" => $comunidad, "proyecto" => $proyecto]);
    }

    public function actualizar()
    {
        verificarSesion();
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Token no válido"]);
            return;
        }
        $usuario_modelo = new Usuario($this->conn);
        $password = $_POST["actual_password"];
        $nuevaPassword = $_POST["nueva_password"];
        $usuario = $usuario_modelo->obtener_usuario_por_id($this->usuarioSession->id);
        if (password_verify($password, $usuario->password)) {
            $usuario_modelo->cambiar_clave($this->usuarioSession->id, password_hash($nuevaPassword, PASSWORD_DEFAULT));
            echo json_encode(["status" => "success", "title" => "Éxito", "message" => "Contraseña actualizada correctamente, se cerrará la sesión", "redirect" => url("/login/logout")]);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Contraseña incorrecta"]);
        }
    }
}
