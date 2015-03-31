<?php
class servletCurso extends controladorComandos{
        public function doPost(){
            $daoCurso=creadorDAO::getCursoDAO();
            switch ($_POST['action']):
                case 'cargarCurso':
				$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=2;
                    echo json_encode($daoCurso->cargarCurso($data));
                    break;				
                case 'actualizarCurso':
                $data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=2;
				$data['id']=trim($_POST['id']);
				$data['dcurso']=trim($_POST['dcurso']);
				$data['dnemoni']=trim($_POST['dnemoni']);
				$data['cusuari']=trim($_POST['usuario_modificacion']);
				$data['codicur']=trim($_POST['codicur']);
				$data['cestado']=trim($_POST['cestado']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                    
                    echo json_encode($daoCurso->actualizarCurso($data));
                    break;
                case 'insertarCurso':
                $data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=2;	
				$data['codicur']=trim($_POST['codicur']);
				$data['dcurso']=trim($_POST['dcurso']);
				$data['dnemoni']=trim($_POST['dnemoni']);
				$data['cestado']=trim($_POST['cestado']);
				$data['cusuari']=trim($_POST['usuario_creacion']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCurso->insertarCurso($data));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$daoCurso=creadorDAO::getCursoDAO();
			switch($_GET['action']):
				case 'jqgrid_curso':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
		
					if( isset($_GET['codicur']) ) {
						if( trim($_GET['codicur'])!='' ) {
							$where.=" AND c.codicur LIKE '%".trim($_GET['codicur'])."%' ";
						}
					}
					
					if( isset($_GET['dnemoni']) ) {
						if( trim($_GET['dnemoni'])!='' ) {
							$where.=" AND c.dnemoni LIKE '%".trim($_GET['dnemoni'])."%' ";
						}
					}
					
					if( isset($_GET['dcurso']) ) {
						if( trim($_GET['dcurso'])!='' ) {
							$where.=" AND c.dcurso LIKE '%".trim($_GET['dcurso'])."%' ";
						}
					}
					
					if( isset($_GET['cinstit']) or isset($_GET['cinstit2']) ) {
						if( trim($_GET['cinstit'])!='' ) {
							$where.=" AND c.cinstit='".trim($_GET['cinstit'])."' ";
						}
						elseif(trim($_GET['cinstit2'])!=''){
							$where.=" AND c.cinstit='".trim($_GET['cinstit2'])."' ";
						}
					}
					
                    if( isset($_GET['cestado']) ) {
						if( trim($_GET['cestado'])!='' ) {
							$where.=" AND c.cestado =  '".trim($_GET['cestado'])."' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoCurso->JQGridCountCurso( $where );
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
					$data=$daoCurso->JQGRIDRowsCurso($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array("id"=>$data[$i]['ccurso'],"cell"=>array(								
								$data[$i]['cinstit'],
								$data[$i]['codicur'],
								$data[$i]['dcurso'],								
								$data[$i]['dnemoni'],
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
