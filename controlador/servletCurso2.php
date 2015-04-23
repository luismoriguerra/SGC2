<?
class servletCurso extends controladorComandos{
	public function doPost(){
		$daoCurso=creadorDAO::getCursoDAO();
    	switch ($_POST['accion']){
            case 'cargar_cursos':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=trim($_POST['ctipcar']);
                echo json_encode($daoCurso->cargarCursos($data));
            break;
            case 'Insertar_Curso':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['dcurso']=trim($_POST['dcurso']);
				$data['dnemoni']=trim($_POST['dnemoni']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCurso->insertarCursos($data));
            break;
            case 'Actualiza_Curso':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['ccurso']=trim($_POST['ccurso']);
				$data['dcurso']=trim($_POST['dcurso']);
				$data['dnemoni']=trim($_POST['dnemoni']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCurso->ActualizaCurso($data));
            break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoCurso=creadorDAO::getCursoDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>