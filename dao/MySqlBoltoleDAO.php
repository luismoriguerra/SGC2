<?php
class MySqlBoltoleDAO{
   
    public function actualizarBoltole($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cboltole FROM boltolem where (dboltole='".$post["dboltole"]."') and cboltole!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tolerancia de la boleta</b> ya existe'));exit();}
        /*******/
        $sql="update boltolem set dboltole='".$post["dboltole"]."',desbolt='".$post['desbolt']."',ntiempo='".$post['ntiempo']."',cestado='".$post["cestado"]."',cusuari='".$post["cusuari"]."',fusuari=now()  where cboltole='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Tolerancia de la boleta Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
    }
    public function insertarBoltole($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
		$sqlVal="SELECT cboltole FROM boltolem where (dboltole='".$post["dboltole"]."')  limit 1";
        
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tolerancia de la boleta</b> ya existe'));exit();}
        /********************/	
		$sqlver1="select if (cboltole+1 >9,(cboltole+1),concat('0',(cboltole+1))) as cboltole
				  from boltolem
				  order by cboltole desc";
		$db->setQuery($sqlver1);
		$cboltole=$db->loadObjectList();	 

        $sql="update boltolem set cestado='0'";
        $db->setQuery($sql);
        if(!$db->executeQuery()){
            $db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
		
        $sql="insert into boltolem(cboltole,dboltole,desbolt,ntiempo,cestado,cusuari,fusuari) values('".$cboltole[0]['cboltole']."','".$post["dboltole"]."','".$post["desbolt"]."','".$post["ntiempo"]."','".$post["cestado"]."','".$post["cusuari"]."',now())";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Tolerancia de la boleta Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }   
    }
    public function JQGridCountBoltole ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM boltolem WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsBoltole ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT cboltole,dboltole,desbolt,ntiempo,
			CASE
                WHEN	cestado='1' THEN 'Activo'
                WHEN	cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM boltolem 
            WHERE 1=1 ".$where." 
            ORDER BY cboltole DESC
            LIMIT 0,1" ;

            /* ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start*/;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
}
?>
