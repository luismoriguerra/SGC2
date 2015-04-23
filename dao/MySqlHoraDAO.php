<?php
class MySqlHoraDAO{
   
    public function actualizarHora($post){
        $db=creadorConexion::crear('MySql');		
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT chora 
				 FROM horam 
				 WHERE cinstit='".$post["cinstit"]."' 
				   And cturno ='".$post["cturno"]."'
				   And hinici ='".$post["hinici"]."'
				   And hfin   ='".$post["hfin"]."'
				   And thorari='".$post["thorari"]."'
				   And thora  ='".$post["thora"]."'				   
				   AND chora!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Hora</b> ya existe'));exit();}
        /*******/
        $sql="UPDATE horam 
			  SET cinstit ='".$post["cinstit"]."'
				  , cturno ='".$post["cturno"]."'
				  , hinici ='".$post["hinici"]."'
				  , hfin   ='".$post["hfin"]."'
				  , thorari='".$post["thorari"]."'
				  , thora  ='".$post["thora"]."'
				  , cestado='".$post['cestado']."'
			  WHERE chora='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Hora Actualizada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }
    }
	
    public function insertarHora($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT chora 
				 FROM horam 
				 WHERE cinstit='".$post["cinstit"]."' 
				   And cturno ='".$post["cturno"]."'
				   And hinici ='".$post["hinici"]."'
				   And hfin   ='".$post["hfin"]."'
				   And thorari='".$post["thorari"]."'
				   And thora  ='".$post["thora"]."'
				   AND chora!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Hora</b> ya existe'));exit();}
        /********************/	
		$sqlver1="SELECT RIGHT(CONCAT('000000',CONVERT( IFNULL(MAX(chora),'0')+1, CHAR)),6) As chora
				  FROM horam";
		$db->setQuery($sqlver1);
		$chora=$db->loadObjectList();	 
		
        $sql="INSERT INTO horam (chora, cturno, cinstit, hinici, hfin, thorari, thora, cestado, cusuari, fusuari) 
			  VALUES	('".$chora[0]['chora']."'
						,'".$post["cturno"]."'
						,'".$post["cinstit"]."'
						,'".$post["hinici"]."'
						,'".$post["hfin"]."'
						,'".$post["thorari"]."'
						,'".$post["thora"]."'
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
            return array('rst'=>'1','msj'=>'Hora Ingresada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
	
    public function JQGridCountHora ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM horam c 
				INNER JOIN instita c2
					ON c.cinstit = c2.cinstit
				INNER JOIN turnoa c3
					ON c.cturno = c3.cturno WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsHora ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT c.chora
				   , c3.dturno
				   , c3.cturno
				   , c2.dinstit
				   , c2.cinstit
				   , c.hinici
				   , c.hfin
				   , CASE
               		 	WHEN	c.thorari='R' THEN 'Regular'
                		WHEN	c.thorari='M' THEN 'Muerto'
                		ELSE	''
            		 END AS thorari
				   , c.thorari As cod_thorari
				   , CASE
               		 	WHEN	c.thora='2' THEN 'Grupo'
                		WHEN	c.thora='1' THEN 'Curso'
                		ELSE	''
            		 END AS thora
				   , c.thora As cod_thora
				   , CASE
               		 	WHEN	c.cestado='1' THEN 'Activo'
                		WHEN	c.cestado='0' THEN 'Inactivo'
                		ELSE	''
            		 END AS estado,c.cestado
            FROM horam c 
				INNER JOIN instita c2
					ON c.cinstit = c2.cinstit
				INNER JOIN turnoa c3
					ON c.cturno = c3.cturno
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
