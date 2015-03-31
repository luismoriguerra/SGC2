<?
class MySqlInscritoDAO{	
	public function JQGridCountInscrito($where,$cinstit){
		$db=creadorConexion::crear('MySql');
		$sql="select count(*) as count
			  from postulm po, personm p, carrerm ca
			  where p.cperson=po.cperson
			  and po.ccarrer=ca.ccarrer
			  and (po.cingalu is null or trim(po.cingalu)='') 
			  and po.cestado='1'
			  and po.cinstit='$cinstit' $where";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('count'=>0));
        }
	}
	
	public function JQGRIDRowsInscrito ( $sidx, $sord, $start, $limit, $where,$cinstit) {
	$sql="SELECT p.cperson,p.dnomper,p.dappape,p.dapmape,p.email1,p.ntelpe2,p.ntelper,p.ntellab,
		  p.dtipsan as cestciv,p.tipdocper,p.ndniper,p.fnacper,p.tsexo,p.coddpto,p.codprov,p.coddist,
		  p.ddirper,p.ddirref,p.cdptlab,p.cprvlab,p.cdislab,p.ddirlab,p.dnomlab,p.tcolegi,p.dcolpro,
			(select u.nombre from ubigeo u where u.codprov=0 and u.coddist=0 and u.coddpto=p.coddpto GROUP BY u.coddpto) as ddepart,	
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist=0 and u.coddpto=p.coddpto and u.codprov=p.codprov GROUP BY u.codprov) as dprovin,
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist!=0 and u.coddpto=p.coddpto and u.codprov=p.codprov and u.coddist=p.coddist GROUP BY u.coddist) as ddistri,
		  po.*,
    	  ca.dcarrer, ca.ctipcar, ca.cmodali, ti.dtipcar
		  from postulm po, personm p, carrerm ca, tipcarm ti
		  where p.cperson=po.cperson
		  and po.ccarrer=ca.ccarrer
		  and ca.ctipcar=ti.ctipcar
		  and (po.cingalu is null or trim(po.cingalu)='') 
		  and po.cestado='1'
		  and po.cinstit='$cinstit' $where 
	 	  ORDER BY $sidx $sord
          LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data; 
    }
	
	public function InsertarInscripcion($data){
	$db=creadorConexion::crear('MySql');
	
	$sqlconsulta2="SELECT * FROM gracprp
				  WHERE cgracpr='".$data['cgruaca']."'";
	$db->setQuery($sqlconsulta2);	
	$data2=$db->loadObjectList();		
	$data2['cgrupo']="01";
	
	$sqlver2="SELECT i.* 
			  FROM ingalum i
			  INNER JOIN conmatp c on (c.cingalu=i.cingalu)
			  where i.ccarrer='".$data2[0]['ccarrer']."'
			  and i.cinstit='".$data2[0]['cinstit']."'
			  and i.cperson='".$data['cperson']."'
			  and i.cestado='1'";	
	$db->setQuery($sqlver2);	
    $valsql2=$db->loadObjectList();
		if(count($valsql2)>0){
		return array('rst'=>'2','msj'=>"La persona ya existe como alumno en la carrera seleccionada",'sql'=>$sqlver2);exit();
		}
		
	$sqlver2="SELECT * 
			  FROM ingalum 
			  where dcodlib='".$data['dcodlib']."'";
	$db->setQuery($sqlver2);	
    $valsql2=$db->loadObjectList();
		if(count($valsql2)>0){
		return array('rst'=>'2','msj'=>"Codigo de Libro ya Existe en la BD",'sql'=>$sqlver2);exit();
		}
  
	/*$sqlver2="SELECT * 
			  FROM ingalum 
			  where sermatr='".$data['sermatr']."'";			  
	$db->setQuery($sqlver2);	
    $valsql2=$db->loadObjectList();
		if(count($valsql2)>0){
		return array('rst'=>'2','msj'=>"Serie de Matricula ya Existe en la BD",'sql'=>$sqlver2);exit();
		}*/

$codigopago="S";
if($data['persona_elegida']==''){
$codigopago="C";
	/*validando solo si es especial*/
		
	if($data['tipo_documento_ins']=="B"){
		$sqlver2="SELECT * 
			  FROM boletap 
			  where dserbol='".$data['serie_boleta_ins']."'
			  AND dnumbol='".$data['numero_boleta_ins']."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"La Boleta de Inscripcion ingresada ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	elseif($data['tipo_documento_ins']=="V"){
		$sqlver2="SELECT * 
			  FROM vouchep 
			  where numvou='".$data["numero_voucher_ins"]."'
			  AND cbanco='".$data["banco_voucher_ins"]."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"El Voucher de Inscripcion ingresado ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	
	if($data['tipo_documento']=="B" and $data['monto_deuda_ins']==0){
		$sqlver2="SELECT * 
			  FROM boletap 
			  where dserbol='".$data['serie_boleta']."'
			  AND dnumbol='".$data['numero_boleta']."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"La Boleta de Matricula ingresada ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	elseif($data['tipo_documento']=="V" and $data['monto_deuda_ins']==0){
		$sqlver2="SELECT * 
			  FROM vouchep 
			  where numvou='".$data["numero_voucher"]."'
			  AND cbanco='".$data["banco_voucher"]."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"El Voucher de Matricula ingresado ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}	
	
	if($data['tipo_documento_pension']=="B" and $data['monto_deuda']==0 and $data['monto_deuda_ins']==0){
		$sqlver2="SELECT * 
			  FROM boletap 
			  where dserbol='".$data['serie_boleta_pension']."'
			  AND dnumbol='".$data['numero_boleta_pension']."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"La Boleta de Pension ingresada ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	elseif($data['tipo_documento_pension']=="V" and $data['monto_deuda']==0 and $data['monto_deuda_ins']==0){
		$sqlver2="SELECT * 
			  FROM vouchep 
			  where numvou='".$data["numero_voucher_pension"]."'
			  AND cbanco='".$data["banco_voucher_pension"]."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"El Voucher de Pension ingresado ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	
	if($data['testalu']!="RE" and $data['tipo_documento_convalida']=="B" and $data['monto_deuda']==0 and $data['monto_deuda_ins']==0 and $data['monto_deuda_pension']==0){
		$sqlver2="SELECT * 
			  FROM boletap 
			  where dserbol='".$data['serie_boleta_convalida']."'
			  AND dnumbol='".$data['numero_boleta_convalida']."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"La Boleta de Convalidacion ingresada ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
	elseif($data['testalu']!="RE" and $data['tipo_documento_convalida']=="V" and $data['monto_deuda']==0 and $data['monto_deuda_ins']==0 and $data['monto_deuda_pension']==0){
		$sqlver2="SELECT * 
			  FROM vouchep 
			  where numvou='".$data["numero_voucher_convalida"]."'
			  AND cbanco='".$data["banco_voucher_convalida"]."'";			  
		$db->setQuery($sqlver2);	
		$valsql2=$db->loadObjectList();
			if(count($valsql2)>0){
			return array('rst'=>'2','msj'=>"El Voucher de Convalidacion ingresado ya Existe en la BD",'sql'=>$sqlver2);exit();
			}
	}
} // finaliza validacion...
/* finalizo validacion..*/
				
		$cpostul=$db->generarCodigo('postulm','cpostul',12,$data['cusuari']);
		$cingalu=$db->generarCodigo('ingalum','cingalu',11,$data['cusuari']);
		$db->iniciaTransaccion();
		$sql="Insert Into postulm  (cpostul,cfilial,tmodpos,csemadm,cinicio,ccarrer,ctipcap,cvended,cmedpre,serinsc,cinstit,dcodlib,cperson,finscri,crecepc,cestado,cingalu,cusuari,fusuari,tinstip,dinstip,dcarrep,ultanop,dciclop,certest,partnac,fotodni,otrodni,destica,locestu,cgruaca,ccencap,posbeca,ddocval,cpais) 
			  values ('".$cpostul."','".$data['cfilial']."','".$data['tmodpos']."',
				'".$data['csemadm']."',
				'".$data['cinicio']."',
				'".$data['ccarrer']."',
				'".$data['ctipcap']."',
				'".$data['cvended']."',
				'".$data['cmedpre']."',
				'".$data['serinsc']."',
				'".$data['cinstit']."',
				'".$data['dcodlib']."',
				'".$data['cperson']."',
				'".$data['finscri']."',
				'".$data['crecepc']."',
				'1','".$cingalu."','".$data['cusuari']."',now(),
				'".$data['tinstip']."',
				'".$data['dinstip']."',
				'".$data['dcarrep']."',
				'".$data['ultanop']."',
				'".$data['dciclop']."',
				'".$data['certest']."',
				'".$data['partnac']."',
				'".$data['fotodni']."',
				'".$data['otrodni']."',
				'".$data['destica']."',
				'".$data['locestu']."',
				'".$data['cgruaca']."',
				'".$data['ccencap']."',
				'".$data['posbeca']."',
				'".$data['ddocval']."',
				'".$data['cpais']."')";		
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilial']) ){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
		/////////////////CONSTANCIA MATRICULA
		$cconmat=$db->generarCodigo('conmatp','cconmat',11,$data['cusuari']);			
		
		$cgruaca=$data['cgruaca'];
		if($data['testalu']!="RE"){			
			$cgruaca=$db->generarCodigo('gracprp','cgracpr',12,$data['cusuari']);
			$sqlinsgru="INSERT INTO gracprp (cgracpr,csemaca,cfilial,cinstit,ctipcar,cmodali,cinicio,cturno,cfrecue,chora,ccarrer,cciclo,dseccio,ccurric,cesgrpr,fingrpr,finicio,ffin,dmotest,fesgrpr,cperson,cusuari,fusuari,ttiptra,trgrupo,nmetmat) VALUES 
					('".$cgruaca."',
					'".$data2[0]["csemaca"]."',
					'".$data2[0]["cfilial"]."',
					'".$data2[0]['cinstit']."',
					'".$data2[0]['ctipcar']."',
					'".$data2[0]['cmodali']."',
					'".$data2[0]["cinicio"]."',
					'".$data2[0]["cturno"]."',
					'".$data2[0]['cfrecue']."',
					'".$data2[0]["chora"]."',
					'".$data2[0]['ccarrer']."',
					'".$data2[0]['cciclo']."',
					'1',
					'".$data2[0]["ccurric"]."',
					'3',
					'".$data2[0]["fingrpr"]."',
					'".$data2[0]["finicio"]."',
					'".$data2[0]["ffin"]."',
					'',
					'".$data2[0]['fesgrpr']."',
					'','".$data['cusuari']."',now(),'I','I','".$data2[0]['nmetmat']."');";
				$db->setQuery($sqlinsgru);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsgru);exit();
				}
				if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsgru,$data['cfilial']) ){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsgru);exit();
				}
		}
			
			
		$sqlinsmat="INSERT INTO conmatp 
