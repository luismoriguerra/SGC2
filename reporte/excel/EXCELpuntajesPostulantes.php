<?php
/*conexion*/
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
try {


//ini_set('xdebug.max_nesting_level', 1000000);
ini_set("memory_limit", "258M");
ini_set("max_execution_time", 300);
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$azcount=array(5,45,45,30,30,11,7,9,8,6,6,6,11,4,4,4,4,4,11,11,11,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,
    15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,
    15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,
    15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,
    15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,
    15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);
$letras=array(
    'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
// AUMENTAMOS LA CANTIDAD DE COLUMNAS
for ($i = 0; $letras[$i]; $i++) {
    for ($j = 0; $letras[$j]; $j++) {
        $az[] = $letras[$i].$letras[$j];
        $azcount[] = 15;
    }
}
    $cfilial = str_replace(",","','",$_GET['cfilial']);
    $cinstit=str_replace(",","','",$_GET['cinstit']);
    $fechini =$_GET['fechini'];
    $fechfin = $_GET['fechfin'];


    if($fechini !='' and $fechfin !=''){
        $filtro.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
    }

$sql = "select
				p.cpostul , p.cingalu , p.cgruaca , notaalu,notacar, postest , g.finicio
				,CONCAT(pe.dappape, ' ',pe.dapmape, ' ', pe.dnomper) nombre
				, ca.dcarrer carrera
				from postulm p
				inner join gracprp g on g.cgracpr = p.cgruaca
				inner join personm pe on pe.cperson = p.cperson
				inner join gracprp gr on gr.cgracpr = p.cgruaca
				inner join carrerm ca on ca.ccarrer = gr.ccarrer
				where 1 = 1
				AND g.cfilial in ('".$cfilial."')
				and g.cinstit in ('".$cinstit."')
				".$filtro."
				order by ca.dcarrer asc, pe.dappape asc";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();

date_default_timezone_set('America/Lima');


require_once 'includes/Classes/PHPExcel.php';
require_once 'includes/Classes/PHPExcel/Calculation.php';

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
$color = 'FFEBF1DE';
$colorVerde = "FFEBF1DE";

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


//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A1","REPORTE DE PUNTAJE DE POSTULANTES");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

// LLENANDO LAS CABECERAS
$cabecera=array('N°','CARRERA','POSTUALNTE', "POSTULANTE OBTENIDO","PUNTAJE MINIMO", "ESTADO");

$colActual = 0; // columna donde se agrega el nro
$filaActual = 6; // fila para cabeceras
$countGrupos = 0;

    for ($i = $colActual; $i < count($cabecera); $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue($az[$i].$filaActual,$cabecera[$i]);
//        $objPHPExcel->getActiveSheet()->getStyle($az[$i].$filaActual)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);

    }
    $objPHPExcel->getActiveSheet()->getStyle("A6:F6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("FFEBF1DE");

    $colActual = $i;

    $count = 0;
    foreach($rpt as $row) {
        $filaActual++;
        $count++;
        $objPHPExcel->getActiveSheet()->setCellValue("A".$filaActual,$count);
        $objPHPExcel->getActiveSheet()->setCellValue("B".$filaActual,$row["carrera"]);
        $objPHPExcel->getActiveSheet()->setCellValue("C".$filaActual,$row["nombre"]);
        $objPHPExcel->getActiveSheet()->setCellValue("D".$filaActual,$row["notaalu"]);
        $objPHPExcel->getActiveSheet()->setCellValue("E".$filaActual,$row["notacar"]);
        $objPHPExcel->getActiveSheet()->setCellValue("F".$filaActual,$row["postest"]);
    }

    $objPHPExcel->getActiveSheet()->getStyle("A6".":F$filaActual")->applyFromArray($styleThinBlackBorderAllborders);


////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Reporte_Consolidado_Masivo');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
PHPExcel_Calculation::getInstance()->cyclicFormulaCount = 1;

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Consolidado_Masivo_'.date("Y-m-d_H-i-s"). " - ".$nombreReporte .'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

} catch (Exception $e) {
print_r($e);
}
?>
