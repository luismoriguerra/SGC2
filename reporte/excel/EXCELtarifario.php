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

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(3.5,18,9,32,14,11.6,7,2.9,11,5.3,5.3,6.6,6,6,11,5.9,5.9,5.9,5.9,5.9,5.9,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$fechas=" '".$_GET['fechini']."' AND '".$_GET['fechfin']."'";
$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);


$sql="  SELECT f.dfilial, i.dinstit, c.dcarrer, 
        (   
            SELECT GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
            FROM diasm d 
            WHERE FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0
        ) fre, CONCAT(h.hinici,' - ',h.hfin) as horario, g.csemaca,
        g.cinicio, g.finicio, g.nmetmat,g.nmetmin,
        (
        SELECT co.nprecio -- ,co.cfilial,co.cinstit,co.dconcep,co.fusuari
        FROM concepp co
        WHERE co.cctaing like '708.01'
        AND co.tinscri='O'
        AND co.cestado=1
        AND co.cfilial=g.cfilial
        AND co.cinstit=g.cinstit
        ORDER BY co.fusuari DESC,co.cfilial,co.cinstit
        LIMIT 1
        ) ins,
        (
        SELECT co.nprecio -- ,co.cfilial,co.cinstit,co.dconcep,co.fusuari
        FROM concepp co
        WHERE co.cctaing='701.01.01'
        AND co.tinscri='O'
        AND co.cestado=1
        AND co.cfilial=g.cfilial
        AND co.cinstit=g.cinstit
        ORDER BY co.fusuari DESC,co.cfilial,co.cinstit
        LIMIT 1
        ) mat,
        (
        SELECT co.nprecio -- ,co.cfilial,co.cinstit,co.dconcep,co.fusuari
        FROM concepp co
        WHERE co.cctaing LIKE '701.03%'
        AND co.tinscri='O'
        AND co.cestado=1
        AND co.ncuotas=1
        AND (co.ccarrer in (g.ccarrer))
        AND co.cfilial=g.cfilial
        AND co.cinstit=g.cinstit
        ORDER BY co.fusuari DESC,co.cfilial,co.cinstit
        LIMIT 1
        ) pen1
        ,MAX(CONCAT(cc.ccarrer,cc.fusuari,'|',cc.nprecio)) pen
        ,MAX(cr.ccuota) as duracion
        FROM gracprp g
        INNER JOIN cropaga cr ON (cr.cgruaca=g.cgracpr AND cr.ccuota>='5' AND cr.cestado='1')
        INNER JOIN concepp cc ON (cc.cconcep=cr.cconcep AND cc.cestado='1' AND (cc.ccarrer in (g.ccarrer)) )
        INNER JOIN filialm f ON f.cfilial=g.cfilial
        INNER JOIN instita i ON i.cinstit=g.cinstit
        INNER JOIN carrerm c ON c.ccarrer=g.ccarrer
        INNER JOIN horam h ON h.chora=g.chora
        WHERE g.cesgrpr='3'
        AND g.cfilial IN ('$cfilial')
        AND g.cinstit IN ('$cinstit')
        AND g.finicio BETWEEN $fechas
        GROUP BY g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
        ORDER BY f.dfilial,i.dinstit,c.dcarrer,fre";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql2="Select concat(dnomper,' ',dappape,' ',dapmape) as nombre
        FROM personm
        WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();

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
$styleThickBlackBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
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
$styleAlignmentLeft= array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
                             ->setTitle("Indice de Matriculacion para gerencia")
                             ->setSubject("Reporte IMG")
                             ->setDescription("Agiliza la toma de desiciones en los indice de matriculación realizadas según el filtro realizado.")
                             ->setKeywords("php")
                             ->setCategory("Reporte");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(false);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(89);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.7);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(0);