(cconmat,fmatric,cingalu,testmat,nnomina,cgruaca,cgracan,fusuari,cusuari,tgrupo,testalu,titptra,tforpag,cpromot,cfilial,sermatr,dproeco) VALUES('".$cconmat."','".$data['finscri']."','".$cingalu."','1','','".$cgruaca."','',now(),'".$data['cusuari']."','2','".$data['testalu']."','I','C','".$data['cvended']."','".$data['locestu']."','".$data['sermatr']."','".$data['dproeco']."')";
		$db->setQuery($sqlinsmat);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsmat);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsmat,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsmat);exit();
			}
		
		////////// DETALLE DE CONSTANCIA
		if($data['testalu']=="RE"){
		$sqlcur="SELECT * FROM cuprprp WHERE cgracpr='".$data['cgruaca']."'";
		$db->setQuery($sqlcur);	
		$detcur=$db->loadObjectList();
			foreach($detcur as $r){				
			$sqlinsdet="INSERT INTO decomap  (ccurpro,cconmat,cestado,tgruaca,tprocur,nnoficu,dmonofi,tmonofi,nregist,tusbeno,nnomadi,fusuari,cusuari,cesgeac,tesalgr,fincute,cfilial) VALUES('".$r['ccuprpr']."','".$cconmat."','1','2','U','','','','','','',now(),'".$data['cusuari']."','N','A','','".$data['locestu']."')";
			$db->setQuery($sqlinsdet);
				if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdet);exit();
				}
				if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdet,$data['cfilial']) ){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdet);exit();
				}			
			}		
		}
		
		////////////CRONOGRAMA DE PAGOS////////////////////////////			
		$sqlcropag="SELECT * FROM cropaga
					where cconcep='".$data['cconcep_pension']."'
					and cgruaca='".$data['cgruaca']."'
					order by ccuota,fvencim";
		$db->setQuery($sqlcropag);	
		$cropag=$db->loadObjectList();
		$fecha_fin_cuota1="";
		$listacodigos="";// para almacenar en caso el monto pension sea 0	

			foreach($cropag as $r){
				if($data['testalu']!="RE"){
					$ccropag=$db->generarCodigo('cropaga','ccropag',11,$data['cusuari']);
					$sql="INSERT INTO cropaga  (ccropag, cconcep, cgruaca, ccuota, fvencim, tcropag, fusuari, cusuari, ttiptra, cfilial) VALUES ('".$ccropag."','".$r['cconcep']."','".$cgruaca."','".$r['ccuota']."','".$r['fvencim']."','2',now(),'".$data['cusuari']."','I','".$data['locestu']."')";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
				}				
				
				if($r['ccuota']==1){
				$fecha_fin_cuota1=$r['fvencim'];
				}
				else{
				$monto_pension=$data['monto_concepto_pension'];
					if($data['ctaprom']>=$r["ccuota"]){
					$monto_pension=($data['monto_pago_pension']+$data['monto_deuda_pension']);
					}				
				$codrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);
				
					if($monto_pension==0){						
					$listacodigos.="'".$codrec."',";	
					}
				$sqlinsrecpen="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$codrec."','".$data['cfilial']."','','','".$data['cperson']."','".$cingalu."','".$r['ccuota']."','".$monto_pension."','".$r['fvencim']."','A','C','E','','','".$data['cconcep_pension']."','".$cgruaca."','2','P','P','".$r['fvencim']."','".$r['fvencim']."','".$data['cusuari']."',now(),'I','P','','P')";
				$db->setQuery($sqlinsrecpen);
					if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrecpen);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrecpen,$data['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrecpen);exit();
					}
				}
			}			
		
		/*///////////////////INSCRIPCION////////////////////////*/	
		if($data['tipo_documento_ins']=="B"){
		$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
		$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta_ins']."','".$data['numero_boleta_ins']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago_ins']."','".$data['fecha_pago_ins']."','".$data['cusuari']."','".$data['cusuari']."',now(),'I','".$data['cinstit']."','".$data['monto_pago_ins']."')";
							
		$db->setQuery($sqlinsbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
			}
			
		$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$newcodbol."','B','".$data['cperson']."','".$cingalu."','','".$data['monto_pago_ins']."','".$data['fecha_pago_ins']."','P','C','E','','','".$data['cconcep_ins']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_ins']."','".$data['fecha_pago_ins']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
		
		$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec."','1','1','".$data['monto_pago_ins']."','".$data['cfilial']."')";
		$db->setQuery($sqlinsdetbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
			}
		}
		elseif($data['tipo_documento_ins']=="V"){
		$nvouche=$data["numero_voucher_ins"];
		$cbanco=$data["banco_voucher_ins"];
		$monto=$data['monto_pago_ins'];
		//$dserbol=add_ceros($serbol,3);
		$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
		$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."',now(),'I','".$monto."')";
		$db->setQuery($insvoucher);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
			}
		
		$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$codi_vouche."','V','".$data['cperson']."','".$cingalu."','','".$monto."','".$data['fecha_pago_ins']."','P','C','E','','','".$data['cconcep_ins']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_ins']."','".$data['fecha_pago_ins']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
		}
		
		if($data['monto_deuda_ins']>0){
		$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','','','".$data['cperson']."','".$cingalu."','','".$data['monto_deuda_ins']."','".$data['fecha_deuda_ins']."','P','C','E','','','".$data['cconcep_ins']."','".$cgruaca."','2','P','P','".$data['fecha_deuda_ins']."','".$data['fecha_deuda_ins']."','".$data['cusuari']."',now(),'I','M','','P')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		}
		
		/*///////////////////MATRICULA////////////////////////*/	
		$pagare="no";
		if($data['monto_pago']>0 or ($data['monto_pago']==0 and $data['monto_deuda']==0)){
		$pagare="si";
		}
		if($data['tipo_documento']=="B" and $pagare=="si"){			
		$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
		$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta']."','".$data['numero_boleta']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."','".$data['cusuari']."',now(),'I','".$data['cinstit']."','".$data['monto_pago']."')";
		
		$db->setQuery($sqlinsbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
			}
			
		$newcodrecmat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);				
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrecmat."','".$data['cfilial']."','".$newcodbol."','B','".$data['cperson']."','".$cingalu."','','".$data['monto_pago']."','".$data['fecha_pago']."','P','C','E','','','".$data['cconcep']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
			
		$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec."','1','1','".$data['monto_pago']."','".$data['cfilial']."')";
		$db->setQuery($sqlinsdetbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
			}
		}
		elseif($data['tipo_documento']=="V"  and $data['monto_deuda_ins']==0 and $pagare=="si"){
		$nvouche=$data["numero_voucher"];
		$cbanco=$data["banco_voucher"];
		$monto=$data['monto_pago'];
		//$dserbol=add_ceros($serbol,3);
		$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
		$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."',now(),'I','".$monto."')";
		$db->setQuery($insvoucher);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
			}
		
		$newcodrecmat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrecmat."','".$data['cfilial']."','".$codi_vouche."','V','".$data['cperson']."','".$cingalu."','','".$monto."','".$data['fecha_pago']."','P','C','E','','','".$data['cconcep']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}		
		}
		
		if($data['monto_deuda']>0){
		$newcodrec2mat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2mat."','".$data['cfilial']."','','','".$data['cperson']."','".$cingalu."','','".$data['monto_deuda']."','".$data['fecha_deuda']."','P','C','E','','','".$data['cconcep']."','".$cgruaca."','2','P','P','".$data['fecha_deuda']."','".$data['fecha_deuda']."','".$data['cusuari']."',now(),'I','M','','P')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		}
		/*////////////////////CONVALIDACIÓN////////////////////*/
		$pagare="no";
if($data['testalu']!="RE"){
	if($data['monto_pago_convalida']>0 or ($data['monto_pago_convalida']==0 and $data['monto_deuda_convalida']==0)){
	$pagare="si";
	}

		if($data['tipo_documento_convalida']=="B" and $pagare=="si"){			
		$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
		$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta_convalida']."','".$data['numero_boleta_convalida']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago_convalida']."','".$data['fecha_pago_convalida']."','".$data['cusuari']."','".$data['cusuari']."',now(),'I','".$data['cinstit']."','".$data['monto_pago_convalida']."')";
		
		$db->setQuery($sqlinsbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
			}
			
		$newcodrecmat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);				
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrecmat."','".$data['cfilial']."','".$newcodbol."','B','".$data['cperson']."','".$cingalu."','','".$data['monto_pago_convalida']."','".$data['fecha_pago_convalida']."','P','C','E','','','".$data['cconcep_convalida']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_convalida']."','".$data['fecha_pago_convalida']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
			
		$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec."','1','1','".$data['monto_pago_convalida']."','".$data['cfilial']."')";
		$db->setQuery($sqlinsdetbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
			}
		}
		elseif($data['tipo_documento_convalida']=="V"  and $data['monto_deuda_ins']==0 and $pagare=="si"){
		$nvouche=$data["numero_voucher_convalida"];
		$cbanco=$data["banco_voucher_convalida"];
		$monto=$data['monto_pago_convalida'];
		//$dserbol=add_ceros($serbol,3);
		$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
		$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."',now(),'I','".$monto."')";
		$db->setQuery($insvoucher);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
			}
		
		$newcodrecmat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrecmat."','".$data['cfilial']."','".$codi_vouche."','V','".$data['cperson']."','".$cingalu."','','".$monto."','".$data['fecha_pago_convalida']."','P','C','E','','','".$data['cconcep_convalida']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_convalida']."','".$data['fecha_pago_convalida']."','".$data['cusuari']."',now(),'I','M','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}		
		}
		
		if($data['monto_deuda_convalida']>0){
		$newcodrec2mat=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2mat."','".$data['cfilial']."','','','".$data['cperson']."','".$cingalu."','','".$data['monto_deuda_convalida']."','".$data['fecha_deuda_convalida']."','P','C','E','','','".$data['cconcep_convalida']."','".$cgruaca."','2','P','P','".$data['fecha_deuda_convalida']."','".$data['fecha_deuda_convalida']."','".$data['cusuari']."',now(),'I','M','','P')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		}
}// verifica si es irregular
		/*///////////////////PENSION////////////////////////*/	
		$pagare="no";
		if($data['monto_pago_pension']>0 or ($data['monto_pago_pension']==0 and $data['monto_deuda_pension']==0)){
		$pagare="si";
		}
		if($data['tipo_documento_pension']=="B" and $pagare=="si"){
		$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
		$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta_pension']."','".$data['numero_boleta_pension']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."','".$data['cusuari']."',now(),'I','".$data['cinstit']."','".$data['monto_pago_pension']."')";
		
		$db->setQuery($sqlinsbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
			}
			
		$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$newcodbol."','B','".$data['cperson']."','".$cingalu."','1','".$data['monto_pago_pension']."','".$fecha_fin_cuota1."','A','C','E','','','".$data['cconcep_pension']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."',now(),'I','P','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
		
		$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec."','1','1','".$data['monto_pago_pension']."','".$data['cfilial']."')";
		$db->setQuery($sqlinsdetbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
			}
			
		$sqlupdate="UPDATE recacap
				    SET cdocpag='".$newcodbol."',tdocpag='B',
					testfin='C',cestpag='C'
					WHERE crecaca in (".$listacodigos."'0')";
		
		$db->setQuery($sqlupdate);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
			}
		}
		elseif($data['tipo_documento_pension']=="V" and $pagare=="si"){
		$nvouche=$data["numero_voucher_pension"];
		$cbanco=$data["banco_voucher_pension"];
		$monto=$data['monto_pago_pension'];
		//$dserbol=add_ceros($serbol,3);
		$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
		$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."',now(),'I','".$monto."')";
		$db->setQuery($insvoucher);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
			}
		
		$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$codi_vouche."','V','".$data['cperson']."','".$cingalu."','1','".$monto."','".$fecha_fin_cuota1."','A','C','E','','','".$data['cconcep_pension']."','".$cgruaca."','2','C','".$codigopago."','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."',now(),'I','P','','".$codigopago."')";
		
		$db->setQuery($sqlinsrec);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
			}
		
		$sqlupdate="UPDATE recacap
				    SET cdocpag='".$codi_vouche."',tdocpag='V',
					testfin='C',cestpag='C'
					WHERE crecaca in (".$listacodigos."'0')";
		
		$db->setQuery($sqlupdate);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
			}
		}
		
		if($data['monto_deuda_pension']>0){
		$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','','','".$data['cperson']."','".$cingalu."','1','".$data['monto_deuda_pension']."','".$fecha_fin_cuota1."','P','C','E','','','".$data['cconcep_pension']."','".$cgruaca."','2','P','P','".$data['fecha_deuda_pension']."','".$data['fecha_deuda_pension']."','".$data['cusuari']."',now(),'I','P','','P')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		}
		
	/////////////////INGRESO ALUMNO	
	$recibo=$newcodrecmat;
	if($recibo==""){
	$recibo=$newcodrec2mat;
	}
	$thorari="R";
	if($data['testalu']!="RE"){
	$thorari="I";
	}			
		$sql="INSERT INTO ingalum (cingalu,cperson,finscri,cmoding,ctipcap,cpromot,cmedpre,cconcep,ccarrer,ccurric,cfilial,cinstit,cturno,cseming,ciniing,testalu,consnew,comauma,compuma,tusorec,crecmat,thorari,cgrupo,cmodali,ctipcar,fusuari,cusuari,ctiptra,sermatr,dcodlib,certest,partnac,fotodni,dcoduni,otrodni,posbeca,cpais,tinstip,dinstip,dcarrep,ultanop,dciclop,ddocval,destica,ccencap,dcompro,dproeco,nfotos)
		VALUES ('".$cingalu."'
			  ,'".$data['cperson']."'
			  ,'".$data['finscri']."'
			  ,'".$data['cmoding']."'
			  ,'".$data['ctipcap']."'
			  ,'".$data['cvended']."'
			  ,'".$data['cmedpre']."'
			  ,'".$data['cconcep']."'
			  ,'".$data2[0]['ccarrer']."'
			  ,'".$data2[0]['ccurric']."'
			  ,'".$data['locestu']."'
			  ,'".$data['cinstit']."'
			  ,'".$data2[0]['cturno']."'
			  ,'".$data['cseming']."'
			  ,'".$data2[0]['cinicio']."'
			  ,'".$data['testalu']."'
			  ,'".$cconmat."'
			  ,'".$cconmat."'
			  ,'".$cconmat."'
			  ,'V'
			  ,'".$recibo."'
			  ,'".$thorari."'
			  ,'".$data2['cgrupo']."'
			  ,'".$data2[0]['cmodali']."'
			  ,'".$data2[0]['ctipcar']."'
			  ,now(),'".$data['cusuari']."','I'
			  ,'".$data['sermatr']."'
			  ,'".$data['dcodlib']."'
			  ,'".$data['certest']."'
			  ,'".$data['partnac']."'
			  ,'".$data['fotodni']."'
			  ,'".$data['dcoduni']."'
			  ,'".$data['otrodni']."'
			  ,'".$data['posbeca']."'
			  ,'".$data['cpais']."'
			  ,'".$data['tinstip']."'
			  ,'".$data['dinstip']."'
			  ,'".$data['dcarrep']."'
			  ,'".$data['ultanop']."'
			  ,'".$data['dciclop']."'
			  ,'".$data['ddocval']."'
			  ,'".$data['destica']."'
			  ,'".$data['ccencap']."'
			  ,'".$data['dcompro']."'
			  ,'".$data['dproeco']."'
			  ,'".$data['nfotos']."')";
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}

		$sqlver2="SELECT * 
				  FROM usugrup
				  WHERE cperson='".$data['cperson']."'";
		$db->setQuery($sqlver2);
    	$valsql2=$db->loadObjectList();
		if(count($valsql2)==0){		
			$paslog=str_replace("-","",$data['dcodlib']);
			$actpersona="UPDATE personm 
						 SET dlogper='".$paslog."',dpasper=concat('".$paslog."',SUBSTR(dnomper,1,1)) 
						 WHERE cperson='".$data['cperson']."'";
			$db->setQuery($actpersona);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$actpersona);exit();
				}
				if(!MySqlTransaccionDAO::insertarTransaccion($actpersona,$data['cfilial']) ){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$actpersona);exit();
				}
		}
		
		$sqlver2="Select cgrupo 
				  FROM grupom 
				  WHERE cinstit='".$data['cinstit']."'
				  AND dgrupo like 'ALUMNO%'";
		$db->setQuery($sqlver2);
    	$codigoGrupo=$db->loadObjectList();
		$cgrupo="01";
		if(count($codigoGrupo)>0){
		$cgrupo=$codigoGrupo[0]["cgrupo"];
		}
		
		$sqlver2="SELECT * 
				  FROM usugrup
				  WHERE cperson='".$data['cperson']."'
				  AND cgrupo='".$cgrupo."'";
		$db->setQuery($sqlver2);
    	$valsql2=$db->loadObjectList();
		if(count($valsql2)==0){
			$sqlgrupos="INSERT INTO usugrup (cperson,cgrupo,cfilial,fingres,cestado,cusuari,fusuari)
					VALUES ('".$data['cperson']."','".$cgrupo."','".$data['locestu']."','".$data['finscri']."','1','".$data['cusuari']."',now())";
			$db->setQuery($sqlgrupos);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlgrupos);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlgrupos,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlgrupos);exit();
			}
		}
		
		if($data['persona_elegida']!=''){
		$persona_elegida=explode("-",$data['persona_elegida']);	
		$estadofinal=1;
		$monto=$data['persona_elegida_monto'];
		$montofinal="retensi";
		$recacapersona=$persona_elegida[4];
			if($data['persona_elegida_monto']!='' and $data['persona_elegida_monto']!='0'){
				$estadofinal=0;
				$montofinal="'".$monto."'";
				
			$sqlupdate="UPDATE recacap SET cfilial='".$data['cfilial']."',festfin='".$data['fecha_pago']."',cusuari='".$data['cusuari']."',fusuari=now(),ttiptra='M',cestpag='F',testfin='F'
							WHERE crecaca='".$persona_elegida[4]."'";
				
				$db->setQuery($sqlupdate);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$data['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
					}
					
				$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);
				$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','','','".$persona_elegida[2]."','".$persona_elegida[0]."','','".$monto."','".$data['fecha_pago']."','P','C','E','','','".$persona_elegida[3]."','".$persona_elegida[1]."','2','P','S','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."',now(),'I','P','','S')";
				$db->setQuery($sqlinsrec2);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$data['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
					}
				$pagoreal=$data['monto_pago_ins']+$data['monto_pago']+$data['monto_pago_convalida']+$data['monto_pago_pension'];
				$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);
				$recacapersona=$newcodrec;
				$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','','','".$persona_elegida[2]."','".$persona_elegida[0]."','','".$pagoreal."','".$data['fecha_pago']."','P','C','E','','','".$persona_elegida[3]."','".$persona_elegida[1]."','2','C','S','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."',now(),'I','P','','S')";
				
				$db->setQuery($sqlinsrec);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$data['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
					}
			
			}		
		$actpersona="UPDATE bitacop 
					 SET cestado='".$estadofinal."',traspas=".$montofinal.",
					 crecaca=IF(IFNULL(crecaca,'')='','".$recacapersona."',CONCAT(crecaca,',','".$recacapersona."')),
					 cingal2=IF(IFNULL(cingal2,'')='','".$cingalu."',CONCAT(cingal2,',','".$cingalu."')),
					 cgracp2=IF(IFNULL(cgracp2,'')='','".$cgruaca."',CONCAT(cgracp2,',','".$cgruaca."'))
					 WHERE cingalu='".$persona_elegida[0]."'					 
					 AND cgracpr='".$persona_elegida[1]."'";
		$db->setQuery($actpersona);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$actpersona);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($actpersona,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$actpersona);exit();
			}			
		}
		
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Persona registrada correctamente');exit();
	}
}
?>