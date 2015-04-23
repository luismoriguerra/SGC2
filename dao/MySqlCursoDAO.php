<?php
class MySqlCursoDAO{
   	public function cargarCurso($r){
        $sql="SELECT ccurso as id,concat(codicur,' | ',dcurso) as nombre
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
            return array('rst'=>'2','msj'=>'No existen Cursos','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function actualizarCurso($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccurso FROM cursom where dcurso='".$post["dcurso"]."' and cinstit='".$post['cinstit']."' and ccurso!='".$post["id"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Curso</b> ya existe','sql'=>$sqlVal));exit();}
		
		$sqlVal="	SELECT c.ccurso 
					FROM placurp p
					INNER JOIN cursom c on (c.ccurso=p.ccurso)
					where c.cinstit!='".$post['cinstit']."' 
					and c.ccurso='".$post["id"]."'";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'No se actualiza el <b>Instituto del Curso</b> por que Curso existe en Plan Curricular','sql'=>$sqlVal));exit();}
        /*******/
        $sql="update cursom set codicur='".$post['codicur']."',dnemoni='".$post['dnemoni']."',cinstit='".$post['cinstit']."',dcurso='".$post["dcurso"]."',fusuari=now(),ttiptra='M',cusuari='".$post['cusuari']."',cestado='".$post["cestado"]."' where ccurso='".$post["id"]."'";
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Curso Actualizado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }
    }
    public function insertarCurso($post){
       
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT ccurso FROM cursom where dcurso='".$post["dcurso"]."' and cinstit='".$post['cinstit']."'  limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msg'=>'<b>Curso</b> ya existe','sql'=>$sqlVal));exit();}
        /********************/	
		$sqlver1="SELECT concat(substring(year(now()),2),right(Concat('0000',convert((substring(IFNULL(max(ccurso),0),4)+1),Char)),4)) As ccurso
				  FROM cursom
				  WHERE substring(ccurso,1,3) = substring(year(now()),2)";
		$db->setQuery($sqlver1);
		$ccurso=$db->loadObjectList();	 
		
        $sql="insert into cursom(ccurso,dcurso,dnemoni,ctipcar,cinstit,codicur,cestado,fusuari,cusuari,ttiptra) values('".$ccurso[0]['ccurso']."','".$post["dcurso"]."','".$post["dnemoni"]."','2','".$post["cinstit"]."','".$post["codicur"]."','".$post["cestado"]."',now(),'".$post['cusuari']."','I')";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msg'=>'Curso Ingresado');
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msg'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    public function JQGridCountCurso ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" 	SELECT COUNT(*) AS count 
				FROM cursom c,instita i
            	WHERE c.cinstit=i.cinstit ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsCurso ( $sidx, $sord, $start, $limit, $where) {
        $sql = "SELECT c.ccurso,c.dcurso,c.dnemoni,c.codicur,
			i.dinstit cinstit,
            CASE
                WHEN	c.cestado='1' THEN 'Activo'
                WHEN	c.cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS cestado
            FROM cursom c,instita i
            WHERE c.cinstit=i.cinstit ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
}
?>
