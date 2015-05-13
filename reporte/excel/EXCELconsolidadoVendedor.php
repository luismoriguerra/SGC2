<?php
/*conexion*/
//
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,24.5,24.5,5.5,5.5,5.5,5.5,5.5,5.5,7.5,5.5,5.5,5.5,5.5,5.5,5.5,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");



$cfilial = str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);

$fechainicio =$_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-01";

// First day of the month.
$mesPrimerDia = date('Y-m-01', strtotime($fechainicio));
// Last day of the month.
$mesUltimoDia = date('Y-m-t', strtotime($fechainicio));

// SI CONSULTAMOS EL REPORTE PARA EL PRESENTE MES SE DEBE SOLO CONTAR HASTA EL DIA VIGENTE
if ($_GET["mes"] + 1 == date("m")) {
    $mesUltimoDia = $_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-" . date("d");

}

list($anioff,$mesff,$diafinalff) = explode("-",$mesUltimoDia);


$sql = "SELECT  o.copeven
,(SELECT COUNT(v.cvended) from vendedm v where v.tvended=f.tvended and v.copeven=o.copeven and v.cestado=1) as activo
,(SELECT COUNT(v.cvended) from vendedm v where v.tvended=f.tvended and v.copeven=o.copeven and v.cestado=0 and v.fretven!='' and v.fretven!='0000-00-00') as desactivo
,o.dopeven,o.ddiopve,f.dtipcap as vendedor,f.tvended,i.dinstit AS inst_vende,o.ctelefono,o.ccelular,f.cinstit,f.dinstit,sum(c0) total,o.ntelefo,sum(pago) pago
FROM opevena  o
INNER JOIN instita i ON i.cinstit=o.cinstit
INNER JOIN
    (
            SELECT o.copeven,v.cvended,i.cinstit,g.cpromot,v.fretven,i.dinstit,o.ctipcap,v.cestado,  o.ntelefo,
            count(IF(g.it=i.cinstit,g.ft,NULL)) c0,v.tvended,t.dtipcap,
            DATEDIFF(
                if(ifnull(fretven,'')<>'' and fretven<>'0000-00-00',fretven,'$mesUltimoDia'),
                if(fingven>'$mesPrimerDia',fingven,'$mesPrimerDia')
            )+1-
            (select count(*) faltas from venfala
                where cvended = v.cvended and cestado = 1 and diafalt between '$mesPrimerDia' and '$mesUltimoDia'
            ) as dlab
            ,v.codintv,v.fingven,
            (v.sueldo/$diafinalff)*
            (
                DATEDIFF(
                    if(ifnull(fretven,'')<>'' and fretven<>'0000-00-00',fretven,'$mesUltimoDia'),
                    if(fingven>'$mesPrimerDia',fingven,'$mesPrimerDia')
                )+1-
                (select count(*) faltas from venfala
                    where cvended = v.cvended and cestado = 1 and diafalt between '$mesPrimerDia' and '$mesUltimoDia'
                )
            ) - IFNULL(v.descto,0)  AS pago
            ,(select count(*) faltas from venfala
                where cvended = v.cvended and cestado = 1 and diafalt between '$mesPrimerDia' and '$mesUltimoDia'
            ) faltas
      FROM instita i
            INNER JOIN vendedm v
            INNER JOIN
                (
                SELECT dtipcap,didetip
                FROM tipcapa
                WHERE dclacap=2
                ) t ON t.didetip=v.tvended
            INNER JOIN opevena o ON o.copeven=v.copeven
      LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cpromot,f.dfilial,g.cfilial,g.cfilial ft,g.cinstit it,c.fmatric
             FROM conmatp c
                        INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
                        INNER JOIN filialm f ON f.cfilial=g.cfilial
            WHERE c.fmatric BETWEEN '$mesPrimerDia' and '$mesUltimoDia'
            GROUP BY c.cconmat
        ) g ON (g.cpromot=v.cvended AND g.ctipcap=o.ctipcap)
       WHERE i.cinstit IN ('$cinstit')
                        AND g.cfilial IN ('$cfilial')
            GROUP BY v.cvended,i.cinstit
            HAVING (v.cestado='1' or count(g.ft)>0 )
) f ON f.copeven=o.copeven
GROUP BY o.copeven,f.tvended,f.cinstit";

