<?php
class servletBoltole extends controladorComandos{
        public function doPost(){
            $daoBoltole=creadorDAO::getBoltoleDAO();
            switch ($_POST['action']):
                case 'cargarBoltole':
                    echo json_encode($daoBoltole->cargarBoltole());
                    break;
                case 'actualizarBoltole':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dboltole"] =(trim($_POST['dboltole']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["desbolt"] =(trim($_POST['desbolt']));
				   $post["ntiempo"] =(trim($_POST['ntiempo']));
				   $post["cusuari"] =(trim($_POST['usuario_modificacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
                    
                    echo json_encode($daoBoltole->actualizarBoltole($post));
                    break;
                case 'insertarBoltole':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dboltole"] =(trim($_POST['dboltole']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["desbolt"] =(trim($_POST['desbolt']));
				   $post["ntiempo"] =(trim($_POST['ntiempo']));
				   $post["cusuari"] =(trim($_POST['usuario_creacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   
                    echo json_encode($daoBoltole->insertarBoltole($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoBoltole=creadorDAO::getBoltoleDAO();
			switch($_GET['action']):
				case 'jqgrid_boltole':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
					
					if( isset($_GET['dolbtole']) ) {
						if( trim($_GET['dolbtole'])!='' ) {
							$where.=" AND dolbtole LIKE '%".trim($_GET['dolbtole'])."%' ";
						}
					}
					
					if( isset($_GET['desbolt']) ) {
						if( trim($_GET['desbolt'])!='' ) {
							$where.=" AND desbolt LIKE '%".trim($_GET['desbolt'])."%' ";
						}
					}
					
					if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['cestado'])."' ";
						}
					}

					if( isset($_GET['ntiempo']) ) {
						if( trim($_GET['ntiempo'])!='' ) {
							$where.=" AND ntiempo =  '".trim($_GET['ntiempo'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoBoltole->JQGridCountBoltole( $where );
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
					$data=$daoBoltole->JQGRIDRowsBoltole($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cboltole'],"cell"=>array(								
								$data[$i]['dboltole'],
								$data[$i]['desbolt'],
								$data[$i]['ntiempo'],
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
