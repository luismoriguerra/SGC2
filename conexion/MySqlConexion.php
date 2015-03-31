<?php
class MySqlConexion {

    private $conexion;
    private $resource;
    private $sql;
    public $queries;
    private static $_singleton;

    public static function getInstance(){
        if (is_null (self::$_singleton)) {
                self::$_singleton = new MySqlConexion();
        }
        return self::$_singleton;
    }

    private function __construct(){
        $config=new configMySql();
        $this->conexion = mysqli_connect($config->getHost(),$config->getUser(),$config->getPass(),$config->getDataBase());
        $this->queries = 0;
        $this->resource = null;
    }

    public function iniciaTransaccion(){
        if(!(mysqli_query($this->conexion,'begin'))){
                return false;
        }
        return true;
    }
    
    public function commitTransaccion(){
        return $this->conexion->commit();
    }
    
    public function rollbackTransaccion(){
        return $this->conexion->rollback();
    }
    public function last_insert_id(){
        return $this->conexion->insert_id;
    }
    public function execute(){
        //group_concat aumento de caracteres
            //mysqli_query($this->conexion,'SET GLOBAL group_concat_max_len=10000');
        if(!($this->resource = mysqli_query($this->conexion, $this->sql))){
                return null;
        }
        $this->queries++;
        return $this->resource;
    }
    public function getError(){
        return mysqli_error($this->conexion);
    }
    public function executeQuery(){
        if(!($this->resource = mysqli_query($this->conexion,$this->sql))){
            return false;
        }
        return true;
    }
    public function alter(){
            if(!($this->resource = mysqli_query($this->sql, $this->conexion))){
                    return false;
            }
            return true;
    }
    public function loadObjectList(){
            if (!($cur = $this->execute())){
                    return null;
            }
            $array = array();
            while ($row = mysqli_fetch_assoc($cur)){
                    $array[] = $row;
            }
            return $array;
    }

    public function setQuery($sql){
            if(empty($sql)){
                    return false;
            }
            $this->sql = $sql;
            return true;
    }

    public function freeResults(){
            @mysqli_free_result($this->resource);
            return true;
    }

    public function loadObject(){
        if ($cur = $this->execute()){
            if ($object = mysqli_fetch_object($cur)){
                @mysqli_free_result($cur);
                return $object;
            }
            else {
                return null;
            }
        }
        else {
            return false;
        }
    }
	
	public function generarCodigo($tabla,$campoLlave,$longitud,$cusuari){
	/*$a="desc ".$tabla;
	$this->setQuery($a);
	$data=$this->loadObjectList();
	$i=false;
	foreach($data as $r){
		if($r['Field']=="cfilial"){
		$i=true;
		}
	}
	
	if($i==true){
	$cad="Select ".$campoLlave." from ".$tabla." where cfilial='".$cfilial."'  order by ".$campoLlave." desc limit 0,1";
	}
	else{*/
	$cad="	select  substr(".$campoLlave.",9) as ".$campoLlave."
			from ".$tabla."
			where substr(".$campoLlave.",1,8)='".$cusuari."'
			order by ".$campoLlave." DESC
			limit 0,1";
	//$cad="Select ".$campoLlave." from ".$tabla." order by ".$campoLlave." desc limit 0,1";
	//}
	$this->setQuery($cad);
	$fila=$this->loadObjectList();	
	$longitud=$longitud-3;
	if(count($fila)>0){
		foreach($fila as $f){
		$dato[0]=substr($f[$campoLlave],0,3);
		$dato[1]=substr($f[$campoLlave],3,$longitud);
		}
	}else{
		$dato[1]=0;
		$dato[0]=date("y");
	}
	
	if($dato[0]!=date("y")){
	$dato[1]=0;
	}
	$dato[1]++;
	$cod=$cusuari."0".date("y").str_pad($dato[1],$longitud,"0",0);
	
	return $cod;
	}
	
    
    public function limpiaString($txt){
        //return mysql_real_escape_string($txt, $this->conexion);
        return $this->conexion->real_escape_string($txt);
    }

    function __destruct(){
        @mysqli_free_result($this->resource);
        @mysqli_close($this->conexion);
    }
}
?>