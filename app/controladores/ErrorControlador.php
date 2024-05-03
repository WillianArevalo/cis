<?php

class ErrorControlador
{
    public function index()
    {
        cargar_vista("error", "404", [], true, false);
    }
}
