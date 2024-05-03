<?php
session_start();
require("vendor/autoload.php");

try {
    $env = \Dotenv\Dotenv::createImmutable(__DIR__);
    $env->safeLoad();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die("Error: No se pudo cargar el archivo .env");
}

require("app/auxiliares.php");
require("app/vistas/componentes.php");

registrar_modelos();
registrarResultadosAjax();

$_SERVER['REQUEST_URI'] = rtrim($_SERVER['REQUEST_URI'], "/");
$urlProyecto = $_ENV['URL_PROYECTO'];
$urlProyecto = rtrim($urlProyecto, "/");
$_SERVER['REQUEST_URI'] = str_replace($urlProyecto, '', $_SERVER['REQUEST_URI']);


if ($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "") {
    $nombreControlador = "LoginControlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
} else {
    $parametrosRequest = explode("?", $_SERVER['REQUEST_URI']);
    if (count($parametrosRequest) > 1) {
        $uriRequest = explode("/", $parametrosRequest[0]);
    } else {
        $uriRequest = explode("/", $_SERVER['REQUEST_URI']);
    }
    $nombreControlador = ucfirst($uriRequest[1] ?? "Login") . "Controlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
}

if (!file_exists($archivoControlador)) {
    $nombreControlador = "ErrorControlador";
    $archivoControlador = __DIR__ . "/app/controladores/" . $nombreControlador . ".php";
}

require_once($archivoControlador);
$controlador = new $nombreControlador();

if (isset($uriRequest[3])) {
    $id = $uriRequest[3];
    $controlador->set_id($id);
}

if (isset($uriRequest[2])) {
    $accion = $uriRequest[2];
    $parametros = array_slice($uriRequest, 4);
    if (method_exists($controlador, $accion)) {
        call_user_func_array([$controlador, $accion], $parametros);
    } else {
        cargar_vista("error", "index", [], true, false);
    }
} else {
    $controlador->index();
}