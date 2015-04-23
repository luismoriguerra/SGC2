<?php
require_once 'PHPWord.php';
$dcarrer=$_REQUEST["dcarrer"];
$dalumno=$_REQUEST["dalumno"];
$cusuari=$_REQUEST["cusuari"];
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('WORDresolucion_convenio.docx');

function utf8($text){
$text=iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
return $text;
}

$document->setValue('dalumno',utf8($dalumno));
$document->setValue('dcarrer',utf8($dcarrer));
$document->setValue('dia', date('d'));
$document->setValue('mes', $meses[date('m')]);
$document->setValue('año', date('Y'));

$nombre="Resolucion_Convenio_".$cusuari.".docx";
$document->save($nombre);
header ("Location:".$nombre);
?>
