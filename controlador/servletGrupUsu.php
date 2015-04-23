<?php
class servletGrupUsu extends controladorComandos{
        public function doPost(){
            $daoGrupUsu=creadorDAO::getGrupUsuDAO();
            switch ($_POST['action']):
                case 'addGrupUsu':
                    $data=array();
                    $data['dgrupo'] =trim($_POST['dgrupo']);
                    $data['cestado']=trim($_POST['cestado']);
					$data['cinstit']=trim($_POST['cinstit']);
                    $data['cusuari']=trim($_POST['cusuari']);
                    $data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoGrupUsu->addGrupUsu($data));
                    break;
                case 'editGrupUsu':
                $data=array();
                    $data['cgrupo'] =trim($_POST['cgrupo']);
                    $data['dgrupo'] =trim($_POST['dgrupo']);
                    $data['cestado']=trim($_POST['cestado']);
					$data['cinstit']=trim($_POST['cinstit']);
                    $data['cusuari']=trim($_POST['cusuari']);
                    $data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoGrupUsu->editGrupUsu($data));
                    break; 
                case 'modificarPass':
                $data=array();
                    $data['pass'] =trim($_POST['pass']);
                    $data['cusuari']=trim($_POST['cusuari']);
                    $data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoGrupUsu->modificarPass($data));
                    break; 
                case 'cargar_grupos':
                $data=array();
                    echo json_encode($daoGrupUsu->cargarGrupos());
                    break;    		
                case 'cargar_modulos':
                $data=array();
                    echo json_encode($daoGrupUsu->cargarModulos());
                    break;    		
                case 'cargar_opciones':
                $data=array();
                    echo json_encode($daoGrupUsu->cargarOpciones());
                    break;    
                case 'addGrUsuOp':
                    $data=array();
                    $data['cgrupo'] =trim($_POST['cgrupo']);
                    $data['ccagrop']=trim($_POST['ccagrop']);
                    $data['copcion']=trim($_POST['copcion']);
                    $data['cestado']=trim($_POST['cestado']);
                    $data['cusuari']=trim($_POST['cusuari']);
                    $data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoGrupUsu->addGrUsuOp($data));
                    break;				
                case 'editGrUsuOp':
                $data=array();
                    $data['cgrupo'] =trim($_POST['cgrupo']);
                    $data['ccagrop']=trim($_POST['ccagrop']);
                    $data['copcion']=trim($_POST['copcion']);
                    $data['cestado']=trim($_POST['cestado']);
                    $data['cusuari']=trim($_POST['cusuari']);
                    $data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoGrupUsu->editGrUsuOp($data));
                    break;         			
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$daoGrupUsu=creadorDAO::getGrupUsuDAO();
			switch($_GET['action']):
				case 'jqgrid_grupusu':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
                                        
                    if( isset($_GET['cgrupo']) ) {
						if( trim($_GET['cgrupo'])!='' ) {
							$where.=" AND c.cgrupo like '%".trim($_GET['cgrupo'])."%' ";
						}
					}
                                        
					if( isset($_GET['dgrupo']) ) {
						if( trim($_GET['dgrupo'])!='' ) {
							$where.=" AND c.dgrupo like '%".trim($_GET['dgrupo'])."%' ";
						}
					}
					
                    if( isset($_GET['instit']) ) {
						if( trim($_GET['instit'])!='' ) {
							$where.=" AND (SELECT f.dinstit FROM instita AS f WHERE f.cinstit = c.cinstit ) like '%".trim($_GET['instit'])."%' ";
						}
					}
                                        
                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoGrupUsu->JQGridCountGrupUsu( $where );
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
					$data=$daoGrupUsu->JQGRIDRowsGrupUsu($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cgrupo'],"cell"=>array( 
								$data[$i]['cgrupo'],
								$data[$i]['dgrupo'],
								$data[$i]['instit'],
								$data[$i]['cinstit'],
                                $data[$i]['estado'],
								$data[$i]['cestado']
								)
							)
						);
					}
					$response["rows"]=$dataRow;
					echo json_encode($response);
				break;
				case 'jqgrid_grusuop':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
                                        
                    if( isset($_GET['cgrupo']) ) {
						if( trim($_GET['cgrupo'])!='' ) {
							$where.=" AND c.cgrupo like '%".trim($_GET['cgrupo'])."%' ";
						}
					}
                                        
					if( isset($_GET['dgrupo']) ) {
						if( trim($_GET['dgrupo'])!='' ) {
							$where.="  AND (SELECT g.dgrupo FROM grupom AS g WHERE g.cgrupo = c.cgrupo ) like '%".trim($_GET['dgrupo'])."%' ";
						}
					}
                                        
					if( isset($_GET['dopcion']) ) {
						if( trim($_GET['dopcion'])!='' ) {
							$where.="  AND (SELECT o.dopcion FROM opcionm AS o WHERE o.copcion = c.copcion ) like '%".trim($_GET['dopcion'])."%' ";
						}
					}
                                        
					if( isset($_GET['dcagrop']) ) {
						if( trim($_GET['dcagrop'])!='' ) {
							$where.="  AND (SELECT m.dcagrop FROM cagropp AS m WHERE m.ccagrop = c.ccagrop ) like '%".trim($_GET['dcagrop'])."%' ";
						}
					}
                                        
                    if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoGrupUsu->JQGridCountGrUsuOp( $where );
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
					$data=$daoGrupUsu->JQGRIDRowsGrUsuOp($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['cgrupo']."-".$data[$i]['ccagrop']."-".$data[$i]['copcion'],"cell"=>array(								
								$data[$i]['cgrupo'],
								$data[$i]['dgrupo'],						
								$data[$i]['dcagrop'],
								$data[$i]['ccagrop'],						
								$data[$i]['dopcion'],
								$data[$i]['copcion'],
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
