<?php

class Reporte
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function agregar_reporte_mensual($data)
    {
        $sql = " INSERT INTO reporte_mensual(id_proyecto, mes, tema, numero_participantes, descripcion, obstaculos, enviado_por, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ississsd", $data["id_proyecto"], $data["mes"], $data["tema"], $data["numero_participantes"], $data["descripcion"], $data["obstaculos"], $data["enviado_por"], $data["fecha"]);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    }

    public function agregar_imagenes_reporte($id_reporte, $imagen)
    {
        $sql = "INSERT INTO fotografia_reporte(id_reporte, imagen) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("is", $id_reporte, $imagen);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    }

    public function obtener_reportes($id)
    {
        $sql = "SELECT * FROM reporte_mensual WHERE id_proyecto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reportes = array();
        while ($row = $result->fetch_assoc()) {
            $reporte = new stdClass();
            $reporte->id = $row["id"];
            $reporte->id_proyecto = $row["id_proyecto"];
            $reporte->mes = $row["mes"];
            $reporte->tema = $row["tema"];
            $reporte->numero_participantes = $row["numero_participantes"];
            $reporte->descripcion = $row["descripcion"];
            $reporte->obstaculos = $row["obstaculos"];
            $reporte->enviado_por = $row["enviado_por"];
            $reportes[] = $reporte;
        }
        return $reportes;
        $stmt->close();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM reporte_mensual WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function obtener_reporte_por_id($id)
    {
        $sql = "SELECT r.id AS id, mes, tema, numero_participantes, descripcion, obstaculos, enviado_por, p.id AS id_proyecto, nombre_proyecto, id_comunidad FROM reporte_mensual r INNER JOIN proyecto p ON r.id_proyecto = p.id WHERE r.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return null;

        $reporte = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $reporte->id = $row["id"];
            $reporte->id_proyecto = $row["id_proyecto"];
            $reporte->mes = $row["mes"];
            $reporte->tema = $row["tema"];
            $reporte->numero_participantes = $row["numero_participantes"];
            $reporte->descripcion = $row["descripcion"];
            $reporte->obstaculos = $row["obstaculos"];
            $reporte->enviado_por = $row["enviado_por"];
            $reporte->nombre_proyecto = $row["nombre_proyecto"];
            $reporte->id_comunidad = $row["id_comunidad"];
        }
        return $reporte;
        $stmt->close();
    }

    public function obtener_imagenes_reporte($id)
    {
        $sql = "SELECT * FROM fotografia_reporte WHERE id_reporte = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $imagenes = array();
        while ($row = $result->fetch_assoc()) {
            $imagen = new stdClass();
            $imagen->id = $row["id"];
            $imagen->imagen = $row["imagen"];
            $imagenes[] = $imagen;
        }
        return $imagenes;
        $stmt->close();
    }

    public function obtener_imagen($id)
    {
        $sql = "SELECT * FROM fotografia_reporte WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return null;

        $imagen = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $imagen->id = $row["id"];
            $imagen->id_reporte = $row["id_reporte"];
            $imagen->imagen = $row["imagen"];
        }
        return $imagen;
        $stmt->close();
    }

    public function eliminar_imagen($id)
    {
        $sql = "DELETE FROM fotografia_reporte WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function editar_reporte($data)
    {
        $sql = "UPDATE reporte_mensual SET tema = ?, numero_participantes = ?, descripcion = ?, obstaculos = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sissi", $data["tema"], $data["numero_participantes"], $data["descripcion"], $data["obstaculos"], $data["id"]);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }

    public function obtener_reporte_mes($id_proyecto, $mes)
    {
        $sql = "SELECT * FROM reporte_mensual WHERE id_proyecto = ? AND mes = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("is", $id_proyecto, $mes);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function ultimos_reportes()
    {
        $sql = "SELECT r.id AS id_reporte, r.mes, r.tema, r.enviado_por, p.nombre_proyecto, p.id AS id_proyecto FROM reporte_mensual r INNER JOIN proyecto p ON r.id_proyecto = p.id ORDER BY r.id DESC LIMIT 5";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $reportes = array();
        while ($row = $result->fetch_assoc()) {
            $reporte = new stdClass();
            $reporte->id = $row["id_reporte"];
            $reporte->id_proyecto = $row["id_proyecto"];
            $reporte->mes = $row["mes"];
            $reporte->tema = $row["tema"];
            $reporte->enviado_por = $row["enviado_por"];
            $reporte->nombre_proyecto = $row["nombre_proyecto"];
            $reportes[] = $reporte;
        }
        return $reportes;
        $stmt->close();
    }
}
