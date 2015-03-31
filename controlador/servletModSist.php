<?php
class servletModSist extends controladorComandos{
        public function doPost(){
            $daoModSist=creadorDAO::getModSistDAO();
            switch ($_POST['action']):
                case 'cargarModSist':
                    echo json_encode($daoModSist->cargarModSist());
                    break;
                case 'actualizarModSist':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dcagrop"] =(trim($_POST['dcagrop']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_modificacion"] =(trim($_POST['usuario_modificacion']));
                    
                    echo json_encode($daoModSist->actualizarModSist($post));
                    break;
                case 'insertarModSist':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dcagrop"] =(trim($_POST['dcagrop']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_creacion"] =(trim($_POST['usuario_creacion']));
				   
                    echo json_encode($daoModSist->insertarModSist($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado1'));
            endswitch;
        }
        public function doGet(){
			$daoModSist=creadorDAO::getModSistDAO();
			switch($_GET['action']):
				case 'jqgrid_modsist':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['ccagrop']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND ccagrop LIKE '%".trim($_GET['ccagrop'])."%' ";
						}
					}
					
					if( isset($_GET['dcagrop']) ) {
						if( trim($_GET['dcagrop'])!='' ) {
							$where.=" AND dcagrop LIKE '%".trim($_GET['dcagrop'])."%' ";
						}
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoModSist->JQGridCountModSist( $where );
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
					$data=$daoModSist->JQGRIDRowsModSist($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ccagrop'],"cell"=>array(								
								$data[$i]['dcagrop'],
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
