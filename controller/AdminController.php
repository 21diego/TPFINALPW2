<?php

require_once "helper/Library.php";

 class AdminController {
    private $renderer;
    private $usuarioDAO;
    private $contenidistaDAO;
    private $publicacionDAO;

     /**
      * ContenidistaController constructor.
      * @param Renderer $renderer
      * @param UsuarioDAO $usuarioDAO
      * @param ContenidistaDAO $contenidistaDAO
      * @param PublicacionDAO $publicacionDAO
      */

     public function __construct($renderer, $contenidistaDAO, $usuarioDAO, $publicacionDAO)
     {
         $this->renderer= $renderer;
         $this->usuarioDAO=$usuarioDAO;
         $this->contenidistaDAO=$contenidistaDAO;
         $this->publicacionDAO=$publicacionDAO;
     }

     public function getRechazarVerificacion(){

         $idUsuario = $_GET["idUsuario"];

            try {
                $usuario = $this->usuarioDAO->getUsuarioById($idUsuario);
                $usuario["rol"] = Rol::Usuario;


                $contenidista = $this->contenidistaDAO->getContenidistaByUsuario($usuario["idUsuario"]);

                $this->usuarioDAO->updateUsuario($usuario);

                $this->contenidistaDAO->deleteContenidista($contenidista["idcontenidista"]);

                header('Location: /admin/usuariosPendientes');
                exit();

            }catch (EntityNotFoundException $exEN){
                $data = array("error" => "No existe un usuario con es Id");
                $vista= "view/lista-pendiente.mustache";
                $this->renderer->render($vista,$data);
            }catch (UpdateEntityException $exUP){
                $data = array("error" => "No se pudo actualizar el usuario");
                $vista= "view/lista-pendiente.mustache";
                $this->renderer->render($vista,$data);
            }
            return null;
     }

     public function getAceptarVerificacion(){
         $idUsuario = $_GET["idUsuario"];

         try {
             $usuario = $this->usuarioDAO->getUsuarioById($idUsuario);
             $usuario["rol"] = Rol::Contenidista;

             $this->usuarioDAO->updateUsuario($usuario);

             header('Location: /admin/usuariosPendientes');
             exit();

         }catch (EntityNotFoundException $exEN){
             $this->renderer->render("", array(
                 "error" => "No existe un usuario con es Id"
             ));
         }catch (UpdateEntityException $exUP){
             $this->renderer->render("", array(
                 "error" => "No se pudo actualizar el usuario"
             ));
         }
     }
     public function getUsuariosPendientes(){
         $usuarios = $this->usuarioDAO->getUsuariosPendiente();
         if(count($usuarios) == 0){
             $data = array("listaVacia" => "no hay usuarios pendientes");
         }else {
             $keys = array_keys($usuarios[0]);
             $data = array("usuarios" => $usuarios, "keys" => $keys);
         }
         $this->renderer->render("view/admin/lista-pendiente.mustache",$data);
     }

     public function getAceptarPublicacion(){
         $idpublicacion = $_GET['idpublicacion'];
         try{
             $this->publicacionDAO->aprobar($idpublicacion);
             header('Location: /admin/publicacionesPendientes');
             exit();
         }
         catch (Exception $ex){

         }
     }

     public function getRechazarPublicacion(){
         $idpublicacion = $_GET['idpublicacion'];
         try{
             $this->publicacionDAO->rechazar($idpublicacion);
             header('Location: /admin/publicacionesPendientes');
             exit();
         }
         catch (Exception $ex){

         }
     }

     public function getPublicacionesPendientes(){
         $publicaciones = $this->publicacionDAO->getPublicacionesPendiente();
         if(count($publicaciones) == 0){
             $data = array("listaVacia" => "no hay publicaciones pendientes");
         }else {
             $keys = array_keys($publicaciones[0]);
             $data = array("publicaciones" => $publicaciones, "keys" => $keys);
         }
         $this->renderer->render("view/admin/publicacionesPendientes.mustache",$data);
     }

 }
?>