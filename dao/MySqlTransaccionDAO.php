<?
class MySqlTransaccionDAO{
    public static function insertarTransaccion($sqlx,$cfilial){
        $sql=addslashes(trim($sqlx));

        $db=creadorConexion::crear('MySql');
        $sql="INSERT INTO transam (transaccion,fecha,cfilial) Values ('$sql',now(),'$cfilial')";
        $db->setQuery($sql);
        if($db->executeQuery()){
            return true;
        }else{
            return false;
        }
    }

    public function procesaArchivoImportar ($file) {
        /*******elimino si existe el archivo******/
        if(!file_exists('../archivos/cargados/'.$file) ) {
            echo json_encode(array('rst'=>2,'msj'=>'Error al procesar, archivo subido ya no existe'));exit();       
        }
        /****proceso de carga del archivo****/
        $contenidox=file_get_contents('../archivos/cargados/'.$file);
        //decodifica
        $contenido=base64_decode($contenidox);
        $registros=explode('$&*', $contenido);
        //var_dump($registros);exit;
        $registrosOK=0;
        $registrosError=0;
        $db=creadorConexion::crear('MySql');

        //insertando registros
        for($i=0;$i<count($registros);$i++){
            if($registros[$i]!=''){
                $sql=$registros[$i];
                $db->setQuery($sql);
                if($db->executeQuery()){
                    $registrosOK++;
                }else{
                    $registrosError++;
                }        
            }
        }

        return array('rst'=>1,'msj'=>'Procesados='.$registrosOK.' Error='.$registrosError);
    }

