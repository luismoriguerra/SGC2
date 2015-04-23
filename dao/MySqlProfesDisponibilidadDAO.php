<?php 
class MySqlProfesDisponibilidadDAO{
    
    public function guardarDisponibilidad($post){
        
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        
        //RECEPCION DE DATA
        $datos  = $post["datos"];
        $cprofe = $post["cprofes"];
        $datos_array = explode('|', $datos);
        $inserts_ids = array();
        // print_r($datos_array);
        // die();
        $registros = 0;
        foreach ($datos_array as $row) {
            # code...
             if(empty($row))
                continue;

            $registros++;
            $data_array = explode("-", $row);

            if($data_array[0] == 0){

                $sql = " INSERT INTO disprom set "
                     ." cprofes = '". $post["cprofes"] ."'" 
                     ." ,cdia = '". $data_array[1] ."'" 
                     ." ,hini = '".$data_array[2].":".$data_array[3] ."'" 
                     ." ,hfin = '". $data_array[4].":".$data_array[5] ."'" 
                     ." ,cestado = '". $data_array[6] ."'" 
                     ." ,cusucre = '". $post["cusuari"] ."'" 
                     ." ,fusucre = now() " 
                     ." ,cusumod = '". $post["cusuari"] ."'" 
                     ." ,fusumod = now() ";
            }else{
                    $sql = " UPDATE  disprom set "
                     ." cestado = '". $data_array[6] ."'" 
                     //." ,cusucre = '". $post["cusuari"] ."'" 
                     //." ,fusucre = now() " 
                     ." ,cusumod = '". $post["cusuari"] ."'" 
                     ." ,fusumod = now() "
                     ." WHERE cdispro=".$data_array[0]
                     ;
            }


            $db->setQuery($sql);
            if($db->executeQuery()){
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
                }

                // $db->commitTransaccion();
                // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql,'id'=>$id);
                //$inserts_ids[] = $id; // GUARDA LOS IDS REGISTRADOS

            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar Query , no retorno id','sql'=>$sql);
            }// FIN EXECUTE QUERY
        }// FIN FOREACH
            if($registros){
                $db->commitTransaccion();
                return array('rst'=>'1','msj'=>'Horario Ingresado');
            }else{
                return array('rst'=>'1','msj'=>'No hay registros que guardar');
            }

    }//fin public functions

    public function cargarHorario($post){
        $sql="select * from disprom where cprofes = ".$post['cprofes'];
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horarios cargados','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No se encontraron horarios','data'=>$data,'sql'=>$sql);
        }
    }
    
}
?>