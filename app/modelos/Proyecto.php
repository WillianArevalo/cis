<?php

class Proyecto
{

    private $conexion;

    public function __construct($con)
    {
        $this->conexion = $con;
    }

    public function agregar_proyecto($nombre, $id_comunidad)
    {
        $sql = "INSERT INTO proyecto (nombre_proyecto, id_comunidad) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $nombre, $id_comunidad);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    }

    public function cantidad_proyectos()
    {
        $sql = "SELECT COUNT(*) AS cantidad FROM proyecto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $proyecto = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $proyecto->total = $row["cantidad"];
        }
        return $proyecto;
        $stmt->close();
    }

    public function obtener_proyectos()
    {
        $sql = "SELECT 
      p.id AS id_proyecto, 
      p.nombre_proyecto, 
      b.id AS id_becado, 
      b.nombre AS nombre_becado,
      b.foto AS foto, 
      c.nombre AS nombre_comunidad
      FROM proyecto p
      LEFT JOIN becado b ON p.id = b.id_proyecto
      LEFT JOIN comunidad c ON c.id = p.id_comunidad";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $proyectos = array();
        while ($row = $result->fetch_assoc()) {
            $id = $row["id_proyecto"];
            $nombre = $row["nombre_proyecto"];
            $comunidad = $row["nombre_comunidad"];
            if (!isset($proyectos[$id])) {
                $proyecto = new stdClass();
                $proyecto->id = $id;
                $proyecto->nombre = $nombre;
                $proyecto->comunidad = $comunidad;
                $proyecto->becados = array();
                $proyectos[$id] = $proyecto;
            }
            $becado = new stdClass();
            $becado->id_becado = $row["id_becado"];
            $becado->nombre_becado = $row["nombre_becado"];
            $becado->foto = $row["foto"];
            $proyectos[$id]->becados[] = $becado;
        }
        return $proyectos;
        $stmt->close();
    }


    public function obtener_proyecto_por_nombre($nombre)
    {
        $sql = "SELECT * FROM proyecto WHERE nombre_proyecto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
        $stmt->close();
    }

    public function obtener_proyecto_por_id($id)
    {
        $sql = "SELECT * FROM proyecto WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $proyecto = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $proyecto->id = $row["id"];
            $proyecto->nombre = $row["nombre_proyecto"];
            $proyecto->id_comunidad = $row["id_comunidad"];
        }
        return $proyecto;
        $stmt->close();
    }

    public function eliminar_proyecto($id)
    {
        $sql = "DELETE FROM proyecto WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function actualizar_proyecto($id, $nombre, $id_comunidad)
    {
        $sql = "UPDATE proyecto SET nombre_proyecto = ?, id_comunidad = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sii", $nombre, $id_comunidad, $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function obtener_proyectos_por_comunidad($id)
    {
        $sql = "SELECT * FROM proyecto WHERE id_comunidad = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
