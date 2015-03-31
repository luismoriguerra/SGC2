<?php
class servletRegistro extends controladorComandos{
        public function doPost(){
            $dao=creadorDAO::getRegistroDAO();
            switch ($_POST['accion']):
                case 'Cargar':
				$data['paterno']=trim($_POST['paterno']);				
				$data['materno']=trim($_POST['materno']);
				$data['nombre']=trim($_POST['nombre']);
				$data['dni']=trim($_POST['dni']);
                    echo json_encode($dao->Cargar($data));
                    break;               
                case 'Insertar':
                $data=array();
				$data['paterno']=trim($_POST['paterno']);				
				$data['materno']=trim($_POST['materno']);
				$data['nombre']=trim($_POST['nombre']);
				$data['dni']=trim($_POST['dni']);
				$data['email']=trim($_POST['email']);
				$data['tel']=trim($_POST['tel']);
				$data['cel']=trim($_POST['cel']);
				$data['carrera']=trim($_POST['carrera']);
                    echo json_encode($dao->Insertar($data));
                    break;				
                default:
                    echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'.$_POST['action']));
            endswitch;
        }
        public function doGet(){
			$dao=creadorDAO::getRegistroDAO();
			switch($_GET['action']):				
				default:
				echo json_encode(array('rst'=>3,'msg'=>'Action no encontrado'));
            endswitch;
        }
}
?>
