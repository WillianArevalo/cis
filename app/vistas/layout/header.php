<!DOCTYPE html>
<html lang="en" style="visibility: hidden;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo obtenerToken() ?>">
    <title>CIS</title>
    <link rel="shortcut icon" href="<?php echo asset("img", "cis-logo.webp") ?>" type="image/x-icon">
    <!-- CSS   -->
    <link rel="stylesheet" href="<?php echo asset("css", "style.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "login.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "navbar-admin.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "navbar-becado.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "dashboard.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "becados.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "proyectos.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "comunidades.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "usuarios.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "asignar.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "reportes.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "inicio.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "error.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "perfil.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "responsive.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("css", "load.css") ?>">
    <link rel="stylesheet" href="<?php echo asset("libs/sweetalert2", "sweetalert2.css") ?>">
    <link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
    <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" />
</head>

<body id="body">
    <div id="overlay"></div>