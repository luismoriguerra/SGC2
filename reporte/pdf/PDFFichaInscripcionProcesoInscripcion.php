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


$variables = array(
    "{{fecha}}"=> $_REQUEST["fecha"],
    "{{paterno}}"=> $_REQUEST["paterno"],
    "{{materno}}"=> $_REQUEST["materno"],
    "{{nombres}}"=> $_REQUEST["nombres"],
    "{{centro_captacion}}"=> $_REQUEST["centro_captacion"],
//    "{{oficina_enlace}}"=> "",
    "{{codlib}}"=> $_REQUEST['codlib'],
    "{{estado_civil}}"=> $_REQUEST['estado_civil'],
    "{{documento}}"=> $_REQUEST['documento'],
    "{{fecha_nacimiento}}"=> $_REQUEST['fecha_nac'],
    "{{genero}}"=> $_REQUEST["genero"],

    // LUGAR DE NACIMIENTO DEL POSTULANTE
    "{{pais}}"=> $_REQUEST[""],
    "{{region}}"=> $_REQUEST[""],
    "{{provincia}}"=> $_REQUEST[""],
    "{{distrito}}"=> $_REQUEST[""],

    // DATOS DEL POSTULANTE
    "{{email}}"=> $_REQUEST["email"],
    "{{celular}}"=> $_REQUEST["celular"],
    "{{telf_casa}}"=> $_REQUEST["tel_casa"],
    "{{telf_trabajo}}"=> $_REQUEST["tel_tra"],
    "{{direccion}}"=> $_REQUEST[""],
    "{{urb}}"=> $_REQUEST[""],
    "{{tenencia}}"=> "PROPIO/ALQUILADO",
    // datos del trabajo
    "{{p_region}}"=> "",
    "{{p_provincia}}"=> "",
    "{{p_distrito}}"=> "",
    "{{p_distrito}}"=> "",
    "{{p_empresa}}"=> "",
    "{{p_empresa_direcicon}}"=> "",

    // Datos del la carrera
    "{{carrera}}"=>"",
    "{{semestre}}"=>"",
    "{{fecha_inicio}}"=>"",
    "{{modalidad}}"=>"",
    "{{frecuencia}}"=>"",
    "{{local_estudio}}"=>"",



);

$html = file_get_contents('template/fichaInscripcion.php');
$html = str_replace(array_keys($variables), array_values($variables), $html);

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();

$dompdf->stream("fichaInscripcion.pdf", array("Attachment"=>0));

exit(0);


?>