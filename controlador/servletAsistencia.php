<?
class servletAsistencia extends controladorComandos{
	public function doPost(){
		$daoAsistencia=creadorDAO::getAsistenciaDAO();
    	switch ($_POST['accion']){
           
			case 'cargarAlumnos':
				$cgrupo=trim($_POST['cgrupo']);
				echo json_encode($daoAsistencia->cargarAlumnos($cgrupo));
			break;
                    case 'rangoFechasGrupo':
				$cgrupo=trim($_POST['cgrupo']);
				echo json_encode($daoAsistencia->rangoFechasGrupo($cgrupo));
			break;
                        case 'mostrarListadoCheck':
				$cgrupo=trim($_POST['cgrupo']);
                                $seccion=trim($_POST['seccion']);
				echo json_encode($daoAsistencia->mostrarListadoCheck($cgrupo,$seccion));
			break;
                    case 'asistenciaAlumno':
				$idseing=trim($_POST['seingalu']);
                                $fecha=trim($_POST['fecha']);
				echo json_encode($daoAsistencia->asistenciaAlumno($idseing,$fecha));
			break;
                        case 'registrarAsistencia':
                                $idse=trim($_POST['idse']);
                                $estado=trim($_POST['estado']);
                                $fecha=trim($_POST['fecha']);
                                $data["cfilialx"]=trim($_POST['cfilialx']);
                                $data["usuario"]=trim($_POST['usuario']);
				echo json_encode($daoAsistencia->registrarAsistencia($idse,$estado,$fecha,$data));
                        break;
                    case 'actualizarSeccionGrupo':
                                $data = array();
				$data["cgruaca"]=trim($_POST['cgruaca']);
                                $data["seccion"]=trim($_POST['seccion']);
                                $data["cingalu"]=trim($_POST['cingalu']);
                                $data["cperson"]=trim($_POST['cperson']);
                                $data["cfilialx"]=trim($_POST['cfilialx']);
                                $data["usuario"]=trim($_POST['usuario']);
        
				echo json_encode($daoAsistencia->actualizarSeccionGrupo($data));
			break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST servletAsistencia no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoCarrera=creadorDAO::getAsistenciaDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>