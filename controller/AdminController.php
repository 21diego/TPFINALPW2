<?php
 class AdminController{
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
                $_SESSION["usuario"] = $usuario;

                $this->usuarioDAO->updateUsuario($_SESSION["usuario"]);

                $this->contenidistaDAO->deleteContenidista($contenidista["idcontenidista"]);

                return $this->getPendientes();

            }catch (EntityNotFoundException $exEN){
                echo $this->renderer->render("view/lista-pendiente.mustache", array(
                    "error" => "No existe un usuario con es Id"
                ));
            }catch (UpdateEntityException $exUP){
                echo $this->renderer->render("view/lista-pendiente.mustache", array(
                    "error" => "No se pudo actualizar el usuario"
                ));
            }
     }

     public function getAceptarVerificacion(){
         $idUsuario = $_GET["idUsuario"];

         try {
             $usuario = $this->usuarioDAO->getUsuarioById($idUsuario);
             $usuario["rol"] = Rol::Contenidista;
             $_SESSION["usuario"] = $usuario;

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
             echo $this->renderer->render("view/lista-pendiente.mustache",
                 array("listaVacia" => "no hay usuarios pendientes"));
         }else {
             $keys = array_keys($usuarios[0]);
             echo $this->renderer->render("view/lista-pendiente.mustache",
                 array("usuarios" => $usuarios, "keys" => $keys));
         }
     }

 }
?>