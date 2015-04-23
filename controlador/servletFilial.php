<?php
class servletFilial extends controladorComandos{
        public function doPost(){
            $daoFilial=creadorDAO::getFilialDAO();
            switch ($_POST['action']):
                case 'cargarFilial':
                    echo json_encode($daoFilial->cargarFilial());
                    break;
                case 'actualizarFilial':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dfilial"] =(trim($_POST['dfilial']));
				   $post["cfilial"] =(trim($_POST['cfilial']));
				   $post["ddirfil"] =(trim($_POST['ddirfil']));
				   $post["ntelfil"] =(trim($_POST['ntelfil']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['usuario_modificacion']));
                    
                    echo json_encode($daoFilial->actualizarFilial($post));
                    break;
                case 'insertarFilial':
                   $post = array();
                   $post["dfilial"] =(trim($_POST['dfilial']));
				   $post["cfilial"] =(trim($_POST['cfilial']));
				   $post["ddirfil"] =(trim($_POST['ddirfil']));
				   $post["ntelfil"] =(trim($_POST['ntelfil']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['usuario_creacion']));
				   
                    echo json_encode($daoFilial->insertarFilial($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoFilial=creadorDAO::getFilialDAO();
			switch($_GET['action']):
				case 'jqgrid_filial':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['cfilial']) ) {
						if( trim($_GET['cfilial'])!='' ) {
							$where.=" AND cfilial LIKE '%".trim($_GET['cfilial'])."%' ";
						}
					}
					
					if( isset($_GET['dfilial']) ) {
						if( trim($_GET['dfilial'])!='' ) {
							$where.=" AND dfilial LIKE '%".trim($_GET['dfilial'])."%' ";
						}
					}
					
					if( isset($_GET['ddirfil']) ) {
						if( trim($_GET['ddirfil'])!='' ) {
							$where.=" AND ddirfil LIKE '%".trim($_GET['ddirfil'])."%' ";
						}
					}
					
					if( isset($_GET['ntelfil']) ) {
						if( trim($_GET['ntelfil'])!='' ) {
							$where.=" AND ntelfil LIKE '%".trim($_GET['ntelfil'])."%' ";
						}
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoFilial->JQGridCountFilial( $where );
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
					$data=$daoFilial->JQGRIDRowsFilial($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cfilial'],"cell"=>array(								
								$data[$i]['cfilial'],
								$data[$i]['dfilial'],
								$data[$i]['ddirfil'],
								$data[$i]['ntelfil'],
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
