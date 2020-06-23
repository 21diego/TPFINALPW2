<?php
require_once("helper/Renderer.php");
include_once("helper/Database.php");
include_once("helper/Config.php");
require_once('third-party/mustache/src/Mustache/Autoloader.php');


class ModuleInitializer
{
    private $renderer;
    private $config;
    private $database;

    public function __construct()
    {
        $this->renderer = new Renderer('view/partial');
        $this->config = new Config("config/config.ini");
        $this->database = Database::getInstance($this->config);
    }

    public function createDefaultController()
    {
        return $this->createInicioController();
    }

    /**
     * @return InicioController
     */
    public function createInicioController()
    {
        include_once("controller/InicioController.php");
        return new InicioController($this->renderer);
    }

    /**
     * @return RegistroController
     */
    public function createRegistroController()
    {
        include_once("controller/RegistroController.php");
        include_once("dao/UsuarioDAO.php");

        $usuarioDao = new UsuarioDAO($this->database);
        return new RegistroController($usuarioDao, $this->renderer);
    }

    /**
     * @return LoginController
     */
    public function createLoginController()
    {
        include_once("controller/LoginController.php");
        include_once("dao/UsuarioDAO.php");

        $usuarioDao = new UsuarioDAO($this->database);
        return new LoginController($usuarioDao, $this->renderer);
    }

    /**
     * @return DashboardController
     */
    public function createDashboardController()
    {
        include_once("controller/DashboardController.php");
        include_once("dao/UsuarioDAO.php");

        return new DashboardController($this->renderer);
    }

    public function createLogoutController() {
        include_once ("controller/LogoutController.php");

        return new LogoutController();
    }

    public function createContenidistaController(){
        include_once ("controller/ContenidistaController.php");
        include_once ("dao/EditorialDAO.php");
        include_once ("dao/ContenidistaDAO.php");
        include_once ("dao/UsuarioDAO.php");

        $editorialDAO = new EditorialDAO($this->database);
        $contenidistaDAO = new ContenidistaDAO($this->database);
        $usuarioDAO = new UsuarioDAO(($this->database));
        return new ContenidistaController($this->renderer,$editorialDAO,$contenidistaDAO,$usuarioDAO);
    }
    public function createAdminController(){
        include_once ("controller/AdminController.php");
        include_once ("dao/ContenidistaDAO.php");
        include_once ("dao/UsuarioDAO.php");

        $contenidistaDAO = new ContenidistaDAO($this->database);
        $usuarioDAO = new UsuarioDAO(($this->database));
        return new AdminController($this->renderer,$contenidistaDAO,$usuarioDAO);
    }

    public function createNoticiaController(){
        include_once ("controller/NoticiaController.php");
        include_once ("dao/NoticiaDAO.php");
        include_once ("dao/SeccionDAO.php");

        $seccionDAO = new SeccionDAO($this->database);
        $noticiaDAO = new NoticiaDAO($this->database);
        return new NoticiaController($this->renderer,$noticiaDAO,$seccionDAO);
    }

}