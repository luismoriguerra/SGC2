<?
class servletProfesDisponibilidad extends controladorComandos{
	public function doPost(){
		$daoProfesDisponibilidad=creadorDAO::getProfesDisponibilidadDAO();
    	switch ($_POST['accion']){
           
			case 'guardarDisponibilidad':
				$data["cprofes"]=trim($_POST['cprofes']);
                $data["datos"]=trim($_POST['datos']);
                $data["cfilialx"]=trim($_POST['cfilialx']);
                $data["cusuari"]=trim($_POST['usuario']);
				echo json_encode($daoProfesDisponibilidad->guardarDisponibilidad($data));
			break;
			case 'cargarHorario':
				$data["cprofes"]=trim($_POST['cprofes']);
				echo json_encode($daoProfesDisponibilidad->cargarHorario($data));
				
			break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST servletAsistencia no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoProfesDisponibilidad=creadorDAO::getProfesDisponibilidadDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>