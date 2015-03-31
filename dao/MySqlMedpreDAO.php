<?php
class MySqlMedpreDAO{   
	public function ListarFiltro(){
		$db=creadorConexion::crear('MySql');
		$sql="	select upper(didetip) as id,upper(didetip) as nombre
				from tipcapa
				where cestado=1
				and dclacap=3
				order by didetip";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filtros cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filtros','data'=>$data,'sql'=>$sql);
        }
	}
    public function actualizarMedpre($post){
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cmedpre 
				 FROM medprea 
				 WHERE dmedpre='".$post["dmedpre"]."' 
				   And cfilial='".$post["cfilial"]."'
                                   and tmedpre = '".$post["tmedpre"]."'
				   AND cmedpre!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Medio de Prensa</b> ya existe'));exit();}
        /*******/
        $sql="UPDATE medprea 
			  SET dmedpre ='".$post["dmedpre"]."'
				, tmedpre ='".$post["tmedpre"]."'
				, cfilial = '".$post["cfilial"]."'
			  WHERE cmedpre='".$post["id"]."'";
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
	
    public function insertarMedpre($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        $filiales = $post["cfilial"];
        $mensaje = "";
        foreach($filiales as $filial){
         $post["cfilial"] =    $filial ;
        
            /****verifico que registro no exista******/
        $sqlVal="SELECT cmedpre 
				 FROM medprea 
				 WHERE dmedpre='".$post["dmedpre"]."'
				   AND cfilial='".$post["cfilial"]."' 
                                       AND tmedpre='".$post["tmedpre"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Medio de prensa</b> ya existe'));exit();}
        /********************/	
		$sqlver1="SELECT RIGHT(CONCAT('00',CONVERT( IFNULL(MAX(cmedpre),'0')+1, CHAR)),4) As cmedpre
				  FROM medprea";
		$db->setQuery($sqlver1);
		$cmedpre=$db->loadObjectList();	 
		
        $sql="INSERT INTO medprea (cmedpre, dmedpre, cfilial, tmedpre) 
			  VALUES	('".$cmedpre[0]['cmedpre']."'
						,'".$post["dmedpre"]."'
						,'".$post["cfilial"]."'
						,'".$post["tmedpre"]."'
						)";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
            $db->commitTransaccion();
            $mensaje = array('rst'=>'1','msj'=>'Medio de Prensa Ingresado');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query');
        }
        }
        
        if( $mensaje != ""){
            return array('rst'=>'1','msj'=>'Medio de Prensa Ingresado en las filiales seleccionados');
        }
    }
	
    public function JQGridCountMedpre ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count 
            FROM medprea c 
            inner JOIN filialm c2 on c2.cfilial = c.cfilial
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
	
    public function JQGRIDRowsMedpre ( $sidx, $sord, $start, $limit, $where) {
        $sql = "select 
DISTINCT c.cmedpre,
c.dmedpre,
c.tmedpre,
c.cfilial,
c2.dfilial 
from medprea c 
inner JOIN filialm c2 on c2.cfilial = c.cfilial
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
