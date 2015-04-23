<?php
class servletAmbiente extends controladorComandos{
        public function doPost(){
            $daoAmbiente=creadorDAO::getAmbienteDAO();
            switch ($_POST['action']):
                case 'cargarAmbiente':
                    echo json_encode($daoAmbiente->cargarAmbiente());
                    break;
                case 'cargarTipoAmbiente':
                	echo json_encode($daoAmbiente->cargarTipoAmbiente());
                	break;
                case 'editAmbiente':
                   $post = array();
				   
                   $post["id"] = (trim($_POST['id']));
                   $post["cfilial"]=(trim($_POST['cfilial']));
				   $post["ctipamb"] =(trim($_POST['ctipamb']));
				   $post["numamb"] =(trim($_POST['numamb']));
				   $post["ncapaci"]   =(trim($_POST['ncapaci']));
				   $post["nmetcua"]=(trim($_POST['nmetcua']));
				   $post["ntotmaq"]  =(trim($_POST['ntotmaq']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoAmbiente->actualizarAmbiente($post));
                    break;
                case 'addAmbiente':
                   $post = array();
                   $post["cfilial"]=(trim($_POST['cfilial']));
				   $post["ctipamb"] =(trim($_POST['ctipamb']));
				   $post["numamb"] =(trim($_POST['numamb']));
				   $post["ncapaci"]   =(trim($_POST['ncapaci']));
				   $post["nmetcua"]=(trim($_POST['nmetcua']));
				   $post["ntotmaq"]  =(trim($_POST['ntotmaq']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['cusuari']));
				   
                    echo json_encode($daoAmbiente->insertarAmbiente($post));
                    break;	
                case 'actualizarTipoAmbiente':
                   $post = array();				   
                   $post["id"] = (trim($_POST['id']));
                   $post["dtipamb"]=(trim($_POST['dtipamb']));
				   $post["dnetiam"] =(trim($_POST['dnetiam']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoAmbiente->actualizarTipoAmbiente($post));
                    break;
                case 'insertarTipoAmbiente':
                   $post = array();
                   $post["dtipamb"]=(trim($_POST['dtipamb']));
				   $post["dnetiam"] =(trim($_POST['dnetiam']));
				   $post["cestado"]=(trim($_POST['cestado']));
				   $post["cfilialx"] =(trim($_POST['cfilialx']));
				   $post["cusuari"] =(trim($_POST['cusuari']));
                    
                    echo json_encode($daoAmbiente->insertarTipoAmbiente($post));
                    break;			
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
        public function doGet(){
			$daoAmbiente=creadorDAO::getAmbienteDAO();
			switch($_GET['action']):
				case 'jqgrid_ambiente':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();

					
					if($_GET['cfilial']!='' and substr($_GET['cfilial'],0,3)!='000'){
						$where.=" AND a.cfilial in ('".str_replace(",","','",$_GET['cfilial'])."')";
					}
		
					if( isset($_GET['dfilial']) ) {
						if( trim($_GET['dfilial'])!='' ) {
							$where.=" AND f.dfilial like '%".trim($_GET['dfilial'])."%' ";
						}
					}
					
					if( isset($_GET['dtipamb']) ) {
						if( trim($_GET['dtipamb'])!='' ) {
							$where.=" AND t.dtipamb like '%".trim($_GET['dtipamb'])."%' ";
						}
					}
		
					if( isset($_GET['numamb']) ) {
						if( trim($_GET['numamb'])!='' ) {
							$where.=" AND a.numamb LIKE '%".trim($_GET['numamb'])."%' ";
						}
					}
		
					if( isset($_GET['ncapaci']) ) {
						if( trim($_GET['ncapaci'])!='' ) {
							$where.=" AND a.ncapaci =  '".trim($_GET['ncapaci'])."' ";
						}
					}
					
                    if( isset($_GET['nmetcua']) ) {
						if( trim($_GET['nmetcua'])!='' ) {
							$where.=" AND a.nmetcua =  '".trim($_GET['nmetcua'])."' ";
						}
					}
					
					if( isset($_GET['ntotmaq']) ) {
						if( trim($_GET['ntotmaq'])!='' ) {
							$where.=" AND a.ntotmaq =  '".trim($_GET['ntotmaq'])."' ";
						}
					}

                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoAmbiente->JQGridCountAmbiente( $where );
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
					$data=$daoAmbiente->JQGRIDRowsAmbiente($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cambien'],"cell"=>array(								
								$data[$i]['cfilial'],
								$data[$i]['dfilial'],
								$data[$i]['ctipamb'],
								$data[$i]['dtipamb'],
								$data[$i]['numamb'],
								$data[$i]['ncapaci'],
								$data[$i]['nmetcua'],
								$data[$i]['ntotmaq'],
								$data[$i]['estado'],
								$data[$i]['cestado']								
								)
							)
						);
					}
					$response["rows"]=$dataRow;
					echo json_encode($response);
				break;
				case 'jqgrid_tipo_ambiente':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['dtipamb']) ) {
						if( trim($_GET['dtipamb'])!='' ) {
							$where.=" AND dtipamb LIKE '%".trim($_GET['dtipamb'])."%' ";
						}
					}
					
					if( isset($_GET['dnetiam']) ) {
						if( trim($_GET['cmodali'])!='' ) {
							$where.=" AND dnetiam LIKE '%".trim($_GET['dnetiam'])."%' ";
						}
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoAmbiente->JQGridCountTipoAmbiente( $where );
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
					$data=$daoAmbiente->JQGRIDRowsTipoAmbiente($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ctipamb'],"cell"=>array(								
								$data[$i]['dtipamb'],
								$data[$i]['dnetiam'],
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
