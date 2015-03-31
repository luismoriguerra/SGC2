<?php
class dto_enviarCorreo{
    private $idencuesta;
    private $encuesta;
    private $usuario;
    
    public function setIdEncuesta($valor){
        $this->idencuesta=$valor;
    }
    public function getIdEncuesta(){
        return $this->idencuesta;
    }
    public function setEncuesta($valor){
        $this->encuesta=$valor;
    }
    public function getEncuesta(){
        return $this->encuesta;
    }
    public function setUsuario($valor){
        $this->usuario=$valor;
    }
    public function getUsuario(){
        return $this->usuario;
    }
}
?>