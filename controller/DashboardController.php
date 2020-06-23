<?php

require_once "controller/GenericController.php";

class DashboardController extends GenericController
{
    private $renderer;

    /**
     * DashboardController constructor.
     * @param Renderer $renderer
     */
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        $rol = $_SESSION['usuario']['rol'];
        $data = array("title" => "Dashboard","$rol" => 'rol');
        $this->verficarUsuario("view/dashboard.mustache",$data,$this->renderer);
    }
}