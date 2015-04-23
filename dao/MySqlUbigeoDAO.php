<?
class MySqlUbigeoDAO{
    public function cargarDepartamento(){
        $sql="select u.coddpto as id,u.nombre 
			  from ubigeo u 
			  where u.codprov=0 
			  and u.coddist=0 
			  GROUP BY u.coddpto
              ORDER BY 2 ASC";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Departamentos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Departamentos','data'=>$data);
        }
    }
	
	public function cargarProvincia($dep){
        $sql="select u.codprov as id,u.nombre 
			  from ubigeo u 
			  where u.codprov!=0 
			  and u.coddist=0 
			  and u.coddpto='".$dep."' 
			  GROUP BY u.codprov
              ORDER BY 2 ASC";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Provincias cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Provincias','data'=>$data);
        }
    }
	
	public function cargarDistrito($dep,$pro){
        $sql="select u.coddist as id,u.nombre 
			  from ubigeo u 
			  where u.codprov!=0 
			  and u.coddist!=0 
			  and u.coddpto='".$dep."' 
			  and u.codprov='".$pro."' 
			  GROUP BY u.coddist
              ORDER BY 2 ASC";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Distritos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Distritos','data'=>$data);
        }
    }
}
?>