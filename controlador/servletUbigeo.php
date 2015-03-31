<?
class servletUbigeo extends controladorComandos{
	public function doPost(){
		$daoUbigeo=creadorDAO::getUbigeoDAO();
    	switch ($_POST['accion']){
            case 'cargar_departamento':
                echo json_encode($daoUbigeo->cargarDepartamento());
            break;
			case 'cargar_provincia':
				$dep=trim($_POST['departamento']);				
				echo json_encode($daoUbigeo->cargarProvincia($dep));
			break;
			case 'cargar_distrito':
				$dep=trim($_POST['departamento']);
				$pro=trim($_POST['provincia']);
				echo json_encode($daoUbigeo->cargarDistrito($dep,$pro));
			break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoUbigeo=creadorDAO::getUbigeoDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>