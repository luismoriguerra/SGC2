<?php
class MySqlOpcSistDAO{
   
    public function actualizarOpcSist($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT copcion 
				 FROM opcionm 
				 WHERE dopcion='".$post["dopcion"]."' 
				   AND copcion!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Opcion de Sistema</b> ya existe'));exit();}
        /*******/
        $sql="UPDATE opcionm 
			  SET dopcion='".$post["dopcion"]."'
			  	, durlopc='".$post["durlopc"]."'
				, dcoment='".$post["dcoment"]."'
				, cestado='".$post["cestado"]."'
				, cusuari='".$post["usuario_modificacion"]."'
				, fusuari=now() 
			  WHERE copcion='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Opcion de Sistema Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query');
        }
    }
	
    public function insertarOpcSist($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT copcion 
				 FROM opcionm 
				 WHERE dopcion='".$post["dopcion"]."'  limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Opcion de Sistema</b> ya existe'));exit();}
        /********************/	
		$sqlver1="SELECT RIGHT(CONCAT('000',CONVERT( IFNULL(MAX(copcion),'0')+1, CHAR)),3) As copcion
				  FROM opcionm";
		$db->setQuery($sqlver1);
		$copcion=$db->loadObjectList();	 
		
        $sql="INSERT INTO opcionm (copcion, dopcion, durlopc, dcoment, cestado, cusuari, fusuari) 
			  VALUES	('".$copcion[0]['copcion']."'
						,'".$post["dopcion"]."'
						,'".$post["durlopc"]."'
						,'".$post["dcoment"]."'
						,'".$post["cestado"]."'
						,'".$post["usuario_creacion"]."'
						,now())";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Opcion de Sistema Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query');
        }   
    }
	
    public function JQGridCountOpcSist ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM opcionm WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsOpcSist ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT copcion, dopcion, durlopc, dcoment,
            CASE
                WHEN	cestado='1' THEN 'Activo'
                WHEN	cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS estado,cestado
            FROM opcionm 
            WHERE 1=1 ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
}
?>
