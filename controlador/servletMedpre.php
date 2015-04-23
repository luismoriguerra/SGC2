<?php
class servletMedpre extends controladorComandos{
        public function doPost(){
            $daoMedpre=creadorDAO::getMedpreDAO();
            switch ($_POST['action']):
                case 'ListarFiltro':
                    echo json_encode($daoMedpre->ListarFiltro());
                    break;
                case 'editMedpre':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dmedpre"] =(trim($_POST['dmedpre']));
                   $post["cfilial"] =(trim($_POST['cfilial']));
                   $post["tmedpre"] =(trim($_POST['tmedpre']));
                   $post["cfilialx"] =(trim($_POST['cfilialx']));
                   $post["usuario_modificacion"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoMedpre->actualizarMedpre($post));
                    break;
                case 'addMedpre':
                   $post = array();
                   $post["cmedpre"] = (trim($_POST['cmedpre']));
                   $post["dmedpre"] =(trim($_POST['dmedpre']));
                   $post["cfilial"] =($_POST['cfilial']);
                   $post["tmedpre"] =(trim($_POST['tmedpre']));
                   $post["cfilialx"] =(trim($_POST['cfilialx']));
                   $post["usuario_creacion"] =(trim($_POST['cusuari']));
				   
                    echo json_encode($daoMedpre->insertarMedpre($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado1'));
            endswitch;
        }
        public function doGet(){
			$daoMedpre=creadorDAO::getMedpreDAO();
			switch($_GET['action']):
				case 'jqgrid_medpre':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['cmedpre']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND c.cmedpre LIKE '%".trim($_GET['cmedpre'])."%' ";
						}
					}
					
					if( isset($_GET['dmedpre']) ) {
						if( trim($_GET['dmedpre'])!='' ) {
							$where.=" AND c.dmedpre LIKE '%".trim($_GET['dmedpre'])."%' ";
						}
					}
					
                                        if( isset($_GET['tmedpre']) ) {
						if( trim($_GET['tmedpre'])!='' ) {
							$where.=" AND c.tmedpre LIKE '%".trim($_GET['tmedpre'])."%' ";
						}
					}
                                        
					 if( isset($_GET['dfilial']) ) {
						if( trim($_GET['dfilial'])!='' ) {
							$where.=" AND c2.dfilial LIKE '%".trim($_GET['dfilial'])."%' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoMedpre->JQGridCountMedpre( $where );
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
					$data=$daoMedpre->JQGRIDRowsMedpre($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cmedpre'],"cell"=>array(								
								$data[$i]['cmedpre'],								
								$data[$i]['dmedpre'],								
								$data[$i]['tmedpre'],
								$data[$i]['cfilial'],
                                                                $data[$i]['dfilial']
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
