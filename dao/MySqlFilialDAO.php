<?php
class MySqlFilialDAO{
   
    public function actualizarFilial($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cfilial FROM filialm where (dfilial='".$post["dfilial"]."' or cfilial='".$post['cfilial']."')  and cfilial!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Filial</b> ya existe','sql'=>$sqlVal));exit();}
        /*******/
        $sql="update filialm set cfilial='".$post["cfilial"]."',dfilial='".$post["dfilial"]."',ddirfil='".$post["ddirfil"]."',ntelfil='".$post["ntelfil"]."',cestado='".$post["cestado"]."',cusuari='".$post['cusuari']."',fusuari=now() where cfilial='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Filial Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }
    }
    public function insertarFilial($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cfilial FROM filialm where dfilial='".$post["dfilial"]."'  limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Filial</b> ya existe','sql'=>$sqlVal));exit();}
        /********************/		
        $sql="insert into filialm(cfilial,dfilial,ddirfil,ntelfil,cestado,cusuari,fcreaci,fusuari) values('".$post['cfilial']."','".$post["dfilial"]."','".$post['ddirfil']."','".$post['ntelfil']."','".$post["cestado"]."','".$post['cusuari']."',now(),now())";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Filial Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    public function JQGridCountFilial ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM filialm WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsFilial ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT cfilial,dfilial,ddirfil,ntelfil,
            CASE
                WHEN	cestado='1' THEN 'Activo'
                WHEN	cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM filialm 
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
