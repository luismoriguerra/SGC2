<?
class MySqlCronogramaDAO{
	
	public function insertarCronograma($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$repetidas="no";
		$encontro="no";
		$arrfil = explode(",",$r['cfilial']);
		
		$db->iniciaTransaccion();
		//foreach($arrfil as $cfilial){
			/*$sqlgrupo="SELECT * 
					  FROM  gracprp 
					  WHERE cfilial='".$cfilial."'
						AND csemaca='".$r["csemaca"]."'
						AND cinstit='".$r["cinstit"]."'
						AND ctipcar='".$r["ctipcar"]."'
						AND cmodali='".$cmodali[0]["cmodali"]."'
						AND ccarrer='".$r["ccarrer"]."'
						AND ccurric='".$r["ccurric"]."'
						AND cciclo ='".$r["cciclo"]."'
						AND cinicio='".$r["cinicio"]."'";*/
			$sqlgrupo=" SELECT *
						FROM gracprp
						WHERE cgracpr in ('".str_replace("\\","",$r['cgracpr'])."')";
			$db->setQuery($sqlgrupo);
			$arrgrupos=$db->loadObjectList();
		
			/*$sqlconcep="SELECT * 
						FROM concepp 
						WHERE cctaing like '701.03.%' 
						  AND cfilial='".$cfilial."'
						  AND ctipcar='".$r["ctipcar"]."'
						  AND cmodali='".$cmodali[0]["cmodali"]."'
						  AND cinstit='".$r["cinstit"]."'
						  AND tinscri='O' 
						  AND cestado='1'";
			$db->setQuery($sqlconcep);
			$arrconceptos=$db->loadObjectList();*/
			$arrconceptos=explode(",",$r['conceptos']);
			if(count($arrgrupos)>0 and count($arrconceptos)>0){					
				foreach($arrgrupos as $grupo){
					$cfilial=$grupo['cfilial'];
					//foreach($arrconceptos as $concepto){
					for($i=0;$i<count($arrconceptos);$i++){
						$detconcepto=explode("-",$arrconceptos[$i]);						
						$concepto['cconcep']=$detconcepto[0];
						$concepto['ncuotas']=$detconcepto[1];
						$concepto['cfilial']=$detconcepto[2];
						if($concepto['cfilial']==$cfilial){
						$encontro="si";
								if(trim($concepto['ncuotas'])=="" or $concepto['ncuotas']==0)
								{	$concepto['ncuotas']=1;		}
								
							$sql="SELECT * 
								  FROM cropaga 
								  WHERE cconcep='".$concepto['cconcep']."' 
									AND cgruaca='".$grupo['cgracpr']."'
									AND cfilial='".$cfilial."'";
							$db->setQuery($sql);
							$data=$db->loadObjectList();	
							if(count($data)>0){
								for($cuota=1; $cuota<=$concepto['ncuotas']; $cuota++){
									$repetidas="si";
									$sql="UPDATE cropaga
										  SET fvencim= '".$r['fvencim'.$cuota]."'
										  WHERE cconcep='".$concepto['cconcep']."' 
											AND cgruaca='".$grupo['cgracpr']."'
											AND cfilial='".$cfilial."'
											AND ccuota='".$cuota."'";
									$db->setQuery($sql);
									if(!$db->executeQuery()){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos1','sql'=>$sql);exit();
									}
									if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
									}	
								}
							}else{
								
								for($cuota=1; $cuota<=$concepto['ncuotas']; $cuota++){
									$ccropag=$db->generarCodigo('cropaga','ccropag',11,$r['cusuari']);
									$sql="INSERT INTO cropaga  (ccropag, cconcep, cgruaca, ccuota, fvencim, tcropag, fusuari, cusuari, ttiptra, cfilial)
										  VALUES ('".$ccropag."',
												  '".$concepto['cconcep']."',
												  '".$grupo['cgracpr']."',
												  '".$cuota."',
												  '".$r['fvencim'.$cuota]."',
												  '2',
												  now(),
												  '".$r['cusuari']."',
												  '1',
												  '".$cfilial."')";	
									$db->setQuery($sql);
									if(!$db->executeQuery()){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
									}
									if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
									}
								}
							}// fin del if esle
						}//valida si pertenece a esta filial
					}//foreach concepto conceptos en array
				}//foreach grupo
			}
		//}
		if($encontro=="no"){
			$db->rollbackTransaccion();
			return array('rst'=>'2','msj'=>'No se encontraron grupos y/o conceptos relacionados con los datos seleccionados.','sql'=>$sqlgrupo);exit();
		}elseif($repetidas=="si"){
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente; Se actualizaron los cronogramas registrados anteriormente.');exit();
		}else{
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente');exit();
		}
	}
}
?>