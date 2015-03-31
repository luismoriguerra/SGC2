<?php

class MySqlEquivalenciaDAO {

    public function cargarCarreras($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select ca.cinstit , ca.ccarrer id, ca.dcarrer nombre
                    from curricm cu
                    inner join carrerm ca on cu.ccarrer = ca.ccarrer
                    where cinstit = '$post'";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sqlVal);
        }
        
    }
    
    public function cargarModulos($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select  cmodulo id, dmodulo nombre
                    from moduloa
                    where ccarrer = '$post'";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Modulos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Modulos','data'=>$data,'sql'=>$sqlVal);
        }
        
    }

     public function GetInstitucionyCarrera($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = " select c.ccurric,
car.cinstit,
car.ccarrer 
from curricm c 
inner join carrerm car on car.ccarrer = c.ccarrer
where c.ccurric = '$post'";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Datos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen datos','data'=>$data,'sql'=>$sqlVal);
        }
        
    }
    
    public function cargarCurriculas($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select cu.ccurric id , cu.dtitulo nombre
                    from curricm cu
                    inner join carrerm ca on cu.ccarrer = ca.ccarrer
                    where cinstit = '".$post["cinstit"] ."'  and ca.ccarrer = '".$post["ccarrer"] ."' ";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Curriculas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen curriculas','data'=>$data,'sql'=>$sqlVal);
        }
    }
    
    public function cargarCursos($post) {
        $db = creadorConexion::crear('MySql');
        
        $sqlVal = "SELECT c.ccurso id , c.dcurso nombre
                    FROM placurp p
                    inner join cursom c on c.ccurso = p.ccurso
                    where p.ccurric = '".$post["ccurric"] ."' and p.cmodulo = '".$post["cmodulo"] ."' ";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Cursos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cursos','data'=>$data,'sql'=>$sqlVal);
        }
    }
    
    public function addEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        
		$actas  = $post["actas"];
        $actas_array = explode('^', $actas);
		// print json_encode($actas_array);
		// exit();
        $actas_cantidad = count($actas_array);

        //ARMANDO FIND IN SET
        $find = "";
        foreach ($actas_array as $value) {
        	# code...
        	$data = explode("|", $value);
        	$filtro = $data[2]."-".$data[3]."-".$data[4];
        	$find .= " and FIND_IN_SET('$filtro',codigos) > 0 ";

        }

        //ARMANDO QUERY
        $sqlVal = "
		select 
				e.cequisag,
				c.ccurric,
				c.dtitulo,
				cu.ccurso,
				cu.dcurso,
				m.cmodulo cciclo,
				m.dmodulo dciclo,
				count(*) cant,
				GROUP_CONCAT(  CONCAT_WS('-',ca.ccurric, ma.cmodulo , cua.ccurso )  SEPARATOR ',') codigos ,
				GROUP_CONCAT(  CONCAT_WS('		',ca.dtitulo, ma.dmodulo , cua.dcurso )  SEPARATOR '<br>') titulos,
				e.gruequi grupo,
				IF(estide = 'r','Regular','Irregular') estide,
				estide cestide,
				car.cinstit inst,
				car.ccarrer carrer

                FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
                where e.cestado  = 1 and e.estide = '". $post["estide"] ."'
                group by e.gruequi 
				having cant  = $actas_cantidad 
				 " . $find ;

		// print $sqlVal;
		// exit();
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Registro de equivalencia ya existe</b> ya existe'));exit();}
        /********************/	
		 
        //RECEPCION DE DATA
        $actas  = $post["actas"];
        $actas_array = explode('^', $actas);
        $inserts_ids = array();
        foreach ($actas_array as $acta) {
            # code...
            $data_array = explode("|", $acta);
            $sql = " INSERT INTO equisag set "
                 ." ccurric = '". $post["ccurric"] ."'" 
                 ." ,ccurso = '". $post["ccurso"] ."'" 
                 ." ,cmodulo = '". $post["cmodulo"] ."'" 
                 ." ,gruequi = '". 0 ."'" 
                 ." ,ccurria = '". $data_array[2] ."'" 
                 ." ,cmoduloa = '".$data_array[3] ."'" 
                 ." ,ccursoa = '". $data_array[4] ."'" 
                 ." ,ccuract = '". $data_array[5] ."'" 
                 ." ,estide = '". $post["estide"] ."'" 
                 ." ,cestado = '". 1 ."'" 
                 ." ,cusuari = '". $post["cusuari"] ."'" 
                 ." ,fusuari = now() " 
                 ." ,cusuariu = '". $post["cusuari"] ."'" 
                 ." ,fusuariu = now() " 
            ;
            // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql);
            // $sql = "INSERT INTO equisag (ccurric,ccurso,cmodulo,gruequi,ccurria,ccursoa,cmoduloa,estide,cusuari,fusuari,cusuariu,fusuariu) 
            //                 values( '". $post["ccurric"] ."' ,'". $post["ccurso"] ."','". $post["cmodulo"] ."',0, '". $data_array[2] ."','". $data_array[3] ."'
            //                     ,'". $data_array[4] ."','". $post["estide"] ."',1,'". $post["cusuari"] ."')";

            $db->setQuery($sql);
            
            if($id = $db->executeQuery_returnid()){
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
                }

                // $db->commitTransaccion();
                // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql,'id'=>$id);
                $inserts_ids[] = $id; // GUARDA LOS IDS REGISTRADOS

            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar Query , no retorno id','sql'=>$sql);
            }// FIN EXECUTE QUERY


            

        }// FIN FOREACH
        
        // $db->commitTransaccion();
        // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql);

        $first_id = $inserts_ids[0];
        $updates_ids = implode(",", $inserts_ids);
        $sql = "UPDATE equisag set gruequi = ". $first_id . " where cequisag in ($updates_ids) ";
        $db->setQuery($sql);
        
        if($db->executeQuery()){
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
             $db->rollbackTransaccion();
             return array('rst'=>'3','msj'=>'Error al actualizar Datos','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql,'ids'=>$inserts_ids);
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query updates','sql'=>$sql);
         } 




    }



    
    public function EditarEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        
		$actas  = $post["actas"];
        $actas_array = explode('^', $actas);
		// print json_encode($actas_array);
		// exit();
        $actas_cantidad = count($actas_array);

        //ARMANDO FIND IN SET
        $find = "";
        foreach ($actas_array as $value) {
        	# code...
        	// $find .= " and FIND_IN_SET('$value',codigos) > 0 ";
        	$data = explode("|", $value);
        	$filtro = $data[2]."-".$data[3]."-".$data[4];
        	$find .= " and FIND_IN_SET('$filtro',codigos) > 0 ";
        }

        //ARMANDO QUERY
        $sqlVal = "
		select 
				e.cequisag,
				c.ccurric,
				c.dtitulo,
				cu.ccurso,
				cu.dcurso,
				m.cmodulo cciclo,
				m.dmodulo dciclo,
				count(*) cant,
				GROUP_CONCAT(  CONCAT_WS('-',ca.ccurric, ma.cmodulo , cua.ccurso )  SEPARATOR ',') codigos ,
				GROUP_CONCAT(  CONCAT_WS('		',ca.dtitulo, ma.dmodulo , cua.dcurso )  SEPARATOR '<br>') titulos,
				e.gruequi grupo,
				IF(estide = 'r','Regular','Irregular') estide,
				estide cestide,
				car.cinstit inst,
				car.ccarrer carrer

                FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
                where e.cestado  = 1 and gruequi != '".$post["id"]."' and e.estide = '". $post["estide"] ."'
                group by e.gruequi 
				having cant  = $actas_cantidad 
				 " . $find ;


        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Registro de equivalencia ya existe</b> ya existe'));exit();}
        /********************/	
        //Eliminamos lo existentes del grupo y agregamos los nuevos
		$sql="update equisag set cestado = 0 , cusuariu ='". $post["cusuari"] ."' , fusuariu = now()   where gruequi =  '".$post["id"]."'";
		$db->setQuery($sql);
            
            if($db->executeQuery()){
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al actualizar antiguos cursos','sql'=>$sql);exit();
                }

            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar update Query , no retorno id','sql'=>$sql);
            }// FIN EXECUTE QUERY

		//AGREGAMOS LOS NUEVOS

		//RECEPCION DE DATA
        $actas  = $post["actas"];
        $actas_array = explode('^', $actas);
        $inserts_ids = array();
        foreach ($actas_array as $acta) {
            # code...
            $data_array = explode("|", $acta);
            $sql = " INSERT INTO equisag set "
                 ." ccurric = '". $post["ccurric"] ."'" 
                 ." ,ccurso = '". $post["ccurso"] ."'" 
                 ." ,cmodulo = '". $post["cmodulo"] ."'" 
                 ." ,gruequi = '". 0 ."'" 
                 ." ,ccurria = '". $data_array[2] ."'" 
                 ." ,cmoduloa = '".$data_array[3] ."'" 
                 ." ,ccursoa = '". $data_array[4] ."'" 
                 ." ,ccuract = '". $data_array[5] ."'" 
                 ." ,estide = '". $post["estide"] ."'" 
                 ." ,cestado = '". 1 ."'" 
                 ." ,cusuari = '". $post["cusuari"] ."'" 
                 ." ,fusuari = now() " 
                 ." ,cusuariu = '". $post["cusuari"] ."'" 
                 ." ,fusuariu = now() " 
            ;
            // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql);
            // $sql = "INSERT INTO equisag (ccurric,ccurso,cmodulo,gruequi,ccurria,ccursoa,cmoduloa,estide,cusuari,fusuari,cusuariu,fusuariu) 
            //                 values( '". $post["ccurric"] ."' ,'". $post["ccurso"] ."','". $post["cmodulo"] ."',0, '". $data_array[2] ."','". $data_array[3] ."'
            //                     ,'". $data_array[4] ."','". $post["estide"] ."',1,'". $post["cusuari"] ."')";

            $db->setQuery($sql);
            
            if($id = $db->executeQuery_returnid()){
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
                }

                // $db->commitTransaccion();
                // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql,'id'=>$id);
                $inserts_ids[] = $id; // GUARDA LOS IDS REGISTRADOS

            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar Query , no retorno id','sql'=>$sql);
            }// FIN EXECUTE QUERY
        }// FIN FOREACH
        
        // $db->commitTransaccion();
        // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql);

        $first_id = $inserts_ids[0];
        $updates_ids = implode(",", $inserts_ids);
        $sql = "UPDATE equisag set gruequi = ". $first_id . " where cequisag in ($updates_ids) ";
        $db->setQuery($sql);
        
        if($db->executeQuery()){
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
             $db->rollbackTransaccion();
             return array('rst'=>'3','msj'=>'Error al actualizar Datos','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencias Actualizadas','sql'=>$sql,'ids'=>$inserts_ids);
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query updates','sql'=>$sql);
         } 

		/*********/


 
    }
    
    
    public function EliminarEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        
		   $sql="update equisag set cestado = 0,cusuariu = '".$post["cusuari"]."',fusuariu = now()  where gruequi =  '".$post["id"]."'";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencia Actualizada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    
    public function JQGridCountEquivalencia($where = '' , $having= '',$fields = '') {
        $db = creadorConexion::crear('MySql');
        $sql = " SELECT COUNT(*) AS count " . $fields .  "
                FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
                where e.cestado  = 1 " . $where
                .  " group by e.gruequi " 
                .  " having 1 =1  " . $having;

        $db->setQuery($sql);
        $data = $db->loadObjectList();
          // print($sql);exit();
        if (count($data) > 0) {
            return $data;
        } else {
            return array(array('COUNT' => 0));
        }
    }

    public function JQGRIDRowsEquivalencia($sidx, $sord, $start, $limit, $where = '' , $having= '',$fields = '') {
        $sql = "select 
e.cequisag,
c.ccurric,
c.dtitulo,
cu.ccurso,
cu.dcurso,
m.cmodulo cciclo,
m.dmodulo dciclo,
GROUP_CONCAT(  CONCAT_WS('~',ca.ccurric, ma.cmodulo , cua.ccurso, cuact.ccurso )  SEPARATOR ',') codigos ,
GROUP_CONCAT(  CONCAT('<b>Curricula:</b>',ca.dtitulo, '<br><b>Modulo:</b>',ma.dmodulo ,'<br><b>Curso:</b>', cua.dcurso, '<br><b>Acta:</b>',cuact.dcurso )  SEPARATOR '<hr>') titulos,
e.gruequi grupo,
IF(estide = 'r','Regular','Irregular') estide,
estide cestide,
car.cinstit inst,
car.ccarrer carrer,
GROUP_CONCAT( cuact.dcurso  SEPARATOR ',') dactas 


                FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                inner join cursom cuact on cuact.ccurso = e.ccuract
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
                where e.cestado  = 1 
                group by e.gruequi "
                . $where 
                . " having 1 =1  " . $having
                . " ORDER BY  " . $sidx . " " . $sord 
                . " LIMIT " . $limit . " OFFSET " . $start;
           // print $sql;    
        $db = creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data = $db->loadObjectList();
        return $data;
    }

}

?>
