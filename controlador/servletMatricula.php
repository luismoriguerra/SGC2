<?
class servletMatricula extends controladorComandos{
	public function doPost(){
		$daoMatricula=creadorDAO::getMatriculaDAO();
		switch ($_POST['accion']){            
			default:
				case 'InsertarMatricula':
				$data=array();
				$data['cperson']=trim($_POST['cperson']);
				$data['finscri']=trim($_POST['finscri']);
				$data['sermatr']=trim($_POST['sermatr']);
				$data['dcodlib']=trim($_POST['dcodlib']);
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['cmodali']=trim($_POST['cmodali']);
				$data['cseming']=trim($_POST['cseming']);				
				$data['ciniing']=trim($_POST['ciniing']);				
				$data['cmoding']=trim($_POST['cmoding']);				
				$data['cgruaca']=trim($_POST['cgruaca']);				
				$data['thorari']=trim($_POST['thorari']);				
				$data['tusorec']=trim($_POST['tusorec']);				
				$data['testalu']=trim($_POST['testalu']);				
				$data['certest']=trim($_POST['certest']);				
				$data['partnac']=trim($_POST['partnac']);
				$data['fotodni']=trim($_POST['fotodni']);
				$data['crecepc']=trim($_POST['crecepc']);
				$data['dcoduni']=trim($_POST['dcoduni']);
				$data['otrodni']=trim($_POST['otrodni']);
				///////Matricula
				$data['tipo_pago']=trim($_POST['tipo_pago']);
				$data['cconcep']=trim($_POST['cconcep']);
				$data['monto_pago']=trim($_POST['monto_pago']);
				$data['fecha_pago']=trim($_POST['fecha_pago']);
				$data['monto_deuda']=trim($_POST['monto_deuda']);
				$data['fecha_deuda']=trim($_POST['fecha_deuda']);				
				$data['tipo_documento']=trim($_POST['tipo_documento']);
				$data['serie_boleta']=trim($_POST['serie_boleta']);
				$data['numero_boleta']=trim($_POST['numero_boleta']);
				$data['numero_voucher']=trim($_POST['numero_voucher']);
				$data['banco_voucher']=trim($_POST['banco_voucher']);
				///////Pension
				$data['cconcep_pension']=trim($_POST['cconcep_pension']);
				$data['monto_pago_pension']=trim($_POST['monto_pago_pension']);
				$data['fecha_pago_pension']=trim($_POST['fecha_pago_pension']);
				$data['monto_deuda_pension']=trim($_POST['monto_deuda_pension']);
				$data['fecha_deuda_pension']=trim($_POST['fecha_deuda_pension']);				
				$data['tipo_documento_pension']=trim($_POST['tipo_documento_pension']);
				$data['serie_boleta_pension']=trim($_POST['serie_boleta_pension']);
				$data['numero_boleta_pension']=trim($_POST['numero_boleta_pension']);
				$data['numero_voucher_pension']=trim($_POST['numero_voucher_pension']);
				$data['banco_voucher_pension']=trim($_POST['banco_voucher_pension']);
				
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cusuari']=trim($_POST['cusuari']);
				echo json_encode($daoMatricula->InsertarMatricula($data));
				break;
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoMatricula=creadorDAO::getMatriculaDAO();
		switch ($_GET['accion']){			
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>