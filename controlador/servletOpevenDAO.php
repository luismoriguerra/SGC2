<?php
class servletOpeven extends controladorComandos{
        public function doPost(){
            $daoCencap=creadorDAO::getOpevenDAO();
            switch ($_POST['action']):
                case 'cargarFiliales':
					$data=array();				
                    echo json_encode($daoCencap->cargarFiliales($data));
                    break;
				case 'cargarInstitutos':
					$data=array();				
                    echo json_encode($daoCencap->cargarInstitutos());
                    break;
                case 'cargarOpevenbyTipcap':
					$data=array();		
                    $didetip=trim($_POST['didetip']);
                    echo json_encode($daoCencap->cargarOpevenbyTipcap($didetip));
                    break;
                case 'addOpeven':
                    $data=array();
                    $data['descrip']=trim($_POST['descrip']);
                    $data['depa']=trim($_POST['depa']);
                    $data['prov']=trim($_POST['prov']);
                    $data['dist']=trim($_POST['dist']);
                    $data['tipo']=trim($_POST['tipo']);
                    $data['direc']=trim($_POST['direc']);
                    $data['cestado']=trim($_POST['cestado']);
					$data['cusuari']=trim($_POST['cusuari']);
					$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCencap->addCencap($data));
                    break;				
                case 'editOpeven':
                $data=array();
                     $data['id']=trim($_POST['id']);
                   $data['descrip']=trim($_POST['descrip']);
                    $data['depa']=trim($_POST['depa']);
                    $data['prov']=trim($_POST['prov']);
                    $data['dist']=trim($_POST['dist']);
                    $data['tipo']=trim($_POST['tipo']);
                    $data['direc']=trim($_POST['direc']);
                    $data['cestado']=trim($_POST['cestado']);
                                                                      $data['cusuari']=trim($_POST['cusuari']);
					$data['cfilialx']=trim($_POST['cfilialx']);
                    echo json_encode($daoCencap->editCencap($data));
                    break;
				case 'ListCencap':
                $data=array();                    
                    $data['cfilial']=trim($_POST['cfilial']);
                    echo json_encode($daoCencap->ListCencap($data));
                    break;                			
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$daoCencap=creadorDAO::getOpevenDAO();
			switch($_GET['action']):
				case 'jqgrid_opeven':
					$page=$_GET["page"];
					$limit=$_GET["rows"];
					$sidx=$_GET["sidx"];
					$sord=$_GET["sord"];
		
					$where="";
					$param=array();
                                        
                                        if( isset($_GET['dopeven']) ) {
						if( trim($_GET['dopeven'])!='' ) {
							$where.=" AND o.dopeven like '%".trim($_GET['dopeven'])."%' ";
						}
					}
                                        
					if( isset($_GET['depa']) ) {
						if( trim($_GET['depa'])!='' ) {
							$where.=" AND ( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov = 0 and u.coddist = 0)  like '%".trim($_GET['depa'])."%' ";
						}
					}
			if( isset($_GET['tipo']) ) {
						if( trim($_GET['tipo'])!='' ) {
							$where.=" AND  t.dtipcap like '%".trim($_GET['tipo'])."%'  ";
						}
					}
                                        
                                        if( isset($_GET['prov']) ) {
						if( trim($_GET['prov'])!='' ) {
							$where.=" AND ( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov = o.codprov and u.coddist = 0)   like '%".trim($_GET['prov'])."%' ";
						}
					}
                                        if( isset($_GET['dist']) ) {
						if( trim($_GET['dist'])!='' ) {
							$where.=" AND ( select nombre from ubigeo u where u.coddpto= o.coddpto and u.codprov =o.codprov  and u.coddist = o.coddistr)   like '%".trim($_GET['dist'])."%' ";
						}
					}
                                        
                                        if( isset($_GET['estado']) ) {
						if( trim($_GET['estado'])!='' ) {
							$where.=" AND o.cestado =  '".trim($_GET['estado'])."' ";
						}
					}
                                        
                                        if( isset($_GET['ddiopve']) ) {
						if( trim($_GET['ddiopve'])!='' ) {
							$where.=" AND o.ddiopve like '%".trim($_GET['ddiopve'])."%' ";
						}
					}
					
					if(!$sidx)$sidx=1 ; 
		
					$row=$daoCencap->JQGridCountCencap( $where );
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
					$data=$daoCencap->JQGRIDRowsCencap($sidx, $sord, $start, $limit, $where);
					$dataRow=array();
					for($i=0;$i<count($data);$i++){
						array_push($dataRow, array(
                                                                                                                        "id"=>$data[$i]['copeven'],
                                                                                                                        "cell"=>array(								
                                                                                                                                        $data[$i]['copeven'],
                                                                                                                                        $data[$i]['dopeven'],
                                                                                                                                        $data[$i]['coddpto'],								
                                                                                                                                        $data[$i]['depa'],
                                                                                                                                        $data[$i]['codprov'],								
                                                                                                                                        $data[$i]['prov'],
                                                                                                                                        $data[$i]['coddistr'],	
                                                                                                                                        $data[$i]['dist'],
                                                                                                                                        $data[$i]['ddiopve'],	
                                                                                                                                        $data[$i]['ctipcap'],
                                                                                                                                        $data[$i]['tipo'],
                                                                                                                                        (($data[$i]['cestado'])? "Activo" : "Inactivo"),
                                                                                                                                        $data[$i]['cestado']
								) ) ); }
                                                                
					$response["rows"]=$dataRow;
					echo json_encode($response);
				break;
				default:
				echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
}
?>
