<?
class MySqlConceptoDAO{
	public function cargarConcepto($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$precio="";
		if(trim($r['nprecio'])!=""){
		$precio=" AND nprecio='".$r['nprecio']."'";
		}
        $sql="SELECT concat(cconcep,'-',nprecio) as id,concat(dconcep,' - ',nprecio) as nombre
			  FROM concepp 
			  WHERE cctaing like '".$r['cctaing']."%' 
			  AND cfilial='".$r['cfilial']."' 
			  AND cinstit='".$r['cinstit']."' 
			  AND cmodali='".$cmodali[0]['cmodali']."' 
			  AND tinscri='".$r['tinscri']."' 
			  AND (ccarrer in (Select ccarrer FROM gracprp WHERE cgracpr='".$r['cgruaca']."') OR ccarrer='')
			  ".$precio."
			  AND cestado='1' 
			  GROUP BY cconcep
			  ORDER BY dconcep";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Conceptos cargados','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Conceptos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarConceptoPension($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$precio=" AND co.nprecio>0";
		if(trim($r['nprecio'])!=""){
		$precio=" AND co.nprecio='".$r['nprecio']."'";
		}
        $sql="SELECT concat(co.cconcep,'-',co.nprecio,'-',co.ctaprom,'-',co.mtoprom) as id,concat(co.dconcep,' - ',co.ncuotas,'C - ',co.nprecio,' - Prom ',co.ctaprom,'C - ',co.mtoprom) as nombre
			  FROM concepp co
			  INNER JOIN cropaga cr on (co.cconcep=cr.cconcep)
			  WHERE co.cctaing like '".$r['cctaing']."%' 
			  AND co.cfilial='".$r['cfilial']."' 
			  AND co.cinstit='".$r['cinstit']."' 
			  AND co.cmodali='".$cmodali[0]['cmodali']."'
			  AND co.tinscri='".$r['tinscri']."' 
			  AND cr.cgruaca='".$r['cgruaca']."'
			  ".$precio."
			  AND co.cestado='1' 
			  GROUP BY co.cconcep
			  ORDER BY co.dconcep";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Conceptos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Conceptos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCuentaIngreso($d){
		$estado='';
		if($d['validacuentas']!=''){
			$estado=" AND cestado=1";
		}

        $sql="SELECT cctaing as id,dctaing as nombre
			  FROM ctaingm 
			  WHERE tctaing='0'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cuentas de Ingreso cargadas','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCuentaIngresoC($d){
		$estado='';
		if($d['validacuentas']!=''){
			$estado=" AND cestado=1";
		}
        $sql="SELECT cctaing as id,Concat(cctaing,' - ',dctaing,' / ', If(cestado = '1' , 'Activo', 'Inactivo')) as nombre
			  FROM ctaingm 
			  WHERE tctaing='0'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cuentas de Ingreso cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function ActEstCtaIng($r){	
        $db=creadorConexion::crear('MySql');
		
        $sql="SELECT cestado as cestado
			  FROM ctaingm 
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->setQuery($sql);
		$cestado=$db->loadObjectList();
		
		If($cestado[0]['cestado'] != "0")
		{	$est = "0";	}
		else
		{	$est = "1";	}
		
		$sql="Update ctaingm
			  Set cestado = '".$est."'
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Actualizar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Cuenta de Ingreso Actualizada correctamente','cctaing'=>$r['cctaing']);exit();
			}
    }
		
	public function cargarSubCuenta1($r){
		$estado='';
		if($r['validacuentas']!=''){
			$estado=" AND cestado=1";
		}
        $sql="SELECT cctaing as id, dctaing as nombre
			  FROM ctaingm 
			  WHERE tctaing='".$r['cctaing']."'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Sub-Cuentas de Ingreso cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Sub-Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
		
	public function cargarSubCuenta1C($r){
		$estado='';
		if($r['validacuentas']!=''){
			$estado=" AND cestado=1";
		}
        $sql="SELECT cctaing as id, Concat(cctaing,' - ',dctaing,' / ', If(cestado = '1' , 'Activo', 'Inactivo')) as nombre
			  FROM ctaingm 
			  WHERE tctaing='".$r['cctaing']."'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Sub-Cuentas de Ingreso cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Sub-Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function ActEstSubCta1($r){	
        $db=creadorConexion::crear('MySql');
		
        $sql="SELECT cestado as cestado
			  FROM ctaingm 
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->setQuery($sql);
		$cestado=$db->loadObjectList();
		
		If($cestado[0]['cestado'] != "0")
		{	$est = "0";	}
		else
		{	$est = "1";	}
		
		$sql="Update ctaingm
			  Set cestado = '".$est."'
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Actualizar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Sub Cuenta 1 Actualizada correctamente','cctaing'=>$r['cctaing']);exit();
			}
    }
		
	public function cargarSubCuenta2($r){
		$estado='';
		if($r['validacuentas']!=''){
			$estado=" AND cestado=1";
		}
        $sql="SELECT cctaing as id, dctaing as nombre
			  FROM ctaingm 
			  WHERE tctaing='".$r['cctaing']."'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Sub-Cuentas de Ingreso cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Sub-Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
		
	public function cargarSubCuenta2C($r){
		$estado='';
		if($r['validacuentas']!=''){
			$estado=" AND cestado=1";
		}
        $sql="SELECT cctaing as id, Concat(cctaing,' - ',dctaing,' / ', If(cestado = '1' , 'Activo', 'Inactivo')) as nombre
			  FROM ctaingm 
			  WHERE tctaing='".$r['cctaing']."'
			  ".$estado."
			  ORDER BY cctaing";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Sub-Cuentas de Ingreso cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Sub-Cuentas de Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function ActEstSubCta2($r){	
        $db=creadorConexion::crear('MySql');
		
        $sql="SELECT cestado as cestado
			  FROM ctaingm 
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->setQuery($sql);
		$cestado=$db->loadObjectList();
		
		If($cestado[0]['cestado'] != "0")
		{	$est = "0";	}
		else
		{	$est = "1";	}
		
		$sql="Update ctaingm
			  Set cestado = '".$est."'
			  WHERE cctaing ='".$r['cctaing']."'";
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Actualizar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Sub Cuenta 2 Actualizada correctamente','cctaing'=>$r['cctaing']);exit();
			}
    }
	
	public function InsertarCuentaIng($r){
        $db=creadorConexion::crear('MySql');
		$sqlver1="SELECT SUBSTRING(IFNULL(MAX(cctaing),700),1,3)+1 As cctaing
				  FROM ctaingm
				  WHERE tctaing = '0'";
		$db->setQuery($sqlver1);
		$cctaing=$db->loadObjectList();
		
        $sql="SELECT *
			  FROM ctaingm 
			  WHERE dctaing='".$r['dctaing']."'";
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
			return array('rst'=>'2','msj'=>"La Cuenta de Ingreso ya ha sido registrada Anteriormente");exit();
        }else{
			$sql="INSERT INTO ctaingm (cctaing, dctaing, tctaing, cusuari, fusuari, ttiptra, cestado)
				  VALUES ('".$cctaing[0]['cctaing']."',
					'".$r['dctaing']."',
					'0',
					'".$r['cusuari']."',
					now(),
					'I',	
					'1')";	
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Cuenta de Ingreso Registrada correctamente','cctaing'=>$cctaing[0]['cctaing']);exit();
			}
		}
    }
	
