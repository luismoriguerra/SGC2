<?php
set_time_limit(0);
ini_set('memory_limit','1024M');

//error_reporting(E_ALL);
//ini_set("display_errors", 1);


//$idencuesta=$_GET['idenc'];
//$empresa=$_GET['empresa'];

/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
$cn=MySqlConexion::getInstance();



if (trim($cingalu) != "") {
    $listAlum = str_replace(",", "','", $cingalu);
    $alumno = " AND co.cingalu in ('" . $listAlum . "')";
}



// inhibit DOMPDF's auto-loader
define('DOMPDF_ENABLE_AUTOLOAD', false);
require_once("../../php/includes/dompdf/dompdf_config.inc.php");
require_once('../../php/includes/dompdf/include/autoload.inc.php');
$html = file_get_contents('template/fichaInscripcion.php');

$sql = 'select cc.description
from postulm  p
inner join cencapm cc on cc.ccencap = p.ccencap
where p.cingalu = "032CARGA01300000002"';

$cn->setQuery($sql);
$data = $cn->loadObjectList();
$centro_captacion = $data[0]['description'];


$variables = array(
    "{{fecha}}",
    "{{paterno}}",
    "{{materno}}",
    "{{nombres}}",
    "{{centro_captacion}}",
    "{{oficina_enlace}}",
    "{{cod_lib}}",
    "{{serie}}"
);

$valores = array(
 $_REQUEST["finscri"],
 $_REQUEST["dappape"],
 $_REQUEST["dapmape"],
 $_REQUEST["dnomper"],
    $centro_captacion,
    $oficina_enlace,
    $_REQUEST['dcodlib'],
    $_REQUEST['sermatr'],

);

$html = str_replace($variables, $valores, $html);




//print $html;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();

$dompdf->stream("fichaInscripcion.pdf", array("Attachment"=>0));

exit(0);


?>