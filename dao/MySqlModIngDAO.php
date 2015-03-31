<?php
class MySqlModIngDAO{
   
    public function actualizarModIng($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cmoding 
				 FROM modinga 
				 WHERE dmoding='".$post["dmoding"]."' 
				   And cinstita='".$post["cinstit"]."'
				   AND cmoding!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Modalidad de Ingreso</b> ya existe'));exit();}
        /*******/
        $sql="UPDATE modinga 
			  SET dmoding ='".$post["dmoding"]."'
			  	, treqcon ='".$post["treqcon"]."'
				, cestado ='".$post["cestado"]."'
				, cusuari ='".$post["usuario_modificacion"]."'				
				, fusuari =now() 
			  WHERE cmoding='".$post["id"]."'
			    AND cinstita='".$post["cinstit"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Modalidad de Ingreso Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query');
        }
    }
	
    public function insertarModIng($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cmoding 
				 FROM modinga 
				 WHERE dmoding='".$post["dmoding"]."'				 
				   AND cinstita='".$post["cinstit"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Modalidad de Ingreso</b> ya existe'));exit();}
        /********************/	
		$sqlver1="SELECT RIGHT(CONCAT('00',CONVERT( IFNULL(MAX(cmoding),'0')+1, CHAR)),2) As cmoding
				  FROM modinga";
		$db->setQuery($sqlver1);
		$cmoding=$db->loadObjectList();	 
		
        $sql="INSERT INTO modinga (cmoding, dmoding, cinstita, cestado, cusuari, fusuari,treqcon) 
			  VALUES	('".$cmoding[0]['cmoding']."'
						,'".$post["dmoding"]."'
						,'".$post["cinstit"]."'
						,'".$post["cestado"]."'
						,'".$post["usuario_creacion"]."'
						,now()
						,'".$post["treqcon"]."')";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Modalidad de Ingreso Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query');
        }   
    }
	
    public function JQGridCountModIng ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM modinga c,instita c2  WHERE c.cinstita=c2.cinstit ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsModIng ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT c.cmoding
				   , c.dmoding
				   , c2.dinstit
				   , c2.cinstit
				   , CASE
               		 	WHEN	c.cestado='1' THEN 'Activo'
                		WHEN	c.cestado='0' THEN 'Inactivo'
                		ELSE	''
            		 END AS destado,c.cestado
					, CASE
               		 	WHEN	c.treqcon='S' THEN 'SI'
                		WHEN	c.treqcon='N' THEN 'NO'
                		ELSE	''
            		 END AS dreqcon,treqcon
            FROM modinga c 
				INNER JOIN instita c2
					ON c.cinstita = c2.cinstit
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
