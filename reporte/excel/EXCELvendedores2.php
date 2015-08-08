<?php
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
/*conexion*/
ini_set("memory_limit", "128M");
ini_set("max_execution_time", 300);
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
$cn=MySqlConexion::getInstance();
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$azcount=array(5,24.5,9,9,11,11,11,11,7,9,8,6,6,6,11,4,4,4,4,4,11,11,11,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);
$letras=array(
	'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
// AUMENTAMOS LA CANTIDAD DE COLUMNAS
for ($i = 0; $letras[$i]; $i++) {
	for ($j = 0; $letras[$j]; $j++) {
		$az[] = $letras[$i].$letras[$j];
		$azcount[] = 15;
	}
}
$tvended=$_GET['tvended'];
$dvendedor=$_GET['dvendedor'];

$copeven=str_replace(",","','",$_GET['copeven']);
$fechafin = $_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-" . $_GET["fin"];
$fechainicio = $_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-" . $_GET["ini"];
if (date("m") == date("m", strtotime($fechainicio))){
	$diaFinalDeCalculo = date("Y-m-d");
} else {
	$diaFinalDeCalculo = date("Y-m-t", strtotime($fechainicio));
}
$diastotales = date("Y-m-d" , strtotime("+1 month",strtotime($fechainicio)));
$diastotales = date("d" , strtotime("-1 day",strtotime($diastotales)));
$ayer = date("Y-m-d" , strtotime("-1 day",strtotime($fechafin)));
$anteayer = date("Y-m-d" , strtotime("-2 day",strtotime($fechafin)));
$cinstit=str_replace(",","','",$_GET['cinstit']);
$diaspromedio=explode("-",$fechafin);
// First day of the month.
$mesPrimerDia = date('Y-m-01', strtotime($fechainicio));
// Last day of the month.
$mesUltimoDia = date('Y-m-t', strtotime($fechainicio));
$cantulimodia = date('t', strtotime($fechainicio));

$sql_dias = "";
$sql_dias_column = "";
$sql_column_count = "";
$query1 = "";
$query2 = "";
$cantidadDias = $_GET["fin"] - $_GET["ini"] + 1;

for ($i = 0; $i < $cantidadDias ; $i++) {
	$cam = $i + 1;
	$dia = date("Y-m-d" , strtotime("-$i day",strtotime($fechafin)));
	$sql_dias .=" LEFT JOIN conmatp c$i ON (c$i.cconmat=c.cconmat AND c$i.fmatric='$dia')  LEFT JOIN gracprp g$i ON g$i.cgracpr=c$i.cgruaca ";
	$sql_dias_column .=" ,g$i.cfilial f$cam, g$i.cinstit i$cam ";
	$sql_column_count .= " ,count(IF(g.i$cam=i.cinstit,g.f$cam,NULL)) c$cam ";
	if ($i <= 20) {
	$query1 = "
		SELECT v.cvended,o.dopeven,i.cinstit,g.cpromot,CONCAT(v.dapepat,' ',v.dapemat,', ',v.dnombre) AS vendedor,v.fretven,i.dinstit,o.ctipcap,v.cestado, IFNULL(v.horari,'') horari, IFNULL(v.descto,'') descto, IFNULL(v.montele,0) ntelefo,IFNULL(v.dinstit,'') vinstit,
			count(IF(g.it=i.cinstit,g.ft,NULL)) c0,count(g.cconmat) ctf
			 $sql_column_count
			,v.codintv,v.fingven, v.sueldo pago
			,(select count(*) faltas from venfala
				where cvended = v.cvended and cestado = 1 and diafalt between '$mesPrimerDia' and '$mesUltimoDia'
			) faltas
        FROM instita i
		INNER JOIN vendedm v
		INNER JOIN opevena o ON o.copeven=v.copeven
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,c.fmatric
			 $sql_dias_column
            FROM conmatp c
			INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
			INNER JOIN filialm f ON f.cfilial=g.cfilial
            $sql_dias
            WHERE c.fmatric BETWEEN '$mesPrimerDia' and '$mesUltimoDia'
            GROUP BY c.cconmat
        ) g ON (g.cpromot=v.cvended AND g.ctipcap=o.ctipcap)
        WHERE v.tvended='$tvended'
        AND o.fingven<='$mesUltimoDia'
		AND o.copeven IN ('$copeven')
		AND v.cestado='1'
		AND i.cinstit IN ('$cinstit')
		GROUP BY v.cvended,i.cinstit
	";
		if ($i == 20) {
			// reiniciamos variables
			$sql_dias = "";
			$sql_dias_column = "";
			$sql_column_count = "";
		}
	} elseif ($i < 40) {
		$query2 = "
			SELECT v.cvended,i.cinstit,v.cestado
			$sql_column_count
        FROM instita i
				INNER JOIN vendedm v
				INNER JOIN opevena o ON o.copeven=v.copeven
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,c.fmatric
			$sql_dias_column
            FROM conmatp c
			INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
			INNER JOIN filialm f ON f.cfilial=g.cfilial
			$sql_dias
            WHERE c.fmatric BETWEEN '$mesPrimerDia' and '$mesUltimoDia'
            GROUP BY c.cconmat
        ) g ON (g.cpromot=v.cvended AND g.ctipcap=o.ctipcap)
        WHERE v.tvended='$tvended'
		AND o.copeven IN ('$copeven')
		AND v.cestado='1'
		AND i.cinstit IN ('$cinstit')
		GROUP BY v.cvended,i.cinstit
		";
	}
}
$sql = " select * from ($query1) q1 ";
if ($query2) {	$sql.= " inner join	($query2) q2 ON q2.cvended=q1.cvended AND q2.cinstit=q1.cinstit ";}
$sql .= " order BY ctf DESC,q1.vendedor,q1.dinstit ";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();
$sql2="SELECT concat(dnomper,' ',dappape,' ',dapmape) as nombre
		FROM personm
		WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();
