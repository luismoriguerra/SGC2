<?
class servletCronograma extends controladorComandos{
	public function doPost(){
		$daoCronograma=creadorDAO::getCronogramaDAO();
    	switch ($_POST['accion']){
            case 'insertar_cronograma':
			$data=array();
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['conceptos']=trim($_POST['conceptos']);
				$data['cgracpr']=trim($_POST['cgracpr']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['csemaca']=trim($_POST['csemaca']);
				$data['cciclo'] =trim($_POST['cciclo']);
				$data['cinicio']=trim($_POST['cinicio']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['ccurric']=trim($_POST['ccurric']);
				$cant=explode(",",$_POST['fvencim']);
				for($i=0;$i<count($cant);$i++){
				$data['fvencim'.($i+1)]=trim($cant[$i]);
				}
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCronograma->insertarCronograma($data));
            break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoConcepto=creadorDAO::getConceptoDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>