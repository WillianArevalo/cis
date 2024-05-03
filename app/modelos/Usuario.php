<?php

class Usuario
{
    private $conexion;

    public function __construct($con)
    {
        $this->conexion = $con;
    }

    public function buscar_por_email($email)
    {
        $sql = "SELECT id, clave, email,usuario, rol FROM usuario WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 0) return false;

        $usuario = new stdClass();
        while ($row = $resultado->fetch_assoc()) {
            $usuario->id = $row["id"];
            $usuario->clave = $row["clave"];
            $usuario->email = $row["email"];
            $usuario->usuario = $row["usuario"];
            $usuario->rol = $row["rol"];
        }
        return $usuario;
        $stmt->close();
    }

    public function obtener_becado_por_usuario($id)
    {
        $sql = "SELECT * FROM becado WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $becado = new StdClass();
        while ($row = $resultado->fetch_assoc()) {
            $becado->id = $row["id"];
            $becado->nombre = $row["nombre"];
            $becado->foto = $row["foto"];
            $becado->id_usuario = $row["id_usuario"];
        }
        return $becado;
        $stmt->close();
    }

    public function agregar_usuario($data)
    {
        $sql = "INSERT INTO usuario (clave, usuario, rol, email) VALUES ( ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssss", $data["clave"], $data["usuario"], $data["rol"], $data["email"]);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    }

    public function obtener_usuarios()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = array();
        while ($row = $result->fetch_assoc()) {
            $usuario = new StdClass();
            $usuario->id = $row["id"];
            $usuario->usuario = $row["usuario"];
            $usuario->rol = $row["rol"];
            $usuario->email = $row["email"];
            $usuarios[] = $usuario;
        }
        return $usuarios;
        $stmt->close();
    }

    public function obtener_usuarios_disponibles()
    {
        $sql = "SELECT u.id AS id, u.usuario as usuario ,u.rol AS rol FROM usuario u LEFT JOIN becado b ON u.id = b.id_usuario WHERE b.id_usuario IS NULL";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = array();

        while ($row = $result->fetch_assoc()) {
            $usuario = new StdClass();
            $usuario->id = $row["id"];
            $usuario->usuario = $row["usuario"];
            $usuario->rol = $row["rol"];
            $usuarios[] = $usuario;
        }
        return $usuarios;
        $stmt->close();
    }

    public function obtener_usuario_por_id($id)
    {
        $sql = "SELECT id, usuario, rol, email, clave FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $usuario->id = $row["id"];
            $usuario->usuario = $row["usuario"];
            $usuario->rol = $row["rol"];
            $usuario->password = $row["clave"];
            $usuario->email = $row["email"];
        }
        return $usuario;
        $stmt->close();
    }

    public function actualizar_usuario($data)
    {
        $sql = "UPDATE usuario SET email = ?, usuario = ?, rol = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssi", $data["email"], $data["usuario"], $data["rol"], $data["id"]);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function eliminar_usuario($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function cambiar_clave($id, $clave)
    {
        $sql = "UPDATE usuario SET clave = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $clave, $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function cambiar_correo($id, $correo)
    {
        $sql = "UPDATE usuario SET email = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $correo, $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }
}