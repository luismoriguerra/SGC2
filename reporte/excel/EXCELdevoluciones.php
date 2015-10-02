<?php
/*conexion*/
set_time_limit(3000);
ini_set('memory_limit','512M');
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array(  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD'
,'AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH'
,'BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL'
,'CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP'
,'DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ','EA','EB','EC','ED','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU');
$azcount=array( 8,15,15,15,25,15,28,30,15,15,15,15,15,20,15,15,15,15,15,15,15,15,15,19,40,20,20,20,20,20,20,20,20,20,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cingalu=$_GET['cingalu'];
$cgracpr=$_GET['cgracpr'];
$cusuari=$_GET['usuario'];
$alumno="";

$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);


$fechini=$_GET['fechini'];
$fechfin=$_GET['fechfin'];

$where='';
$order=" ORDER BY f.dfilial, ins.dinstit, ca.dcarrer, p.dappape, p.dapmape, p.dnomper ";

if ($cfilial) {
    $where .= " and g.cfilial in ('".$cfilial."') ";
}
if ($cinstit) {
    $where .= " and g.cinstit in ('".$cinstit."') ";
}


if($fechini!='' and $fechfin!=''){
    $where .=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
}

$sql="select

p.dappape a
,p.dapmape b
,p.dnomper c
, it.dinstit d
, c.dcarrer e
, g.finicio f

, d.concept g
, DATE(d.fdocpag)  h
,d.cdocpag  i
,d.ctippag  j
,d.monpag  k


, dt.concepto l
, DATE(dt.fecbole) m
, dt.bolserie n
, dt.tipbolet o
, dt.monbole p

, d.pordesc  q
, d.descripc r
, f.dfilial s

from devoldet dt
left join devolucim d on d.gruaca = dt.cgruaca and dt.cingalu = d.codalu
left join gracprp g on g.cgracpr = dt.cgruaca
left join ingalum i on i.cingalu = dt.cingalu
left join personm p on p.cperson = i.cperson
left join instita it on it.cinstit = g.cinstit
left join carrerm c on c.ccarrer = g.ccarrer
left join filialm f on f.cfilial = g.cfilial
  where 1 = 1 ". $where;

$cn->setQuery($sql);
$control=$cn->loadObjectList();


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


$objPHPExcel->getActiveSheet()->setCellValue("A2","ANULACION DE COMPROBANTES  DE  PAGO  Y  DEVOLUCION DE DINERO");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleAlignmentBold);


// FORMATO DE CABEZAR
$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
$objPHPExcel->getActiveSheet()->mergeCells('C4:F4');
$objPHPExcel->getActiveSheet()->mergeCells('G4:K4');
$objPHPExcel->getActiveSheet()->mergeCells('L4:P4');
$objPHPExcel->getActiveSheet()->setCellValue("B4", "ALUMNO");
$objPHPExcel->getActiveSheet()->setCellValue("C4", "DATOS ACADEMICOS");
$objPHPExcel->getActiveSheet()->setCellValue("G4", "COMPROBANTE DE PAGOS EMITIDOS");
$objPHPExcel->getActiveSheet()->setCellValue("L4", "DEVOLUCION");


$objPHPExcel->getActiveSheet()->mergeCells('Q4:Q5');
$objPHPExcel->getActiveSheet()->mergeCells('R4:R5');


$cabecera=array('N°',"APELLIDOS Y NOMBRES", "ODE",
    "INST.", "CARRERA","FECHA DE INICIO",
    "CONCEPTO", "FECHA", "SERIE", "TIPO", "MONTO",
    "CONCEPTO", "FECHA", "SERIE", "TIPO", "MONTO",
    "DSCTO GASTOS ADMIN", "MOTIVO DE DEVOLUCION");

for($i=0;$i<count($cabecera);$i++){
    $objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);
    $objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
}

$objPHPExcel->getActiveSheet()->setCellValue("A4", "NRO");
$objPHPExcel->getActiveSheet()->setCellValue("Q4", "DSCTO GASTOS ADMINI");
$objPHPExcel->getActiveSheet()->getStyle("Q4")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("R4", "MOTIVO DE DEVOLUCION");
$objPHPExcel->getActiveSheet()->getStyle("R4")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A4:R5')->applyFromArray($styleAlignmentBold);
$pos=1;
$valorinicial=5;
$cont=0;
foreach($control As $r){
    $cont++;
    $valorinicial++; // INICIA EN 6
    $paz=0;

    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$cont);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['a'] ." ".$r['b']. " ".$r['c']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['s']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['d']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['e']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['f']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['g']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['h']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['i']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['j']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['k']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['l']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['m']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['n']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['o']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['p']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['q']);$paz++;
    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['r']);$paz++;


}
$objPHPExcel->getActiveSheet()->getStyle('A4:R'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Documentos');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DEVOLUCIONES'.date("Y-m-d_His").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>