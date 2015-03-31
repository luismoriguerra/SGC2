<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,24.5,24.5,5.5,5.5,5.5,5.5,5.5,5.5,7.5,5.5,5.5,5.5,5.5,5.5,5.5,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$fechafin = $_GET['fmatric'];
$pago= $_GET['pago'];
$fechainicio = date("Y-m-01" , strtotime($fechafin));
$diastotales = date("Y-m-d" , strtotime("+1 month",strtotime($fechainicio)));
$diastotales = date("d" , strtotime("-1 day",strtotime($diastotales)));

$ayer = date("Y-m-d" , strtotime("-1 day",strtotime($fechafin)));
$anteayer = date("Y-m-d" , strtotime("-2 day",strtotime($fechafin)));

$diaspromedio=explode("-",$_GET['fmatric']);

$sql="  SELECT o.copeven,o.dopeven,t.dtipcap,o.ctipcap,COUNT(IF(v.cestado=1,V.cestado,NULL)) estado1,COUNT(IF(v.cestado=0,V.cestado,NULL)) estado0,
            count(v.cvended) totalv,o.ntelefo telefono,o.ncelula celular,(o.ntelefo+o.ncelula) totalc,count(g.ft) c0,count(g.f1) c1,
            count(g.f2) c2,(count(g.ft)/17) promedio
        FROM opevena o 
        INNER JOIN tipcapa t ON (t.ctipcap=o.ctipcap AND t.dclacap=2 AND t.cestado=1)
        LEFT JOIN vendedm v ON o.copeven=v.copeven
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,           
            c.fmatric,g2.cfilial f1,g2.cinstit i1,g3.cfilial f2,g3.cinstit i2
            FROM conmatp c
                        INNER JOIN ingalum i ON c.cingalu=i.cingalu 
            INNER JOIN recacap r 
                ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca 
                        AND r.ccuota='1' AND r.testfin!='F' 
                        AND (r.testfin IN ('P','C') 
                                    OR (r.testfin='S' AND r.tdocpag!='')
                                )
                        )
            INNER JOIN concepp co 
                ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
                        INNER JOIN filialm f ON f.cfilial=g.cfilial
            LEFT JOIN conmatp c2 ON (c2.cconmat=c.cconmat AND c2.fmatric='$ayer')
            LEFT JOIN gracprp g2 ON g2.cgracpr=c2.cgruaca
            LEFT JOIN conmatp c3 ON (c3.cconmat=c.cconmat AND c3.fmatric='$anteayer')
            LEFT JOIN gracprp g3 ON g3.cgracpr=c3.cgruaca
            WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
            GROUP BY c.cconmat
            HAVING MIN(r.tdocpag)!=''
        ) g ON (g.cpromot=v.cvended AND g.ctipcap=o.ctipcap)
        WHERE o.cestado=1
        GROUP BY o.copeven,o.ctipcap
        ORDER BY o.dopeven,t.dtipcap
";
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
*/
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
/*
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/images/logohdec.jpg');
$objDrawing->setHeight(40);
$objDrawing->setCoordinates('A2');
$objDrawing->setOffsetX(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
*/

//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A2","CONSOLIDADO VENDEDOR");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);


$cabecera=array('N°','SEDE','VENDEDOR','ACTIVO','RETIRADO','TOTAL','FIJOS','CELULAR','TOTAL MATRICULA','PPROMEDIO DIARIO');
$iniciadinamica=11;
$cantidadaz=$iniciadinamica-1;

    for($i=0;$i<count($cabecera);$i++){
    $objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6",$cabecera[$i]);    
        if($i>=3){
            $objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setTextRotation(90);
        }
    $objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
    }

$objPHPExcel->getActiveSheet()->mergeCells('A2:'.$az[($i-1)].'2');
$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->getRowDimension("5")->setRowHeight(23); // altura
$objPHPExcel->getActiveSheet()->getRowDimension("6")->setRowHeight(66.5); // altura
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($i-1)].'6')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->setCellValue("B3","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D3",$rpt2[0]['nombre']);

$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->setCellValue("B4","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D4",date("Y-m-d"));

//$objPHPExcel->getActiveSheet()->mergeCells('L4');
$objPHPExcel->getActiveSheet()->setCellValue("B5","FECHA MATRÍCULA \n".$fechafin);
$objPHPExcel->getActiveSheet()->getStyle("B5")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->setCellValue("D5","PERSONAL");
$objPHPExcel->getActiveSheet()->mergeCells("D5:F5");
$objPHPExcel->getActiveSheet()->getStyle("D5:F5")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->setCellValue("G5","TELEFONO");
$objPHPExcel->getActiveSheet()->mergeCells("G5:H5");
$objPHPExcel->getActiveSheet()->getStyle("G5:H5")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->setCellValue("I5","PRODUCCION");
$objPHPExcel->getActiveSheet()->mergeCells("I5:J5");
$objPHPExcel->getActiveSheet()->getStyle("I5:J5")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D5:J5')->applyFromArray($styleThinBlackBorderAllborders);


$valorinicial=7;
$cont=0;
$posicionaz=0;


foreach($rpt as $r){
    $cont++;
    $posicionaz=0;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $cont); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['dopeven']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['dtipcap']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['estado1']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['estado0']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['totalv']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['telefono']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['celular']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['c0']); $posicionaz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['promedio']); $posicionaz++;
    $valorinicial++;
}

$objPHPExcel->getActiveSheet()->getStyle($az['0']."6:".$az[($posicionaz-1)].($valorinicial-1))->applyFromArray($styleThinBlackBorderAllborders);
//$objPHPExcel->getActiveSheet()->getStyle($az[$iniciadinamica].$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleBold);

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
