<?php

require_once "controller/GenericController.php";

 class AdminController extends GenericController {
    private $renderer;
    private $usuarioDAO;
    private $contenidistaDAO;

     /**
      * ContenidistaController constructor.
      * @param Renderer $renderer
      * @param UsuarioDAO $usuarioDAO
      * @param ContenidistaDAO $contenidistaDAO
      */

     public function __construct($renderer, $contenidistaDAO, $usuarioDAO)
     {
         $this->renderer= $renderer;
         $this->usuarioDAO=$usuarioDAO;
         $this->contenidistaDAO=$contenidistaDAO;
     }

     public function getRechazarVerificacion(){

         $idUsuario = $_GET["idUsuario"];

            try {
                $usuario = $this->usuarioDAO->getUsuarioById($idUsuario);
                $usuario["rol"] = Rol::Usuario;


                $contenidista = $this->contenidistaDAO->getContenidistaByUsuario($usuario["idUsuario"]);

                $this->usuarioDAO->updateUsuario($usuario);

                $this->contenidistaDAO->deleteContenidista($contenidista["idcontenidista"]);

                return $this->getPendientes();

            }catch (EntityNotFoundException $exEN){
                $data = array("error" => "No existe un usuario con es Id");
                $vista= "view/lista-pendiente.mustache";
                $this->genericRender($vista,$data,$this->renderer);
            }catch (UpdateEntityException $exUP){
                $data = array("error" => "No se pudo actualizar el usuario");
                $vista= "view/lista-pendiente.mustache";
                $this->genericRender($vista,$data,$this->renderer);
            }
            return null;
     }

     public function getAceptarVerificacion(){
         $idUsuario = $_GET["idUsuario"];

         try {
             $usuario = $this->usuarioDAO->getUsuarioById($idUsuario);
             $usuario["rol"] = Rol::Contenidista;

             $this->usuarioDAO->updateUsuario($usuario);

             return $this->getPendientes();

         }catch (EntityNotFoundException $exEN){
             echo $this->renderer->render("", array(
                 "error" => "No existe un usuario con es Id"
             ));
         }catch (UpdateEntityException $exUP){
             echo $this->renderer->render("", array(
                 "error" => "No se pudo actualizar el usuario"
             ));
         }
     }
     public function getPendientes(){
         $usuarios = $this->usuarioDAO->getUsuariosPendiente();
         if(count($usuarios) == 0){
             $data = array("listaVacia" => "no hay usuarios pendientes");
             $vista = "view/lista-pendiente.mustache";
         }else {
             $keys = array_keys($usuarios[0]);
             $data = array("usuarios" => $usuarios, "keys" => $keys);
             $vista = "view/lista-pendiente.mustache";
         }
         $this->genericRender($vista,$data,$this->renderer);
     }

 }
?>