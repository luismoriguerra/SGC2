<?php
class servletCencap extends controladorComandos{
        public function doPost(){
            $daoCencap=creadorDAO::getCencapDAO();
            switch ($_POST['action']):
                case 'cargarFiliales':
					$data=array();				
                    echo json_encode($daoCencap->cargarFiliales($data));
                    break;
				case 'cargarInstitutos':
					$data=array();				
                    echo json_encode($daoCencap->cargarInstitutos());
                    break;
                case 'addCencap':
                    $data=array();
                    $data['cfilial']=trim($_POST['cfilial']);
                    $data['descrip']=trim($_POST['descrip']);
                    $data['cestado']=trim($_POST['cestado']);
					$data['cusuari']=trim($_POST['cusuari']);
					$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCencap->addCencap($data));
                    break;				
                case 'editCencap':
                $data=array();
                    $data['ccencap']=trim($_POST['ccencap']);
                    $data['cfilial']=trim($_POST['cfilial']);
                    $data['descrip']=trim($_POST['descrip']);
                    $data['cestado']=trim($_POST['cestado']);
                    $data['cusuari']=trim($_POST['cusuari']);
					$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCencap->editCencap($data));
                    break;
				case 'ListCencap':
                $data=array();                    
                    $data['cfilial']=trim($_POST['cfilial']);
                    echo json_encode($daoCencap->ListCencap($data));
                    break;                			
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$daoCencap=creadorDAO::getCencapDAO();
			switch($_GET['action']):
				case 'jqgrid_cencap':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
                                        
                                        if( isset($_GET['ccencap']) ) {
						if( trim($_GET['ccencap'])!='' ) {
							$where.=" AND c.ccencap like '%".trim($_GET['ccencap'])."%' ";
						}
					}
                                        
					if( isset($_GET['description']) ) {
						if( trim($_GET['description'])!='' ) {
							$where.=" AND c.description like '%".trim($_GET['description'])."%' ";
						}
					}
					
                                        if( isset($_GET['filial']) ) {
						if( trim($_GET['filial'])!='' ) {
							$where.=" AND (SELECT f.dfilial FROM filialm AS f WHERE f.cfilial = c.cfilial ) like '%".trim($_GET['filial'])."%' ";
						}
					}
                                        
                                        if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoCencap->JQGridCountCencap( $where );
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
					$data=$daoCencap->JQGRIDRowsCencap($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ccencap'],"cell"=>array(								
								$data[$i]['ccencap'],
								$data[$i]['description'],
								$data[$i]['filial'],								
								$data[$i]['cfilial'],
                                                                $data[$i]['estado'],
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
