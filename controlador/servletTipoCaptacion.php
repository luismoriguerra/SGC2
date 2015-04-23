<?php
class servletTipoCaptacion extends controladorComandos{
        public function doPost(){
            $daoTipoCaptacion=creadorDAO::getTipoCaptacionDAO();
            switch ($_POST['action']):
                case 'actualizarTipoCaptacion':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
				   $post["dtipcap"] =(trim($_POST['dtipcap']));
				   $post["dclacap"] =(trim($_POST['dclacap']));
				   $post["didetip"] =(trim($_POST['didetip']));
				   $post["cestado"] =(trim($_POST['cestado']));
                   $post["cusuari"] =(trim($_POST['usuario_modificacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
                    
                    echo json_encode($daoTipoCaptacion->actualizarTipoCaptacion($post));
                    break;
                case 'insertarTipoCaptacion':
                   $post = array();
                   $post["id"] = (trim($_POST['id']));
                   $post["dtipcap"] =(trim($_POST['dtipcap']));
				   $post["dclacap"] =(trim($_POST['dclacap']));
				   $post["didetip"] =(trim($_POST['didetip']));
				   $post["cestado"] =(trim($_POST['cestado']));
				   $post["cusuari"] =(trim($_POST['usuario_creacion']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   
                    echo json_encode($daoTipoCaptacion->insertarTipoCaptacion($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoTipoCaptacion=creadorDAO::getTipoCaptacionDAO();
			switch($_GET['action']):
				case 'jqgrid_tipo_captacion':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();		
					
					if( isset($_GET['dtipcap']) ) {
						if( trim($_GET['dtipcap'])!='' ) {
							$where.=" AND dtipcap LIKE '%".trim($_GET['dtipcap'])."%' ";
						}
					}
					
					if( isset($_GET['dclacap']) ) {
						if( trim($_GET['dclacap'])!='' ) {
							$where.=" AND dclacap LIKE '%".trim($_GET['dclacap'])."%' ";
						}
					}
					
					if( isset($_GET['didetip']) ) {
						if( trim($_GET['didetip'])!='' ) {
							$where.=" AND didetip LIKE '%".trim($_GET['didetip'])."%' ";
						}
					}
					
					if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado LIKE '%".trim($_GET['cestado'])."%' ";
						}
					}					
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoTipoCaptacion->JQGridCountTipoCaptacion( $where );
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
					$data=$daoTipoCaptacion->JQGRIDRowsTipoCaptacion($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ctipcap'],"cell"=>array(								
								$data[$i]['dtipcap'],
								$data[$i]['didetip'],
								$data[$i]['dclacap'],
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
