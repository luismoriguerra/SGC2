<?php
set_time_limit(0);
ini_set('memory_limit','1024M');

error_reporting(E_ALL);
ini_set("display_errors", 1);


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
    "{{serie}}"=> $_REQUEST["serie"],

    "{{centro_captacion}}"=> $_REQUEST["centro_captacion"],
    "{{oficina_enlace}}"=> "_",
    "{{codlib}}"=> $_REQUEST['codlib'],
    "{{estado_civil}}"=> $_REQUEST['estado_civil'],
    "{{documento}}"=> $_REQUEST['documento'],
    "{{fecha_nacimiento}}"=> $_REQUEST['fecha_nac'],
    "{{genero}}"=> $_REQUEST["genero"],

    // LUGAR DE NACIMIENTO DEL POSTULANTE
    "{{pais}}"=> "PERU",
    "{{region}}"=> $_REQUEST["pregion"],
    "{{provincia}}"=> $_REQUEST["pprovincia"],
    "{{distrito}}"=> $_REQUEST["pdistrito"],

    // DATOS DEL POSTULANTE
    "{{email}}"=> $_REQUEST["email"],
    "{{celular}}"=> $_REQUEST["celular"],
    "{{telf_casa}}"=> $_REQUEST["tel_casa"],
    "{{telf_trabajo}}"=> $_REQUEST["tel_tra"],
    "{{direccion}}"=> "_",
    "{{urb}}"=> "_",
    "{{tenencia}}"=> "PROPIO/ALQUILADO",
    // datos del trabajo
    "{{p_region}}"=> "",
    "{{p_provincia}}"=> "",
    "{{p_distrito}}"=> "",
    "{{p_distrito}}"=> "",
    "{{p_empresa}}"=> "",
    "{{p_empresa_direcicon}}"=> "",

    // datos del colegio
    "{{nombre_colegio}}"=> $_REQUEST["nombre_colegio"],
    "{{c_ubicacion}}"=> $_REQUEST["colegio_ubi"],

    // DATOS DE  CARRERA
    "{{carrera}}"=>$_REQUEST["carrera"],
    "{{semestre}}"=>$_REQUEST["semestre"],
    "{{fecha_inicio}}"=>$_REQUEST["fecha_ini"],
    "{{modalidad}}"=>$_REQUEST["modalidad"],
    "{{frecuencia}}"=>$_REQUEST["frecuencia"],
    "{{local_estudio}}"=>$_REQUEST["loc_estudio"],
    "{{tipo_ingreso}}"=>$_REQUEST["tipo_ingreso"],
    "{{cert_estudio}}"=>$_REQUEST["cert_estudio"],

    // DOCUMENTOS OBLIGATORIOS
    "{{partida_nacimiento}}"=>$_REQUEST["depar_nac"],
    "{{tiene_foto}}"=>$_REQUEST["dfoto_dni"],
    "{{otros_documentos}}"=>$_REQUEST["dotro"],

    // inscripcion
    "{{ins_fecha}}" => $_REQUEST["ins_monto"]? $_REQUEST["ins_fecha"]: '',
    "{{ins_serie}}" => $_REQUEST["ins_monto"]?$_REQUEST["ins_serie"]: '',
    "{{ins_monto}}" => $_REQUEST["ins_monto"]?$_REQUEST["ins_monto"]: '',

    // matricula
    "{{mat_fecha}}" => $_REQUEST["mat_monto"] ? $_REQUEST["mat_fecha"] : '',
    "{{mat_serie}}" =>  $_REQUEST["mat_monto"] ? $_REQUEST["mat_serie"] : '',
    "{{mat_monto}}" =>  $_REQUEST["mat_monto"] ? $_REQUEST["mat_monto"] : '',


    "{{cuotas}}" => $_REQUEST["cuotas"],

    // convalidacion
    "{{conv_procedencia}}" => $_REQUEST["conv_procedencia"],
    "{{conv_tipo}}" => $_REQUEST["conv_tipo"],
    "{{conv_inst}}" => $_REQUEST["conv_inst"],
    "{{conv_car}}" => $_REQUEST["conv_car"],
    "{{conv_ano}}" => $_REQUEST["conv_ano"],

    "{{conv_docs}}" => $_REQUEST["conv_docs"],

    // pago convalidacion
    "{{conv_fecha}}" => $_REQUEST["conv_monto"] ? $_REQUEST["conv_fecha"] : '',
    "{{conv_serie}}" => $_REQUEST["conv_monto"] ? $_REQUEST["conv_serie"]: '',
    "{{conv_monto}}" =>$_REQUEST["conv_monto"] ?  $_REQUEST["conv_monto"]: '',

    // recepcionista
    "{{slct_medio_captacion}}" => $_REQUEST["slct_medio_captacion"],
    "{{txt_medio_captacion}}" => $_REQUEST["txt_medio_captacion"],
    "{{txt_recepcionista}}" => $_REQUEST["txt_recepcionista"],

    // pago cuotas
    "{{pen_fecha}}" => $_REQUEST["pen_monto"] ? $_REQUEST["pen_fecha"] : '',
    "{{pen_serie}}" => $_REQUEST["pen_monto"] ? $_REQUEST["pen_serie"] : '',
    "{{pen_monto}}" => $_REQUEST["pen_monto"] ? $_REQUEST["pen_monto"] : '',

    "{{pen_promo}}" => $_REQUEST["pen_promo"],

    // escalas

    "{{escala_matricula}}" => $_REQUEST["escala_matricula"],

    "{{escala_inscripcion}}" => $_REQUEST["escala_inscripcion"]


);

$html = file_get_contents('template/fichaInscripcion.php');
$html = str_replace(array_keys($variables), array_values($variables), $html);
//print $html;
//die();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();

$dompdf->stream("fichaInscripcion.pdf", array("Attachment"=>0));

exit(0);


?>
