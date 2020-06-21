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
        if ($this->existeSesion()) {
            echo $this->renderer->render("view/dashboard.mustache",
                array("title" => "Dashboard"));
        } else {
            header("Location: /login");
            exit();
        }
    }
}