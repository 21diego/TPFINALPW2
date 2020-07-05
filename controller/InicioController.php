<?php

require_once "helper/Library.php";

class InicioController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        if (Library::existeSesion()) {
            header("Location: /dashboard");
            exit();
        }
        $this->renderer->render("view/inicio.mustache");
    }
}