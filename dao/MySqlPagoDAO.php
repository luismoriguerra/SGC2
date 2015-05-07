<?
class MySqlPagoDAO{	
	public function cargarMontoPago($crecacasx){
		$db=creadorConexion::crear('MySql');

		$crecacas="'".implode("','", $crecacasx)."'";
		$sql="SELECT r.crecaca,r.nmonrec,r.cingalu,r.cperson,r.fvencim,r.cgruaca
			  from recacap r 
			  where r.crecaca in (".$crecacas.")  
			  ORDER BY r.fvencim,r.ccuota";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
			foreach($data as $d){
			if($d['cingalu']!="" and $d['cperson']!='' and strlen(trim($d['cperson']))==19 and strlen(trim($d['cingalu']))==19 and $d['cgruaca']!=""){
			$where=" where (rr.cingalu='".$d['cingalu']."' or rr.cperson='".$d['cperson']."')
					 AND rr.cgruaca='".$d['cgruaca']."'";
			}
			elseif($d['cingalu']!="" and $d['cgruaca']!=""){
			$where=" where (rr.cingalu='".$d['cingalu']."')
					 AND rr.cgruaca='".$d['cgruaca']."'";
			}
			else{
			$where=" where (rr.cperson='".$d['cperson']."')
					 AND rr.cgruaca='".$d['cgruaca']."'";
			}
			$sqlvalida="select *
						from recacap rr
						 ".$where."	 
						and rr.testfin='P' 
						and rr.fvencim<'".$d['fvencim']."'
						and rr.crecaca not in ($crecacas)  ";
			$db->setQuery($sqlvalida);
			$data2=$db->loadObjectList();
				if(count($data2)>0){
				return array('rst'=>'2','msj'=>'Ud tiene una deuda anterior debe seleccionarlo primero','data'=>$data,'sql'=>$sqlvalida);exit();
				}				
			}
			return array('rst'=>'1','msj'=>'','data'=>$data,'sql'=>$sqlvalida);exit();
        }else{
            return array();
        }
	}	
	public function cargarMontoAcumulado($array){
		$db=creadorConexion::crear('MySql');
		$sql="	select *
				from recacap r
				inner join ingalum i on (r.cingalu=i.cingalu)
				where r.cingalu='".$array["cingalu"]."'
				and r.cgruaca='".$array["cgracpr"]."'
				and r.testfin='S'
				and i.cestado='0'";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if(count($data)>0){			
			return array('rst'=>'2','msj'=>'EL ALUMNO YA FUE RETIRADO DE ESTE GRUPO','data'=>$data,'sql'=>$sql);exit();
        }				
				
		$sql="	select sum(nmonrec) as total
				from recacap
				where cingalu='".$array["cingalu"]."'
				and cgruaca='".$array["cgracpr"]."'
				and (testfin='C' OR (testfin='S' AND tdocpag is not null AND tdocpag!=''))
				GROUP BY cingalu,cgruaca";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0){			
			return array('rst'=>'1','msj'=>'Alumno Cargado','data'=>$data,'sql'=>$sql);exit();
        }else{ 
			return array('rst'=>'2','msj'=>'Alumno no realizó ningun pago en el semestre actual','data'=>$data,'sql'=>$sql);exit();
        }
	}

	public function cargarMontoEscala($array){
		$db=creadorConexion::crear('MySql');
				
		$sql="	SELECT SUM(r.nmonrec) as monto,r.cconcep,CONCAT(c.dconcep,' - ',c.ncuotas,'C - ',c.nprecio,' - Prom ',c.ctaprom,'C - ',c.mtoprom) AS concepto 
				FROM recacap r
				INNER JOIN concepp c ON (r.`cconcep`=c.`cconcep`)				
				where cingalu='".$array["cingalu"]."'
				and cgruaca='".$array["cgracpr"]."'
				AND (r.testfin='C' OR (r.testfin='S' AND r.tdocpag IS NOT NULL AND r.tdocpag!=''))
				AND r.ccuota>=1
				GROUP BY r.cingalu,r.cgruaca";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0){			
			return array('rst'=>'1','msj'=>'Alumno Cargado','data'=>$data[0],'sql'=>$sql);exit();
        }else{ 
        $sql="	SELECT '0' as monto,r.cconcep,CONCAT(c.dconcep,' - ',c.ncuotas,'C - ',c.nprecio,' - Prom ',c.ctaprom,'C - ',c.mtoprom) AS concepto 
				FROM recacap r
				INNER JOIN concepp c ON (r.`cconcep`=c.`cconcep`)				
				where cingalu='".$array["cingalu"]."'
				and cgruaca='".$array["cgracpr"]."'				
				AND r.ccuota>=1
				GROUP BY r.cingalu,r.cgruaca";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
			//return array('rst'=>'2','msj'=>'Alumno no realizó ningun pago de pensión en el semestre actual','data'=>$data,'sql'=>$sql);exit();
			return array('rst'=>'1','msj'=>'Alumno Cargado','data'=>$data[0],'sql'=>$sql);exit();				
        }
	}

	public function cargarEscalaPersonalizada($array){
		$db=creadorConexion::crear('MySql');
				
		$sql="SELECT CONCAT(co.cconcep,'-',co.nprecio,'-',co.ctaprom,'-',co.mtoprom,'-',co.ncuotas) AS id,CONCAT(co.dconcep,' - ',co.ncuotas,'C - ',co.nprecio,' - Prom ',co.ctaprom,'C - ',co.mtoprom) AS nombre
			  FROM concepp co
			  INNER JOIN cropaga cr ON (co.cconcep=cr.cconcep)
			  WHERE cr.cgruaca='".$array['cgracpr']."'
			  AND co.cconcep!='".$array['cconcep']."'
			  AND co.nprecio>0
			  AND co.cestado='1' 
			  GROUP BY co.cconcep
			  ORDER BY co.dconcep";				
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0){			
			return array('rst'=>'1','msj'=>'Escalas Cargadas','data'=>$data,'sql'=>$sql);exit();
        }else{ 
			return array('rst'=>'2','msj'=>'Escalas no encontradas para actualizar','data'=>$data,'sql'=>$sql);exit();
        }
	}

	public function cambiarEscala($array){
		$montototal=$array['monto'];
		$montoapagar=0;
		$db=creadorConexion::crear('MySql');

		$db->iniciaTransaccion();

		$update="UPDATE recacap
				SET cestpag='F',testfin='F'
				WHERE cingalu='".$array['cingalu']."'
				and cgruaca='".$array['cgracpr']."'
				AND cconcep='".$array['cconcep']."'";
				
		$db->setQuery($update);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$update);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($update,$array['cfilial']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$update);exit();
		}

		$sqldatos="	SELECT i.`testalu`,i.cperson,g.*
					FROM gracprp g
					INNER JOIN conmatp c ON (c.`cgruaca`=g.cgracpr)
					INNER JOIN ingalum i ON (i.`cingalu`=c.`cingalu`)
					WHERE i.`cingalu`='".$array['cingalu']."'
					AND g.cgracpr='".$array['cgracpr']."'";
		$db->setQuery($sqldatos);	
		$datoscropaga=$db->loadObjectList();
		////////////CRONOGRAMA DE PAGOS////////////////////////////			
		$sqlcropag="SELECT c.* 
					FROM cropaga c
					INNER JOIN gracprp g on (c.`cgruaca`=g.cgracpr) 
					where c.cconcep='".$array['cconcepnuevo']."'
					AND g.csemaca='".$datoscropaga[0]['csemaca']."'
					AND g.cfilial='".$datoscropaga[0]['cfilial']."'
					AND g.cinstit='".$datoscropaga[0]['cinstit']."'
					AND g.cinicio='".$datoscropaga[0]['cinicio']."'
					AND g.cfrecue='".$datoscropaga[0]['cfrecue']."'
					AND g.ctipcar='".$datoscropaga[0]['ctipcar']."'
					AND g.cmodali='".$datoscropaga[0]['cmodali']."'
					AND g.cciclo='".$datoscropaga[0]['cciclo']."'
					AND g.ccurric='".$datoscropaga[0]['ccurric']."'
					GROUP BY c.ccuota
					order by c.ccuota,c.fvencim";
		$db->setQuery($sqlcropag);	
		$cropag=$db->loadObjectList();
		if(count($cropag)>0){

			foreach($cropag as $r){
				if($datoscropaga[0]['testalu']!="RE"){
					$ccropag=$db->generarCodigo('cropaga','ccropag',11,$array['cusuari']);
					$sql="INSERT INTO cropaga  (ccropag, cconcep, cgruaca, ccuota, fvencim, tcropag, fusuari, cusuari, ttiptra, cfilial) VALUES ('".$ccropag."','".$r['cconcep']."','".$array['cgracpr']."','".$r['ccuota']."','".$r['fvencim']."','2',now(),'".$array['cusuari']."','I','".$datoscropaga[0]['cfilial']."')";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
				}
				
				$monto_pension=$array['montonuevo'];
					if($array['cuotapronuevo']>=$r["ccuota"]){
					$monto_pension=$array['montopronuevo'];
					}			
				
					$tipopago="P";
					if($montototal>0){
					$newcodbol=$db->generarCodigo('boletap','cboleta',14,$array['cusuari']);
						$tipopago="S";
						if($montototal>=$monto_pension){
							$montoapagar=$monto_pension;
							$newcodrec=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
							$sqlinsrecpen="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) 
							VALUES('".$newcodrec."','".$datoscropaga[0]['cfilial']."','".$newcodbol."','B','".$datoscropaga[0]['cperson']."','".$array['cingalu']."','".$r['ccuota']."','".$montoapagar."','".$r['fvencim']."','A','C','E','','','".$r['cconcep']."','".$array['cgracpr']."','2','P','".$tipopago."','".$r['fvencim']."','".$r['fvencim']."','".$array['cusuari']."',now(),'I','P','','".$tipopago."')";
							$db->setQuery($sqlinsrecpen);
								if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrecpen);exit();
								}
								if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrecpen,$array['cfilial']) ){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrecpen);exit();
								}
						}
						else{
							$montoapagar=$montototal;
							$newcodrec=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
							$sqlinsrecpen="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) 
							VALUES('".$newcodrec."','".$datoscropaga[0]['cfilial']."','".$newcodbol."','B','".$datoscropaga[0]['cperson']."','".$array['cingalu']."','".$r['ccuota']."','".$montoapagar."','".$r['fvencim']."','A','C','E','','','".$r['cconcep']."','".$array['cgracpr']."','2','P','".$tipopago."','".$r['fvencim']."','".$r['fvencim']."','".$array['cusuari']."',now(),'I','P','','".$tipopago."')";
							$db->setQuery($sqlinsrecpen);
								if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrecpen);exit();
								}
								if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrecpen,$array['cfilial']) ){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrecpen);exit();
								}

							$restapendiente=$monto_pension*1-$montoapagar*1;
							$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
							$sqlinsrecpen="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) 
							VALUES('".$newcodrec2."','".$datoscropaga[0]['cfilial']."','','','".$datoscropaga[0]['cperson']."','".$array['cingalu']."','".$r['ccuota']."','".$restapendiente."','".$r['fvencim']."','A','C','E','','','".$r['cconcep']."','".$array['cgracpr']."','2','P','P','".$r['fvencim']."','".$r['fvencim']."','".$array['cusuari']."',now(),'I','P','','P')";
							$db->setQuery($sqlinsrecpen);
								if(!$db->executeQuery()){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrecpen);exit();
								}
								if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrecpen,$array['cfilial']) ){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrecpen);exit();
								}
						}
						$montototal=$montototal*1-$montoapagar*1;

					
					$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) 
					VALUES ('".$newcodbol."','000','0000000','".$datoscropaga[0]['cfilial']."','','','1','2','".date("Y-m-d")."','".date("Y-m-d")."','".$array['cusuari']."','".$array['cusuari']."',now(),'I','".$datoscropaga[0]['cinstit']."','".$montoapagar."')";
					
					$db->setQuery($sqlinsbol);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$array['cfilial']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
						}

					$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) 
					VALUES('".$newcodbol."','".$newcodrec."','1','1','".$montoapagar."','".$datoscropaga[0]['cfilial']."')";
					$db->setQuery($sqlinsdetbol);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$array['cfilial']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
						}
					}
					else{
						$newcodrec=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
						$sqlinsrecpen="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) 
						VALUES('".$newcodrec."','".$datoscropaga[0]['cfilial']."','','','".$datoscropaga[0]['cperson']."','".$array['cingalu']."','".$r['ccuota']."','".$monto_pension."','".$r['fvencim']."','A','C','E','','','".$r['cconcep']."','".$array['cgracpr']."','2','P','".$tipopago."','".$r['fvencim']."','".$r['fvencim']."','".$array['cusuari']."',now(),'I','P','','".$tipopago."')";
						$db->setQuery($sqlinsrecpen);
							if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrecpen);exit();
							}
							if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrecpen,$array['cfilial']) ){
								$db->rollbackTransaccion();
								return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrecpen);exit();
							}
					}
					
				
			}		
		}
		else{
			$db->rollbackTransaccion();
			return array('rst'=>'2','msj'=>'No hay cronograma para el concepto seleccionado','sql'=>$sqlcropag);exit();
		}

		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Se realizó con éxito');exit();

	}
	
	public function registrarRetiro($array){
		$db=creadorConexion::crear('MySql');

		$db->iniciaTransaccion();
		
		
		$sql="	Select *
				from ingalum
				where cingalu='".$array['cingalu']."'";
		$db->setQuery($sql);
		$datosalumno=$db->loadObjectList();
		/*Comisión Retiro*/
		$sql="	Select *
				from concepp
				where cctaing like '707.08.01%'
				and cfilial='".$array['cfilial']."'";
		$db->setQuery($sql);
		$datoscomision=$db->loadObjectList();
		
		/*Comision por cambio*/
		/*$sql="	Select *
				from concepp
				where cctaing like '707.08.02%'
				and cfilial='".$array['cfilial']."'";
		$db->setQuery($sql);
		$datoscambio=$db->loadObjectList();*/
		
		/*Retensión Retiro*/
		$sql="	Select *
				from concepp
				where cctaing like '707.09.01%'
				and cfilial='".$array['cfilial']."'";
		$db->setQuery($sql);
		$datosretension=$db->loadObjectList();
		
		/*Retensión por cambio*/
		/*$sql="	Select *
				from concepp
				where cctaing like '707.09.02%'
				and cfilial='".$array['cfilial']."'";
		$db->setQuery($sql);
		$datoscambio=$db->loadObjectList();*/
		/***********************************VERIFICA SI EXISTE UN PENDIENTE DE DEUDA EN RETIRO*************************************/
		$sql="	select r.nmonrec,r.crecaca,b.crecaca,r.cingalu,r.cgruaca,r.cperson
				from recacap r
				INNER JOIN concepp c on (r.cconcep=c.cconcep)
				LEFT JOIN bitacop b on (FIND_IN_SET(r.crecaca,b.crecaca)>0)
				where c.cctaing='707.09.01'
				and b.crecaca is null
				AND r.cperson='".$datosalumno[0]['cperson']."'";
		$db->setQuery($sql);
		$datosreciboadicional=$db->loadObjectList();

		if(count($datosreciboadicional)>0){
			$array['retensi']=$array['retensi']+$datosreciboadicional[0]['nmonrec'];
			$actpersona="UPDATE bitacop 
						 SET cestado='1',traspas=retensi,
						 crecaca=IF(IFNULL(crecaca,'')='','".$datosreciboadicional[0]['crecaca']."',CONCAT(crecaca,',','".$datosreciboadicional[0]['crecaca']."'))					 
						 WHERE cingalu='".$datosreciboadicional[0]['cingalu']."'					 
						 AND cgracpr='".$datosreciboadicional[0]['cgruaca']."'";
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

		/*************************EN CASO EXISTA SE AUMENTA LA RETENSION***********************************************/


		$fechahoy=date("Y-m-d");

		$insert="INSERT INTO bitacop (cingalu,cgracpr,descuen,retensi,comisio,reserva,fechaop,cusuari,fusuari) VALUES ('".$array['cingalu']."','".$array['cgracpr']."','".$array['descuen']."','".$array['retensi']."','".$array['comisio']."','".$array['reserva']."',now(),'".$array['cusuari']."',now())";
							
		$db->setQuery($insert);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insert);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($insert,$array['cfilial']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insert);exit();
		}

		
		$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$array['cfilial']."','','','".$datosalumno[0]['cperson']."','".$array['cingalu']."','','".$array['comisio']."','".$fechahoy."','P','C','E','','','".$datoscomision[0]['cconcep']."','".$array['cgracpr']."','2','S','S','".$fechahoy."','".$fechahoy."','".$array['cusuari']."',now(),'I','P','','S')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$array['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		
		$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
		$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$array['cfilial']."','','','".$datosalumno[0]['cperson']."','".$array['cingalu']."','','".$array['retensi']."','".$fechahoy."','P','C','E','','','".$datosretension[0]['cconcep']."','".$array['cgracpr']."','2','S','S','".$fechahoy."','".$fechahoy."','".$array['cusuari']."',now(),'I','P','','S')";
		$db->setQuery($sqlinsrec2);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$array['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
			}
		
		$update="UPDATE recacap
				SET cestpag='S',testfin='S'
				WHERE cingalu='".$array['cingalu']."'
				and cgruaca='".$array['cgracpr']."'
				and cestpag='P'";
				
		$db->setQuery($update);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$update);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($update,$array['cfilial']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$update);exit();
		}
		
		$update2="UPDATE ingalum
				SET cestado='0'
				WHERE cingalu='".$array['cingalu']."'";
				
		$db->setQuery($update2);
		if(!$db->executeQuery()){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$update2);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($update,$array['cfilial']) ){
			$db->rollbackTransaccion();
			return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$update2);exit();
		}	
		
		
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Pago realizado','sql'=>$update2);exit();
	}
	
	public function registrarPago($array){
		$db=creadorConexion::crear('MySql');		
		$sql="Select *
			  FROM recacap
			  WHERE crecaca in ('".str_replace("\\","",$array['crecacas'])."')
			  ORDER BY fvencim,ccuota";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		$cant=0;
		$db->iniciaTransaccion();
		
		if($array['tpago']=="B"){
			$sqlvalida="Select *
						FROM boletap
						WHERE dserbol='".$array['dserbol']."'
						AND dnumbol='".$array['dnumbol']."'";
			$db->setQuery($sqlvalida);
			$datavalida=$db->loadObjectList();
			//if(count($datavalida)>0){
			//return array('rst'=>'2','msj'=>'La Boleta ingresada ya existe');exit();
			//}
			
			
		$newcod=$db->generarCodigo('boletap','cboleta',14,$array['cusuari']);					
		$sqlinsbol="INSERT INTO boletap (cboleta,dserbol,dnumbol,cfilial,dnomraz,dobsanu,cestini,cestfin,festini,festfin,cusuini,cusufin,fusuari,ttiptra,cinstit,ntotbol) VALUES ('".$newcod."','".$array['dserbol']."','".$array['dnumbol']."','".$array['cfilial']."','','','1','2','".$array['fechapago']."','".$array['fechapago']."','".$array['cusuari']."','".$array['cusuari']."',now(),'I','','".$array['monto']."')";
							
		$db->setQuery($sqlinsbol);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsbol);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsbol,$array['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsbol);exit();
			}
		}
		elseif($array['tpago']=="V"){
		$nvouche=$array["numvou"];
		$cbanco=$array["cbanco"];
		$monto=$array['monto'];
		
			$sqlvalida="Select *
						FROM vouchep
						WHERE numvou='".$array['numvou']."'
						AND cbanco='".$array['cbanco']."'";
			$db->setQuery($sqlvalida);
			$datavalida=$db->loadObjectList();
			//if(count($datavalida)>0){
			//return array('rst'=>'2','msj'=>'El Voucher ingresado ya existe');exit();
			//}
		//$dserbol=add_ceros($serbol,3);
		$newcod=$db->generarCodigo('vouchep','cvouche',14,$array['cusuari']);		
		$insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) values('".$newcod."','".$nvouche."','".$cbanco."','".$array['cfilial']."','','".$array['cusuari']."',now(),'I','".$monto."')";
		$db->setQuery($insvoucher);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$array['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
			}
		}
		
		
			foreach($data as $r){
			$cant++;
			$montopago=$r['nmonrec'];		
				if($cant<$array['cant'] or $array['deuda']==0){
				$sqlupdate="UPDATE recacap SET cfilial='".$array['cfilial']."',cdocpag='".$newcod."',tdocpag='".$array['tpago']."',festfin='".$array['fechapago']."',cusuari='".$array['cusuari']."',fusuari=now(),ttiptra='M',cestpag='C',testfin='C'
							WHERE crecaca='".$r['crecaca']."'";
				
				$db->setQuery($sqlupdate);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
					}
					
					if($array['tpago']=="B"){
					$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcod."','".$r['crecaca']."','1','1','".$montopago."','".$array['cfilial']."')";
					$db->setQuery($sqlinsdetbol);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$array['cfilial']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
						}
					}
				}
				else{
				$sqlupdate="UPDATE recacap SET cfilial='".$array['cfilial']."',festfin='".$array['fechapago']."',cusuari='".$array['cusuari']."',fusuari=now(),ttiptra='M',cestpag='F',testfin='F'
							WHERE crecaca='".$r['crecaca']."'";
				
				$db->setQuery($sqlupdate);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
					}
					
				$newcodrec2=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);
				$sqlinsrec2="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec2."','".$array['cfilial']."','','','".$r['cperson']."','".$r['cingalu']."','".$r['ccuota']."','".$array['deuda']."','".$r['fvencim']."','P','C','E','','','".$r['cconcep']."','".$r['cgruaca']."','2','P','P','".$array['fechapago']."','".$array['fechapago']."','".$array['cusuari']."',now(),'I','P','','P')";
				$db->setQuery($sqlinsrec2);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec2);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec2,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec2);exit();
					}
				$pagoreal=$montopago-$array['deuda'];
				$newcodrec=$db->generarCodigo('recacap','crecaca',13,$array['cusuari']);		
				$sqlinsrec="INSERT INTO recacap (crecaca,cfilial,cdocpag,tdocpag,cperson,cingalu,ccuota,nmonrec,fvencim,tpagant,dmodpag,tpagcaj,nvouche,nctabco,cconcep,cgruaca,tgruaca,cestini,testfin,festini,festfin,cusuari,fusuari,ttiptra,tpago,cfut,cestpag) VALUES('".$newcodrec."','".$array['cfilial']."','".$newcod."','".$array['tpago']."','".$r['cperson']."','".$r['cingalu']."','".$r['ccuota']."','".$pagoreal."','".$r['fvencim']."','P','C','E','','','".$r['cconcep']."','".$r['cgruaca']."','2','C','C','".$array['fechapago']."','".$array['fechapago']."','".$array['cusuari']."',now(),'I','P','','C')";
				
				$db->setQuery($sqlinsrec);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsrec);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsrec,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsrec);exit();
					}
					
					if($array['tpago']=="B"){
					$sqlinsdetbol="INSERT INTO detbolp (cboleta,crecibo,ttiprec,ncantidad,nmonto,cfilial) VALUES('".$newcod."','".$newcodrec."','1','1','".$pagoreal."','".$array['cfilial']."')";
					$db->setQuery($sqlinsdetbol);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsdetbol);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsdetbol,$array['cfilial']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsdetbol);exit();
						}
					}
				}
			}
		
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Pago realizado','sql'=>$sql);exit();
	}
	public function JQGridCountPago($where,$cperson,$cingalu,$cgracpr){
		$db=creadorConexion::crear('MySql');
		
		$sql="SELECT count(*) as count
			from recacap r 
			INNER JOIN concepp c on r.cconcep=c.cconcep
			LEFT join cuota cu on cu.ccuota=r.ccuota
			LEFT join gracprp g on g.cgracpr=r.cgruaca
			LEFT join cicloa ci on ci.cciclo=g.cciclo
			where r.testfin in ('P','C','S')
			AND (r.cingalu='".$cingalu."')
			AND r.cgruaca='".$cgracpr."'
			$where
			group by r.crecaca";
			//echo($sql);exit;
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('count'=>0));
        }
	}
	
	public function JQGRIDRowsPago ( $sidx, $sord, $start, $limit, $where,$cperson,$cingalu,$cgracpr) {
		$sql="SELECT IF(r.testfin='C' or r.testfin='S',concat('P_',r.crecaca),IF(r.testfin='P',r.crecaca,'')) as crecaca,
			  cu.dcuota,c.dconcep,g.csemaca,ci.dciclo,r.nmonrec,r.fvencim, 
			  IF (r.testfin='P','Pendiente',
					IF(r.testfin='C','Cancelado',
						IF(r.testfin='S' AND FIND_IN_SET(r.crecaca,b.crecaca)>0,'Devuelto',
							IF(r.testfin='S' AND c.cctaing='707.09.01','Pendiente',
								IF(r.testfin='S','Anulado','')
							)
						)
					)
				) as pago,
			  IF(r.testfin='C',
			  	IF(r.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol) from boletap b where b.cboleta=r.cdocpag),
					IF(r.tdocpag='V',(select concat(v.numvou,'<br>',b.dbanco) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=r.cdocpag),''
					)
				)
				,'') as monto,IF(r.testfin='C',date(r.festfin),'') as festfin
			from recacap r 
			INNER JOIN concepp c on (r.cconcep=c.cconcep)
			LEFT join cuota cu on (cu.ccuota=r.ccuota)
			LEFT join gracprp g on (g.cgracpr=r.cgruaca)
			LEFT join cicloa ci on (ci.cciclo=g.cciclo)			
			LEFT JOIN bitacop b on (b.cingalu=r.cingalu and b.cgracpr=r.cgruaca) 
			where r.testfin in ('P','C','S')
			AND (r.cingalu='".$cingalu."')
			AND r.cgruaca='".$cgracpr."'
			$where
			group by r.crecaca ORDER BY $sidx $sord			
		  	LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data; 
    }

    public function editBoleta($array){
		$db=creadorConexion::crear('MySql');

			$sqlvalida="SELECT DATE_SUB(CURDATE(), INTERVAL ntiempo DAY) as fecha,ntiempo
						FROM boltolem
						WHERE cestado='1'
						ORDER BY cboltole DESC
						Limit 0,1";
			$db->setQuery($sqlvalida);
			$datavalida=$db->loadObjectList();
			if(count($datavalida)==0){
			return array('rst'=>'2','msj'=>'No hay tiempo de tolerancia; Crear un tiempo tolerancia para actualizar boletas');exit();
			}

			if($datavalida[0]['fecha']>$array['fecha2']){
			//return array('rst'=>'2','msj'=>'Tiempo de tolerancia "'.$datavalida[0]['ntiempo'].' Día(s)" no permite modificar la boleta');exit();
			}
		
			if($array['dserbol']!=$array['dserbol2'] or $array['dnumbol']!=$array['dnumbol2']){
				$sqlvalida="Select *
							FROM boletap
							WHERE dserbol='".$array['dserbol']."'
							AND dnumbol='".$array['dnumbol']."'";
				$db->setQuery($sqlvalida);
				$datavalida=$db->loadObjectList();
				//if(count($datavalida)>0){
				//return array('rst'=>'2','msj'=>'La Boleta ingresada ya existe');exit();
				//}
			}

			if($array['dserbol']!=$array['dserbol2'] or $array['dnumbol']!=$array['dnumbol2'] or $array['fecha']!=$array['fecha2']){
				if($array['fecha']!=$array['fecha2']){
					$sqlactrec="UPDATE recacap
					SET festfin='".$array['fecha']."'
					WHERE cdocpag IN (
					SELECT cboleta 
					FROM boletap					
					WHERE concat(dserbol,'-',dnumbol) = concat('".$array['dserbol2']."-".$array['dnumbol2']."'))";
							
					$db->setQuery($sqlactrec);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlactrec);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sqlactrec,$array['cfilial']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlactrec);exit();
						}
				}

				/* Obteniendo info de la boleta antes de act*/
				$sqlboleta="Select *
							FROM boletap
							WHERE concat(dserbol,'-',dnumbol) = '".$array['dserbol2']."-".$array['dnumbol2']."'";
				$db->setQuery($sqlboleta);
				$databoleta=$db->loadObjectList();
		
	
				$sqlactbol="UPDATE boletap 
							SET dserbol='".$array['dserbol']."',dnumbol='".$array['dnumbol']."', festfin='".$array["fecha"]."'
							WHERE concat(dserbol,'-',dnumbol) = '".$array['dserbol2']."-".$array['dnumbol2']."'";
									
				$db->setQuery($sqlactbol);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlactbol);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlactbol,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlactbol);exit();
					}	

				$sqlperson="Select cperson
							FROM personm
							WHERE dlogper='".$array['cusuari']."'";
				$db->setQuery($sqlperson);
				$dataperson=$db->loadObjectList();					

				$sqlbitacora="INSERT INTO bitbolm (cfilial,cboleta,cusuari,fusuari,dserbol,dnumbol,fechaan,fechanu,cperson)
				VALUES ('".$databoleta[0]['cfilial']."','".$array['dserbol2']."-".$array['dnumbol2']."','".$array['cusuari']."',now(),'".$array['dserbol']."','".$array['dnumbol']."','".$array['fecha2']."','".$array['fecha']."','".$dataperson[0]['cperson']."')";
				
					$db->setQuery($sqlbitacora);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlbitacora);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sqlbitacora,$array['cfilial']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlbitacora);exit();
					}	
			}
		
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Boleta Actualizada','sql'=>$sql);exit();
	}
}
?>