<?php
class servletModIng extends controladorComandos{
        public function doPost(){
            $daoModIng=creadorDAO::getModIngDAO();
            switch ($_POST['action']):
                case 'cargarModIng':
                    echo json_encode($daoModIng->cargarModIng());
                    break;
                case 'editModIng':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dmoding"] =(trim($_POST['dmoding']));
                   $post["cinstit"] =(trim($_POST['cinstit']));
				   $post["treqcon"] =(trim($_POST['treqcon']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_modificacion"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoModIng->actualizarModIng($post));
                    break;
                case 'addModIng':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dmoding"] =(trim($_POST['dmoding']));
                   $post["cinstit"] =(trim($_POST['cinstit']));
				   $post["treqcon"] =(trim($_POST['treqcon']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_creacion"] =(trim($_POST['cusuari']));
				   
                    echo json_encode($daoModIng->insertarModIng($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado1'));
            endswitch;
        }
        public function doGet(){
			$daoModIng=creadorDAO::getModIngDAO();
			switch($_GET['action']):
				case 'jqgrid_moding':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
					
		
					$where="";
					$param=array();
		
					if( isset($_GET['cmoding']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND c.cmoding LIKE '%".trim($_GET['cmoding'])."%' ";
						}
					}
					
					if( isset($_GET['dmoding']) ) {
						if( trim($_GET['dmoding'])!='' ) {
							$where.=" AND c.dmoding LIKE '%".trim($_GET['dmoding'])."%' ";
						}
					}
					
					if( isset($_GET['dinstit']) ) {
						if( trim($_GET['dinstit'])!='' ) {
							$where.=" AND c2.dinstit like '%".trim($_GET['dinstit'])."%' ";
						}
					}
					
                    if( isset($_GET['destado']) ) {
						if( trim($_GET['destado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['destado'])."' ";
						}
					}
					
					if( isset($_GET['dreqcon']) ) {
						if( trim($_GET['dreqcon'])!='' ) {
							$where.=" AND c.treqcon =  '".trim($_GET['dreqcon'])."' ";
						}
					}
					
					if( isset($_GET["cinstit"]) ) {
						if( trim($_GET["cinstit"])!='' ) {
							$where.=" AND c2.cinstit='".trim($_GET['cinstit'])."' ";
						}
					}
					
					
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoModIng->JQGridCountModIng( $where );
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
					$data=$daoModIng->JQGRIDRowsModIng($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cmoding'],"cell"=>array(								
								$data[$i]['dmoding'],								
								$data[$i]['dinstit'],								
								$data[$i]['cinstit'],
								$data[$i]['dreqcon'],
								$data[$i]['treqcon'],
								$data[$i]['destado'],
								$data[$i]['cestado']
								)
							)
						);
					}
					$response["rows"]=$dataRow;
					$response["where"]=$sidx."|".$sord."|".$start."|".$limit;
					echo json_encode($response);
				break;
				default:
				echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
}
?>
