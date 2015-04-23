<?php
$idencuesta=$_GET['idenc'];
$empresa=$_GET['empresa'];

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
<table style="color: #ffffff;border:none;" cellpadding="8" cellspacing="0" border="0">
	<tr>
		<td style="background-color:#7F7F7F;color:#fff;border:none;width:100px;" align="center">
			<img src="../../images/logo.jpg" height="56" width="39"/>
		</td>
		<td style="background-color:#7F7F7F;color:#fff;border:none;width:590px" align="center">
			<span style="font-size:55px;font-weight:bold;">ENCUESTA DE CLIMA ORGANIZACIONAL</span><br>
			<span style="font-size:70px;font-weight:bold;">'.$empresa.'</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="background-color:#F3F3F3;color:#000;border:none;font-size:33px" align="justify">
			<ul>
				<li><i>Esta encuesta busca medir el grado de satisfacción de los colaboradores.</i></li>
				<li><i>La encuesta es completamente anónima. Siéntase libre de expresar su opinión.</i></li>
				<li><i>No es un examen. No hay respuestas correctas o incorrectas. Conteste según su percepción personal.</i></li>
				<li><i>Por favor no deje ninguna pregunta sin contestar.</i></li>
			</ul>
			<p align="right"><i>Muchas gracias por su participación.</i></p>
		</td>
	</tr>
</table>';
$pdf->writeHTML($html, false, false, true, false, '');

/************PARAMETROS*************/
	/*****cabecera****/
$html='
<table style="color: #ffffff;border:none;" cellpadding="0">
	<tr>
		<td colspan="2" style="color:#000;border:none;" align="justify" valign="top">
			<br><br>
			<span style="font-size:37px"><i><b>DATOS REFERENCIALES</b></i></span><br>
			<span style="font-size:30px"><i>Marque con un aspa <img src="../../images/aspa.jpg" width="11" height="13"/> donde corresponda:</i></span>
		</td>
	</tr>
