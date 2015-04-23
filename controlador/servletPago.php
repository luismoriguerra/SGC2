<?
class servletPago extends controladorComandos{
	public function doPost(){
		$daoPago=creadorDAO::getPagoDAO();
		switch ($_POST['accion']){            
            case 'cargar_monto_pago':
                $crecacas=$_POST['crecacas'];
                echo(json_encode($daoPago->cargarMontoPago($crecacas) ));
                break;
			case 'cargarMontoAcumulado':
				$data=array();
                $data["cingalu"]=$_POST['cingalu'];
				$data["cgracpr"]=$_POST['cgracpr'];				
                echo(json_encode($daoPago->cargarMontoAcumulado($data)));
                break;
            case 'cargarMontoEscala':
				$data=array();
                $data["cingalu"]=$_POST['cingalu'];
				$data["cgracpr"]=$_POST['cgracpr'];				
                echo(json_encode($daoPago->cargarMontoEscala($data)));
                break;
            case 'cargarEscalaPersonalizada':
				$data=array();
                $data["cconcep"]=$_POST['cconcep'];
				$data["cgracpr"]=$_POST['cgracpr'];				
                echo(json_encode($daoPago->cargarEscalaPersonalizada($data)));
                break;
            case 'cambiarEscala':
            	$data=array();
                $data["cingalu"]=$_POST['cingalu'];
				$data["cgracpr"]=$_POST['cgracpr'];
				$data["cconcep"]=$_POST['cconcep'];
				$data["monto"]=$_POST['monto'];
				$data["cconcepnuevo"]=$_POST['cconcepnuevo'];
				$data["montonuevo"]=$_POST['montonuevo'];
				$data["cuotanuevo"]=$_POST['cuotanuevo'];
				$data["montopronuevo"]=$_POST['montopronuevo'];
				$data["cuotapronuevo"]=$_POST['cuotapronuevo'];
				$data["cfilial"]=$_POST['cfilial'];
				$data["cusuari"]=$_POST['cusuari'];
                echo(json_encode($daoPago->cambiarEscala($data)));
            	break;
			case 'registrarRetiro':
				$data=array();
                $data["cingalu"]=$_POST['cingalu'];
				$data["cgracpr"]=$_POST['cgracpr'];
				$data["descuen"]=$_POST['descuen'];
				$data["retensi"]=$_POST['retensi'];
				$data["comisio"]=$_POST['comisio'];
				$data["reserva"]=$_POST['reserva'];
				$data["fechaop"]=$_POST['fechaop'];
				$data["cusuari"]=$_POST['cusuari'];
				$data["cfilial"]=$_POST['cfilial'];
                echo(json_encode($daoPago->registrarRetiro($data)));
                break;			
			case 'registrarPago':
				$data=array();
				$detalle=explode("','",trim(str_replace("\\","",$_POST['crecacas'])));
				$data['crecacas']=trim($_POST['crecacas']);
				$data['cant']=count($detalle);
				$data['monto']=trim($_POST['monto']);
				$data['deuda']=trim($_POST['deuda']);
				$data['tpago']=trim($_POST['tpago']);
				$data['dserbol']=trim($_POST['dserbol']);
				$data['dnumbol']=trim($_POST['dnumbol']);
				$data['numvou']=trim($_POST['numvou']);
				$data['cbanco']=trim($_POST['cbanco']);
				$data['fechapago']=trim($_POST['fechapago']);
				
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
							
				echo(json_encode($daoPago->registrarPago($data)));
				break;
			case 'editBoleta':
				$data=array();
				$data['dserbol']=trim($_POST['dserbol']);
				$data['dnumbol']=trim($_POST['dnumbol']);
				$data['dserbol2']=trim($_POST['dserbol2']);
				$data['dnumbol2']=trim($_POST['dnumbol2']);
				$data['fecha']=trim($_POST['fecha']);
				$data['fecha2']=trim($_POST['fecha2']);
				
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
							
				echo(json_encode($daoPago->editBoleta($data)));
				break;
			default:
				echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoPago=creadorDAO::getPagoDAO();
		switch ($_GET['accion']){
            case 'jqgrid_pago':
				if(!isset($_GET["cingalu"])){
                    echo '{"page":0,"total":0,"records":"0","rows":[]}';
                    exit();
                }else if( $_GET['cingalu']=='' ) {
                    echo '{"page":0,"total":0,"records":"0","rows":[]}';
                    exit();
                }	
				

                $cingalu=$_GET['cingalu'];
				$cperson=$_GET['cperson'];
                $cfilial=$_GET["cfilial"];
				$cgracpr=$_GET['cgracpr'];

				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";                

                if(!$sidx)$sidx=1 ; 

                $row=$daoPago->JQGridCountPago($where,$cperson,$cingalu,$cgracpr);
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
				
				$data=$daoPago->JQGRIDRowsPago($sidx, $sord, $start, $limit, $where,$cperson,$cingalu,$cgracpr);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['crecaca'],"cell"=>array(
                            $data[$i]['crecaca'],
                            $data[$i]['dcuota'],
                            $data[$i]['dconcep'],
                            $data[$i]['csemaca'],
                            $data[$i]['dciclo'],
							$data[$i]['pago'],
							$data[$i]['monto'],
                            $data[$i]['nmonrec'],
							$data[$i]['festfin'],
							$data[$i]['fvencim']
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