<?php
class MySqlRegistroDAO{
   	public function Cargar($post){
		
		$paterno=trim($post['paterno']);
		$materno=trim($post['materno']);
		$nombre=trim($post['nombre']);
		$dni=trim($post['dni']);
		$where="";
		if($paterno!=''){
		$where.=" AND paterno like '%".$paterno."%'";
		}
		if($materno!=''){
		$where.=" AND materno like '%".$materno."%'";
		}
		if($nombre!=''){
		$where.=" AND nombre like '%".$nombre."%'";
		}
		if($dni!=''){
		$where.=" AND dni like '%".$dni."%'";
		}
        $sql="Select *
			  from registro 
			  WHERE 1=1 ".$where."
			  order by paterno,materno,nombre";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Registros cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Registros','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function Insertar($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        /********************/	
		$sql="Insert Into registro (paterno,materno,nombre,dni,email,tel,cel,carrera)
			  Values('".$post['paterno']."','".$post['materno']."','".$post['nombre']."','".$post['dni']."','".$post['email']."','".$post['tel']."','".$post['cel']."','".$post['carrera']."')";
        $db->setQuery($sql);
        if($db->executeQuery()){
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Registro Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }    
}
?>
