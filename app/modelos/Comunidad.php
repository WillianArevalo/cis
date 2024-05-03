<?php

class Comunidad
{
    private $conexion;

    public function __construct($con)
    {
        $this->conexion = $con;
    }

    public function obtener_comunidades()
    {
        $sql = "SELECT * FROM comunidad";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $comunidades = array();
        while ($row = $result->fetch_assoc()) {
            $comunidad = new StdClass();
            $comunidad->id = $row["id"];
            $comunidad->nombre = $row["nombre"];
            $comunidades[] = $comunidad;
        }
        return $comunidades;
        $stmt->close();
    }

    public function obtener_comunidad_por_id($id)
    {
        $sql = "SELECT * FROM comunidad WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comunidad = new StdClass();
        while ($row = $result->fetch_assoc()) {
            $comunidad->id = $row["id"];
            $comunidad->nombre = $row["nombre"];
        }
        return $comunidad;
        $stmt->close();
    }

    public function cantidad_comunidades()
    {
        $sql = "SELECT COUNT(*) as cantidad FROM comunidad";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $comunidad = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $comunidad->total = $row["cantidad"];
        }
        return $comunidad;
        $stmt->close();
    }

    public function agregar_comunidad($nombre_comunidad)
    {
        $sql = "INSERT INTO comunidad (nombre) VALUES (?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre_comunidad);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM comunidad WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function obtener_comunidad_por_nombre($nombre)
    {
        $sql = "SELECT * FROM comunidad WHERE nombre = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
        $stmt->close();
    }

    public function actualizar_comunidad($id, $nombre)
    {
        $sql = "UPDATE comunidad SET nombre = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }
}