    public function procesaArchivoImportarSilabo ($file,$array) {
        /*******elimino si existe el archivo******/
        if(!file_exists('../archivos/silabo/'.$file) ) {
            echo json_encode(array('rst'=>2,'msj'=>'Error al procesar, archivo subido ya no existe'));exit();       
        }
        $buscar=array('"',';',"'",',');
        $reemplazar=array('','','','');
       $file=str_replace($buscar,$reemplazar,$file);
       $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        //1ro Actualizar login y password de cperson
        $sql = "update aspralm set  
                csilabo = concat(csilabo,',".$file."'),                
                fusuari = NOW(), cusuari = '".$array["cusuari"]."'  
                WHERE caspral = '".$array["caspral"]."'
                AND csilabo not like '%,".$file."%'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'Archivo Almacenado','file'=>$file);
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update ',"sql"=>$sql);
        }
       
    }

    public function procesaArchivoImportar2 ($file,$array) {
        /*******elimino si existe el archivo******/
        if(!file_exists('../archivos/cargados/'.$file) ) {
            echo json_encode(array('rst'=>2,'msj'=>'Error al procesar, archivo subido ya no existe'));exit();       
        }
        /****proceso de carga del archivo****/
        $registros=file('../archivos/cargados/'.$file);
        //var_dump($registros);exit;
        $registrosOK=0;
        $registrosError=0;
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        //insertando registros
        $recaca="";
        for($i=0;$i<count($registros);$i++){
            if($registros[$i]!='' and strtoupper(substr($registros[$i],0,2))=='DD'){
                $recaca=trim(substr($registros[$i],27,30));
                $fecha=trim(substr($registros[$i],57,8));
                $monto=trim(substr($registros[$i],103,15));
                $nroope=trim(substr($registros[$i],124,6));
                $hora=trim(substr($registros[$i],168,6));


                /**************************BCP**************************/
                $nvouche=$nroope;
                $cbanco='003';
                $monto=($monto*1)/100;
                
                    $sqlvalida="Select *
                                FROM vouchep
                                WHERE numvou='".$nvouche."'
                                AND cbanco='".$cbanco."'";
                    $db->setQuery($sqlvalida);
                    $datavalida=$db->loadObjectList();
                if(count($datavalida)==0){
                $newcod=$db->generarCodigo('vouchep','cvouche',14,$array['cusuari']);       
                $insvoucher="Insert into vouchep (cvouche,numvou,cbanco,cfilial,cinstita,cusuari,fusuari,ttiptra,ntotvou) 
                values('".$newcod."','".$nvouche."','".$cbanco."','".$array['cfilial']."','','".$array['cusuari']."',now(),'I','".$monto."')";
                $db->setQuery($insvoucher);
                    if(!$db->executeQuery()){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$insvoucher);exit();
                    }
                    if(!MySqlTransaccionDAO::insertarTransaccion($insvoucher,$array['cfilial']) ){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$insvoucher);exit();
                    }

                $sqlupdate="UPDATE recacap SET cfilial='".$array['cfilial']."',cdocpag='".$newcod."',tdocpag='V',festfin='".$fecha."',cusuari='".$array['cusuari']."',fusuari=now(),ttiptra='M',cestpag='C',testfin='C'
                            WHERE crecaca='".$recaca."'";
                
                $db->setQuery($sqlupdate);
                    if(!$db->executeQuery()){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlupdate);exit();
                    }
                    if(!MySqlTransaccionDAO::insertarTransaccion($sqlupdate,$array['cfilial']) ){
                        $registrosError++;
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlupdate);exit();
                    }
                    else{
                        $registrosOK++;
                    }
                    
                }
                else{
                     $registrosOK++;
                }                     
            }
        }
        $db->commitTransaccion();
        //rec:'.$recaca.'|fechayhora:'.$fecha.'|'.$hora.'|mon:'.$monto.'|nro:'.$nroope
        return array('rst'=>1,'msj'=>'Procesados='.$registrosOK.' Error='.$registrosError);
    }

    public function uploadArchivoImportar ( $_post, $_files ) {
        /***archivo a subir***/
            //$cargado=date("Ymd_His").$_files['uploadFileArchivoConfiguracion']['name'];
        $cargado=$_files['uploadFileImportar']['name'];
        /*******elimino si existe el archivo******/
        if(file_exists('../archivos/cargados/'.$cargado) ) {
            if(!unlink("../archivos/cargados/".$cargado)){
                echo json_encode(array('rst'=>2,'msj'=>'Error al eliminar archivo antiguo','file'=>''));exit();       
            }
        }
        /****proceso de carga del archivo****/
        if( opendir('../archivos/cargados/') ) {
            //echo($_files['uploadFileTraficoLlamadas']['type']);exit();
            if($_files['uploadFileImportar']['type']!='text/plain'){//tipo excel 2007
                echo json_encode(array('rst'=>2,'msj'=>'Formato Incorrecto, solo se acepta <b>.txt</b>','file'=>''));       
            }else{
                /*if($_files['uploadFileArchivoDigitacion']['name']!='Ptlla_Digit.xlsx'){
                    echo json_encode(array('rst'=>2,'msj'=>'Archivo Incorrecto, se requiere <b>Ptlla_Digit.xlsx</b>','file'=>''));       
                }else{*/
                    if(move_uploaded_file($_files['uploadFileImportar']['tmp_name'],'../archivos/cargados/'.$cargado)){
                        echo json_encode(array('rst'=>1,'msj'=>'Archivo Subido','file'=>$_files['uploadFileImportar']['name'],'file_upload'=>$cargado));
                    }else{
                        echo json_encode(array('rst'=>2,'msj'=>'Error al subir archivo al servidor','file'=>''));       
                    }
                //}
            }
        }else{
            echo json_encode(array('rst'=>2,'msg'=>'Error al abrir carpeta contenedora','file'=>''));       
        }   
    }

    public function uploadArchivoImportarSilabo ( $_post, $_files ) {
        /***archivo a subir***/
            //$cargado=date("Ymd_His").$_files['uploadFileArchivoConfiguracion']['name'];
        $cargado=$_files['uploadFileImportar']['name'];
        $ext=explode(".",$cargado);
        $ListadoExt='pdf,doc,docx,ppt,pptx,txt,xls,xlsx';
        $verificaExt=explode($ext[1],$ListadoExt);
        /*******elimino si existe el archivo******/
        if(file_exists('../archivos/silabo/'.$cargado) ) {
            if(!unlink("../archivos/silabo/".$cargado)){
                echo json_encode(array('rst'=>2,'msj'=>'Error al eliminar archivo antiguo','file'=>''));exit();       
            }
        }
        /****proceso de carga del archivo****/
        if( opendir('../archivos/silabo/') ) {
            //echo($_files['uploadFileTraficoLlamadas']['type']);exit();
            if(count($verificaExt)==1){//tipo excel 2007
                echo json_encode(array('rst'=>2,'msj'=>'Formato Incorrecto, solo se acepta <b>'.$ListadoExt.'</b>','file'=>''));       
            }else{
                /*if($_files['uploadFileArchivoDigitacion']['name']!='Ptlla_Digit.xlsx'){
                    echo json_encode(array('rst'=>2,'msj'=>'Archivo Incorrecto, se requiere <b>Ptlla_Digit.xlsx</b>','file'=>''));       
                }else{*/
                    if(move_uploaded_file($_files['uploadFileImportar']['tmp_name'],'../archivos/silabo/'.$cargado)){
                        echo json_encode(array('rst'=>1,'msj'=>'Archivo Subido','file'=>$_files['uploadFileImportar']['name'],'file_upload'=>$cargado));
                    }else{
                        echo json_encode(array('rst'=>2,'msj'=>'Error al subir archivo al servidor','file'=>''));       
                    }
                //}
            }
        }else{
            echo json_encode(array('rst'=>2,'msg'=>'Error al abrir carpeta contenedora','file'=>''));       
        }   
    }

	public function generaTransaccionExportar($cfilial,$f_ini,$f_fin){
	/*crea archivo*/
    $archivo="exportado".date("YmdHis").rand(0,50);
    $fp = fopen('../reporte/txt/'.$archivo, 'w');
    
    /*******pinta datos******/
    $db=creadorConexion::crear('MySql');
    $sql="SELECT transaccion from transam where cfilial='$cfilial' and date(fecha) BETWEEN '$f_ini' and '$f_fin' order by fecha";
    $db->setQuery($sql);
    $datos=$db->loadObjectList();

    $datosunidos="";
    /****recorro datos y voy metiendo filas en txt****/
    foreach ($datos as $key => $value) {
        foreach($value as $k=>$v){
            $datosunidos.=$v;
        }
        $datosunidos.="$&*";
    }
    //encripta
    $data=base64_encode($datosunidos);
    //escribe
    fwrite($fp, $data);        
    //cierra archivo
    fclose($fp);

    return array('rst'=>'1','file'=>$archivo);
	}
}
?>