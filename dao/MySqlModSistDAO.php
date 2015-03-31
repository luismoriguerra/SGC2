<?php
class MySqlModSistDAO{
   
    public function actualizarModSist($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccagrop FROM cagropp where dcagrop='".$post["dcagrop"]."' and ccagrop!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Modulo de Sistema</b> ya existe'));exit();}
        /*******/
        $sql="update cagropp set dcagrop='".$post["dcagrop"]."',cestado='".$post["cestado"]."', cusuari='".$post["usuario_modificacion"]."', fusuari=now() where ccagrop='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Modulo de Sistema Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
    }
	
    public function insertarModSist($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccagrop FROM cagropp where dcagrop='".$post["dcagrop"]."'  limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Modulo de Sistema</b> ya existe'));exit();}
        /********************/	
		$sqlver1="select if (ccagrop+1 >9,(ccagrop+1),concat('0',(ccagrop+1))) as ccagrop
				  from cagropp
				  order by ccagrop desc";
		$db->setQuery($sqlver1);
		$cinstit=$db->loadObjectList();	 
		
        $sql="insert into cagropp(ccagrop,dcagrop,cestado,cusuari,fusuari) values('".$cinstit[0]['ccagrop']."','".$post["dcagrop"]."','".$post["cestado"]."','".$post["usuario_creacion"]."',now())";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Modulo de Sistema Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }   
    }
	
    public function JQGridCountModSist ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM cagropp WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsModSist ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT ccagrop,dcagrop,
            CASE
                WHEN	cestado='1' THEN 'Activo'
                WHEN	cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM cagropp 
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
