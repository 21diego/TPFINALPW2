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
        //$publicaciones = $this->publicacion->getPublicaciones();
        $data = array("title" => "Dashboard", "publicaciones" => "publi");
        $vista = "view/dashboard.mustache";
        $this->renderer->render($vista,$data);
    }
}