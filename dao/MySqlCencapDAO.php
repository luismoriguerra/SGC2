<?php
class MySqlCencapDAO{
    
    public function cargarFiliales($r){
        $sql="SELECT cfilial AS id , dfilial AS nombre FROM filialm WHERE cestado = 1 ORDER BY dfilial";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filiales cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filiales','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarInstitutos(){
		$sql="SELECT concat(cinstit,'-',cmodali,'-',dnmeins) AS id , dinstit AS nombre FROM instita WHERE cestado = 1 ORDER BY dinstit";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Institutos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Institutos','data'=>$data,'sql'=>$sql);
        }
	}
	
	public function ListCencap($r){
        $sql="SELECT ccencap AS id , description AS nombre 
			  FROM cencapm 
			  WHERE cestado = 1 
			  AND cfilial='".$r['cfilial']."'
			  ORDER BY description";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filiales cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filiales','data'=>$data,'sql'=>$sql);
        }
    }
    
    
   	public function addCencap($r){
		$db=creadorConexion::crear('MySql');
		$sql="SELECT *
			  FROM cencapm 
			  WHERE cfilial='".$r['cfilial']."'
			  AND description='".$r['descrip']."'";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if(count($data)==0){
			$ccencap=$db->generarCodigo('cencapm','ccencap',7,$r['cusuari']);
			$sql="insert into cencapm set ccencap='".$ccencap."', cfilial ='".$r['cfilial']."', description = '".$r['descrip']."', fusuari = now() ,cusuari='".$r['cusuari']."', cestado='".$r['cestado']."'";			
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
			return array('rst'=>'1','msj'=>'Centro de captación Insertado');
		}
		else{
		return array('rst'=>'2','msj'=>'Ya existe centro de captación','sql'=>$sql);exit();
		}
    }
	
    public function editCencap($post){
       
	   
        $db=creadorConexion::crear('MySql');
        
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccencap FROM cencapm where description='".$post["descrip"]."' and cfilial ='".$post["cfilial"]."' and ccencap!='".$post['ccencap']."'";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Centro de captacion</b> ya existe','sql'=>$sqlVal));exit();}
        /*******/
        $sql="update cencapm set cfilial='".$post['cfilial']."',description='".$post['descrip']."', cestado='".$post['cestado']."',cusuari='".$post['cusuari']."',fusuari=now() where ccencap='".$post["ccencap"]."'";
        $db->iniciaTransaccion();
        $db->setQuery($sql);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
        $db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Centro de captacion Actualizado');
    }    
    
    public function JQGridCountCencap ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql="SELECT COUNT(*) as count FROM cencapm c WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsCencap ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT
                c.ccencap,
                c.description,
                (SELECT f.dfilial FROM filialm AS f WHERE f.cfilial = c.cfilial ) AS filial,
                cfilial,
                CASE
                WHEN	c.cestado='1' THEN 'Activo'
                WHEN	c.cestado='0' THEN 'Inactivo'
                ELSE	''
                END AS estado,
                c.cestado
              FROM cencapm c
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