//exit($sql);
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql3="SELECT dinstit FROM instita  WHERE cinstit IN ('$cinstit') ORDER BY dinstit";
$cn->setQuery($sql3);
$rpt3=$cn->loadObjectList();

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
    ''
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
    $num = 'FA'.$dcolor;
    
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

$fila = 1;
$objPHPExcel->getActiveSheet()->setCellValue("A$fila","PRODUCCION DE VENDEDORES LIMA");
$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells("A1:J1");

$fila++;
$objPHPExcel->getActiveSheet()->setCellValue("B2","MES: " . strtoupper($meses[$_GET["mes"] + 1]));
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->mergeCells("B2:C2");

$fila++;
$objPHPExcel->getActiveSheet()->setCellValue("A3","FECHA: " . date("d/m/Y"));
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->mergeCells("A3:C3");


//agregando cabeceras
$cabeceraDoble= array('N°','SEDE','INST. QUE VENDE','VENDEDOR');
$grupos = array("COSTO POR ALUMNO", "PRODUCCION", "PROMEDIO");

$fila = 4;
$col = 0;
for($i = 0 ; $cabeceraDoble[$i] ; $i++) {
    $objPHPExcel->getActiveSheet()->setCellValue($az[$col].$fila,$cabeceraDoble[$i]);
    $objPHPExcel->getActiveSheet()->mergeCells($az[$col].$fila.":".$az[$col].($fila+1));
    $objPHPExcel->getActiveSheet()->getStyle($az[$col].$fila.":".$az[$col].($fila+1))->applyFromArray($styleAlignmentBold);
    /*AQUI FALTA EL AJUSTAR TEXTO*/
    $col++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(21);

$objPHPExcel->getActiveSheet()->setCellValue("E4", "PERSONAL");
$objPHPExcel->getActiveSheet()->mergeCells("E4:G4");
$objPHPExcel->getActiveSheet()->getStyle("E4:G4")->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->setCellValue("E5", "ACTIVO");
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle("E5")->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle("E5")->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("F5", "RETIRADO");
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle("F5")->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle("F5")->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("G5", "TOTAL");
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle("G5")->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle("G5")->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->setCellValue("H4", "EQUIPO");
$objPHPExcel->getActiveSheet()->mergeCells("H4:I4");
$objPHPExcel->getActiveSheet()->getStyle("H4:I4")->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->setCellValue("H5", "FIJOS");
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle("H5")->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle("H5")->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("I5", "CELULARES");
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle("I5")->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle("I5")->applyFromArray($styleAlignmentBold);


$col = 8; // I

//agregamos grupos
for ($i=0; $i < 3; $i++) {   // costo por alumno , produccion , promedio
    $colGrupoIni = ++$col;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$col].$fila, $grupos[$i]);
    $objPHPExcel->getActiveSheet()->setCellValue($az[$col].($fila + 1), "TOTAL");
    $objPHPExcel->getActiveSheet()->getColumnDimension($az[$col])->setWidth(5.6);
    $objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->getAlignment()->setTextRotation(90);
    $objPHPExcel->getActiveSheet()->getStyle($az[$col].$fila)->applyFromArray($styleAlignmentBold);

    foreach($rpt3 as $r){
        $col++;
        $objPHPExcel->getActiveSheet()->setCellValue($az[$col].($fila + 1), $r['dinstit']);
        $objPHPExcel->getActiveSheet()->getColumnDimension($az[$col])->setWidth(5.6);
        $objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->applyFromArray($styleAlignmentBold);

    }
    $objPHPExcel->getActiveSheet()->mergeCells($az[$colGrupoIni].$fila.":".$az[$col].$fila);
}
$col++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$col]."4", "PERSONAL");
$objPHPExcel->getActiveSheet()->mergeCells($az[$col]."4:".$az[($col+2)]."4");
$objPHPExcel->getActiveSheet()->setCellValue($az[$col].($fila + 1), "TELEFONO");
$objPHPExcel->getActiveSheet()->getColumnDimension($az[$col])->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->getAlignment()->setTextRotation(90);
$col++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$col].($fila + 1), "PLANILLA");
$objPHPExcel->getActiveSheet()->getColumnDimension($az[$col])->setWidth(5.6);
$objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->getAlignment()->setTextRotation(90);
$col++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$col].($fila + 1), "TOTAL");
$objPHPExcel->getActiveSheet()->getColumnDimension($az[$col])->setWidth(6.7);
$objPHPExcel->getActiveSheet()->getStyle($az[$col].($fila + 1))->getAlignment()->setTextRotation(90);


