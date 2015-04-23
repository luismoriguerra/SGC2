<?php
class dto_empresa{
    private $id;
    private $nombre;
    private $estado;
    private $usuario;
    private $ruc;
    private $email;

    public function setRuc($valor){
        $this->ruc=$valor;
    }
    public function getRuc(){
        return $this->ruc;
    }
    public function setEmail($valor){
        $this->email=$valor;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setId($valor){
        $this->id=$valor;
    }
    public function getId(){
        return $this->id;
    }
    public function setNombre($valor){
        $this->nombre=$valor;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setEstado($valor){
        $this->estado=$valor;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setUsuario($valor){
        $this->usuario=$valor;
    }
    public function getUsuario(){
        return $this->usuario;
    }
}
?>