</table>
<style>
	.cabeza{background-color:#EBEBEB;border:none;}
	.contenedor{border:1px solid #ccc;}
	.contenido{border:none;background-color:#ffffff}
</style>';

$sql="SELECT enp.idencuesta_parametro,enp.nombre,enpd.nombre as 'detalle'
    from sc_encuesta_parametro enp 
        left join sc_encuesta_parametro_segmento enpd on enp.idencuesta_parametro=enpd.idencuesta_parametro
    where enp.idencuesta=$idencuesta and enpd.nro_correlativo_segmento!='0'";
$cn->setQuery($sql);
$datosp=$cn->loadObjectList();

	/*****parametros****/
$html.=		'<table cellpadding="0" cellspacing="0" border="0">';//inicio tabla principal
$html.=			'<tr>';//inicio fila principal

for($i=0;$i<count($datosp);$i++){
    if($i==0){//si es 1er registro
    	$num=1;//inicializo numerador de alternativas
	    	$html.='<td class="contenedor">';//inicio columna
			$html.='	<table cellpadding="2" style="font-size:28px;">';//abro subtabla
			$html.='		<tr><td class="cabeza"><b> '.$datosp[$i]['nombre'].'</b></td></tr>';//pinto parametro
			$html.='		<tr><td class="contenido"> <img src="../../images/'.$num.'b.jpg" width="11" height="11"/> '.$datosp[$i]['detalle'].'</td></tr>';//pinto detalle
    }else{//sino es 1er registro
        if($datosp[$i]['idencuesta_parametro']==$datosp[$i-1]['idencuesta_parametro']){//si id es igual al anterior tons es un detalle Y PINTO DEMAS DETALLES
        	$num++;//sumo numerador de alternativas
        	$html.=			'<tr><td class="contenido"> <img src="../../images/'.$num.'b.jpg" width="11" height="11"/> '.$datosp[$i]['detalle'].'</td></tr>';//pinto detalle
        }else{//si es un nuevo parametro
        	$num=1;//inicializo numerador de alternativas
        	$html.=		'</table>';//cierro subtabla anterior
			$html.='</td>';//cierro columna anterior
			$html.='<td class="contenedor">';//abro nueva columna
			$html.=		'<table cellpadding="2" style="font-size:28px;">';//abro subtabla
			$html.=			'<tr><td class="cabeza"><b> '.$datosp[$i]['nombre'].'</b></td></tr>';//pinto parametro
			$html.=			'<tr><td class="contenido"> <img src="../../images/'.$num.'b.jpg" width="11" height="11"/> '.$datosp[$i]['detalle'].'</td></tr>';//pinto detalle
        }

    }
}
$html.=					'</table>';//cierro subtabla anterior (q fue la ultima)
$html.=				'</td>';//cierro columna anterior (q fue la ultima)
$html.=			'</tr>';//cierro fila principal
$html.=		'</table>';//cierro tabla principal

$pdf->writeHTML($html, true, false, true, false, '');

/************INSTRUCCIONES**************/
$html='
<table style="color: #ffffff;border:none;" cellpadding="8">
	<tr>
		<td colspan="2" style="color:#000;border:none;" align="justify" valign="top">
			<span style="font-size:37px"><i><b>INSTRUCCIONES:</b></i></span><br>
			<span style="font-size:30px"><i>Exprese su opinión con un aspa <img src="../../images/aspa.jpg" width="11" height="13"/> conforme al siguente criterio:</i></span>
		</td>
	</tr>
</table>
<style>
	.cabeza{background-color:#EBEBEB;border:none;}
	.contenedor{border:1px solid #ccc;}
	.contenido{border:none;background-color:#ffffff}
</style>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td class="contenedor">
			<table cellpadding="2" style="font-size:33px;">
				<tr>
					<td class="cabeza" align="center">
						<br><br><b><i>En total desacuerdo <img src="../../images/1-5.jpg" width="107" height="13"/> Totalmente de acuerdo</i></b><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');


/************PREGUNTAS SIN GRUPOS**************/
$html='<style>
	.marco{border:1px solid #ccc;margin:0px 0px 0px 0px;}
	.gris{background-color:#EBEBEB;border:none;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;}
	.blanco{background-color:#fff;border:none;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;}
</style>';

$sql="SELECT entp.nro_correlativo_pregunta as nro,entp.nombre as nombrep, ent.grupo
	from sc_encuesta_tema ent 
	    left join sc_encuesta_tema_pregunta entp on ent.idencuesta_tema=entp.idencuesta_tema
	where ent.idencuesta=$idencuesta and trim(grupo)='' order by 1";
$cn->setQuery($sql);
$datostp_sg=$cn->loadObjectList();

if(count($datostp_sg)>0){//si hay datos sin grupo...

	for($j=0;$j<count($datostp_sg);$j++){
		if((($j+1)%2)==0){$estilo="blanco";$img='1-5b.jpg';}else{$estilo="gris";$img='1-5g.jpg';}//estilo pares e impares

		if($j==0){//si es 1er registro
			$html.=	'<table cellpadding="0" cellspacing="0">';//abro tabla principal
			$html.=		'<tr><td class="marco">';//abro fila y columna principal
			$html.=			'<table cellpadding="2" style="font-size:33px;">';//abro tabla de contenidos
		}
		$html.=					'<tr>';//pinto pregunta
		$html.=						'<td class="'.$estilo.'">';
		$html.=							$datostp_sg[$j]['nro'].' <img src="../../images/'.$img.'" width="68" height="11"/> '.$datostp_sg[$j]['nombrep'];
		$html.=						'</td>';
		$html.=					'</tr>';
		if($j<(count($datostp_sg)-1)){//si no esta en el ultimo registro
			if((($j+1)%8)==0){//si es multiplo de 8
				$html.=			'</table>';//cierro tabla de contenidos
				$html.=		'</td></tr>';//cierro fila y columna principal
				$html.=	'</table><br>';//abro tabla principal
				
				$html.=	'<table cellpadding="0" cellspacing="0">';//abro tabla principal
				$html.=		'<tr><td class="marco">';//abro fila y columna principal
				$html.=			'<table cellpadding="2" style="font-size:33px;">';//abro tabla de contenidos	
			}
		}
	}
	
	$html.=					'</table>';//cierro tabla de contenidos
	$html.=				'</td></tr>';//cierro fila y columna principal
	$html.=			'</table>';//cierro tabla principal

}

$pdf->writeHTML($html, true, false, true, false, '');

/************PREGUNTAS CON GRUPOS **************/
$html='<style>
	.marco{border:1px solid #ccc;margin:0px 0px 0px 0px;}
	.gris{background-color:#EBEBEB;border:none;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;}
	.blanco{background-color:#fff;border:none;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;}
</style>';

$sql="SELECT entp.nro_correlativo_pregunta as nro,entp.nombre as nombrep, ent.grupo
	from sc_encuesta_tema ent 
	    left join sc_encuesta_tema_pregunta entp on ent.idencuesta_tema=entp.idencuesta_tema
	where ent.idencuesta=$idencuesta and trim(grupo)!='' order by 1";
$cn->setQuery($sql);
$datostp_sg=$cn->loadObjectList();

if(count($datostp_sg)>0){//si hay datos con grupo...

	for($j=0;$j<count($datostp_sg);$j++){
		if((($j+1)%2)==0){$estilo="blanco";$img='1-5b.jpg';}else{$estilo="gris";$img='1-5g.jpg';}//estilo pares e impares

		if($j==0){//si es 1er registro
			$html.='<span style="font-size:33px;"><b>'.$datostp_sg[$j]['grupo'].'</b></span><br>';//pinto titulo del grupo
			$html.=	'<table cellpadding="0" cellspacing="0">';//abro tabla principal
			$html.=		'<tr><td class="marco">';//abro fila y columna principal
			$html.=			'<table cellpadding="2" style="font-size:33px;">';//abro tabla de contenidos
		}else{
		if($datostp_sg[$j]['grupo']!=$datostp_sg[$j-1]['grupo']){//si es nuevo grupo
			$html.=			'</table>';//cierro tabla de contenidos
			$html.=		'</td></tr>';//cierro fila y columna principal
			$html.=	'</table><br>';//abro tabla principal
			
			$html.='<span style="font-size:33px;"><b>'.$datostp_sg[$j]['grupo'].'</b></span><br>';//pinto titulo del grupo
			$html.=	'<table cellpadding="0" cellspacing="0">';//abro tabla principal
			$html.=		'<tr><td class="marco">';//abro fila y columna principal
			$html.=			'<table cellpadding="2" style="font-size:33px;">';//abro tabla de contenidos	
		}
		}
		
		$html.=					'<tr>';//PINTO PREGUNTA
		$html.=						'<td class="'.$estilo.'">';
		$html.=							$datostp_sg[$j]['nro'].' <img src="../../images/'.$img.'" width="68" height="11"/> '.$datostp_sg[$j]['nombrep'];
		$html.=						'</td>';
		$html.=					'</tr>';
		
	}
	$html.=					'</table>';//cierro tabla de contenidos
	$html.=				'</td></tr>';//cierro fila y columna principal
	$html.=			'</table>';//cierro tabla principal
}

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
$pdf->Output('formato_encuesta.pdf', 'I');
?>