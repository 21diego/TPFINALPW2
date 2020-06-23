<?php

require_once "controller/GenericController.php";

class InicioController extends GenericController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        if ($this->existeSesion()) {
            header("Location: /dashboard");
            exit();
        }
        echo $this->renderer->render("view/inicio.mustache");
    }
}