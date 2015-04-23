<?
class servletInstitucion extends controladorComandos{
	public function doPost(){
		$daoInstitucion=creadorDAO::getInstitucionDAO();
    	switch ($_POST['accion']){
            case 'cargar_filial':
				$array=array();
				$array['cfilial']=trim($_POST['cfilial']);
                echo json_encode($daoInstitucion->cargarFilial($array));
            break;
             case 'cargarCiclo':
				echo json_encode($daoInstitucion->cargarCiclo());
            break;
			 case 'cargar_pension_g':
			 	$array=array();
				$array['cfilial']=$_POST['cfilial'];
				$array['cinstit']=$_POST['cinstit'];
				$array['ccarrer']=$_POST['ccarrer'];
                echo json_encode($daoInstitucion->cargarPensionG($array));
            break;
            case 'cargarSemestreG':
            	$array=array();
				$array['cinstit']=trim($_POST['cinstit']);
				$array['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoInstitucion->cargarSemestreG($array));
			break;
			case 'cargarCarreraG':
            	$array=array();
				$array['cinstit']=trim($_POST['cinstit']);
				$array['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoInstitucion->cargarCarreraG($array));
			break;
			case 'cargar_institucion':
				$array=array();
				$array['cinstit']=trim($_POST['cinstit']);
				echo json_encode($daoInstitucion->cargarInstitucion($array));
			break;
			case 'ListarInstituto':
				$array=array();
				$array['cinstit']=trim($_POST['cinstit']);
				echo json_encode($daoInstitucion->ListarInstituto($array));
			break;
			case 'ListaBancos':
				echo json_encode($daoInstitucion->ListaBancos());
			break;
			case 'ListarDetalleGrupos':
				$array=array();
				$array['cgracpr']=$_POST['cgracpr'];
				echo json_encode($daoInstitucion->ListarDetalleGrupos($array));
			break;			
            case 'ListarGrupos':
            	$data=array();
	            $data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
	            $data['ccarrer']=trim($_POST['ccarrer']);
				$data['csemaca']=trim($_POST['csemaca']);
	                        
	            $data['ccurric']=trim($_POST['ccurric']);
				$data['cciclo']=trim($_POST['cciclo']);
	            $data['cinicio']=trim($_POST['cinicio']);
				$data['cturno']=trim($_POST['cturno']);
	            $data['chora']=trim($_POST['chora']);
            	echo json_encode($daoInstitucion->ListarGrupos($data));
			break;
            case 'ActualizarGrupo':
            	$data=array();
	            $data['cfilialx']=trim($_POST['cfilialx']);
				$data['cusuari']=trim($_POST['cusuari']);
	            $data['ces']=trim($_POST['ces']);
				$data['gru']=trim($_POST['gru']);
            	echo json_encode($daoInstitucion->ActualizarGrupo($data));
			break;
            case 'getFechasSemetre':
            	$data=array();
                $data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);    
				$data['csemaca']=trim($_POST['csemaca']);
                $data['cinicio']=trim($_POST['cinicio']);
				echo json_encode($daoInstitucion->getFechasSemetre($data));
			break;
            case 'listarUsuarios':
            	$data=array();
                $data['cfilial']=trim($_POST['cfilial']);
				$data['nombres']=trim($_POST['nombres']);    
				$data['paterno']=trim($_POST['paterno']);
                $data['materno']=trim($_POST['materno']);
				echo json_encode($daoInstitucion->listarUsuarios($data));
			break;
            case 'listarIndiceMatricula':
            	$data=array();
                $data['cfilial']=trim($_POST['cfilial']);
				$data['cinsiti']=trim($_POST['cinsiti']);    
				$data['csemaca']=trim($_POST['csemaca']);
				$data['fechini']=trim($_POST['fechini']);
				$data['fechfin']=trim($_POST['fechfin']);                       
				echo json_encode($daoInstitucion->listarIndiceMatricula($data));
			break;
            case 'mostrarUsuarios':
            	$data=array();
                $data['cfilial']=trim($_POST['cfilial']);
                $data['cperson']=trim($_POST['cperson']);    
                echo json_encode($daoInstitucion->mostrarUsuarios($data));
            break;
            case 'cargarGrupos':
            	$data=array();
                $data['cfilial']=trim($_POST['cfilial']);
                $data['cperson']=trim($_POST['cperson']);    
                echo json_encode($daoInstitucion->cargarGrupos($data));
            break;
             case 'actualizarUsuario':
             	$data=array();
                 $data['cfilial']=trim($_POST['cfilial']);
                 $data['cperson']=trim($_POST['cperson']);  
                 $data['cestado']=trim($_POST['cestado']);
                 $data['login']=trim($_POST['login']);
                 $data['clave']=trim($_POST['clave']);
                 $data['cgrupos']=trim($_POST['cgrupos']);
                 $data["dnivusu"] =trim($_POST['dnivusu']);
                 $data["cusuari"] = (trim($_POST['cusuari']));
                 $data["cfilialx"] =(trim($_POST['cfilialx']));         
      			echo json_encode($daoInstitucion->actualizarUsuario($data));
      		break; 
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoInstitucion=creadorDAO::getInstitucionDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}

?>