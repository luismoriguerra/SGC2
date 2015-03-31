<?php
class funcionesPersonales{
    public static function limpiaCaracteres($text){
        $char1=array('á','é','í','ó','ú','ñ');
        $char2=array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
        $texto_correo=str_replace($char1, $char2, $text);
        return $texto_correo;
    }
    function encripta($original){//solo funciona con string enviar datos con apostrofes eje: '1'
        $encriptado="";
        for($i=0;$i<strlen($original);$i++){
            $encriptado.=dechex(ord($original[$i]));
        }
        return $encriptado;
    }
    function desencripta($encriptado){//solo funciona con string enviar datos con apostrofes eje: '1' (debido al $encriptado[$i])
        $desencriptado="";
        for($i=0;$i<strlen($encriptado);$i++){
            @$pareja=$encriptado[$i].$encriptado[$i+1];
            $desencriptado.=chr(hexdec($pareja));
            $i++;
        }
        return $desencriptado;
    }
    function diaFecha($fecha=''){//formato: 00-00-0000
      $fecha= empty($fecha)?date('Y-m-d'):$fecha;
      $dias = array('domingo','lunes','martes','miercoles','jueves','viernes','sabado');
      $dd   = explode('-',$fecha);
      $ts   = mktime(0,0,0,$dd[1],$dd[2],$dd[0]);
      return $dias[date('w',$ts)];
    }
    function UCFirstJCLower($nombre='Julio Cesar'){
        $palabras=explode(' ', $nombre);
        
        for($i=0;$i<count($palabras);$i++){
            $palabras[$i]=ucfirst(strtolower($palabras[$i]));
        }
        
        $UC=implode(' ', $palabras);
        return $UC;
    }
    function leeDirectorio($directorio){
        if ($gestor = opendir($directorio)) {
            $array=array();
            while (false !== ($archivo = readdir($gestor))) {
                if($archivo!='.' && $archivo!='..'){
                array_push($array, $archivo);
                }
            }
            closedir($gestor);
            return $array;
        }
    }
    function leeDirectorioToSelect($directorio){
        if ($gestor = opendir($directorio)) {
            $array=array();
            while (false !== ($archivo = readdir($gestor))) {
                if($archivo!='.' && $archivo!='..'){
                array_push($array, $archivo);
                }
            }
            closedir($gestor);
            $array = array_reverse($array);//invierte el orden de los elementos pq readdir los pone segun orden de creacion
            $html="";
            foreach($array as $key=>$val){
                $html.="<option value='$val'>$val</option>";
            }
            return $html;
        }
    }
}
?>
