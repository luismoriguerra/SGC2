<?php
class MySqlInstitutoDAO{
   
    public function actualizarInstituto($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cinstit FROM instita where (dinstit='".$post["dinstit"]."' or dnmeins='".$post['dnmeins']."') and cinstit!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Instituto ó Código</b> ya existe'));exit();}
        /*******/
        $sql="update instita set dinstit='".$post["dinstit"]."',dnmeins='".$post['dnmeins']."',cmodali='".$post['cmodali']."',cestado='".$post["cestado"]."' where cinstit='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Instituto Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
    }
    public function insertarInstituto($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
		$sqlVal="SELECT cinstit FROM instita where (dinstit='".$post["dinstit"]."' or dnmeins='".$post['dnmeins']."')  limit 1";
        
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Instituto ó Código</b> ya existe'));exit();}
        /********************/	
		$sqlver1="select if (cinstit+1 >9,(cinstit+1),concat('0',(cinstit+1))) as cinstit
				  from instita
				  order by cinstit desc";
		$db->setQuery($sqlver1);
		$cinstit=$db->loadObjectList();	 
		
        $sql="insert into instita(cinstit,dinstit,dnmeins,cmodali,cestado) values('".$cinstit[0]['cinstit']."','".$post["dinstit"]."','".$post["dnmeins"]."','".$post["cmodali"]."','".$post["cestado"]."')";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Instituto Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }   
    }
    public function JQGridCountInstituto ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM instita WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsInstituto ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT cinstit,dinstit,dnmeins,
			CASE
				WHEN cmodali='1'	THEN 'Presencial'
				WHEN cmodali='2'	THEN 'Virtual'
			END AS cmodali,
            CASE
                WHEN	cestado='1' THEN 'Activo'
                WHEN	cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM instita 
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
