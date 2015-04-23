<?
	/**********************************************************************************************/
	/*hemos utilizado la función basename el cual devuelve el nombre del archivo, 
	  eliminando alguna ruta existente, con este prevenimos que se intente acceder a otra carpeta. 
	  La carpeta donde están los archivos para descargar lo definimos en la variable $root, 
	  en este caso img/. Luego obtenemos el tamaño del archivo y el tipo de archivo 
	  para finalmente enviar los headers para indicando la descarga*/
	/**********************************************************************************************/

	//recibe por get nombre de archivo y fuerza su descarga

	if (!isset($_GET['file']) || empty($_GET['file'])) {
    exit();
	}
	$root = "";//si fuese otra carpeta la contenedora seria ej: img/
	$file = basename($_GET['file']);
	$path = $root.$file;
	$type = '';
	 
	if (is_file($path)) {
	    $size = filesize($path);
	    if (function_exists('mime_content_type')) {
	        $type = mime_content_type($path);
	    } else if (function_exists('finfo_file')) {
	        $info = finfo_open(FILEINFO_MIME);
	        $type = finfo_file($info, $path);
	        finfo_close($info); 
	    }
	    if ($type == '') {
	        $type = "application/force-download";
	    }
	    // Set Headers
	    header("Content-Type: $type");
	    header("Content-Disposition: attachment; filename=$file");
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Length: " . $size);
	    // Download File
	    readfile($path);
	} else {
	    die("File not exist !!");
}
?>