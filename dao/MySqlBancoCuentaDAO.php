<?php
class MySqlCuentaDAO{
   	public function cargarCuentas(){
        $sql="  select cctacte as id, concat_ws(' - ',c.nrocta,b.dbanco,c.descta) as nombre
                from ctactem c
                INNER JOIN bancosm b on (b.cbanco=c.cbanco)
                ORDER BY b.dbanco";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cuentas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cuentas','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarDetalleEx(){
        $sql="  select DISTINCT(dextxtb) as id,dextxtb as nombre
                from odinctm
                order by dextxtb";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Detalle cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Detalle','data'=>$data,'sql'=>$sql);
        }
    }

    public function verificaNombre($array){
        $sql="  select *
                from odinctm
                WHERE dextxtb='".$array['dextxtb']."' ";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cargar Cuenta','data'=>$data[0]['cctacte']);
        }else{
            return array('rst'=>'2','msj'=>'Usuario Nuevo','data'=>'','sql'=>$sql);
        }
    }    

    public function cargarFilIns($array){
        $sql="  select GROUP_CONCAT(distinct(o.cfilial) SEPARATOR '|') as cfilial,GROUP_CONCAT(distinct(o.cinstit) SEPARATOR '|') as cinstit,
                CONCAT_WS('|',c.dato01,c.dato02,c.dato03,c.dato04,c.dato05) as cuenta,
                GROUP_CONCAT(distinct(f.dfilial) SEPARATOR '|') as dfilial,GROUP_CONCAT(distinct(i.dinstit) SEPARATOR '|') as dinstit
                from odinctm o
                inner join filialm f on (o.cfilial=f.cfilial)
                inner join instita i on (o.cinstit=i.cinstit)
                INNER JOIN ctactem c on (o.cctacte=c.cctacte)                
                where o.cctacte='".$array['cctacte']."'
                AND o.dextxtb='".$array['dextxtb']."'
                GROUP BY o.cctacte";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cuentas cargados','cfilial'=>$data[0]['cfilial'],'cinstit'=>$data[0]['cinstit'],'cuenta'=>$data[0]['cuenta'],'dfilial'=>$data[0]['dfilial'],'dinstit'=>$data[0]['dinstit']);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cuentas','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function actualizarCuenta($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT nrocta FROM ctactem where nrocta='".$post["nrocta"]."' and cbanco='".$post['cbanco']."' and cctacte!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Cuenta</b> ya existe','sql'=>$sqlVal));exit();}
		
		
        $sql="update ctactem set nrocta='".$post['nrocta']."',descta='".$post['descta']."',cbanco='".$post['cbanco']."',dato01='".$post["dato01"]."',dato02='".$post['dato02']."',dato03='".$post['dato03']."',dato04='".$post['dato04']."',dato05='".$post['dato05']."',cestado='".$post["cestado"]."' where cctacte='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Cuenta Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }
    }
    public function insertarCuenta($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT nrocta FROM ctactem where nrocta='".$post["nrocta"]."' and cbanco='".$post['cbanco']."' and cctacte!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Cuenta</b> ya existe','sql'=>$sqlVal));exit();}
        /********************/	
		
        $sql="insert into ctactem(nrocta,descta,cbanco,dato01,dato02,dato03,dato04,dato05,cestado) 
                values('".$post['nrocta']."','".$post["descta"]."','".$post["cbanco"]."','".$post["dato01"]."','".$post["dato02"]."','".$post["dato03"]."','".$post["dato04"]."','".$post["dato05"]."','".$post["cestado"]."')";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Cuenta Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }   
    }

    public function GenerarAsignacion($array){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sql="DELETE FROM odinctm WHERE cctacte='".$array['cctacte']."' AND dextxtb='".$array['dextxtb']."'";
        $db->setQuery($sql);
        if($db->executeQuery()){
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
            }

            $cfilial=explode(",",$array['cfilial']);
            $cinstit=explode(",",$array['cinstit']);

            for($i=0;$i<count($cfilial);$i++){
                for($j=0;$j<count($cinstit);$j++){
                     $sql="insert into odinctm(cctacte,cfilial,cinstit,dextxtb) 
                            values('".$array['cctacte']."','".$cfilial[$i]."','".$cinstit[$j]."','".$array['dextxtb']."')";
                    $db->setQuery($sql);
                    if($db->executeQuery()){
                        if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                            $db->rollbackTransaccion();
                            return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
                        }                        
                    }else{
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
                    }
                }
            }

            $db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Asignacion Realizada');
           
        }
        else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }        
    }

    public function JQGridCountCuenta ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" 	SELECT COUNT(*) AS count 
				FROM ctactem c,bancosm b
            	WHERE c.cbanco=b.cbanco ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsCuenta ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT c.cctacte,c.dato01,c.dato02,c.dato03,c.dato04,c.dato05,c.descta,
			b.dbanco cbanco,c.nrocta,
            CASE
                WHEN	c.cestado='1' THEN 'Activo'
                WHEN	c.cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM ctactem c,bancosm b
            WHERE c.cbanco=b.cbanco ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
}
?>
