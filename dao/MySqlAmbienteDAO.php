<?php
class MySqlAmbienteDAO{

	public function cargarTipoAmbiente(){
		$db=creadorConexion::crear('MySql');		
		$sqlVal="SELECT ctipamb as id, dtipamb as nombre 
				 FROM tipamba
				 WHERE cestado='1'";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tipo de Ambiente cargado','data'=>$data);
        }
        else{
            return array('rst'=>'2','msj'=>'No existen Tipos de Ambientes','data'=>$data,'sql'=>$sql);
        }        
	}
   
    public function actualizarAmbiente($post){
        $db=creadorConexion::crear('MySql');		
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        /*******/
        $sql="UPDATE ambienm 
			  SET ncapaci ='".$post["ncapaci"]."'
				  , nmetcua ='".$post["nmetcua"]."'
				  , ntotmaq ='".$post["ntotmaq"]."'				 
				  , cestado='".$post['cestado']."'
			  WHERE cambien='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Ambiente Actualizada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }
    }
	
    public function insertarAmbiente($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
		$reg=0;
        /****verifico que registro no exista******/
        $cfilial=explode(",",$post['cfilial']);
        	for($i=0;$i<count($cfilial);$i++){
        		$sqlVal="SELECT cambien 
				 FROM ambienm 
				 WHERE cfilial='".$cfilial[$i]."' 
				   And ctipamb ='".$post["ctipamb"]."'
				   And numamb ='".$post["numamb"]."'
				   limit 1";
			        $db->setQuery($sqlVal);
			        $data=$db->loadObjectList();
					
			        if(count($data)==0){
			        	$reg++;
			        	$sql="INSERT INTO ambienm (numamb,cfilial,ctipamb,ncapaci,cusuari,fusuari,nmetcua,ntotmaq) 
			  				  VALUES	('".$post['numamb']."','".$cfilial[$i]."','".$post["ctipamb"]."','".$post["ncapaci"]."','".$post["cusuari"]."',now(),'".$post["nmetcua"]."','".$post["ntotmaq"]."')";
				        $db->setQuery($sql);
						
				        if($db->executeQuery()){
							if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
							}							
				        }
				        else{
							$db->rollbackTransaccion();
				            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
				        } 
			        }
			        /********************/			
        	}
        
        if($reg>0){
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Ambiente Ingresada','sql'=>$sql);
        }
        else{
        $db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>'No se encontraron registros nuevos','sql'=>$sql);exit();	
        }
		
          
    }
	
    public function JQGridCountAmbiente ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count 
        		FROM ambienm a 
				INNER JOIN tipamba t ON a.`ctipamb`=t.`ctipamb` 
				INNER JOIN filialm f ON f.`cfilial`=a.`cfilial`
				WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
	
    public function JQGRIDRowsAmbiente ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT a.cambien,a.`cfilial`,f.`dfilial`,a.`ctipamb`,t.`dtipamb`,a.`numamb`,a.`ncapaci`,a.`nmetcua`,a.`ntotmaq`
        		, CASE
           		 	WHEN	a.cestado='1' THEN 'Activo'
            		WHEN	a.cestado='0' THEN 'Inactivo'
            		ELSE	''
        		  END AS estado,a.cestado
				FROM ambienm a 
				INNER JOIN tipamba t ON a.`ctipamb`=t.`ctipamb` 
				INNER JOIN filialm f ON f.`cfilial`=a.`cfilial` 
            WHERE 1=1 ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }

    public function actualizarTipoAmbiente($post){       
       
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ctipamb 
                 FROM tipamba 
                 where dtipamb='".$post["dtipamb"]."' and ctipamb!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tipo Ambiente</b> ya existe'));exit();}
        /*******/
        $sql="update tipamba set dtipamb='".$post["dtipamb"]."',dnetiam='".$post['dnetiam']."',cestado='".$post["cestado"]."',cusuari='".$post['cusuari']."',fusuari=now() where ctipamb='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            return array('rst'=>'1','msg'=>'TipoAmbiente Actualizado');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }
    }

    public function insertarTipoAmbiente($post){
       
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ctipamb FROM tipamba where dtipamb='".$post["dtipamb"]."' limit 1";
        
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Tipo Ambiente</b> ya existe'));exit();}
        /********************/         
        
        $sql="insert into tipamba(dtipamb,dnetiam,cestado,cusuari,fusuari) values('".$post["dtipamb"]."','".$post["dnetiam"]."','".$post["cestado"]."','".$post['cusuari']."',now())";
        $db->setQuery($sql);
        if($db->executeQuery()){
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            return array('rst'=>'1','msg'=>'TipoAmbiente Ingresado');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query');
        }   
    }

    public function JQGridCountTipoAmbiente ( $where ) {

       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM tipamba WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }

    public function JQGRIDRowsTipoAmbiente ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT ctipamb,dtipamb,dnetiam,
            CASE
                WHEN    cestado='1' THEN 'Activo'
                WHEN    cestado='0' THEN 'Inactivo'
                ELSE    ''
            END AS cestado
            FROM tipamba 
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
