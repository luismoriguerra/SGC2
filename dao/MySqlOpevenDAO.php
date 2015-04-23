<?php
class MySqlOpevenDAO{
    
    
	
    public function cargarOpevenbyTipcap($didetip){
		$sql="select o.copeven id ,  o.dopeven nombre 
from opevena o
inner join tipcapa t on o.ctipcap = t.ctipcap
where t.didetip = '$didetip'";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Institutos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Institutos','data'=>$data,'sql'=>$sql);
        }
	}
    
	
    
    
   	public function addCencap($r){
		$db=creadorConexion::crear('MySql');
                            //bypaseo de validacion de existencia
		$sql="SELECT *  FROM cencapm where 1 = 0  ";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if(count($data)==0){
			//$ccencap=$db->generarCodigo('cencapm','ccencap',7,$r['cusuari']);
			$sql="insert into opevena set  
                            dopeven= '".$r["descrip"]."' , 
                                coddpto =".$r["depa"]." , 
                                    codprov=".$r["prov"]." , 
                                        coddistr=".$r["dist"]." ,  
                                            ddiopve = '".$r["direc"]."' , 
                                                ctipcap = '".$r["tipo"]."' ,
                                                    fecreac = NOW(), 
                                                    cestado =".$r["cestado"]." , 
                                                        festado= NOW(), 
                                                        cusuari = '".$r["cusuari"]."', 
                                                            fusuari = NOW()  ";			
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
			return array('rst'=>'1','msj'=>'Centro de Operacion de Ventas Insertado');
		}
		else{
		return array('rst'=>'2','msj'=>'Ya existe centro de captación','sql'=>$sql);exit();
		}
    }
	
    public function editCencap($post){
       
	   
        $db=creadorConexion::crear('MySql');
        
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccencap FROM cencapm where 1= 0";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Centro de captacion</b> ya existe','sql'=>$sqlVal));exit();}
        /*******/
        $sql="update opevena set  
            dopeven= '".$post["descrip"]."' , 
                coddpto =".$post["depa"]." , 
                    codprov=".$post["prov"]." , 
                        coddistr=".$post["dist"]." ,  
                            ddiopve = '".$post["direc"]."' , 
                                ctipcap = '".$post["tipo"]."' , 
                                    cestado =".$post["cestado"]." , festado= NOW(), cusuari = '".$post["cusuari"]."', fusuari = NOW() where copeven = ".$post["id"]." ";			
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
		return array('rst'=>'1','msj'=>'Centro de Operación Actualizado');
    }    
    
    public function JQGridCountCencap ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql="select count(*) count
            from opevena o
            inner join tipcapa t on t.ctipcap = o.ctipcap
              WHERE 1 = 1 ".$where;
        
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
        $sql = "
            select o.* 
,t.dtipcap tipo
,( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov = 0 and u.coddist = 0) depa
,( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov = o.codprov and u.coddist = 0) prov
,( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov =o.codprov  and u.coddist = o.coddistr) dist
            from opevena o
            inner join tipcapa t on t.ctipcap = o.ctipcap
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
