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

$semestre = $_GET['csemaca'];
$sem=explode("|", $semestre)[0];
$buscar=array('-1','-2','-3','-4');
$reemplazar=array('-I','-II','-III','-IV');
$sem=str_replace($buscar,$reemplazar,$sem);

$txt_resolucion = $_GET['txt_resolucion'];
$txt_fecha_constancia = $_GET['txt_fecha_constancia'];
$txt_nombre_institucion = $_GET['txt_nombre_institucion'];

//Carrera del grupo
$sql = "select c.dcarrer carrera from gracprp g inner join carrerm c on c.ccarrer = g.ccarrer where g.cgracpr = '$cgracpr'";
$cn->setQuery($sql);
$carrera=$cn->loadObjectList();


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
        "{{resoluc}}"=> $txt_resolucion,
        "{{semestre}}"=> $sem,
        "{{dia}}"=> explode('-',$txt_fecha_constancia)[2],
        "{{mes}}"=> $meses[explode('-',$txt_fecha_constancia)[1]*1],
        "{{anio}}"=> explode('-',$txt_fecha_constancia)[0],
        "{{nombre_institucion}}"=> $txt_nombre_institucion,
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
