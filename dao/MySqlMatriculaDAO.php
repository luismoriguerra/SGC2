<?
class MySqlMatriculaDAO{	
	public function InsertarMatricula($data){
	$db=creadorConexion::crear('MySql');
	$sqlver1="SELECT * 
			  FROM postulm p
			  WHERE p.cperson='".$data['cperson']."'
			  AND p.csemadm='".$data['cseming']."'
			  AND p.cinstit='".$data['cinstit']."'
			  AND p.ccarrer='".$data['ccarrer']."'
			  AND p.cestado='1'";
	
	$db->setQuery($sqlver1);
    $valsql1=$db->loadObjectList();
	
	$sqlver2="SELECT * 
			  FROM ingalum 
			  where ccarrer='".$data['ccarrer']."'
			  and cinstit='".$data['cinstit']."'
			  and cperson='".$data['cperson']."'";
	
	$db->setQuery($sqlver2);	
    $valsql2=$db->loadObjectList();
	
	$db->iniciaTransaccion();
	
		if(count($valsql1)==0){
		$sql="UPDATE postulm SET
			  ccarrer='".$data['ccarrer']."'
			  ,csemadm='".$data['cseming']."'
			  ,cinicio='".$data['ciniing']."'
			  ,cusuari='".$data['cusuari']."'
			  ,fusuari=now()
			  WHERE cperson='".$data['cperson']."'
			  AND cestado='1'
			  AND (cingalu is null or trim(cingalu)='') ";
			$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Actualizar Datos'.$sql);exit();
			}
			$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
			$db->setQuery($transa);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
				}
		}
	
		if(count($valsql2)>0){
		$db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>"La persona ya existe como alumno en la carrera seleccionada");exit();
		}
		else{
			/////////////////////////PAGO MATRICULA
			if($data['tipo_documento']=="B"){
			$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
			$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta']."','".$data['numero_boleta']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."','".$data['cusuari']."','".date("Y-m-d")."','I','".$data['cinstit']."','".$data['monto_pago']."')";					
			$db->setQuery($sqlinsbol);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsbol);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsbol)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}					
				
			$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
			$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$newcodbol."','B','".$data['cperson']."','','','".$data['monto_pago']."','".$data['fecha_pago']."','P','C','E','','','".$data['cconcep']."','','2','C','C','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','C')";
			$db->setQuery($sqlinsrec);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec."','1','1','".$data['monto_pago']."','".$data['cfilial']."')";
			$db->setQuery($sqlinsdetbol);
				if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsdetbol);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsdetbol)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			}	
			elseif($data['tipo_documento']=="V"){
			$nvouche=$data["numero_voucher"];
			$cbanco=$data["banco_voucher"];
			$monto=$data['monto_pago'];
			//$dserbol=add_ceros($serbol,3);
			$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
			$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."','".date('Y-m-d h:i:s')."','I','".$monto."')";
			$db->setQuery($insvoucher);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$insvoucher);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($insvoucher)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			$newcodrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
			$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$data['cfilial']."','".$codi_vouche."','V','".$data['cperson']."','','','".$monto."','".$data['fecha_pago']."','P','C','E','','','".$data['cconcep']."','','2','C','C','".$data['fecha_pago']."','".$data['fecha_pago']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','C')";
			$db->setQuery($sqlinsrec);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			}
			
			if($data['monto_deuda']>0){
				$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
				$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','','','".$data['cperson']."','','','".$data['monto_deuda']."','".$data['fecha_deuda']."','P','C','E','','','".$data['cconcep']."','','2','P','P','".$data['fecha_deuda']."','".$data['fecha_deuda']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','P')";
			$db->setQuery($sqlinsrec2);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec2);exit();
				}	
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec2)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			}			
			
			/////////////////CONSTANCIA MATRICULA
			$cconmat=$db->generarCodigo('conmatp','cconmat',11,$data['cusuari']);
			$cingalu=$db->generarCodigo('ingalum','cingalu',11,$data['cusuari']);
			$sqlconsulta="SELECT * FROM postulm
						  WHERE cperson='".$data['cperson']."'
						  AND cestado='1'
						  AND (cingalu is null or trim(cingalu)='')";
			$db->setQuery($sqlconsulta);	
		    $valcon=$db->loadObjectList();
			$data2=array();
			foreach($valcon as $r){				
			$data2['cpromot']=$r['cpromot'];
			$data2['ctipcap']=$r['ctipcap'];
			$data2['cmedpre']=$r['cmedpre'];			
			}
			
			$sqlconsulta2="SELECT ccurric FROM gracprp
						  WHERE cgracpr='".$data['cgruaca']."'";
			$db->setQuery($sqlconsulta2);	
		    $valcon2=$db->loadObjectList();
			$data2['ccurric']=$valcon2[0]['ccurric'];
			
			
			$sqlconsulta3="SELECT cgrupo FROM grupom
						  WHERE cmodali='".$data['cmodali']."'
							and ctipcar='".$data['ctipcar']."'
							and cinstit='".$data['cinstit']."'
							and cestado='1'";
			$db->setQuery($sqlconsulta3);	
		    $valcon3=$db->loadObjectList();
			if(count($valcon3)>0){
			$data2['cgrupo']=$valcon3[0]['cgrupo'];
			}
			else{
			$data2['cgrupo']="00";
			}
			
			$sqlinsmat="INSERT INTO conmatp (cconmat,fmatric,cingalu,testmat,nnomina,cgruaca,cgracan,fusuari,cusuari,tgrupo,testalu,titptra,tforpag,cpromot,cfilial,sermatr) VALUES('".$cconmat."','".$data['finscri']."','".$cingalu."','1','','".$data['cgruaca']."','','".date("Y-m-d H:i:s")."','".$data['cusuari']."','2','".$data['testalu']."','I','C','".$data2['cpromot']."','".$data['cfilial']."','".$data['sermatr']."')";
			$db->setQuery($sqlinsmat);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsmat);exit();
			}
			
			$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsmat)."',now(),'".$data['cfilial']."')";
			$db->setQuery($transa);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
				}
			////////// DETALLE DE CONSTANCIA
			if($data['testalu']=="RE"){
			$sqlcur="SELECT * FROM cuprprp WHERE cgracpr='".$data['cgruaca']."'";
			$db->setQuery($sqlcur);	
		    $detcur=$db->loadObjectList();
				foreach($detcur as $r){				
				$sqlinsdet="INSERT INTO decomap (ccurpro,cconmat,cestado,tgruaca,tprocur,nnoficu,dmonofi,tmonofi,nregist,tusbeno,nnomadi,fusuari,cusuari,cesgeac,tesalgr,fincute,cfilial) VALUES('".$r['ccuprpr']."','".$cconmat."','1','2','U','','','','','','',now(),'".$data['cusuari']."','N','A','','".$data['cfilial']."')";
				$db->setQuery($sqlinsdet);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsdet);exit();
					}
					
					$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsdet)."',now(),'".$data['cfilial']."')";
					$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}			
				}
			
			}
			//////////////UPDATE INSCRITO
			$upinscrito="UPDATE postulm SET cingalu='".$cingalu."',cestado='2' 
						 WHERE cperson='".$data['cperson']."'
						 AND cestado='1'
						 AND (cingalu is null or trim(cingalu)='')";
			$db->setQuery($upinscrito);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$upinscrito);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($upinscrito)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
				
			////////////CRONOGRAMA DE PAGOS			
			
			$sqlcropag="SELECT * FROM cropaga
						where cconcep='".$data['cconcep_pension']."'
						and cgruaca='".$data['cgruaca']."'
						order by ccuota,fvencim";
			$db->setQuery($sqlcropag);	
		    $cropag=$db->loadObjectList();
			$fecha_fin_cuota1="";
				foreach($cropag as $r){
					if($r['ccuota']==1){
					$fecha_fin_cuota1=$r['fvencim'];
					}
					else{
					$codrec=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);				
					$sqlinsrecpen="INSERT INTO recacap VALUES ('".$codrec."','".$data['cfilial']."','','','','".$cingalu."','".$r['ccuota']."','".($data['monto_pago_pension']+$data['monto_deuda_pension'])."','".$r['fvencim']."','A','','','','','".$r['cconcep']."','".$data['cgruaca']."','2','P','P','','','".$data['cusuari']."','".date("Y-m-d H:i:s")."','I','P','','')";
					$db->setQuery($sqlinsrecpen);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrecpen);exit();
						}
						
						$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrecpen)."',now(),'".$data['cfilial']."')";
						$db->setQuery($transa);
							if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
							}
					}
				}
				
				///////////////////// PAGO PENSION
			if($data['tipo_documento_pension']=="B"){
			$newcodbol=$db->generarCodigo('boletap','cboleta',14,$data['cusuari']);					
			$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcodbol."','".$data['serie_boleta_pension']."','".$data['numero_boleta_pension']."','".$data['cfilial']."','','','1','2','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."','".$data['cusuari']."','".date("Y-m-d")."','I','".$data['cinstit']."','".$data['monto_pago_pension']."')";					
			$db->setQuery($sqlinsbol);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsbol);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsbol)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}					
				
			$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
			$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','".$newcodbol."','B','','".$cingalu."','1','".$data['monto_pago_pension']."','".$fecha_fin_cuota1."','A','','','','','".$data['cconcep_pension']."','".$data['cgruaca']."','2','C','C','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','C')";
			$db->setQuery($sqlinsrec);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcodbol."','".$newcodrec2."','1','1','".$data['monto_pago_pension']."','".$data['cfilial']."')";
			$db->setQuery($sqlinsdetbol);
				if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsdetbol);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsdetbol)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			}	
			elseif($data['tipo_documento']=="V"){
			$nvouche=$data["numero_voucher_pension"];
			$cbanco=$data["banco_voucher_pension"];
			$monto=$data['monto_pago_pension'];
			//$dserbol=add_ceros($serbol,3);
			$codi_vouche=$db->generarCodigo('vouchep','cvouche',14,$data['cusuari']);		
			$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$codi_vouche."','".$nvouche."','".$cbanco."','".$data['cfilial']."','".$data['cinstit']."','".$data['cusuari']."','".date('Y-m-d h:i:s')."','I','".$monto."')";
			$db->setQuery($insvoucher);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$insvoucher);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($insvoucher)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			
			$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
			$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','".$codi_vouche."','V','','".$cingalu."','1','".$monto."','".$fecha_fin_cuota1."','A','','','','','".$data['cconcep_pension']."','".$data['cgruaca']."','2','C','C','".$data['fecha_pago_pension']."','".$data['fecha_pago_pension']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','C')";
			$db->setQuery($sqlinsrec);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
			
			}
			
			if($data['monto_deuda_pension']>0){
				$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$data['cusuari']);		
				$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$data['cfilial']."','','','','".$cingalu."','1','".$data['monto_deuda_pension']."','".$fecha_fin_cuota1."','A','','','','','".$data['cconcep_pension']."','".$data['cgruaca']."','2','P','P','".$data['fecha_deuda_pension']."','".$data['fecha_deuda_pension']."','".$data['cusuari']."','".date("Y-m-d")."','I','M','','P')";
			$db->setQuery($sqlinsrec2);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sqlinsrec2);exit();
				}
				
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sqlinsrec2)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}	
			}
			
			/////////////////INGRESO ALUMNO		
		//$db->rollbackTransaccion();
		//return array('rst'=>'2','msj'=>'Se esta validando aun los registros');exit();	
		$sql="INSERT INTO ingalum (cingalu,cperson,finscri,cmoding,ctipcap,cpromot,cmedpre,cconcep,ccarrer,ccurric,cfilial,cinstit,cseming,ciniing,testalu,consnew,comauma,compuma,tusorec,crecmat,thorari,cgrupo,cmodali,ctipcar,fusuari,cusuari,ctiptra,sermatr,dcodlib,certest,partnac,fotodni,dcoduni,otrodni)
			  VALUES ('".$cingalu."'
			  ,'".$data['cperson']."'
			  ,'".$data['finscri']."'
			  ,'".$data['cmoding']."'
			  ,'".$data2['ctipcap']."'
			  ,'".$data2['cpromot']."'
			  ,'".$data2['cmedpre']."'
			  ,'".$data['cconcep']."'
			  ,'".$data['ccarrer']."'
			  ,'".$data2['ccurric']."'
			  ,'".$data['cfilial']."'
			  ,'".$data['cinstit']."'
			  ,'".$data['cseming']."'
			  ,'".$data['ciniing']."'
			  ,'".$data['testalu']."'
			  ,'".$cconmat."'
			  ,'".$cconmat."'
			  ,'".$cconmat."'
			  ,'".$data['tusorec']."'
			  ,'".$newcodrec."'
			  ,'".$data['thorari']."'
			  ,'".$data2['cgrupo']."'
			  ,'".$data['cmodali']."'
			  ,'".$data['ctipcar']."'
			  ,now()
			  ,'".$data['cusuari']."'
			  ,'I'
			  ,'".$data['sermatr']."'
			  ,'".$data['dcodlib']."'
			  ,'".$data['certest']."'
			  ,'".$data['partnac']."'
			  ,'".$data['fotodni']."'
			  ,'".$data['dcoduni']."'
			  ,'".$data['otrodni']."'
			  )";	
		
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();			
			}
			
			$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
			$db->setQuery($transa);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
				}			
		
		if($data['testalu']=="RE"){
		$msj="Persona Matriculada Correctamente";	
		}
		else{
		$msj="Persona Matriculada Irregular => Armar cursos para su programación";
		}
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>$msj);exit();
		}
	}
}
?>