//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A2","TARIFARIO CONSORCIO EDUCATIVO TELESUP");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','LOCAL DE ESTUDIOS','INSTITUCION','CARRERA','FREC','HORARIO','PERIODO ACADEMICO','INICIO','FECHA INICIO','DURACIÓN','MAXIMA','MINIMO','NORMAL','PROMOCIÓN','NORMAL','PROMOCIÓN','NORMAL','CURSO O CICLO COMPLETO','DESCUENTO 20%','PRONTO PAGO DSCTO 20%');


    for($i=0;$i<count($cabecera);$i++){
    $objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6",$cabecera[$i]);    
        if($i>=6 or $i==2){
            $objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setTextRotation(90);
        }   
    $objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);    
    }
    $objPHPExcel->getActiveSheet()->getRowDimension("6")->setRowHeight(74.75); // altura
    //$objPHPExcel->getActiveSheet()->mergeCells('K5:L5');    

$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->setCellValue("B3","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D3",$rpt2[0]['nombre']);

$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->setCellValue("B4","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D4",date("Y-m-d"));

$objPHPExcel->getActiveSheet()->setCellValue("I4","GRUPOS PROGRAMADOS DEL:");
$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("J4",$_GET['fechini']);
$objPHPExcel->getActiveSheet()->setCellValue("L4","AL");
$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("M4",$_GET['fechfin']);

$objPHPExcel->getActiveSheet()->setCellValue("K5","META");
$objPHPExcel->getActiveSheet()->mergeCells('K5:L5');
$objPHPExcel->getActiveSheet()->setCellValue("M5","INSCRIP");
$objPHPExcel->getActiveSheet()->mergeCells('M5:N5');
$objPHPExcel->getActiveSheet()->setCellValue("O5","MATRICULA");
$objPHPExcel->getActiveSheet()->mergeCells('O5:P5');
$objPHPExcel->getActiveSheet()->setCellValue("Q5","PENSION");
$objPHPExcel->getActiveSheet()->mergeCells('Q5:T5');


$objPHPExcel->getActiveSheet()->getStyle('K5:T5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('K5:T5')->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A6:T6')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle("k5:T6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("A6:T6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
//$objPHPExcel->getActiveSheet()->getStyle("Q5:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F000'); 

$valorinicial=6;
$cont=0;
$total=0;
$pago="";
$fil="";
$cins="";
$frec="";
$hora="";
$concarrera=0;
$dcarrer='';
$sumatotal=array();

//Datos para validar cambio de Local/Intitucion/Carrera
$local_ini = "";
$inst_ini = "";
$car_ini = "";
$bloque_ini = $valorinicial;

foreach($rpt as $r){    

$precio=explode("|",$r['pen']);
$paz=0;
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dinstit']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dcarrer']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['fre']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['horario']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['csemaca']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['cinicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['finicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['duracion']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['nmetmat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['nmetmin']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['ins']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '0');$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['mat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '0');$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $precio[1]);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $precio[1]*$r['duracion']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $precio[1]*$r['duracion']*0.2);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, "=".$az[($paz-2)].$valorinicial."-".$az[($paz-1)].$valorinicial);

    if ($local_ini != $r['dfilial'] or $inst_ini != $r['dinstit'] or $car_ini != $r['dcarrer']){
        $local_ini = $r['dfilial'];
        $inst_ini = $r['dinstit'];
        $car_ini = $r['dcarrer'];
        $objPHPExcel->getActiveSheet()->getStyle("A".$bloque_ini.":T".($valorinicial-1))->applyFromArray($styleThinBlackBorderAllborders);
        $objPHPExcel->getActiveSheet()->getStyle("A".$bloque_ini.":T".($valorinicial-1))->applyFromArray($styleThickBlackBorderOutline);
        $bloque_ini = $valorinicial;
    }

}
$objPHPExcel->getActiveSheet()->getStyle("A".$bloque_ini.":T".$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle("A".$bloque_ini.":T".$valorinicial)->applyFromArray($styleThickBlackBorderOutline);

//$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[$paz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);

$objPHPExcel->getActiveSheet()->getStyle('K5:T5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('K5:T5')->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A6:T6')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle("k5:T6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("A6:T6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
//$objPHPExcel->getActiveSheet()->getStyle("Q5:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F000'); 
//$objPHPExcel->getActiveSheet()->getStyle('AA4:AA'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Tarifario');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Tarifario_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
