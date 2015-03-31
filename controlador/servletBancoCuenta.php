<?php
class servletCuenta extends controladorComandos{
        public function doPost(){
            $daoCuenta=creadorDAO::getCuentaDAO();
            switch ($_POST['action']):
                case 'actualizarCuenta':
                $data=array();
				$data['cbanco']=trim($_POST['cbanco']);
				$data['id']=trim($_POST['id']);
				$data['descta']=trim($_POST['descta']);
				$data['nrocta']=trim($_POST['nrocta']);
				$data['dato01']=trim($_POST['dato01']);
				$data['dato02']=trim($_POST['dato02']);
				$data['dato03']=trim($_POST['dato03']);
				$data['dato04']=trim($_POST['dato04']);
				$data['dato05']=trim($_POST['dato05']);
				$data['cestado']=trim($_POST['cestado']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                    
                    echo json_encode($daoCuenta->actualizarCuenta($data));
                    break;
                case 'insertarCuenta':
                $data=array();
				$data['cbanco']=trim($_POST['cbanco']);
				$data['descta']=trim($_POST['descta']);
				$data['nrocta']=trim($_POST['nrocta']);
				$data['dato01']=trim($_POST['dato01']);
				$data['dato02']=trim($_POST['dato02']);
				$data['dato03']=trim($_POST['dato03']);
				$data['dato04']=trim($_POST['dato04']);
				$data['dato05']=trim($_POST['dato05']);
				$data['cestado']=trim($_POST['cestado']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCuenta->insertarCuenta($data));
                    break;
                case 'verificaNombre' :
                	$array=array();
					$array['dextxtb']=trim($_POST['dextxtb']);
                	echo json_encode($daoCuenta->verificaNombre($array));
                	break;
                case 'cargarCuentas':				
                    echo json_encode($daoCuenta->cargarCuentas());
                    break;
                case 'cargarDetalleEx':				
                    echo json_encode($daoCuenta->cargarDetalleEx());
                    break;                    
                case 'cargarFilIns':
                	$array=array();
                	$array['dextxtb']=$_POST['dextxtb'];
                	$array['cctacte']=$_POST['cctacte'];
                	echo json_encode($daoCuenta->cargarFilIns($array));
                break;
                case 'GenerarAsignacion':
                $array=array();
                $array['dextxtb']=$_POST['dextxtb'];
                $array['cfilial']=$_POST['cfilial'];
                $array['cfilialx']=$_POST['cfilialx'];
                $array['cinstit']=$_POST['cinstit'];
                $array['cctacte']=$_POST['cctacte'];                
                	echo json_encode($daoCuenta->GenerarAsignacion($array));
                break;                
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$daoCuenta=creadorDAO::getCuentaDAO();
			switch($_GET['action']):
				case 'jqgrid_cuenta':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['nrocta']) ) {
						if( trim($_GET['nrocta'])!='' ) {
							$where.=" AND c.nrocta LIKE '%".trim($_GET['nrocta'])."%' ";
						}
					}
					
					if( isset($_GET['descta']) ) {
						if( trim($_GET['descta'])!='' ) {
							$where.=" AND c.descta LIKE '%".trim($_GET['descta'])."%' ";
						}
					}
					
					if( isset($_GET['dato01']) ) {
						if( trim($_GET['dato01'])!='' ) {
							$where.=" AND c.dato01 LIKE '%".trim($_GET['dato01'])."%' ";
						}
					}

					if( isset($_GET['dato02']) ) {
						if( trim($_GET['dato02'])!='' ) {
							$where.=" AND c.dato02 LIKE '%".trim($_GET['dato02'])."%' ";
						}
					}
					if( isset($_GET['dato03']) ) {
						if( trim($_GET['dato03'])!='' ) {
							$where.=" AND c.dato03 LIKE '%".trim($_GET['dato03'])."%' ";
						}
					}
					if( isset($_GET['dato04']) ) {
						if( trim($_GET['dato04'])!='' ) {
							$where.=" AND c.dato04 LIKE '%".trim($_GET['dato04'])."%' ";
						}
					}
					if( isset($_GET['dato05']) ) {
						if( trim($_GET['dato05'])!='' ) {
							$where.=" AND c.dato05 LIKE '%".trim($_GET['dato05'])."%' ";
						}
					}
					
					if( isset($_GET['cbanco'])) {
						if( trim($_GET['cbanco'])!='' ) {
							$where.=" AND c.cbanco='".trim($_GET['cbanco'])."' ";
						}						
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoCuenta->JQGridCountCuenta( $where );
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
					$data=$daoCuenta->JQGRIDRowsCuenta($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cctacte'],"cell"=>array(								
								$data[$i]['cbanco'],
								$data[$i]['nrocta'],
								$data[$i]['descta'],								
								$data[$i]['dato01'],
								$data[$i]['dato02'],
								$data[$i]['dato03'],
								$data[$i]['dato04'],
								$data[$i]['dato05'],
								$data[$i]['cestado']
								)
							)
						);
					}
					$response["rows"]=$dataRow;
					echo json_encode($response);
				break;
				default:
				echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
}
?>