$sql3="SELECT dinstit
		FROM instita
		WHERE cinstit IN ('$cinstit')
		ORDER BY dinstit";
$cn->setQuery($sql3);
$rpt3=$cn->loadObjectList();
/*
echo count($control)."-";
echo $sql;
*///exit($sql);
date_default_timezone_set('America/Lima');
require_once 'includes/Classes/PHPExcel.php';
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$styleThinBlackBorderAllborders = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$styleThickBlackBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleThickBlackBorderRight = array(
    'borders' => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleThickBlackBorderAllborders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleBold= array(
	'font'    => array(
		'bold'      => true
	)
);
$styleAlignmentBold= array(
	'font'    => array(
		'bold'      => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleAlignment= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleAlignmentRight= array(
	'font'    => array(
		'bold'      => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleColor = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,		
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
			),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
			)
	),
);
function color(){
	$color=array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F");
	$dcolor="";
	for($i=0;$i<6;$i++){
	$dcolor.=$color[rand(0,15)];
	}
	$num='FA'.$dcolor;
	
	$styleColorFunction = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,		
		'startcolor' => array(
			'argb' => $num,
			),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
			)
		),
	);
return $styleColorFunction;
}
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Jorge Salcedo")
							 ->setLastModifiedBy("Jorge Salcedo")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

//$objPHPExcel->getActiveSheet()->setCellValue("A2",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A1","MATRÍCULAS DE ".$dvendedor);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
// primermas columnas simples
$cabecera=array('N°','VENDEDOR','CÓDIGO','ESTADO', "HORARIO","INST VENDE",'INICIO','TERMINO','BÁSICO','DESCUENTO','DIAS LABORADOS','DIAS NO LABORADOS','TELÉFONO','PLANILLA','COSTO POR ALUMNO','PROMEDIO DIARIO');
// total de columnas simples 11 , de aqui empeizan las dinamicas
$iniciadinamica = 16;
// index
$cantidadaz = $iniciadinamica - 1;
// agregando fechas de consolidado y fechas
for ($i = 1; $i<= $cantidadDias + 1; $i++) {
	$cantidadaz++;
	$azcount[$cantidadaz]=4.5;
	array_push($cabecera, 'TOTALES');
	//agregando instituciones a la cabecera
	foreach($rpt3 as $r){
		$cantidadaz++;
		$azcount[$cantidadaz]=4.5;
		array_push($cabecera, $r['dinstit']);
	}
}
try {
	for ($i = 0; $i < count($cabecera); $i++) {
		// COLOCA LOS VALORES DE LA CABECERA
		$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6", $cabecera[$i]);
		if ($i >= ($iniciadinamica - 8)) {
			// DE G6 A K6
			$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setTextRotation(90);
		}
		$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
}catch (Exception $e) {
	die ("Error en conteo de cabeceras");
}
$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$az[($i-1)].'1');
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$az[($i-1)].'1')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getRowDimension("5")->setRowHeight(23); // altura
$objPHPExcel->getActiveSheet()->getRowDimension("6")->setRowHeight(50.5); // altura
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($i-1)].'6')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->setCellValue("B2","MES: " . strtoupper($meses[$_GET["mes"] + 1]));
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12)->applyFromArray($styleAlignmentBold);;
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleAlignmentBold);;
$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->setCellValue("B3","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D3",$rpt2[0]['nombre']);
$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->setCellValue("B4","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D4",date("Y-m-d"));
//$objPHPExcel->getActiveSheet()->mergeCells('L4');
$objPHPExcel->getActiveSheet()->setCellValue("B5","FECHA MATRÍCULA \n". $fechainicio . "/" . $fechafin);
$objPHPExcel->getActiveSheet()->getStyle("B5")->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($styleAlignmentRight);
//$objPHPExcel->getActiveSheet()->setCellValue("M4",$fechafin);
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciadinamica]."5", 'CONSOLIDADO');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciadinamica].'5:' . $az[($iniciadinamica + count($rpt3) * 1 + 1 - 1)] . "5");