	public function InsertarSubCuenta1($r){
        $db=creadorConexion::crear('MySql');
		$sqlver1="SELECT SUBSTRING(IFNULL(MAX(cctaing),0),5,2)+1 As cctaing
				  FROM ctaingm
				  WHERE tctaing='".$r['tctaing']."'";
		$db->setQuery($sqlver1);
		$cctaing=$db->loadObjectList();
		
        $sql="SELECT *
			  FROM ctaingm 
			  WHERE dctaing='".$r['dctaing']."'
			  AND tctaing='".$r['tctaing']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
			return array('rst'=>'2','msj'=>"La Sub Cuenta 1 ya ha sido registrada Anteriormente");exit();
        }else{
			$sql="Insert Into ctaingm (cctaing, dctaing, tctaing, cusuari, fusuari, ttiptra, cestado)
				  values ('".$r['tctaing'].".".substr("00".$cctaing[0]['cctaing'],-2)."',
					'".$r['dctaing']."',
					'".$r['tctaing']."',
					'".$r['cusuari']."',
					now(),
					'I',	
					'1')";	
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Cuenta de Ingreso Registrada correctamente','cctaing'=>$r['tctaing'].".".substr("00".$cctaing[0]['cctaing'],-2));exit();
			}
		}
    }
	
	public function InsertarSubCuenta2($r){
        $db=creadorConexion::crear('MySql');
		$sqlver1="SELECT SUBSTRING(IFNULL(MAX(cctaing),0),8,2)+1 As cctaing
				  FROM ctaingm
				  WHERE tctaing='".$r['tctaing']."'";
		$db->setQuery($sqlver1);
		$cctaing=$db->loadObjectList();
		
        $sql="SELECT *
			  FROM ctaingm 
			  WHERE dctaing='".$r['dctaing']."'
			  AND tctaing='".$r['tctaing']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
			return array('rst'=>'2','msj'=>"La Sub Cuenta 2 ya ha sido registrada Anteriormente");exit();
        }else{
			$sql="Insert Into ctaingm (cctaing, dctaing, tctaing, cusuari, fusuari, ttiptra, cestado)
				  values ('".$r['tctaing'].".".substr("00".$cctaing[0]['cctaing'],-2)."',
					'".$r['dctaing']."',
					'".$r['tctaing']."',
					'".$r['cusuari']."',
					now(),
					'I',	
					'1')";	
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Cuenta de Ingreso Registrada correctamente','cctaing'=>$r['tctaing'].".".substr("00".$cctaing[0]['cctaing'],-2));exit();
			}
		}
    }
	
	public function validaConcepto($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$cctaing="";
		if(trim($r['cctaing2'])!=""){
			$cctaing=$r['cctaing2'];
		}else{
			$cctaing=$r['cctaing1'];
		}
			
		$cfiliales = explode(',',$r['cfilial']);
		$cfilials  = implode("','",$cfiliales);
			
        $sql="SELECT 
				fil.cfilial As cfilial,
				fil.dfilial As dfilial,	
				con.ccarrer AS ccarrer,
				IF(con.ccarrer='','Todos',ca.dcarrer) AS dcarrer,		
				con.cconcep As cconcep,
				con.dconcep As dconcep,
				con.ncuotas As ncuotas,
				con.nprecio As nprecio,
				con.ctaprom,
				con.mtoprom,
				con.cestado As cestado
			  FROM concepp con 
			  INNER JOIN filialm fil
			  	ON con.cfilial = fil.cfilial
			  LEFT JOIN carrerm ca 
			  	ON ca.ccarrer=con.ccarrer
			  WHERE cctaing = '".$cctaing."' 
			  AND con.cfilial IN ('".$cfilials."' )
			  AND con.cinstit='".$r['cinstit']."' 
			  AND con.cmodali='".$cmodali[0]['cmodali']."'  
			  AND con.ctipcar='".$r['ctipcar']."' 
			  AND con.tinscri='".$r['tinscri']."'
			  ORDER BY fil.dfilial,con.dconcep";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Conceptos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Conceptos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function guardarCambioConcep($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$cfiliales = explode(',',$r['cfilial']);
		$carreras=array('');
		if($r['valcarr']=='NO'){
		$carreras=explode(',',$r['ccarrer']);
		}
		
		
		$errorins = 0;
		$totalins = 0;
		$cctaing="";
		$valestado="";
		
		if(trim($r['cctaing2'])!=""){
			$cctaing=$r['cctaing2'];
		}else{
			$cctaing=$r['cctaing1'];
		}
		
		$cjtodatos = explode('^',$r['datos']);
		$queryacum="";
		$db->iniciaTransaccion();
		$array_concepto="";
		foreach($cfiliales as $cfilial){
			foreach($cjtodatos as $datalinea){
				$valestado="";
				$datalimpia = explode('|',$datalinea);
				$cfil="";
				$codigounico="";
				
				foreach($carreras as $ccarrer){
					if($datalimpia[0]!="nuevo"){
						$valestado = " AND cestado='".$datalimpia[4]."'";					
						$cfil=" cfilial='".$datalimpia[5]."'";
						$codigounico=" AND cconcep!='".$datalimpia[0]."'";
						$ccar=" AND ccarrer='".$datalimpia[8]."'";
					}
					
					if($datalimpia[0]=="nuevo"){ $cfil=" cfilial='".$cfilial."'"; $ccar= " AND ccarrer='".$ccarrer."'";	$totalins = $totalins + 1 ;	}
				
					$sql="SELECT *
						  FROM concepp  b   
						  WHERE ".$cfil.$ccar."
						  AND cinstit='".$r['cinstit']."'
						  AND cmodali='".$cmodali[0]['cmodali']."' 
						  AND tinscri='".$r['tinscri']."'
						  AND ccarrer='".$ccarrer."'
						  AND cctaing='".$cctaing."'
						  AND dconcep='".$datalimpia[1]."'
						  AND ncuotas='".$datalimpia[2]."'
						  AND nprecio='".$datalimpia[3]."'".$valestado.$codigounico;
					$db->setQuery($sql);
					$data=$db->loadObjectList();
					$valida="";
						if($datalimpia[0]!="nuevo"){
						$valida=explode("|".$datalimpia[0]."|",$array_concepto);
						}
					if(count($valida)>1){
					// no actualiza nada;
					}
					elseif((count($data)>0) and ($datalimpia[0]=="nuevo")){
						$errorins = $errorins + 1 ;	
					}elseif((count($data)>0) and ($datalimpia[0]!="nuevo")){
						$db->rollbackTransaccion();
						return array('rst'=>'2','msj'=>'Error al Actualizar Datos. Ya existen un(os) concepto(s) con los mismos datos.','sql2'=>count($data).'124'.$sql.'33'.$datalimpia[0],'sql'=>$sql);exit();
					}else{
						$array_concepto.="|".$datalimpia[0]."|";
						if($datalimpia[0]!="nuevo"){
							$sql="UPDATE concepp
								  SET dconcep = '".$datalimpia[1]."',
									  ncuotas = '".$datalimpia[2]."',
									  nprecio = '".$datalimpia[3]."',
									  cestado = '".$datalimpia[4]."',
									  ctaprom='".$datalimpia[6]."',
									  mtoprom='".$datalimpia[7]."',
									  cusuari = '".$r['cusuari']."',
									  fusuari = now()
								  WHERE cconcep = '".$datalimpia[0]."'";
							$db->setQuery($sql);
							if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Actualizar Datos: '.$datalimpia[0]);exit();
							}
							if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
							}
						}else{
							$cconcep=$db->generarCodigo('concepp','cconcep',10,$r['cusuari']);
							$sql="INSERT INTO concepp (cconcep, dconcep, cctaing, nprecio, cfilial, cinstit, cmodali, ctipcar,ccarrer, ncuotas, tinscri, thorari, tpago, cestado, cusuari, fusuari, tcondef, ncuoaum, nmonaum,ctaprom,mtoprom)
								  VALUES ('".$cconcep."',
										  '".$datalimpia[1]."',
										  '".$cctaing."',
										  '".$datalimpia[3]."',
										  '".$cfilial."',
										  '".$r['cinstit']."',
										  '".$cmodali[0]['cmodali']."',
										  '".$r['ctipcar']."',
										  '".$ccarrer."',
										  '".$datalimpia[2]."',
										  '".$r['tinscri']."',
										  'R',
										  'U',
										  '1',
										  '".$r['cusuari']."',
										  now(),
										  'S',
										  '0',
										  '0',
										  '".$datalimpia[6]."',
										  '".$datalimpia[7]."')";
							$db->setQuery($sql);
							if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos.','sql'=>$sql);exit();
							}
							if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos.','sql'=>$sql);exit();
							}
						}					
					}// fin valida repeticion
				}// fin foreach carrera
			}// fin foreach datos
		}//fin foreach filial
		if(($errorins > 0) and ($errorins == $totalins)){
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>"Cambios guardados correctamente; No se registraron nuevos conceptos.");exit();
		}elseif(($errorins > 0) and ($errorins != $totalins)){
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>"Cambios guardados correctamente; Se registraron los conceptos no existentes anteriormente.");exit();
		}else{
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente');exit();
		}
	}
}
?>