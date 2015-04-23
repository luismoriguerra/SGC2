<?php
class servletHora extends controladorComandos{
        public function doPost(){
            $daoHora=creadorDAO::getHoraDAO();
            switch ($_POST['action']):
                case 'cargarHora':
                    echo json_encode($daoHora->cargarHora());
                    break;
                case 'editHora':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["cinstit"]=(trim($_POST['cinstit']));
				   $post["cturno"] =(trim($_POST['cturno']));
				   $post["hinici"] =(trim($_POST['hinici']));
				   $post["hfin"]   =(trim($_POST['hfin']));
				   $post["thorari"]=(trim($_POST['thorari']));
				   $post["thora"]  =(trim($_POST['thora']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_modificacion"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoHora->actualizarHora($post));
                    break;
                case 'addHora':
                   $post = array();
                   $post["cinstit"]=(trim($_POST['cinstit']));
				   $post["cturno"] =(trim($_POST['cturno']));
				   $post["hinici"] =(trim($_POST['hinici']));
				   $post["hfin"]   =(trim($_POST['hfin']));
				   $post["thorari"]=(trim($_POST['thorari']));
				   $post["thora"]  =(trim($_POST['thora']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["usuario_creacion"] =(trim($_POST['cusuari']));
				   
                    echo json_encode($daoHora->insertarHora($post));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado1'));
            endswitch;
        }
        public function doGet(){
			$daoHora=creadorDAO::getHoraDAO();
			switch($_GET['action']):
				case 'jqgrid_hora':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['chora']) ) {
						if( trim($_GET['id'])!='' ) {
							$where.=" AND c.chora LIKE '%".trim($_GET['chora'])."%' ";
						}
					}
					
					if( isset($_GET['dinstit']) ) {
						if( trim($_GET['dinstit'])!='' ) {
							$where.=" AND c2.dinstit like '%".trim($_GET['dinstit'])."%' ";
						}
					}
					
					if( isset($_GET['dturno']) ) {
						if( trim($_GET['dturno'])!='' ) {
							$where.=" AND (SELECT t.dturno FROM turnoa AS t WHERE t.cturno= c.cturno ) like '%".trim($_GET['dturno'])."%' ";
						}
					}
		
					if( isset($_GET['hinici']) ) {
						if( trim($_GET['hinici'])!='' ) {
							$where.=" AND c.hinici LIKE '%".trim($_GET['hinici'])."%' ";
						}
					}
		
					if( isset($_GET['hfin']) ) {
						if( trim($_GET['hfin'])!='' ) {
							$where.=" AND c.hfin LIKE '%".trim($_GET['hfin'])."%' ";
						}
					}
					
                    if( isset($_GET['thorario']) ) {
						if( trim($_GET['thorario'])!='' ) {
							$where.=" AND c.thorari =  '".trim($_GET['thorario'])."' ";
						}
					}
					
                    if( isset($_GET['clahora']) ) {
						if( trim($_GET['clahora'])!='' ) {
							$where.=" AND c.thora =  '".trim($_GET['clahora'])."' ";
						}
					}
					
                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if( isset($_GET['cinstit']) ) {
						if( trim($_GET['cinstit'])!='' ) {
							$where.=" AND c.cinstit =  '".trim($_GET['cinstit'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoHora->JQGridCountHora( $where );
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
					$data=$daoHora->JQGRIDRowsHora($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['chora'],"cell"=>array(								
								$data[$i]['dturno'],								
								$data[$i]['cturno'],								
								$data[$i]['dinstit'],								
								$data[$i]['cinstit'],							
								$data[$i]['hinici'],							
								$data[$i]['hfin'],						
								$data[$i]['thorari'],					
								$data[$i]['cod_thorari'],				
								$data[$i]['thora'],			
								$data[$i]['cod_thora'],
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
