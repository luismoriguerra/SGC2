<?
class servletPersona extends controladorComandos{
	public function doPost(){
		$daoPersona=creadorDAO::getPersonaDAO();
		switch ($_POST['accion']){
			case 'ListarFiltro':
				echo json_encode($daoPersona->ListarFiltro());
			break;
			case 'ListarCiclos':
				echo json_encode($daoPersona->ListarCiclos());
			break;
			case 'ListarProc':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				echo json_encode($daoPersona->ListarProc($array));
			break;
			case 'ListarResolucion':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				echo json_encode($daoPersona->ListarResolucion($array));
			break;
			case 'ListarCursoDestino':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				echo json_encode($daoPersona->ListarCursoDestino($array));
			break;			
			case 'listarCursoProcedencia':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				$array['crescon']=trim($_POST['crescon']);
				echo json_encode($daoPersona->listarCursoProcedencia($array));
			break;			
			case 'ActProc':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				$array['dinstpro']=trim($_POST['dinstpro']);
				$array['dcarpro']=trim($_POST['dcarpro']);
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->ActProc($array));
			break;
			case 'RegistrarAsiCon':
				$array=array();
				$array['datos']=trim($_POST['datos']);
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->RegistrarAsiCon($array));
			break;			
			case 'guardarResolucion':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);				
				$array['nrescon']=trim($_POST['nrescon']);
				$array['dautres']=trim($_POST['dautres']);
				$array['frescon']=trim($_POST['frescon']);				
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->guardarResolucion($array));
			break;
			case 'editarResolucion':
				$array=array();
				$array['cingalu']=trim($_POST['cingalu']);
				$array['crescon']=trim($_POST['crescon']);
				$array['nrescon']=trim($_POST['nrescon']);
				$array['dautres']=trim($_POST['dautres']);
				$array['frescon']=trim($_POST['frescon']);				
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->editarResolucion($array));
			break;
			case 'editProcedencia':
				$array=array();
				$array['caspral']=trim($_POST['caspral']);
				$array['cingalu']=trim($_POST['cingalu']);
				$array['daspral']=trim($_POST['daspral']);
				$array['cciclo']=trim($_POST['cciclo']);
				$array['ncredit']=trim($_POST['ncredit']);
				$array['nhorteo']=trim($_POST['nhorteo']);
				$array['nhorpra']=trim($_POST['nhorpra']);
				$array['cestado']=trim($_POST['cestado']);
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->editProcedencia($array));
			break;
			case 'addProcedencia':
				$array=array();				
				$array['cingalu']=trim($_POST['cingalu']);
				$array['daspral']=trim($_POST['daspral']);
				$array['dcarpro']=trim($_POST['dcarpro']);
				$array['dinstpro']=trim($_POST['dinstpro']);
				$array['cciclo']=trim($_POST['cciclo']);
				$array['ncredit']=trim($_POST['ncredit']);
				$array['nhorteo']=trim($_POST['nhorteo']);
				$array['nhorpra']=trim($_POST['nhorpra']);
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoPersona->addProcedencia($array));
			break;
            case 'ListarFiltrobyID':
				echo json_encode($daoPersona->ListarFiltrobyID());
			break;
			case 'ActualizarDocumentos':
				$data=array();
				/*/////////////DATOS PARA EL PROCESO DE CONVALIDACIÓN ////////////*/
				$data['cpais']='';
				$data['tinstip']='';
				$data['dinstip']='';
				$data['dcarrep']='';
				$data['ultanop']='';
				$data['dciclop']='';
				$data['ddocval']='';
					if($_POST['valconv']=="ok"){
					$data['cpais']=trim($_POST['cpais']);
					$data['tinstip']=trim($_POST['tinstip']);
					$data['dinstip']=trim($_POST['dinstip']);
					$data['dcarrep']=trim($_POST['dcarrep']);
					$data['ultanop']=trim($_POST['ultanop']);
					$data['dciclop']=trim($_POST['dciclop']);
					$data['ddocval']=trim($_POST['ddocval']);
					}
				/*////////////////////////////////////////////////////////////////*/
				/*//////////DOCUMENTOS ACADÉMICOS OBLIGATORIOS PARA EL PROCESO DE ADMISIÓN//////////*/
				$data['certest']=trim($_POST['certest']);
				$data['partnac']=trim($_POST['partnac']);
				$data['fotodni']=trim($_POST['fotodni']);
				$data['otrodni']=trim($_POST['otrodni']);
				$data['nfotos']=trim($_POST['nfotos']);
				$data['cdevolu']=trim($_POST['cdevolu']);
				$data['cingalu']=trim($_POST['cingalu']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['dcompro']=trim($_POST['dcompro']);
				/*//////////////////////*/
				echo json_encode($daoPersona->ActualizarDocumentos($data));
			break;			
			case 'ListarVendedor':
				$data=array();
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['dnombre']=trim($_POST['dnombre']);
				$data['tvended']=trim($_POST['tvended']);
				echo json_encode($daoPersona->ListarVendedor($data));
			break;
			case 'cargarModalidadIngresoDocumento':
				$data=array();
				$data['cmoding']=trim($_POST['cmoding']);
				echo json_encode($daoPersona->cargarModalidadIngresoDocumento($data));
			break;
			case 'InsertarPersona':				
				$data=array();
				$data['dnomper']=trim($_POST['dnomper']);
				$data['dappape']=trim($_POST['dappape']);
				$data['dapmape']=trim($_POST['dapmape']);
				$data['ndniper']=trim($_POST['ndniper']);
				$data['email1']=trim($_POST['email1']);
				$data['ntelpe2']=trim($_POST['ntelpe2']);
				$data['ntelper']=trim($_POST['ntelper']);
				$data['ntellab']=trim($_POST['ntellab']);
				$data['cestciv']=trim($_POST['cestciv']);
				$data['tipdocper']='DNI';
				$data['fnacper']=trim($_POST['fnacper']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirper']=trim($_POST['ddirper']);
				$data['ddirref']=trim($_POST['ddirref']);
				$data['cdptlab']=trim($_POST['cdptlab']);
				$data['cprvlab']=trim($_POST['cprvlab']);
				$data['cdislab']=trim($_POST['cdislab']);
				$data['cdptcol']=trim($_POST['cdptcol']);
				$data['cprvcol']=trim($_POST['cprvcol']);
				$data['cdiscol']=trim($_POST['cdiscol']);
				$data['ddirlab']=trim($_POST['ddirlab']);
				$data['dnomlab']=trim($_POST['dnomlab']);
				$data['tcolegi']=trim($_POST['tcolegi']);
				$data['dcolpro']=trim($_POST['dcolpro']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoPersona->InsertarPersona($data));
			break;
			case 'ActualizarPersona':				
				$data=array();
				$data['cperson']=trim($_POST['cperson']);
				$data['dnomper']=trim($_POST['dnomper']);
				$data['dappape']=trim($_POST['dappape']);
				$data['dapmape']=trim($_POST['dapmape']);
				$data['ndniper']=trim($_POST['ndniper']);
				$data['email1']=trim($_POST['email1']);
				$data['ntelpe2']=trim($_POST['ntelpe2']);
				$data['ntelper']=trim($_POST['ntelper']);
				$data['ntellab']=trim($_POST['ntellab']);
				$data['cestciv']=trim($_POST['cestciv']);
				$data['tipdocper']='DNI';
				$data['fnacper']=trim($_POST['fnacper']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirper']=trim($_POST['ddirper']);
				$data['ddirref']=trim($_POST['ddirref']);
				$data['cdptlab']=trim($_POST['cdptlab']);
				$data['cprvlab']=trim($_POST['cprvlab']);
				$data['cdislab']=trim($_POST['cdislab']);
				$data['cdptcol']=trim($_POST['cdptcol']);
				$data['cprvcol']=trim($_POST['cprvcol']);
				$data['cdiscol']=trim($_POST['cdiscol']);
				$data['ddirlab']=trim($_POST['ddirlab']);
				$data['dnomlab']=trim($_POST['dnomlab']);
				$data['tcolegi']=trim($_POST['tcolegi']);
				$data['dcolpro']=trim($_POST['dcolpro']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoPersona->ActualizarPersona($data));
			break;
			case 'InsertarTrabajador':				
				$data=array();
				$data['dnombre']=trim($_POST['dnombre']);
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['ndocper']=trim($_POST['ndocper']);
				$data['demail']=trim($_POST['demail']);
				$data['tdocper']='DNI';
				$data['fingven']=trim($_POST['fingven']);
				$data['fretven']=trim($_POST['fretven']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirecc']=trim($_POST['ddirecc']);
				$data['tvended']=trim($_POST['tvended']);
				$data['codintv']=trim($_POST['codintv']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['dtelefo']=trim($_POST['dtelefo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cestado']=trim($_POST['cestado']);
                $data['copeven']=trim($_POST['copeven']);
				echo json_encode($daoPersona->InsertarTrabajador($data));
			break;
			case 'ActualizarTrabajador':				
				$data=array();
				$data['cvended']=trim($_POST['cvended']);
				$data['dnombre']=trim($_POST['dnombre']);
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['ndocper']=trim($_POST['ndocper']);
				$data['demail']=trim($_POST['demail']);
				$data['tdocper']='DNI';
				$data['fingven']=trim($_POST['fingven']);
				$data['fretven']=trim($_POST['fretven']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirecc']=trim($_POST['ddirecc']);
				$data['tvended']=trim($_POST['tvended']);
				$data['codintv']=trim($_POST['codintv']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['dtelefo']=trim($_POST['dtelefo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cestado']=trim($_POST['cestado']);
                $data['copeven']=trim($_POST['copeven']);
				echo json_encode($daoPersona->ActualizarTrabajador($data));
			break;
			case "guardarSueldosVendedores":
				$data = array();
				$data["data"]=trim($_POST['data']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);

				echo json_encode($daoPersona->guardarSueldosVendedores($data));
				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoPersona=creadorDAO::getPersonaDAO();
		switch ($_GET['accion']){
			case 'jqgrid_personaIngAlum':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND i.cestado='".trim($_GET['cestado'])."' ";
                }
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
				if(isset($_GET['cinicio']) && trim($_GET['cinicio'])!=''){
                    $where.=" AND upper(g.cinicio)='".strtoupper(trim($_GET['cinicio']))."'";
                }
				if(isset($_GET['finicio']) && trim($_GET['finicio'])!=''){
                    $where.=" AND date(g.finicio)='".strtoupper(trim($_GET['finicio']))."'";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }
                if(isset($_GET['sermatr']) && trim($_GET['sermatr'])!=''){
                    $where.=" AND upper(i.sermatr) LIKE '%".strtoupper(trim($_GET['sermatr']))."%' ";
                }
                if(isset($_GET['dcodlib']) && trim($_GET['dcodlib'])!=''){
                    $where.=" AND upper(i.dcodlib) LIKE '%".strtoupper(trim($_GET['dcodlib']))."%' ";
                }
                if(isset($_GET['dtipcap']) && trim($_GET['dtipcap'])!=''){
                    $where.=" AND upper(t.dtipcap) LIKE '%".strtoupper(trim($_GET['dtipcap']))."%' ";
                }
                if(isset($_GET['detalle_captacion']) && trim($_GET['detalle_captacion'])!=''){
                    $where.=" AND ( upper(CONCAT(v.dapepat,' ',v.dapemat,', ',v.dnombre)) LIKE '%".strtoupper(trim($_GET['detalle_captacion']))."%' 
                    				OR upper(m.dmedpre) LIKE '%".strtoupper(trim($_GET['detalle_captacion']))."%' 
                    				OR upper(i.destica) LIKE '%".strtoupper(trim($_GET['detalle_captacion']))."%') ";
                }
                if(isset($_GET['recepcionista']) && trim($_GET['recepcionista'])!=''){
                    $where.=" AND upper(CONCAT(ve.dapepat,' ',ve.dapemat,', ',ve.dnombre)) LIKE '%".strtoupper(trim($_GET['recepcionista']))."%' ";
                }

                if(isset($_GET['codintv']) && trim($_GET['codintv'])!=''){
                    $where.=" AND upper(v.codintv) LIKE '%".strtoupper(trim($_GET['codintv']))."%' ";
                }

                
                


                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaIngAlum($where);
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
				
				$data=$daoPersona->JQGRIDRowsPersonaIngAlum($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['cestado'],
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['cinicio'],
							$data[$i]['finicio'],
							$data[$i]['dhorari'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],  
                    		$data[$i]['sermatr'],                    		                    		                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
                            $data[$i]['cingalu'],
                            $data[$i]['dcodlib'],
                            $data[$i]['dtipcap'],
                            $data[$i]['detalle_captacion'],
                            $data[$i]['recepcionista'],
                            $data[$i]['codintv']														
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_personaIngAlum2':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND i.cestado='".trim($_GET['cestado'])."' ";
                }
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
				if(isset($_GET['cinicio']) && trim($_GET['cinicio'])!=''){
                    $where.=" AND upper(g.cinicio)='".strtoupper(trim($_GET['cinicio']))."'";
                }
				if(isset($_GET['finicio']) && trim($_GET['finicio'])!=''){
                    $where.=" AND date(g.finicio)='".strtoupper(trim($_GET['finicio']))."'";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaIngAlum($where);
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
				
				$data=$daoPersona->JQGRIDRowsPersonaIngAlum($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['cestado'],
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['cinicio'],
							$data[$i]['finicio'],
							$data[$i]['dhorari'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
                            $data[$i]['cingalu'],
                            $data[$i]['nfotos'],
                            $data[$i]['certest'],
                            $data[$i]['partnac'],
                            $data[$i]['fotodni'],
                            $data[$i]['otrodni'],
                            $data[$i]['cpais'],
                            $data[$i]['tinstip'],
                            $data[$i]['dinstip'],
                            $data[$i]['dcarrep'],
                            $data[$i]['ultanop'],
                            $data[$i]['dciclop'],
                            $data[$i]['ddocval'],
                            $data[$i]['cmoding'],
                            $data[$i]['cdevolu']                            														
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_personaIngAlum4':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where=" AND g.trgrupo='I' "; // para mostrar solo irregulares...
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND i.cestado='".trim($_GET['cestado'])."' ";
                }
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
                if(isset($_GET['dmoding']) && trim($_GET['dmoding'])!=''){
                    $where.=" AND upper(mo.dmoding) LIKE '%".strtoupper(trim($_GET['dmoding']))."%' ";
                }
				if(isset($_GET['cinicio']) && trim($_GET['cinicio'])!=''){
                    $where.=" AND upper(g.cinicio)='".strtoupper(trim($_GET['cinicio']))."'";
                }
				if(isset($_GET['finicio']) && trim($_GET['finicio'])!=''){
                    $where.=" AND date(g.finicio)='".strtoupper(trim($_GET['finicio']))."'";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }
                if(isset($_GET['sermatr']) && trim($_GET['sermatr'])!=''){
                    $where.=" AND upper(i.sermatr) LIKE '%".strtoupper(trim($_GET['sermatr']))."%' ";
                }
                if(isset($_GET['dcodlib']) && trim($_GET['dcodlib'])!=''){
                    $where.=" AND upper(i.dcodlib) LIKE '%".strtoupper(trim($_GET['dcodlib']))."%' ";
                }
                


                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaIngAlum($where);
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
				
				$data=$daoPersona->JQGRIDRowsPersonaIngAlum($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['cestado'],
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['dmoding'],
							$data[$i]['cinicio'],
							$data[$i]['finicio'],
							$data[$i]['dhorari'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],  
                    		$data[$i]['sermatr'],                    		                    		                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
                            $data[$i]['cingalu'],
                            $data[$i]['dcodlib'],
                            $data[$i]['dinstip'],
                            $data[$i]['dcarrep']									
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_AlumProc':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];


                $where="";

                $where.=" AND a.cingalu='".trim($_GET['cingalu'])."'";

				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND a.cestado='".trim($_GET['cestado'])."' ";
                }
                if(isset($_GET['daspral']) && trim($_GET['daspral'])!=''){
                    $where.=" AND upper(a.daspral) LIKE '%".strtoupper(trim($_GET['daspral']))."%' ";
                }
                
				if(isset($_GET['dciclo']) && trim($_GET['dciclo'])!=''){
                    $where.=" AND upper(c.dciclo) like '%".strtoupper(trim($_GET['dciclo']))."%'";
                }

                if(isset($_GET['ncredit']) && trim($_GET['ncredit'])!=''){
                    $where.=" AND a.ncredit='".trim($_GET['ncredit'])."'";
                }

                if(isset($_GET['nhorteo']) && trim($_GET['nhorteo'])!=''){
                    $where.=" AND a.nhorteo='".trim($_GET['nhorteo'])."'";
                }

                if(isset($_GET['nhorpra']) && trim($_GET['nhorpra'])!=''){
                    $where.=" AND a.nhorpra='".trim($_GET['nhorpra'])."'";
                }
				

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountAlumProc($where);
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
				
				$data=$daoPersona->JQGRIDRowsAlumProc($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['caspral'],"cell"=>array(
							$data[$i]['daspral'],
							$data[$i]['cciclo'],
							$data[$i]['dciclo'],
							$data[$i]['ncredit'],
							$data[$i]['nhorteo'],
							$data[$i]['nhorpra'],
							$data[$i]['csilabo'],
							$data[$i]['cestado'],
							$data[$i]['estado']                    		                          														
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_personaConcepto':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND b.cestado='".trim($_GET['cestado'])."' ";
                }
				if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }
				if(isset($_GET['nmonrec']) && trim($_GET['nmonrec'])!=''){
                    $where.=" AND r.nmonrec='".strtoupper(trim($_GET['nmonrec']))."' ";
                }
				if(isset($_GET['dconcep']) && trim($_GET['dconcep'])!=''){
                    $where.=" AND upper(con.dconcep) LIKE '%".strtoupper(trim($_GET['dconcep']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaConcepto($where);
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
				
				$data=$daoPersona->JQGRIDRowsPersonaConcepto($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['cestado_b'],
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
							$data[$i]['cconcep'],
							$data[$i]['dconcep'],
							$data[$i]['nmonrec'],
                            $data[$i]['cingalu'],
							$data[$i]['crecaca'] 
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_persona':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersona($where);
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
				
				$data=$daoPersona->JQGRIDRowsPersona($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cperson'],"cell"=>array(
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
							$data[$i]['email1'],
							$data[$i]['ntelpe2'],
							$data[$i]['ntelper'],
							$data[$i]['ntellab'],
							$data[$i]['cestciv'],
							$data[$i]['tipdocper'],
							$data[$i]['fnacper'],
							$data[$i]['tsexo'],
							$data[$i]['coddpto'],
							$data[$i]['codprov'],
							$data[$i]['coddist'],
							$data[$i]['ddirper'],
							$data[$i]['ddirref'],
							$data[$i]['cdptlab'],
							$data[$i]['cprvlab'],
							$data[$i]['cdislab'],
							$data[$i]['cdptcol'],
							$data[$i]['cprvcol'],
							$data[$i]['cdiscol'],
							$data[$i]['ddirlab'],
							$data[$i]['dnomlab'],
							$data[$i]['tcolegi'],
							$data[$i]['dcolpro'],
							$data[$i]['ddepart'],
							$data[$i]['dprovin'],
							$data[$i]['ddistri'],
							$data[$i]['depalab'],
							$data[$i]['provlab'],
							$data[$i]['distlab']
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_trabajador':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dnombre']) && trim($_GET['dnombre'])!=''){
                    $where.=" AND upper(v.dnombre) LIKE '%".strtoupper(trim($_GET['dnombre']))."%' ";
                }
                if(isset($_GET['dapepat']) && trim($_GET['dapepat'])!=''){
                    $where.=" AND upper(v.dapepat) LIKE '%".strtoupper(trim($_GET['dapepat']))."%' ";
                }
                if(isset($_GET['dapemat']) && trim($_GET['dapemat'])!=''){
                    $where.=" AND upper(v.dapemat) LIKE '%".strtoupper(trim($_GET['dapemat']))."%' ";
                }
                if(isset($_GET['ndocper']) && trim($_GET['ndocper'])!=''){
                    $where.=" AND upper(v.ndocper) LIKE '%".strtoupper(trim($_GET['ndocper']))."%' ";
                }				
				if(isset($_GET['tvended']) && trim($_GET['tvended'])!=''){
                    $where.=" AND upper(v.tvended)='".strtoupper(trim($_GET['tvended']))."' ";
                }
				if(isset($_GET['codintv']) && trim($_GET['codintv'])!=''){
                    $where.=" AND upper(v.codintv)='".strtoupper(trim($_GET['codintv']))."' ";
                }
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND upper(v.cestado)='".strtoupper(trim($_GET['cestado']))."' ";
                }
				
				if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountTrabajador($where);
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
				
				$data=$daoPersona->JQGRIDRowsTrabajador($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cvended'],"cell"=>array(
							$data[$i]['codintv'],
							$data[$i]['dapepat'],
                            $data[$i]['dapemat'],
							$data[$i]['dnombre'],
                            $data[$i]['ndocper'],
							$data[$i]['demail'],
							$data[$i]['dtelefo'],							
							$data[$i]['tdocper'],							
							$data[$i]['tsexo'],
							$data[$i]['coddpto'],
							$data[$i]['codprov'],							
							$data[$i]['coddist'],
							$data[$i]['ddirecc'],
							$data[$i]['fingven'],
							$data[$i]['fretven'],
							$data[$i]['cinstit'],
							$data[$i]['tvended'],
							$data[$i]['cestado'],
                            $data[$i]['copeven'],
                            $data[$i]['sueldo'],
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>