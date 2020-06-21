<?php


class InicioController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        echo $this->renderer->render("view/inicio.mustache");
    }
}