<?php
class MySqlGrupUsuDAO{
    
   	public function addGrupUsu($r){
        $db=creadorConexion::crear('MySql');
		 $sqlVal="SELECT cgrupo 
				 FROM grupom 
				 WHERE dgrupo='".$r["dgrupo"]."'
				 AND cinstit='".$r["cinstit"]."'
				 LIMIT 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Grupo de usuarios</b> ya existe','sql'=>$sqlVal));exit();}
		
		
		$sqlcod = "SELECT RIGHT(CONCAT('00',CONVERT( IFNULL(MAX(cgrupo),'0')+1, CHAR)),2) As cgrupo
				   FROM grupom";
        $db->setQuery($sqlcod);
        $cgrupo=$db->loadObjectList();
		
        $sql="INSERT INTO grupom 
			  SET dgrupo = '".$r['dgrupo']."',cinstit='".$r['cinstit']."', fusuari = now() ,cusuari='".$r['cusuari']."', cestado='".$r['cestado']."', cgrupo = '".$cgrupo[0]['cgrupo']."'";
		$db->iniciaTransaccion();
        $db->setQuery($sql);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Grupo de usuarios Insertado');
    }
	
    public function editGrupUsu($r){
        $db=creadorConexion::crear('MySql');
        /****verifico que registro no exista******/
        $sqlVal="SELECT cgrupo 
				 FROM grupom 
				 WHERE dgrupo='".$r["dgrupo"]."'
				 AND cinstit='".$r["cinstit"]."'
				 AND cgrupo!='".$r['cgrupo']."'
				 LIMIT 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Grupo de usuarios</b> ya existe','sql'=>$sqlVal));exit();}
        /*******/
        $sql="UPDATE grupom 
			  SET dgrupo='".$r['dgrupo']."',cinstit='".$r['cinstit']."', cestado='".$r['cestado']."',fusuari=now(),cusuari='".$r['cusuari']."'
			  WHERE cgrupo='".$r["cgrupo"]."'";
        $db->iniciaTransaccion();
        $db->setQuery($sql);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Grupo de Usuarios Actualizado');
    }

    public function modificarPass($r){
        $db=creadorConexion::crear('MySql');
        /****verifico que registro no exista******/
        $sql="UPDATE personm 
              SET dpasper='".$r['pass']."',fusuari=now(),cusuari='".$r['cusuari']."'
              WHERE dlogper='".$r["cusuari"]."'";
        $db->iniciaTransaccion();
        $db->setQuery($sql);
        if(!$db->executeQuery()){
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al Actualizar Contraseña','sql'=>$sql);exit();
        }
        if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
        }
        $db->commitTransaccion();
        return array('rst'=>'1','msj'=>'Contraseña Actualizar');
    }    
    
    public function JQGridCountGrupUsu ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql="SELECT COUNT(*) as count FROM grupom c WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsGrupUsu ( $sidx, $sord, $start, $limit, $where) {
        $sql ="SELECT
                c.cgrupo,
                c.dgrupo,
                CASE
					WHEN	c.cestado='1' THEN 'Activo'
					WHEN	c.cestado='0' THEN 'Inactivo'
					ELSE	''
                END AS estado,
                c.cestado,
				i.dinstit as instit,i.cinstit
              FROM grupom c
			  LEFT JOIN instita i on (i.cinstit=c.cinstit)
              WHERE 1 = 1 ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
	
	/************ Grupos / Modulos / Opciones ******************/
	
    public function cargarGrupos(){
        $sql="SELECT cgrupo AS id , dgrupo AS nombre FROM grupom WHERE cestado = 1 ORDER BY dgrupo";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Grupos','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function cargarModulos(){
        $sql="SELECT ccagrop AS id , dcagrop AS nombre FROM cagropp WHERE cestado = 1 ORDER BY dcagrop";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modulos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Moulos','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function cargarOpciones(){
        $sql="SELECT copcion AS id , dopcion AS nombre FROM opcionm WHERE cestado = 1 ORDER BY dopcion";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Opciones cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Opciones','data'=>$data,'sql'=>$sql);
        }
    }
	
   	public function addGrUsuOp($r){
        $db=creadorConexion::crear('MySql');
		$sqlVal="SELECT 1 
				 FROM gruopcp 
				 WHERE cgrupo ='".$r["cgrupo"]."'
			     AND ccagrop='".$r['ccagrop']."' 
			     AND copcion='".$r['copcion']."'
				 LIMIT 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Datos ingresados</b> ya existen','sql'=>$sqlVal));exit();}
		
        $sql="INSERT INTO gruopcp 
			  SET cgrupo = '".$r['cgrupo']."', ccagrop = '".$r['ccagrop']."', copcion = '".$r['copcion']."', cestado='".$r['cestado']."'";
		$db->iniciaTransaccion();
        $db->setQuery($sql);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Datos Guardados Correctamente.');
    }
	
    public function editGrUsuOp($r){
        $db=creadorConexion::crear('MySql');
        /****verifico que registro no exista******/
        $sqlVal="SELECT 1 
				 FROM gruopcp 
				 WHERE cgrupo ='".$r["cgrupo"]."'
			     AND ccagrop='".$r['ccagrop']."' 
			     AND copcion='".$r['copcion']."'
				 AND cestado='".$r['cestado']."'
				 LIMIT 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Datos ingresados</b> ya existen','sql'=>$sqlVal));exit();}
        /*******/
        $sql="UPDATE gruopcp 
			  SET cestado='".$r['cestado']."'
			  WHERE cgrupo ='".$r["cgrupo"]."'
			  	AND ccagrop='".$r['ccagrop']."' 
				AND copcion='".$r['copcion']."'";
        $db->iniciaTransaccion();
        $db->setQuery($sql);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Datos Actualizados Correctamente.');
    }    
    
    public function JQGridCountGrUsuOp ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql="SELECT COUNT(*) as count FROM gruopcp c WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsGrUsuOp ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT
                c.cgrupo,
                g1.dgrupo,
				c.ccagrop,
				m1.dcagrop,
				c.copcion,
				o1.dopcion,
                CASE
					WHEN	c.cestado='1' THEN 'Activo'
					WHEN	c.cestado='0' THEN 'Inactivo'
					ELSE	''
                END AS estado,
                c.cestado
              FROM gruopcp c
			  	Inner Join grupom g1
					On c.cgrupo = g1.cgrupo
				Inner Join cagropp m1
					On c.ccagrop = m1.ccagrop
				Inner Join opcionm o1
					On c.copcion = o1.copcion
              WHERE 1 = 1 ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
}
?>
