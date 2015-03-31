<?php
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font



/***********ADD A PAGE************/
$pdf->AddPage();

/*******CABECERA*********/
$html='
<style>
.t-14{font-size:16px;}
.t-10{font-size:12px;}
</style>
<table cellspacing="0" cellpadding="2" border="1" background="../images/fondo_graf.jpg" align="left" class="t-14 t-tahoma">
	<tr> 
		<td align="right" class="t-azul2 t-negrita">Percepción de competitividad salarial externa</td> 
		<td width="360" valign="top">
		    <table width="360" height="28" cellspacing="0" cellpadding="0" class="t-10" border="0">
	            <tr>
	                <td width="29%" bgcolor="#CC3300">29%</td>
	                <td width="28%" bgcolor="#FFFF00">28%</td>     
	                <td width="43%" bgcolor="#00FF00">43%</td>   
	            </tr>
	        </table> 
		</td>
	</tr>    
</table>';
$pdf->writeHTML($html, true, false, true, false, '');













/*****PONGO CELDAS*****/
// set cell padding, margin, color
/*$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->setCellMargins(0, 0, 0, 0);
$pdf->SetFillColor(127, 127, 127);
$pdf->SetTextColor(0,1,1,1);
$pdf->SetFont('times', '', 10);

$txt='ENCUESTA DE CLIMA ORGANIZACIONAL SABROSA S.A.';
$pdf->MultiCell(195, 10, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, 10, 'B');
$txt='SABROSA SA';
$pdf->MultiCell(195, 10, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, 10, 'T');*/



/*******FIN PROCESO*******/
// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('resultados_graficos.pdf', 'I');
?>