$iniciocabeceraprincipal = 6;
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciocabeceraprincipal]."5", 'CAMPAÑA');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciocabeceraprincipal].'5:'.$az[($iniciocabeceraprincipal+1)].'5');
$iniciocabeceraprincipal++;$iniciocabeceraprincipal++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciocabeceraprincipal]."5", 'RENUMERACIÓN');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciocabeceraprincipal].'5:'.$az[($iniciocabeceraprincipal+1)].'5');
$iniciocabeceraprincipal++;$iniciocabeceraprincipal++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciocabeceraprincipal]."5", 'ASISTENCIA');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciocabeceraprincipal].'5:'.$az[($iniciocabeceraprincipal+1)].'5');
$iniciocabeceraprincipal++;$iniciocabeceraprincipal++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciocabeceraprincipal]."5", 'INVERSIÓN');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciocabeceraprincipal].'5:'.$az[($iniciocabeceraprincipal+1)].'5');
$iniciocabeceraprincipal++;$iniciocabeceraprincipal++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$iniciocabeceraprincipal]."5", 'INDICE');
$objPHPExcel->getActiveSheet()->mergeCells($az[$iniciocabeceraprincipal].'5:'.$az[($iniciocabeceraprincipal+1)].'5');


// GENERA LAS CABECERAS DE LAS FECHAS
for ($i = 0; $i < $cantidadDias ; $i++) {
	$dia = date("Y-m-d" , strtotime("-$i day",strtotime($fechafin)));
	$x = $i + 1;
	$y = $x + 1;
	$objPHPExcel->getActiveSheet()->setCellValue($az[($iniciadinamica+count($rpt3)*$x+$x)]."5", $dia);
	$objPHPExcel->getActiveSheet()->mergeCells($az[($iniciadinamica+count($rpt3)*$x+$x)]."5:".$az[($iniciadinamica+count($rpt3)*$y+$y-1)]."5");
}
	
