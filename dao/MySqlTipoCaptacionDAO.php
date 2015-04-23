<?php
class MySqlTipoCaptacionDAO{
   
    public function actualizarTipoCaptacion($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ctipcap FROM tipcapa where (dtipcap='".$post["dtipcap"]."' or (didetip='".$post['didetip']."' and dclacap='".$post['dclacap']."')) and ctipcap!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tipo Captacion</b> ya existe'));exit();}
        /*******/
        $sql="update tipcapa set dtipcap='".$post["dtipcap"]."',dclacap='".$post["dclacap"]."',didetip='".$post["didetip"]."',cestado='".$post["cestado"]."',cusuari='".$post["cusuari"]."',fusuari=now() where ctipcap='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Tipo Captacion Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
    }
    public function insertarTipoCaptacion($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
		$sqlVal="SELECT ctipcap FROM tipcapa where (dtipcap='".$post["dtipcap"]."' or (didetip='".$post['didetip']."' and dclacap='".$post['dclacap']."')) and ctipcap!='".$post["id"]."' limit 1";
        
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tipo Captacion</b> ya existe'));exit();}
        /********************/	
		$sqlver1="select if (ctipcap+1 >9,(ctipcap+1),concat('0',(ctipcap+1))) as ctipcap
				  from tipcapa
				  order by ctipcap desc";
		$db->setQuery($sqlver1);
		$ctipcap=$db->loadObjectList();	 
		
        $sql="insert into tipcapa(ctipcap,dtipcap,dclacap,didetip,cestado,cusuari,fusuari) values('".$ctipcap[0]['ctipcap']."','".$post["dtipcap"]."','".$post["dclacap"]."','".$post["didetip"]."','1','".$post["cusuari"]."',now())";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Tipo Captacion Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }   
    }
    public function JQGridCountTipoCaptacion ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM tipcapa WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsTipoCaptacion ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT ctipcap,dtipcap,didetip,
			if(dclacap='1','NO COMISIONAN',
				if(dclacap='2','SI COMISIONAN',
					if(dclacap='3','MASIVOS','')
				)
			) as dclacap,
			if(cestado='1','ACTIVADO','DESACTIVADO') AS cestado
            FROM tipcapa 
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
