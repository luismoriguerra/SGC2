<?php
class dto_usuario{
    private $id;//idusuario
    private $perfil;
    private $nombre;
    private $paterno;
    private $materno;
    private $dni;
    private $password;
    private $estado;
    private $usuario;//idusuario quien crea o modifica
    
    public function setPerfil($valor){
        $this->perfil=$valor;
    }
    public function getPerfil(){
        return $this->perfil;
    }
    public function setEstado($valor){
        $this->estado=$valor;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setMaterno($valor){
        $this->materno=$valor;
    }
    public function getMaterno(){
        return $this->materno;
    }
    public function setPaterno($valor){
        $this->paterno=$valor;
    }
    public function getPaterno(){
        return $this->paterno;
    }
    public function setNombre($valor){
        $this->nombre=$valor;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setId($valor){
        $this->id=$valor;
    }
    public function getId(){
        return $this->id;
    }
    public function setUsuario($valor){
        $this->usuario=$valor;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function setDni($valor){
        $this->dni=$valor;
    }
    public function getDni(){
        return $this->dni;
    }
    public function setPassword($valor){
        $this->password=$valor;        
    }
    public function getPassword(){
        return $this->password;
    }
}

?>