$fila = 6;
$posicionaz = 0;
$cont = 0;
$countrpt3=0;
$arrayFilas = array();
$colTotales = array();
foreach($rpt as $r){
    $posicionaz=0;
    $countrpt3++;

    if ($countrpt3 == 1) {
        $cont++;
    }
    $valorinicial="{fila}";
    $arrayFilas[$r['copeven']][$az[$posicionaz]] = $cont;
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['dopeven'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['inst_vende'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['vendedor'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['activo'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['desactivo'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = '=SUM(E'.$valorinicial.':F'.$valorinicial.")";
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['ctelefono'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['ccelular'];
    $azPlanilla = $az[($posicionaz + count($rpt3)*3 + 3 + 2)];
    $colTotales[] = $az[($posicionaz + 1)];
    for ($i = 0; $i <= count($rpt3); $i++) { // llenando costo por alumno
        $arrayFilas[$r['copeven']][$az[++$posicionaz]] = '=IFERROR('.$azPlanilla.$valorinicial.'/'.$az[($posicionaz + count($rpt3)*1 + 1)].$valorinicial.",0)";
    }

    //llenando produccion
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = '=SUM('.$az[($posicionaz+1)].$valorinicial.':'.$az[($posicionaz + count($rpt3)*1 )].$valorinicial.")";
    $colTotales[] = $az[$posicionaz];

    foreach ($rpt3 as $inst) {
        $posicionaz++;
        if ($inst["dinstit"] == $r["dinstit"]) {
            $arrayFilas[$r['copeven']][$az[$posicionaz]] = $r['total'];

        }
    }

    // promedio
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = '='.$az[($posicionaz - count($rpt3) - 1)].$valorinicial.'/'.($diafinalff*1);
    $colTotales[] = $az[$posicionaz];

    foreach ($rpt3 as $inst) {
        $arrayFilas[$r['copeven']][$az[++$posicionaz]] = '='.$az[($posicionaz - count($rpt3) - 1)].$valorinicial.'/'.$diafinalff;
    }

    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r['ntelefo'];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = $r["pago"];
    $arrayFilas[$r['copeven']][$az[++$posicionaz]] = "=SUM(".$az[$posicionaz-1].$valorinicial.":".$az[($posicionaz-2)]."$valorinicial)";

    if( $countrpt3==count($rpt3) ){
        $countrpt3=0;
    }
}


$valorinicial=5; // filas
foreach ($arrayFilas as $k1 => $v1) {
    $valorinicial++;
    $conteint = 0;
    foreach ($v1 as $columna => $valor) {
        $conteint ++;
        $objPHPExcel->getActiveSheet()->setCellValue($columna.$valorinicial, str_replace("{fila}", $valorinicial, $valor));
    }
}

$valorinicial++;
$posicionaz = 3;
for($i=0; $i <$conteint - 4 ; $i++) {
    $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, "=SUM(".$az[$posicionaz].($valorinicial -1).":".$az[$posicionaz]."6)");
    $objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("FFEBF1DE");
    $objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->applyFromArray($styleBold);

}

$objPHPExcel->getActiveSheet()->getStyle("A4:".$az[$posicionaz].($valorinicial-1))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle("E".$valorinicial.":".$az[$posicionaz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle("E5:".$az[$posicionaz]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("FFEBF1DE");
$objPHPExcel->getActiveSheet()->getStyle("E5:".$az[$posicionaz]."5")->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle("G6:G".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("FFEBF1DE");
$objPHPExcel->getActiveSheet()->getStyle("G6:G".$valorinicial)->applyFromArray($styleBold);

foreach($colTotales as $col){
    $objPHPExcel->getActiveSheet()->getStyle("$col"."6:$col".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("FFEBF1DE");
    $objPHPExcel->getActiveSheet()->getStyle("$col"."6:$col".$valorinicial)->applyFromArray($styleBold);

}

////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Reporte_Consolidado_Vendedor');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Consolidado_Vendedor_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
