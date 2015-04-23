<?php
class servletInstituto extends controladorComandos{
        public function doPost(){
            $daoInstituto=creadorDAO::getInstitutoDAO();
            switch ($_POST['action']):
                case 'cargarInstituto':
                    echo json_encode($daoInstituto->cargarInstituto());
                    break;
                case 'actualizarInstituto':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dinstit"] =(trim($_POST['dinstit']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["dnmeins"] =(trim($_POST['dnmeins']));
				   $post["cmodali"] =(trim($_POST['cmodali']));
				   $post["cusuari"] =(trim($_POST['usuario_modificacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
                    
                    echo json_encode($daoInstituto->actualizarInstituto($post));
                    break;
                case 'insertarInstituto':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dinstit"] =(trim($_POST['dinstit']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["dnmeins"] =(trim($_POST['dnmeins']));
				   $post["cmodali"] =(trim($_POST['cmodali']));
				   $post["cusuari"] =(trim($_POST['usuario_creacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   
                    echo json_encode($daoInstituto->insertarInstituto($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoInstituto=creadorDAO::getInstitutoDAO();
			switch($_GET['action']):
				case 'jqgrid_instituto':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['cinstit']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND cinstit LIKE '%".trim($_GET['cinstit'])."%' ";
						}
					}
					
					if( isset($_GET['dinstit']) ) {
						if( trim($_GET['dinstit'])!='' ) {
							$where.=" AND dinstit LIKE '%".trim($_GET['dinstit'])."%' ";
						}
					}
					
					if( isset($_GET['cmodali']) ) {
						if( trim($_GET['cmodali'])!='' ) {
							$where.=" AND cmodali LIKE '%".trim($_GET['cmodali'])."%' ";
						}
					}
					
					if( isset($_GET['dnmeins']) ) {
						if( trim($_GET['dnmeins'])!='' ) {
							$where.=" AND dnmeins LIKE '%".trim($_GET['dnmeins'])."%' ";
						}
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoInstituto->JQGridCountInstituto( $where );
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
					$data=$daoInstituto->JQGRIDRowsInstituto($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cinstit'],"cell"=>array(								
								$data[$i]['dinstit'],
								$data[$i]['dnmeins'],
								$data[$i]['cmodali'],
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
