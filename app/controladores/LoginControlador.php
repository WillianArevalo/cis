<?php

require_once "app/basedatos/conexion.php";

class LoginControlador
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function index()
    {
        generarToken();
        cargar_vista("login", "index", [], true, false);
    }

    public function validar()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Token no válido"]);
            return;
        }

        $modeloUsuario = new Usuario($this->conn);
        $usuario = $modeloUsuario->buscar_por_email($email);

        if ($usuario) {
            $becado = $modeloUsuario->obtener_becado_por_usuario($usuario->id);
            if (password_verify($password, $usuario->clave)) {
                $_SESSION["usuario"] = $usuario;
                $_SESSION["becado"] = $becado;
                $url = ($usuario->rol == "admin") ? url("/dashboard") : url("/inicio");
                echo json_encode(["title" => "BIENVENIDO&nbsp" . strtoupper($usuario->usuario), "status" => "success", "message" => "Inicio de sesión correcto", "redirect" => $url]);
            } else {
                echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Contraseña incorrecta"]);
            }
        } else {
            echo json_encode(["title" => "ERROR", "status" => "error", "message" => "Usuario no encontrado"]);
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . url("/login"));
    }
}
