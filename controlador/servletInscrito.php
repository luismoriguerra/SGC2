<?
class servletInscrito extends controladorComandos{
	public function doPost(){
		$daoInscrito=creadorDAO::getInscritoDAO();
		switch ($_POST['accion']){            
			default:
				case 'InsertarInscripcion':
				$data=array();				
				$data['persona_elegida']=trim($_POST['persona_elegida']);
				$data['persona_elegida_monto']=trim($_POST['persona_elegida_monto']);
				$data['cperson']=trim($_POST['cperson']);
				$data['tmodpos']=trim($_POST['tmodpos']);// Modalidad ingreso
				$data['cmoding']=trim($_POST['cmoding']); // Modalidad ingreso
				$data['tmodpos2']=trim($_POST['tmodpos2']);// Modalidad ingreso nuevo
				$data['cmoding2']=trim($_POST['cmoding2']);// Modalidad ingreso nuevo
				$data['csemadm']=trim($_POST['csemadm']);
				$data['cseming']=trim($_POST['cseming']);
			
				$data['locestu']=trim($_POST['locestu']);			
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cgruaca']=trim($_POST['cgruaca']);
				
				$data['dcompro']=trim($_POST['dcompro']);
				$data['dproeco']=trim($_POST['dproeco']);
				
				$data['posbeca']=trim($_POST['posbeca']);// para presencial preguntar nomas XD
				/*//////////////////////*/
				/*//////////DOCUMENTOS ACADÉMICOS OBLIGATORIOS PARA EL PROCESO DE ADMISIÓN//////////*/
				$data['certest']=trim($_POST['certest']);
				$data['partnac']=trim($_POST['partnac']);
				$data['fotodni']=trim($_POST['fotodni']);
				$data['otrodni']=trim($_POST['otrodni']);
				/*//////////////////////*/
				/*///////////////// PAGO INSCRIPCIÓN //////////////////////////////*/
				$data['tipo_pago_ins']=trim($_POST['tipo_pago_ins']);
				$data['cconcep_ins']=trim($_POST['cconcep_ins']);
				$data['monto_pago_ins']=trim($_POST['monto_pago_ins']);
				$data['fecha_pago_ins']=trim($_POST['fecha_pago_ins']);
				$data['monto_deuda_ins']=trim($_POST['monto_deuda_ins']);
				$data['fecha_deuda_ins']=trim($_POST['fecha_deuda_ins']);
				$data['tipo_documento_ins']=trim($_POST['tipo_documento_ins']);
				$data['serie_boleta_ins']=trim($_POST['serie_boleta_ins']);
				$data['numero_boleta_ins']=trim($_POST['numero_boleta_ins']);
				$data['numero_voucher_ins']=trim($_POST['numero_voucher_ins']);
				$data['banco_voucher_ins']=trim($_POST['banco_voucher_ins']);
				/*////////////////////////////////////////////////////////*/
				/*////////////PAGO MATRÍCULA/////////////////////////////////////*/
				$data['condi_pago']=trim($_POST['condi_pago']);
				$data['tipo_pago']=trim($_POST['tipo_pago']);
				$data['cconcep']=trim($_POST['cconcep']);
				$data['monto_pago']=trim($_POST['monto_pago']);
				$data['fecha_pago']=trim($_POST['fecha_pago']);
				$data['monto_deuda']=trim($_POST['monto_deuda']);
				$data['fecha_deuda']=trim($_POST['fecha_deuda']);
				$data['tipo_documento']=trim($_POST['tipo_documento']);
				$data['serie_boleta']=trim($_POST['serie_boleta']);
				$data['numero_boleta']=trim($_POST['numero_boleta']);
				$data['numero_voucher']=trim($_POST['numero_voucher']);
				$data['banco_voucher']=trim($_POST['banco_voucher']);
				/*/////////////////////////////////////////////////////*/
				/*////////////PAGO CONVALIDACIÓN/////////////////////////////////////*/
				$data['cconcep_convalida']=trim($_POST['cconcep_convalida']);
				$data['monto_pago_convalida']=trim($_POST['monto_pago_convalida']);
				$data['fecha_pago_convalida']=trim($_POST['fecha_pago_convalida']);
				$data['monto_deuda_convalida']=trim($_POST['monto_deuda_convalida']);
				$data['fecha_deuda_convalida']=trim($_POST['fecha_deuda_convalida']);
				$data['tipo_documento_convalida']=trim($_POST['tipo_documento_convalida']);
				$data['serie_boleta_convalida']=trim($_POST['serie_boleta_convalida']);
				$data['numero_boleta_convalida']=trim($_POST['numero_boleta_convalida']);
				$data['numero_voucher_convalida']=trim($_POST['numero_voucher_convalida']);
				$data['banco_voucher_convalida']=trim($_POST['banco_voucher_convalida']);
				/*/////////////////////////////////////////////////////*/
				//////////////////////// PAGO PENSIÓN/////////////////
				$data['cconcep_pension']=trim($_POST['cconcep_pension']);
				$data['monto_pago_pension']=trim($_POST['monto_pago_pension']);
				$data['fecha_pago_pension']=trim($_POST['fecha_pago_pension']);
				$data['monto_deuda_pension']=trim($_POST['monto_deuda_pension']);
				$data['fecha_deuda_pension']=trim($_POST['fecha_deuda_pension']);
				$data['tipo_documento_pension']=trim($_POST['tipo_documento_pension']);
				$data['serie_boleta_pension']=trim($_POST['serie_boleta_pension']);
				$data['numero_boleta_pension']=trim($_POST['numero_boleta_pension']);
				$data['numero_voucher_pension']=trim($_POST['numero_voucher_pension']);
				$data['banco_voucher_pension']=trim($_POST['banco_voucher_pension']);
				$data['ctaprom']=trim($_POST['ctaprom']);
				$data['mtoprom']=trim($_POST['mtoprom']);
				$data['monto_concepto_pension']=trim($_POST['monto_concepto_pension']);				
				/*////////////////////////////////////////////////////////*/
				/*/////////////DATOS PARA EL PROCESO DE CONVALIDACIÓN ////////////*/
				$data['cpais']='';
				$data['tinstip']='';
				$data['dinstip']='';
				$data['dcarrep']='';
				$data['ultanop']='';
				$data['dciclop']='';
				$data['ddocval']='';
				$data['testalu']='RE';				
					if($_POST['valconv']=="ok"){
					$data['testalu']='IR';
					$data['cpais']=trim($_POST['cpais']);
					$data['tinstip']=trim($_POST['tinstip']);
					$data['dinstip']=trim($_POST['dinstip']);
					$data['dcarrep']=trim($_POST['dcarrep']);
					$data['ultanop']=trim($_POST['ultanop']);
					$data['dciclop']=trim($_POST['dciclop']);
					$data['ddocval']=trim($_POST['ddocval']);
					}
				/*////////////////////////////////////////////////////////////////*/
				/*////////////////////MARKETING///////////////////////*/
				$data['ctipcap']=trim($_POST['ctipcap']);
				$data['cvended']='';
				$data['cmedpre']='';
				$data['destica']='';
				
					if(trim($_POST['dclacap'])=='1'){
					$data['destica']=trim($_POST['destica']);
					}
					elseif(trim($_POST['dclacap'])=='2'){
					$data['cvended']=trim($_POST['id_cvended_jqgrid']);
					}
					elseif(trim($_POST['dclacap'])=='3'){
					$data['cmedpre']=trim($_POST['medio_prensa']); //codigo de prensa
					}					
				/*////////////////////////////////////////////////////////////////*/
				$data['serinsc']=trim($_POST['serinsc']);
				$data['sermatr']=trim($_POST['sermatr']);
				$data['ccencap']=trim($_POST['ccencap']);// centro captcion agregar
				
				$data['crecepc']=trim($_POST['crecepc']);
				$data['finscri']=trim($_POST['finscri']);
				$data['dcodlib']=trim($_POST['dcodlib']);//codigo del libro		
				$data['nfotos']=trim($_POST['nfotos']);
				
				/*/////////////////////////////////////////////////////////////////////////////////*/
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cusuari']=trim($_POST['cusuari']);
				echo json_encode($daoInscrito->InsertarInscripcion($data));
				//echo json_encode(array('rst'=>2,'msj'=>'Falta validar '.$data['testalu']));
				break;
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoInscrito=creadorDAO::getInscritoDAO();
		switch ($_GET['accion']){
			case 'jqgrid_inscrito':
                $cinstit=$_GET["cinstit"];
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoInscrito->JQGridCountInscrito($where,$cinstit);
                $count=$row[0]['count'];				
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoInscrito->JQGRIDRowsInscrito($sidx, $sord, $start, $limit, $where,$cinstit);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cperson']."-".$data[$i]['ccarrer'],"cell"=>array(
                            $data[$i]['dnomper'],
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
                            $data[$i]['ndniper'],
							$data[$i]['email1'],
							$data[$i]['ntelpe2'],
							$data[$i]['ntelper'],
							$data[$i]['ntellab'],
							$data[$i]['ddirper'],
							$data[$i]['ddirref'],							
							$data[$i]['ddirlab'],
							$data[$i]['dnomlab'],
							$data[$i]['ddepart'],
							$data[$i]['dprovin'],
							$data[$i]['ddistri'],//							
                            $data[$i]['ccarrer'],
                            $data[$i]['dcarrer'],
                            $data[$i]['ctipcar'],
                            $data[$i]['cmodali'],
                            $data[$i]['csemadm'],
                            $data[$i]['cinicio'],
                            $data[$i]['tmodpos'],
							$data[$i]['serinsc'],
							$data[$i]['certest'],
							$data[$i]['partnac'],
							$data[$i]['fotodni'],
							$data[$i]['otrodni']
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>