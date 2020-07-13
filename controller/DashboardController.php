<?php


class DashboardController
{
    private $renderer;
    private $publicacion;

    /**
     * DashboardController constructor.
     * @param Renderer $renderer
     * @param PublicacionDAO $publicacionDAO
     */
    public function __construct(Renderer $renderer, $publicacionDAO)
    {
        $this->renderer = $renderer;
        $this->publicacion = $publicacionDAO;
    }

    public function getIndex()
    {
        $data = array();
        $vista = "view/dashboard.mustache";
        $this->renderer->render($vista,$data);
    }
}