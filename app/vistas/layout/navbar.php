<?php
$role = $_SESSION['usuario']->rol ?? 'becado';
require_once 'app/vistas/layout/navbar/' . $role . '.php';
