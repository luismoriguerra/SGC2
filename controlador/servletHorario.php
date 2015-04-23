<?
class servletHorario extends controladorComandos{
	public function doPost(){
		$daoHorario=creadorDAO::getHorarioDAO();
    	switch ($_POST['accion']){            
			case 'cargarDia':
				echo json_encode($daoHorario->cargarDia());
			break;
			case 'cargarHora':
				$array=array();
				$array['cinstit']=trim($_POST['cinstit']);
				echo json_encode($daoHorario->cargarHora($array));
			break;
			case 'cargarTipoAmbiente':
				echo json_encode($daoHorario->cargarTipoAmbiente());
			break;
			case 'cargarAmbiente':
				$array=array();
				$array['ctipamb']=trim($_POST['ctipamb']);
				$array['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoHorario->cargarAmbiente($array));
			break;
			case 'cargarTiempoTolerancia':
				echo json_encode($daoHorario->cargarTiempoTolerancia());
			break;
			case 'guardarHorarios':
				$array=array();
				$array['ccuprpr']=trim($_POST['ccuprpr']);
				$array['cprofes']=trim($_POST['cprofes']);
				$array['finipre']=trim($_POST['finipre'])==''?'null':"'".trim($_POST['finipre'])."'";
				$array['ffinpre']=trim($_POST['ffinpre'])==''?'null':"'".trim($_POST['ffinpre'])."'";
				$array['finivir']=trim($_POST['finivir'])==''?'null':"'".trim($_POST['finivir'])."'";
				$array['ffinvir']=trim($_POST['ffinvir'])==''?'null':"'".trim($_POST['ffinvir'])."'";
				$array['datos']=trim($_POST['datos']);
				$array['cdetgra']=trim($_POST['cdetgra']);
				$array['cusuari']=trim($_POST['cusuari']);
				$array['cfilialx']=trim($_POST['cfilialx']);
				echo json_encode($daoHorario->guardarHorarios($array));
			break;
			case 'cargarHorarioValidado':
				$array=array();
				$array['cambien']=trim($_POST['cambien']);
				$array['cprofes']=trim($_POST['cprofes']);
				$array['cinstit']=trim($_POST['cinstit']);
				$array['dias']=trim($_POST['dias']);
				echo json_encode($daoHorario->cargarHorarioValidado($array));
			break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoHorario=creadorDAO::getHorarioDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>