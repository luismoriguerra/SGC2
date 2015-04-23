<?php
class servletPlanCurricular extends controladorComandos{
        public function doPost(){
            $daoPlancurricular=creadorDAO::getPlanCurricularDAO();
            switch ($_POST['action']):
                case 'cargarPlancurricular':
                    $post["ccur"] = (trim($_POST['ccur']));
                    $post["cmod"] =(trim($_POST['cmod']));
                    echo json_encode($daoPlancurricular->cargarPlancurricular($post));
                    break;
                case 'listarPlanCurricular':
                	$post=array();
                	$post["cingalu"] = (trim($_POST['cingalu']));
                    
                    echo json_encode($daoPlancurricular->listarPlanCurricular($post));
                	break;
                case 'actualizar_plancurricular':
                   $post = array();
				   
                   $post["ccurri"] = (trim($_POST['ccurri']));
                   $post["cmodul"] =(trim($_POST['cmodul']));
		   $post["ccurso"] =(trim($_POST['ccurso']));
                    
                   $post["ccurre"] = (trim($_POST['ccurre']));
                   $post["ncredi"] =(trim($_POST['ncredi']));
                   $post["nroteo"] =(trim($_POST['nroteo']));
                   $post["nropra"] =(trim($_POST['nropra']));
                   $post["estado"] =(trim($_POST['estado']));
                   
                   $post["cusuari"] = (trim($_POST['cusuari']));
		   $post["cfilialx"] =(trim($_POST['cfilialx']));
                    echo json_encode($daoPlancurricular->actualizarPlancurricular($post));
                    break;
                case 'guardar_plancurricular':
                   $post = array();
                   $post["ccurri"] = (trim($_POST['ccurri']));
                   $post["ccurso"] =(trim($_POST['ccurso']));
                   $post["cmodul"] =(trim($_POST['cmodul']));

                   $post["ccurre"] = (trim($_POST['ccurre']));
                   $post["ncredi"] =(trim($_POST['ncredi']));
                   $post["nroteo"] =(trim($_POST['nroteo']));
                   $post["nropra"] =(trim($_POST['nropra']));
                   $post["estado"] =(trim($_POST['estado']));
                   
                   $post["cusuari"] = (trim($_POST['cusuari']));
		   $post["cfilialx"] =(trim($_POST['cfilialx']));
                    echo json_encode($daoPlancurricular->insertarPlancurricular($post));
                    break;
				case 'borrarPlancurricular':
                    $post = array();
				   
	                $post["id"] = (trim($_POST['id']));
                    $post["plancurricular"] =(trim($_POST['nombre']));
                    echo json_encode($daoPlancurricular->borrarPlancurricular($post));
                    break;
                
                case 'guardar_curricular':
                   $post = array();
                    
                   $post["ccarrer"] = (trim($_POST['ccarrer']));
                   $post["dtitulo"] =(trim($_POST['dtitulo']));
				   $post["dresolu"] =(trim($_POST['dresolu']));
                   
                   $post["cusuari"] =(trim($_POST['cusuari']));
	   			   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   
                    echo json_encode($daoPlancurricular->guardarcurricular($post));
                    break;
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoPlancurricular=creadorDAO::getPlancurricularDAO();
			switch($_GET['action']):
				case 'jqgrid_plancurricular':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
                                        
                                        $ccur= $_GET["ccur"];
                                        $cmod= $_GET["cmod"];
					$where=" AND ccurric =$ccur AND cmodulo =$cmod ";
					$param=array();
		
					if( isset($_GET['id_plancurricular']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND c.dcurso LIKE '%".trim($_GET['id_plancurricular'])."%' ";
						}
					}
					
					if( isset($_GET['nombre']) ) {
						if( trim($_GET['nombre'])!='' ) {
							$where.=" AND nombre ILIKE '%".trim($_GET['nombre'])."%' ";
						}
					}
					
                                        if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND estado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)
                                            $sidx=1 ; 
		
					$row=$daoPlancurricular->JQGridCountPlancurricular( $where );
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
					$data=$daoPlancurricular->JQGRIDRowsPlancurricular($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ccurric'],"cell"=>array(								
								$data[$i]['nombre'],
								$data[$i]['estado']
								)
							)
						);
					}
					$response["rows"]=$dataRow;
					echo json_encode($response);
				break;
				case 'jqgrid_listar_plancurricular':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
                                        
                    $cingalu= $_GET["cingalu"];

					$where2=" i.cingalu='".$cingalu."'";
				                
					$param=array();
		
					if( isset($_GET['dcurso']) ) {
						if( trim($_GET['dcurso'])!='' ) {
							$where.=" AND c.dcurso LIKE '%".trim($_GET['dcurso'])."%' ";
						}
					}

					if( isset($_GET['dmodulo']) ) {
						if( trim($_GET['dmodulo'])!='' ) {
							$where.=" AND m.dmodulo LIKE '%".trim($_GET['dmodulo'])."%' ";
						}
					}

					if( isset($_GET['ncredit']) ) {
						if( trim($_GET['ncredit'])!='' ) {
							$where.=" AND p.ncredit='".trim($_GET['ncredit'])."' ";
						}
					}


					
                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND estado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)
                    $sidx=1 ; 
		
					$row=$daoPlancurricular->JQGridCountListarPlancurricular( $where, $where2 );
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
					$data=$daoPlancurricular->JQGRIDRowsListarPlancurricular($sidx, $sord, $start, $limit, $where, $where2);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['id'],"cell"=>array(								
								$data[$i]['dmodulo'],
								$data[$i]['dcurso'],
								$data[$i]['ncredit'],
								$data[$i]['requisito'],
								$data[$i]['estado']
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
