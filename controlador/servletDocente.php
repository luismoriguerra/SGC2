<?
class servletDocente extends controladorComandos{
	public function doPost(){
		$daoDocente=creadorDAO::getDocenteDAO();
		switch ($_POST['accion']){			
			case 'ActualizarDocente':				
				$data=array();
				$data=$_POST['post'];
				echo json_encode($daoDocente->ActualizarDocente($data));
			break;
			case 'InsertarDocente':				
				$data=array();
                $data=$_POST['post'];
				// $data['cperson']=trim($_POST['cperson']);
				// $data['fingreso']=trim($_POST['fingreso']);
				// $data['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoDocente->InsertarDocente($data));
			break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoDocente=creadorDAO::getDocenteDAO();
		switch ($_GET['accion']){
			case 'jqgrid_docente':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(pe.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(pe.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(pe.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(pe.ndniper)='".strtoupper(trim($_GET['ndniper']))."' ";
                }
				if(isset($_GET['fingreso']) && trim($_GET['fingreso'])!=''){
                    $where.=" AND p.fingreso='".trim($_GET['fingreso'])."' ";
                }
                if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND p.cestado='".trim($_GET['cestado'])."' ";
                }
				if(isset($_GET['estado']) && trim($_GET['estado'])!=''){
                    $where.=" AND p.cestado='".trim($_GET['estado'])."' ";
                }
                if(isset($_GET['filial']) && trim($_GET['filial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['filial']))."%' ";
                }
                if(isset($_GET['institucion']) && trim($_GET['institucion'])!=''){
                    $where.=" AND upper(i.dinstit) LIKE '%".strtoupper(trim($_GET['institucion']))."%' ";
                }
                if(isset($_GET['peso']) && trim($_GET['peso'])!=''){
                    $where.=" AND pesodoc =  '".strtoupper(trim($_GET['peso']))."' ";
                }
				if(!$sidx)$sidx=1 ; 

                $row=$daoDocente->JQGridCountDocente($where);
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
				
				$data=$daoDocente->JQGRIDRowsDocente($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cprofes'],"cell"=>array(
							$data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
							$data[$i]['fingreso'],
                            $data[$i]['filial'],                          
                            $data[$i]['cfilial'],                          
                            $data[$i]['institucion'],                          
                            $data[$i]['cinstit'],                          
                            $data[$i]['pesodoc'],                            
                            $data[$i]['estado'],                            
                            $data[$i]['cestado'],                            
                            $data[$i]['cperson'],  							
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