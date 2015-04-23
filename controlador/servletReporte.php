<?
class servletReporte extends controladorComandos{
	public function doPost(){
		$daoReporte=creadorDAO::getReporteDAO();
		switch ($_POST['accion']){            
            case 'ArqueoCaja':
				$array=array();
                $array['finicio']=$_POST['finicio'];
				$array['ffin']=$_POST['ffin'];
				$array['cfilial']=$_POST['cfilial'];
                echo(json_encode($daoReporte->ArqueoCaja($array)));
                break;
			default:
				echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoRepote=creadorDAO::getReporteDAO();
		switch ($_GET['accion']){ 
			case 'jqgrid_arqueo':
				
				$array=array();
				$array['cfilial']=$_GET['cfilial'];
				$array['finicio']=$_GET['finicio'];
				$array['ffin']=$_GET['ffin'];
                $array['serbol']=$_GET['serbol'];
                $array['nrobol']=$_GET['nrobol'];
                $array['visible']=$_GET['visible'];
                
				
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";                

                if(!$sidx)$sidx=1 ; 

                $row=$daoRepote->JQGridCountArqueo($where,$array);
                $count=$row[0]['count'];
				$totalmonto=$row[0]['suma'];
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {						
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoRepote->JQGRIDRowsArqueo($sidx, $sord, $start, $limit, $where,$array);
                $dataRow=array();				
                for($i=0;$i<count($data);$i++){
					$detpago=explode("-",$data[$i]['pago']);					
                    array_push($dataRow, array("id"=>$data[$i]['crecaca'],"cell"=>array(
                            $data[$i]['festfin'],
                            $data[$i]['cctaing'],
                            $data[$i]['alumno'],
                            $data[$i]['cajero'],
                            $data[$i]['dinstit'],
                            trim($detpago[0]),
							trim($detpago[1]),
							$data[$i]['nmonrec']
							)
                        )
                    );
                }
					array_push($dataRow, array("id"=>"total_final","cell"=>array(
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
							'TOTAL:',
							$totalmonto
							)
                        )
                    );
				
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;   
            case 'jqgrid_bitbol':
                
                $array=array();
                $array['cfilial']=$_GET['cfilial'];
                $array['finicio']=$_GET['finicio'];
                $array['ffin']=$_GET['ffin'];
                $array['serbol']=$_GET['serbol'];
                $array['nrobol']=$_GET['nrobol'];
                
                $page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";                

                if(!$sidx)$sidx=1 ; 

                $row=$daoRepote->JQGridCountBitBol($where,$array);
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
                
                $data=$daoRepote->JQGRIDRowsBitBol($sidx, $sord, $start, $limit, $where,$array);
                $dataRow=array();               
                for($i=0;$i<count($data);$i++){            
                    array_push($dataRow, array("id"=>$data[$i]['cbitbol'],"cell"=>array(
                            $data[$i]['dfilial'],
                            $data[$i]['nombre'],
                            $data[$i]['fusuari'],
                            $data[$i]['cboleta'],
                            $data[$i]['fechaan'],
                            $data[$i]['cboletanu'],
                            $data[$i]['fechanu']
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