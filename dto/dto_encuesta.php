<?php
class dto_encuesta{
    private $id;
    private $nombre;
    private $estado;
    private $usuario;
    private $fecha_creacion;
    private $fecha_realizacion;
    private $observacion;
    private $idempresa;

    public function setIdEmpresa($valor){
        $this->idempresa=$valor;
    }
    public function getIdEmpresa(){
        return $this->idempresa;
    }
    public function setFechaCreacion($valor){
        $this->fecha_creacion=$valor;
    }
    public function getFechaCreacion(){
        return $this->fecha_creacion;
    }
    public function setFechaRealizacion($valor){
        $this->fecha_realizacion=$valor;
    }
    public function getFechaRealizacion(){
        return $this->fecha_realizacion;
    }
    public function setObservacion($valor){
        $this->observacion=$valor;
    }
    public function getObservacion(){
        return $this->observacion;
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