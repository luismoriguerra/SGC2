<?
class servletConcepto extends controladorComandos{
	public function doPost(){
		$daoConcepto=creadorDAO::getConceptoDAO();
    	switch ($_POST['accion']){
            case 'cargar_concepto':
			$data=array();
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['tinscri']=trim($_POST['tinscri']);
				$data['cctaing']=trim($_POST['cctaing']);
				$data['nprecio']=trim($_POST['nprecio']);
				$data['nprecio']=trim($_POST['nprecio']);
				$data['cgruaca']=trim($_POST['cgruaca']);
                echo json_encode($daoConcepto->cargarConcepto($data));
            break;
			case 'cargar_concepto_pension':
			$data=array();
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['tinscri']=trim($_POST['tinscri']);
				$data['cctaing']=trim($_POST['cctaing']);
				$data['cgruaca']=trim($_POST['cgruaca']);
				$data['nprecio']=trim($_POST['nprecio']);
                echo json_encode($daoConcepto->cargarConceptoPension($data));
            break;			
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
			case 'cargar_cuentas_ingreso':
				$data=array();
				$data['validacuentas']=trim($_POST['validacuentas']);			
                echo json_encode($daoConcepto->cargarCuentaIngreso($data));
            break;	
			case 'cargar_cuentas_ingreso_comp':
				$data=array();
				$data['validacuentas']=trim($_POST['validacuentas']);
                echo json_encode($daoConcepto->cargarCuentaIngresoC($data));
            break;	
			case 'act_est_cta_ing':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->ActEstCtaIng($data));
            break;	
			case 'cargar_sub_cuentas_1':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['validacuentas']=trim($_POST['validacuentas']);
                echo json_encode($daoConcepto->cargarSubCuenta1($data));
            break;		
			case 'cargar_sub_cuentas_1_comp':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['validacuentas']=trim($_POST['validacuentas']);
                echo json_encode($daoConcepto->cargarSubCuenta1C($data));
            break;		
			case 'act_est_sub_cta_1':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->ActEstSubCta1($data));
            break;	
			case 'cargar_sub_cuentas_2':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['validacuentas']=trim($_POST['validacuentas']);
                echo json_encode($daoConcepto->cargarSubCuenta2($data));
            break;		
			case 'cargar_sub_cuentas_2_comp':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['validacuentas']=trim($_POST['validacuentas']);
                echo json_encode($daoConcepto->cargarSubCuenta2C($data));
            break;			
			case 'act_est_sub_cta_2':
			$data=array();
				$data['cctaing']=trim($_POST['cctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->ActEstSubCta2($data));
            break;	
			case 'Insertar_CuentaIng':
			$data=array();
				$data['dctaing']=trim($_POST['dctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->InsertarCuentaIng($data));
            break;				
			case 'Insertar_SubCuenta1':
			$data=array();
				$data['dctaing']=trim($_POST['dctaing']);
				$data['tctaing']=trim($_POST['tctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->InsertarSubCuenta1($data));
            break;			
			case 'Insertar_SubCuenta2':
			$data=array();
				$data['dctaing']=trim($_POST['dctaing']);
				$data['tctaing']=trim($_POST['tctaing']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoConcepto->InsertarSubCuenta2($data));
            break;				
			case 'valida_conceptos':
			$data=array();
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cinstit']=trim($_POST['cinstit']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['tinscri']=trim($_POST['tinscri']);
				$data['cctaing1']=trim($_POST['cctaing1']);
				$data['cctaing2']=trim($_POST['cctaing2']);
				$data['cusuari']=trim($_POST['cusuari']);
                echo json_encode($daoConcepto->validaConcepto($data));
            break;				
			case 'Guardar_Cambio_Concep':
			$data=array();
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cinstit']=trim($_POST['cinstit']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['valcarr']=trim($_POST['valcarr']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['tinscri']=trim($_POST['tinscri']);
				$data['cctaing1']=trim($_POST['cctaing1']);
				$data['cctaing2']=trim($_POST['cctaing2']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
				$data['datos']=trim($_POST['datos']);
                echo json_encode($daoConcepto->guardarCambioConcep($data));
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