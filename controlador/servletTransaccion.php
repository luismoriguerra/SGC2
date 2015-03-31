<?
class servletTransaccion extends controladorComandos{
	public function doPost(){
		$daoTransaccion=creadorDAO::getTransaccionDAO();
		switch ($_POST['accion']){  
			case 'procesa_archivo_importar':
                $file=$_POST['file'];                
                echo json_encode($daoTransaccion->procesaArchivoImportar($file));
                break;
            case 'procesa_archivo_importar2':
                $file=$_POST['file'];
                $array=array();
                $array['cusuari']=$_POST['cusuari'];
                $array['cfilial']=$_POST['cfilial'];
                echo json_encode($daoTransaccion->procesaArchivoImportar2($file,$array));
                break;
             case 'procesa_archivo_importar_silabo':
                $file=$_POST['file'];
                $array=array();
                $array['cusuari']=$_POST['cusuari'];
                $array['cfilialx']=$_POST['cfilialx'];
                $array['caspral']=$_POST['caspral'];
                echo json_encode($daoTransaccion->procesaArchivoImportarSilabo($file,$array));
                break;
            case 'genera_transaccion_exportar':
                $cfilial=$_POST['cfilial'];
                $f_ini=$_POST['f_ini'];
                $f_fin=$_POST['f_fin'];
                echo json_encode($daoTransaccion->generaTransaccionExportar($cfilial,$f_ini,$f_fin));
                break;
            case 'upload_archivo_importar':
                $daoTransaccion->uploadArchivoImportar($_POST, $_FILES);
                break;
            case 'upload_archivo_importar_silabo':
                $daoTransaccion->uploadArchivoImportarSilabo($_POST, $_FILES);
                break;             
			default:
				echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoTransaccion=creadorDAO::getTransaccionDAO();
		switch ($_GET['accion']){
			case 'jqgrid_pago':
				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>