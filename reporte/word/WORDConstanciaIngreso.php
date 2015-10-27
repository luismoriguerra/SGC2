<?php
require_once 'PHPWord.php';

require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

$cn=MySqlConexion::getInstance();

/* QUERYS */
$cgracpr = $_GET['cgracpr'];
$cingalu = $_GET['cingalu'];
$semestre = $_GET['csemaca'];
$cfilial = $_GET['cfilial'];
$cinstit = $_GET['cinstit'];
$alumno = "";

$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");


$sql = "
select c.dcarrer carrera
from gracprp g
inner join carrerm c on c.ccarrer = g.ccarrer
where g.cgracpr = '$cgracpr'";
$cn->setQuery($sql);
$carrera=$cn->loadObjectList();


$sql = "
select CONCAT(p.dappape, ' '  , p.dapmape, ', ', p.dnomper ) nombre
from ingalum i
inner join personm p on p.cperson = i.cperson
where i.cingalu = '$cingalu'";
$cn->setQuery($sql);
$nombre=$cn->loadObjectList();


$sql = "
select s.resoluc
from semacan s
inner join gracprp g on g.csemaca = s.csemaca
where s.csemaca = g.csemaca
and s.cinicio = g.cinicio
and g.cfilial = s.cfilial
and g.cinstit = s.cinstit
and g.cgracpr = '$cgracpr' limit 1";
$cn->setQuery($sql);
$res=$cn->loadObjectList();


$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('WORDtemplate_constanciaIngreso.docx');

function utf8($text){
    $text=iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
    return $text;
}

$document->setValue('nombre',utf8($nombre[0]["nombre"]));
$document->setValue('carrera',utf8($carrera[0]["carrera"]));
$document->setValue('resoluc',utf8($res[0]["resoluc"]));
$document->setValue('semestre',utf8(explode("|", $semestre)[0]));
$document->setValue('dia', date('d'));
$document->setValue('mes', $meses[date('m')]);
$document->setValue('anio', date('Y'));

$nombre="ConstanciaIngreso".date("Ymdhis").".docx";
$document->save($nombre);
header ("Location:".$nombre);

?>

