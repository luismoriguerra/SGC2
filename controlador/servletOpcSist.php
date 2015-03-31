<?php
class servletOpcSist extends controladorComandos{
        public function doPost(){
            $daoOpcSist=creadorDAO::getOpcSistDAO();
            switch ($_POST['action']):
                case 'cargarOpcSist':
                    echo json_encode($daoOpcSist->cargarOpcSist());
                    break;
                case 'editOpcSist':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dopcion"] =(trim($_POST['dopcion']));
                   $post["durlopc"] =(trim($_POST['durlopc']));
                   $post["dcoment"] =(trim($_POST['dcoment']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_modificacion"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoOpcSist->actualizarOpcSist($post));
                    break;
                case 'addOpcSist':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dopcion"] =(trim($_POST['dopcion']));
                   $post["durlopc"] =(trim($_POST['durlopc']));
                   $post["dcoment"] =(trim($_POST['dcoment']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_creacion"] =(trim($_POST['cusuari']));
				   
                    echo json_encode($daoOpcSist->insertarOpcSist($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado1'));
            endswitch;
        }
        public function doGet(){
			$daoOpcSist=creadorDAO::getOpcSistDAO();
			switch($_GET['action']):
				case 'jqgrid_opcsist':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['copcion']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND copcion LIKE '%".trim($_GET['copcion'])."%' ";
						}
					}
					
					if( isset($_GET['dopcion']) ) {
						if( trim($_GET['dopcion'])!='' ) {
							$where.=" AND dopcion LIKE '%".trim($_GET['dopcion'])."%' ";
						}
					}
					
					if( isset($_GET['durlopc']) ) {
						if( trim($_GET['durlopc'])!='' ) {
							$where.=" AND durlopc LIKE '%".trim($_GET['durlopc'])."%' ";
						}
					}
					
					if( isset($_GET['dcoment']) ) {
						if( trim($_GET['dcoment'])!='' ) {
							$where.=" AND dcoment LIKE '%".trim($_GET['dcoment'])."%' ";
						}
					}
					
                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoOpcSist->JQGridCountOpcSist( $where );
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
					$data=$daoOpcSist->JQGRIDRowsOpcSist($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['copcion'],"cell"=>array(								
								$data[$i]['dopcion'],								
								$data[$i]['durlopc'],								
								$data[$i]['dcoment'],
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
