<?php
class dto_informe{
    private $id;
    private $nombre;
    private $estado;
    private $usuario;
    private $fecha_creacion;
    private $observacion;
    private $idencuesta;
    private $nickname;
    private $contrasena;
    private $correo;
    private $cargo;
    private $nombres;
    private $apellidos;
    private $criticidad_saludable_ini;
    private $criticidad_saludable_fin;
    private $criticidad_regular_ini;
    private $criticidad_regular_fin;
    private $criticidad_critico_ini;
    private $criticidad_critico_fin;



    public function setCriticoIni($valor){
        $this->criticidad_critico_ini=$valor;
    }
    public function getCriticoIni(){
        return $this->criticidad_critico_ini;
    }
    public function setCriticoFin($valor){
        $this->criticidad_critico_fin=$valor;
    }
    public function getCriticoFin(){
        return $this->criticidad_critico_fin;
    }
    public function setRegularIni($valor){
        $this->criticidad_regular_ini=$valor;
    }
    public function getRegularIni(){
        return $this->criticidad_regular_ini;
    }
    public function setRegularFin($valor){
        $this->criticidad_regular_fin=$valor;
    }
    public function getRegularFin(){
        return $this->criticidad_regular_fin;
    }
    public function setSaludableIni($valor){
        $this->criticidad_saludable_ini=$valor;
    }
    public function getSaludableIni(){
        return $this->criticidad_saludable_ini;
    }
    public function setSaludableFin($valor){
        $this->criticidad_saludable_fin=$valor;
    }
    public function getSaludableFin(){
        return $this->criticidad_saludable_fin;
    }
    
    public function setApellidos($valor){
        $this->apellidos=$valor;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function setNombres($valor){
        $this->nombres=$valor;
    }
    public function getNombres(){
        return $this->nombres;
    }
    public function setCargo($valor){
        $this->cargo=$valor;
    }
    public function getCargo(){
        return $this->cargo;
    }
    public function setCorreo($valor){
        $this->correo=$valor;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function setContrasena($valor){
        $this->contrasena=$valor;
    }
    public function getContrasena(){
        return $this->contrasena;
    }
    public function setNickname($valor){
        $this->nickname=$valor;
    }
    public function getNickname(){
        return $this->nickname;
    }
    public function setIdEncuesta($valor){
        $this->idencuesta=$valor;
    }
    public function getIdEncuesta(){
        return $this->idencuesta;
    }
    public function setFechaCreacion($valor){
        $this->fecha_creacion=$valor;
    }
    public function getFechaCreacion(){
        return $this->fecha_creacion;
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