<?php
set_time_limit(0);
ini_set('memory_limit','512M');
//$idencuesta=$_GET['idenc'];
//$empresa=$_GET['empresa'];

/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

/****TCPDF Libreria****/
require_once '../../php/includes/tcpdf/config/lang/spa.php';
require_once '../../php/includes/tcpdf/tcpdf.php';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//hoja A4

/*****CONFIGURACION PDF****/
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Segura');

// remove default header
$pdf->setPrintHeader(false);//elimina cabecera

// remove default footer
$pdf->setPrintFooter(false);//elimina pie

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(25, 10, 25);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// $pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFont('helvetica', '', 8);


/* QUERYS */
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");

$cgracpr = $_GET['cgracpr'];

//$cingalu = $_GET['cingalu'];
$semestre = $_GET['csemaca'];

//Carrera del grupo
$sql = "select c.dcarrer carrera from gracprp g inner join carrerm c on c.ccarrer = g.ccarrer where g.cgracpr = '$cgracpr'";
$cn->setQuery($sql);
$carrera=$cn->loadObjectList();

// Resolucion del grupo
$sql = "select s.resoluc from semacan s inner join gracprp g on g.csemaca = s.csemaca where s.csemaca = g.csemaca
    and s.cinicio = g.cinicio and g.cfilial = s.cfilial and g.cinstit = s.cinstit and g.cgracpr = '$cgracpr' limit 1";
$cn->setQuery($sql);
$res=$cn->loadObjectList();

$url_template = 'template/constanciaMatricula.php';
$html_template = file_get_contents($url_template);

$sql = " select cingalu from conmatp where cgruaca = '".$cgracpr."'" ;
$cn->setQuery($sql);
$alumnos=$cn->loadObjectList();

foreach ($alumnos as $row ) {
    // Nombre del alumno
    $sql = "select CONCAT(p.dappape, ' '  , p.dapmape, ', ', p.dnomper ) nombre
    from ingalum i inner join personm p on p.cperson = i.cperson where i.cingalu = '".$row['cingalu']."'";
    $cn->setQuery($sql);
    $nombre=$cn->loadObjectList();

    /***********ADD A PAGE************/
    $pdf->AddPage('P', 'A4');

    $variables = array(
        "{{nombre}}"=> $nombre[0]["nombre"],
        "{{carrera}}"=> $carrera[0]["carrera"],
        "{{resoluc}}"=> $res[0]["resoluc"],
        "{{semestre}}"=> explode("|", $semestre)[0],
        "{{dia}}"=> date('d'),
        "{{mes}}"=> $meses[date('m')*1],
        "{{anio}}"=> date('Y'),
    );

    $html = str_replace(array_keys($variables), array_values($variables), $html_template);
    $pdf->writeHTML($html, true, false, true, false, '');
    /*******FIN PROCESO*******/
    // reset pointer to the last page
    $pdf->lastPage();

}

//Close and output PDF document
$pdf->Output('ConstanciaIngresos.pdf', 'I');
?>