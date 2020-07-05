<?php


class DashboardController
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
        $data = array("title" => "Dashboard");
        $vista = "view/dashboard.mustache";
        $this->renderer->render($vista,$data);
    }
}