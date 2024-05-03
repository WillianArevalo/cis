<?php

require_once "app/basedatos/conexion.php";


class ReportesControlador
{
    private $id;
    private $conn;
    private $becadoSession;
    private $mesActual;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        $this->becadoSession = obtenerSesión("becado");
        $this->mesActual = obtenerNombreMes(intval(date("m")));
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function index()
    {
        verificarSesion();
        verificarRol("becado");
        $reporte = new Reporte($this->conn);
        $becado = new Becado($this->conn);
        @$proyecto = $becado->obtener_proyecto_del_becado($this->becadoSession->id);

        if (!$proyecto) {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "No ha sido asignado a ningún proyecto", "redirect" => url("/inicio")], true, false);
            return;
        }

        $reportes = $reporte->obtener_reportes($proyecto->id);
        $meses = array();
        foreach ($reportes as $report) {
            array_push($meses, $report->mes);
        }
        crearSessionMeses();
        actualizarMeses($meses, $this->mesActual);
        cargar_vista("reportes", "index", ["meses_reportes" => $meses, "reportes" => $reportes]);
    }

    public function enviar()
    {
        verificarSesion();
        verificarRol("becado");
        $becado = new Becado($this->conn);
        $reporte = new Reporte($this->conn);
        $proyecto = $becado->obtener_proyecto_del_becado($this->becadoSession->id);
        if (!$proyecto) {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "No ha sido asignado a ningún proyecto", "redirect" => url("/inicio")], true, false);
            return;
        }

        $reportes = $reporte->obtener_reportes($proyecto->id);
        $meses_reporte = array();
        foreach ($reportes as $report) {
            array_push($meses_reporte, $report->mes);
        }
        crearSessionMeses();
        actualizarMeses($meses_reporte, $this->mesActual);

        $mes = $this->id;
        $meses = obtenerSesión("meses");
        if (!array_key_exists($mes, $meses)) {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "No se encontró el mes seleccionado", "redirect" => url("/reportes")], true, true);
            return;
        }

        if ($meses[$mes] == "enviado") {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "El reporte de este mes ya fue enviado", "redirect" => url("/reportes")], true, false);
            return;
        } elseif ($meses[$mes] == "no enviado") {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "Todavía no puedes enviar el reporte de este mes", "redirect" => url("/reportes")], true, false);
            return;
        }

        cargar_vista("reportes", "enviar", ["proyecto" => $proyecto, "mes" => $mes]);
    }

    public function agregar()
    {
        verificarSesion();
        verificarRol("becado");
        $reporte = new Reporte($this->conn);
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Token no válido"]);
            return;
        }

        $id_proyecto = $_POST["id"];
        $proyecto = $_POST["proyecto"];
        $mes = $_POST["mes"];
        $fecha = $_POST["fecha"];
        $tema = $_POST["tema"];
        $participantes = $_POST["participantes"];
        $descripcion = $_POST["descripcion"];
        $obstaculos = $_POST["obstaculos"];

        if (isset($_FILES["imagenes_reporte"])) {
            $imagen = subirImagenReporte("imagenes_reporte", "proyectos", $proyecto, $mes);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo subir la imagen a la carpeta"]);
            return;
        }

        if ($imagen == "") {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No hay imágenes seleccionadas"]);
            return;
        }

        $data = [
            "id_proyecto" => $id_proyecto,
            "mes" => $mes,
            "tema" => $tema,
            "numero_participantes" => $participantes,
            "descripcion" => $descripcion,
            "obstaculos" => $obstaculos,
            "enviado_por" => $this->becadoSession->nombre,
            "fecha" => $fecha
        ];

        $id = $reporte->agregar_reporte_mensual($data);
        if ($id) {
            for ($i = 0; $i < count($imagen); $i++) {
                $reporte->agregar_imagenes_reporte($id, $imagen[$i]);
            }
            echo json_encode(["status" => "success", "title" => "ÉXITO", "message" => "Reporte enviado correctamente", "redirect" => url("/reportes")]);
            return;
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo enviar el reporte"]);
            return;
        }
    }

    public function eliminar()
    {
        verificarSesion();
        verificarRol("admin");
        $token = $_POST["_token"];

        if (validarToken($token) == false) {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Token no válido"]);
            return;
        }
        $reporte_modelo = new Reporte($this->conn);
        $id = $_POST["id"];
        $reporte = $reporte_modelo->obtener_reporte_por_id($id);
        $imagenes = $reporte_modelo->obtener_imagenes_reporte($id);
        if ($imagenes) {
            foreach ($imagenes as $imagen) {
                if (!eliminarImagen("proyectos/" . $reporte->nombre_proyecto . "/" . $reporte->mes, $imagen->imagen)) {
                    echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo eliminar la imagen"]);
                    return;
                }
            }
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se encontraron imágenes"]);
            return;
        }

        $delete = $reporte_modelo->eliminar($id);
        if ($delete) {
            echo json_encode(["status" => "success", "title" => "ÉXITO", "message" => "Reporte eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo eliminar el reporte"]);
        }
    }

    public function ver()
    {
        verificarSesion();
        $reporte_modelo = new Reporte($this->conn);
        $id = $this->id;
        $reporte = $reporte_modelo->obtener_reporte_por_id($id);
        $imagenes = $reporte_modelo->obtener_imagenes_reporte($id);
        if (!$reporte || !$imagenes) {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "No se encontró el reporte", "redirect" => url("/reportes")]);
            return;
        }
        cargar_vista("reportes", "ver", ["reporte" => $reporte, "imagenes" => $imagenes]);
    }

    public function editar()
    {
        verificarSesion();
        verificarRol("admin");
        $reporte_modelo = new Reporte($this->conn);
        $id = $this->id;
        $reporte = $reporte_modelo->obtener_reporte_por_id($id);
        $imagenes = $reporte_modelo->obtener_imagenes_reporte($id);
        if (!$reporte || !$imagenes) {
            cargar_vista("error", "404", ["status" => "error", "title" => "ERROR", "message" => "No se encontró el reporte", "redirect" => url("/reportes")]);
            return;
        }
        cargar_vista("reportes", "editar", ["reporte" => $reporte, "imagenes" => $imagenes]);
    }

    public function actualizar()
    {
        verificarSesion();
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Token no válido"]);
            return;
        }

        $reporte = new Reporte($this->conn);
        $id = $_POST["id"];
        $tema = $_POST["tema"];
        $participantes = $_POST["participantes"];
        $descripcion = $_POST["descripcion"];
        $obstaculos = $_POST["obstaculos"];
        $proyecto = $_POST["proyecto"];
        $mes = $_POST["mes"];

        $data = [
            "id" => $id,
            "tema" => $tema,
            "numero_participantes" => $participantes,
            "descripcion" => $descripcion,
            "obstaculos" => $obstaculos
        ];

        if (isset($_FILES["imagenes_reporte"]) && $_FILES["imagenes_reporte"]["error"][0] == 0) {
            $imagen = subirImagenReporte("imagenes_reporte", "proyectos", $proyecto, $mes);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo subir la imagen a la carpeta"]);
            return;
        }

        $edit = $reporte->editar_reporte($data);
        if ($edit) {
            if (count($imagen) > 0) {
                for ($i = 0; $i < count($imagen); $i++) {
                    $reporte->agregar_imagenes_reporte($id, $imagen[$i]);
                }
            }
            echo json_encode(["status" => "success", "title" => "ÉXITO", "message" => "Reporte actualizado correctamente", "redirect" => url("/proyectos")]);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo actualizar el reporte"]);
        }
    }

    public function eliminar_imagen()
    {
        verificarSesion();
        $token = $_POST["_token"];
        if (validarToken($token) == false) {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "Token no válido"]);
            return;
        }
        $reporte_modelo = new Reporte($this->conn);
        $id = $_POST["id"];
        $id_reporte = $_POST["id_reporte"];
        $imagen = $reporte_modelo->obtener_imagen($id);
        $delete = $reporte_modelo->eliminar_imagen($id);
        if ($delete && $imagen) {
            $reporte = $reporte_modelo->obtener_reporte_por_id($id_reporte);
            $imagenes = $reporte_modelo->obtener_imagenes_reporte($id_reporte);
            if (!eliminarImagen("proyectos/" . $reporte->nombre_proyecto . "/" . $reporte->mes, $imagen->imagen)) {
                echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo eliminar la imagen"]);
                return;
            }
            $html = imagesReport($reporte, $imagenes);
            echo json_encode(["status" => "success", "title" => "ÉXITO", "message" => "Imagen eliminada correctamente", "html" => $html]);
        } else {
            echo json_encode(["status" => "error", "title" => "ERROR", "message" => "No se pudo eliminar la imagen"]);
        }
    }
}
