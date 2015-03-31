<?
class MySqlCursoDAO{
	
	public function cargarCursos($r){
        $sql="SELECT ccurso as id,dcurso as nombre
			  FROM cursom 
			  WHERE cinstit='".$r['cinstit']."'
			  	AND ctipcar='".$r['ctipcar']."'
			  ORDER BY dcurso";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cursos','data'=>$data);
        }
    }
	
	public function insertarCursos($r){
        $db=creadorConexion::crear('MySql');
		$sqlver1="SELECT concat(substring(year(now()),2),right(Concat('0000',convert((substring(IFNULL(max(ccurso),0),4)+1),Char)),4)) As ccurso
				  FROM cursom
				  WHERE substring(ccurso,1,3) = substring(year(now()),2)";
		$db->setQuery($sqlver1);
		$ccurso=$db->loadObjectList();
		
        $sql="SELECT *
			  FROM cursom 
			  WHERE dcurso='".$r['dcurso']."'";
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
			return array('rst'=>'2','msj'=>"El curso ya ha sido registrada Anteriormente");exit();
        }else{
			$sql="INSERT INTO cursom (ccurso, dcurso, dnemoni, fusuari, cusuari, ctipcar, ttiptra, cinstit)
				  VALUES ('".$ccurso[0]['ccurso']."',
					'".$r['dcurso']."',
					'".$r['dnemoni']."',
					now(),
					'".$r['cusuari']."',
					'".$r['ctipcar']."',
					'I',
					'".$r['cinstit']."')";	
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Curso Registrada correctamente','ccurso'=>$ccurso[0]['ccurso']);exit();
			}
		}
    }
		
	public function ActualizaCurso($r){
        $db=creadorConexion::crear('MySql');
		
			$sql="UPDATE cursom
				  SET dcurso = '".$r['dcurso']."',
				  	  dnemoni= '".$r['dnemoni']."',
					  fusuari= now(),
					  cusuari= '".$r['cusuari']."',
					  ttiptra= 'U'
				  WHERE ccurso ='".$r['ccurso']."'
				  	AND cinstit='".$r['cinstit']."'
				  	AND ctipcar='".$r['ctipcar']."'";
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Actualizar Datos');exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Curso Actualizado correctamente','ccurso'=>$r['ccurso']);exit();
			}
    }
}
?>