$objPHPExcel->getActiveSheet()->getStyle("B5:B5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("G5:".$az[($iniciadinamica+count($rpt3)*$y+$y-1)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($iniciadinamica+count($rpt3)*$y+$y-1)]."6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
// VALOR INICIAL FILA
$valorinicial=6;
$cont=0;
$countrpt3=0;
$posicionaz=2;
foreach ($rpt as $r) {
	$countrpt3++;
	if ($countrpt3 == 1) {
		// CONTADOR DE REGISTROS  (COLUMNA NRO)
		$cont++;
		// FILA DONDE SE ESTARA IMPRIMIENTO (FILA ACTUAL , COMO EL CURSOR)
		$valorinicial++;
		$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial, $cont);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial, $r['vendedor']);
		$estado = "RETIRADO";
		if ($r['cestado'] == 1) {	$estado="LABORA";		}
		$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial, $r['codintv']);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial, $estado);
		$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial, $r['horari']);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial, $r['vinstit']);
		$fechaing = $mesPrimerDia;
		if($r['fingven']>=$fechaing){
			$fechaing=$r['fingven'];
		}
		$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial, $fechaing);

		$fecharet=$r['fretven'];
		if( ($fecharet=='' or $fecharet=='0000-00-00') or $r['fretven']>$diaFinalDeCalculo ){
			$fecharet = $diaFinalDeCalculo;
		}
		$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial, $fecharet);
		// ESTE PAGO COMO SE CUALCULA ?
		$pago = ($r["pago"]) ? $r["pago"] : 0;
		$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial, "=".$pago);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial, $r['descto']);

		$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial, "=H".$valorinicial."-G".$valorinicial . " + 1 - ".$r["faltas"]);
		$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial, "=".$r['faltas']);

		$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial, "=".$r['ntelefo'] );
		$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial, "=(".$pago."/".$cantulimodia.")*K".$valorinicial."-J".$valorinicial);

		$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial, "=IFERROR((M".$valorinicial." + N".$valorinicial.")/".$az[$iniciadinamica].$valorinicial.",0)");
		$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial, "=".$az[$iniciadinamica].$valorinicial."/K".$valorinicial);


		// INICIO DE COLUMNAS DINAMICAS
		$objPHPExcel->getActiveSheet()->setCellValue(
			$az[$iniciadinamica].$valorinicial,
			'=SUM('.$az[($iniciadinamica+1)].$valorinicial.':'.$az[($iniciadinamica+count($rpt3)*1+1-1)].$valorinicial.")");
		for ($i = 1; $i <= $cantidadDias; $i++) {
			$x = $i + 1;
			$objPHPExcel->getActiveSheet()->setCellValue(
				$az[($iniciadinamica+count($rpt3)*$i+$i)].$valorinicial,
				"=SUM(".$az[($iniciadinamica+count($rpt3)*$i+$i+1)].$valorinicial.":".$az[($iniciadinamica+count($rpt3)*$x+$x-1)].$valorinicial.")");
		}
	}
	$posicionaz = $iniciadinamica + $countrpt3;

	for ($i = 0; $i <= $cantidadDias; $i++) {
		if ($r['c'.$i]*1>0) {
			$objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->applyFromArray($styleBold);
		}

		$objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial,$r['c'.$i]);
		$posicionaz++;
		if ($i == $cantidadDias) {
			$posicionaz++;
		} else {
			$posicionaz+=count($rpt3);
		}
	}
	if( $countrpt3==count($rpt3) ){
		$countrpt3=0;
	}
}
$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[$cantidadaz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A7:F'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('G7:H'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('I7:J'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('K7:L'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('M7:N'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('O7:P'.$valorinicial)->applyFromArray($styleThickBlackBorderOutline);

$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[$cantidadaz]."6")->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle($az[$iniciadinamica]."6:".$az[$iniciadinamica].$valorinicial)->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle($az[$iniciadinamica]."6:".$az[$iniciadinamica].($valorinicial+1))->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle($az[$iniciadinamica]."6:".$az[($iniciadinamica+count($rpt3))].$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle(
//		$az[($iniciadinamica+count($rpt3)*$i+$i+1)]."6:".$az[($iniciadinamica+count($rpt3)*$i+$i+count($rpt3))].$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
for ($i = 1; $i <= $cantidadDias; $i++) {
	$objPHPExcel->getActiveSheet()->getStyle(
		$az[($iniciadinamica+count($rpt3)*$i+$i)]."6:".$az[($iniciadinamica+count($rpt3)*$i+$i)].$valorinicial)->applyFromArray($styleBold);
	$objPHPExcel->getActiveSheet()->getStyle(
		$az[($iniciadinamica+count($rpt3)*$i+$i)]."6:".$az[($iniciadinamica+count($rpt3)*$i+$i)].($valorinicial+1))->applyFromArray($styleThickBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle(
		$az[($iniciadinamica+count($rpt3)*$i+$i+1)]."6:".$az[($iniciadinamica+count($rpt3)*$i+$i+count($rpt3))].$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
}
$objPHPExcel->getActiveSheet()->getStyle('B5:B5')->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('G5:'.$az[$cantidadaz]."5")->applyFromArray($styleThickBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A6:N6')->applyFromArray($styleThickBlackBorderAllborders);
$valorinicial++;
$cantidadaz = 15 ;
for ($i = 1; $i <= $cantidadDias + 1; $i++) {
	$cantidadaz++;
	$objPHPExcel->getActiveSheet()->setCellValue(
		$az[$cantidadaz].$valorinicial,
		"=SUM(".$az[$cantidadaz]."7:".$az[$cantidadaz].($valorinicial-1).")");
	$totalLoop = count($rpt3);
	for ($j = 0;$j < $totalLoop; $j++) {
		$cantidadaz++;
		$objPHPExcel->getActiveSheet()->setCellValue(
			$az[$cantidadaz].$valorinicial,
			"=SUM(".$az[$cantidadaz]."7:".$az[$cantidadaz].($valorinicial-1).")");
	}
}
//AGREGAMOS SUMATORIA de INVERSION
	$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial, "=SUM(M7:M".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,	"=SUM(N7:N".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->getStyle("M".$valorinicial.":N".$valorinicial)->applyFromArray($styleThickBlackBorderAllborders);
//AGREGAMOS LA ULTIMA SUMATORIA
//$cantidadaz++;
//$objPHPExcel->getActiveSheet()->setCellValue(
//	$az[$cantidadaz].$valorinicial,
//	"=SUM(".$az[$cantidadaz]."7:".$az[$cantidadaz].($valorinicial-1).")");

$objPHPExcel->getActiveSheet()->getStyle($az[($iniciadinamica)].$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle($az[($iniciadinamica)].$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle($az[($iniciadinamica)].$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleBold);
////////////////////////////////////////////////////////////////////////////////////////////////

$objPHPExcel->getActiveSheet()->setTitle('Reporte_Vendedores');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Vendedores_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
