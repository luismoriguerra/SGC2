<?php
/*conexion*/
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();  

//var_dump($datos);exit();
/** PHPExcel */
require_once '../../php/includes/phpexcel/Classes/PHPExcel.php';
require_once '../../php/includes/phpexcel/Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
//$objPHPExcel = PHPExcel_IOFactory::load("../../archivos/plantillas/PLANTILLACONFIGURACION.xls");//abro xls pq tuve problemas al abrir xlsx y esporto xlsx

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,15,25,39,15,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);


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
$styleBold= array(
	'font'    => array(
		'bold'      => true
	),
);
$styleAlignment= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleRigth= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
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



/* QUERYS*/
$cgrupo = $_GET["cgrupo"];
$seccion = $_GET["secc"];
$asistencia= ($_GET["asistencia"])?$_GET["asistencia"]:'';
//DATOS DEL GRUPO
$sql="
SELECT
(SELECT c.dtitulo from curricm as c where c.ccurric = g.ccurric) as curricula,
(select f.dfilial from filialm as f where f.cfilial = g.cfilial) as filial,
(select i.dinstit from instita as i where i.cinstit = g.cinstit) as institucion,
(select cc.dciclo from cicloa as cc where cc.cciclo = g.cciclo  ) as ciclo,
(select ca.dcarrer from carrerm ca where ca.ccarrer = g.ccarrer) as carrera,
(select t.dturno from turnoa as t where t.cturno = g.cturno ) as turno,
(select CONCAT	(h.hinici,'-',h.hfin) from horam as h where h.chora = g.chora) as hora,
(
select GROUP_CONCAT(d.dnemdia SEPARATOR '-')
				from diasm d
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0
) as dias,
esg.desgrpr as gestado,
g.*
from gracprp as g
left join esgrpra as esg on esg.cesgrpr = g.cesgrpr
where
g.cgracpr = '$cgrupo'
";
$cn->setQuery($sql);
$grupos=$cn->loadObjectList();

//DATA DE LAS CLASES DEL GRUPO
 $sql="
           select
CONCAT(finicio,'|',ffin) fgrupos
,DATE_FORMAT(now(),'%Y-%m-%d') fhoy
,if(finicio> now() , 0,1) estado
,cfrecue
from gracprp g where g.cgracpr = '$cgrupo';

        ";

        $cn->setQuery($sql);
        $data=$cn->loadObject();

        //OBTENIENDO LA FECHA DE LOS PRIMEROS 10 DIAS
        $fechas = $data->fgrupos;
        list($finicio,$ffin) = explode("|", $fechas);
        $data->finicio= $finicio;
        $fre = explode("-", $data->cfrecue);
        $dias = 0;
        $dfechas = array();
        while($dias < 15){

            $dd = date("w" , strtotime($finicio) );
            $dd++;
            if(in_array($dd, $fre)){
                $dias++;
                $dfechas[] = $finicio;
            }
            $fecha = date_create($finicio);
            date_add($fecha, date_interval_create_from_date_string('1 days'));
            $finicio = date_format($fecha, 'Y-m-d');


        }

        $data->ffin = $ffin;
        $data->fechas = $dfechas;

        $hoy = date("Y-m-d");
        $data->registrar = 0;
        foreach($dfechas as $i=>$v){
            if( $v == $hoy ){
                $clase = $i+1;
                $data->registrar = 1;
                break;
            }elseif(strtotime($v) > strtotime($hoy) ){
                 $clase = $i;
                 $data->registrar = 0;
                 break;
            }
        }

        $data->nroclase = $clase;
$asis_sql= "";
for($i = 0 ; $i<$clase;$i++){

    $asis_sql .=", ( select estasist from aluasist where idseing = s.id and fecha = '".$dfechas[$i]."' ) as dia$i";
}


//DATOS DE LOS ALUMNOS DEL GRUPO
$sql = "select s.*,
                CONCAT_WS(' ',p.dappape,p.dapmape,p.dnomper) nombres,
                CONCAT(p.ntelpe2,' | ',p.ntelper) telefono, i.dcodlib
                $asis_sql
                from seinggr s
                inner join personm p on p.cperson = s.cperson
                inner join ingalum i on (i.cingalu=s.cingalu)
                where s.cgrupo = '$cgrupo' and s.seccion = '$seccion'
                AND i.cestado='1'
				ORDER BY nombres";

$cn->setQuery($sql);
$alumnos=$cn->loadObjectList();


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Jorge Salcedo")
							 ->setLastModifiedBy("Jorge Salcedo")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

/* FORMATO DE IMPRESION*/
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

$pestana=0;
foreach($grupos as $grupo){ // Inicio de Recorrido
	if($pestana>0){
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex($pestana);
	}
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(85);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/imagen.png');
$objDrawing->setHeight(61);
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(0);
$objDrawing->setOffsetY(0);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->setActiveSheetIndex($pestana)
			->setCellValue('A2','INSTITUCION '.$grupo["institucion"])
			->setCellValue('A3','LOCAL DE ESTUDIO:'.$grupo["filial"])
                        ->setCellValue("A4","CARRERA: ".$grupo["carrera"])
			->setCellValue('D2','SEMESTRE/INICIO '.$grupo["csemaca"]." ".$grupo["cinicio"])
			->setCellValue('D3','FECHA INICIO:'.$grupo["finicio"])
                        ->setCellValue("P2","HORARIO: ".$grupo["dias"]." ".$grupo["hora"])
                        ->setCellValue("C1","REGISTRO DE ASISTENCIA")
                        ->setCellValue("G4","SECCION: $seccion")
			;
$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(45);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->mergeCells('C1:N1');
//DATOS DEL GRUPO
$objPHPExcel->getActiveSheet()->mergeCells('D2:N2');
$objPHPExcel->getActiveSheet()->mergeCells('D3:N3');
$objPHPExcel->getActiveSheet()->mergeCells('G4:N4');

//$objPHPExcel->getActiveSheet()->mergeCells('G2:N2');
//$objPHPExcel->getActiveSheet()->mergeCells('G3:N3');
$objPHPExcel->getActiveSheet()->mergeCells('P2:T3')
           ->getStyle("O2:T3")
            ->getAlignment()->setWrapText(true)
            ->applyFromArray($styleAlignmentBold) ;

$objPHPExcel->getActiveSheet()->getStyle("A2:T5")->applyFromArray($styleBold);

$excel =$objPHPExcel->getActiveSheet();
//CABECERA DE LA TABLA DE REGISTRO
$fila = 5;
$f = $fila;
$excel->setCellValue("A$f","Nro")
      ->setCellValue("B$f","CODIGO ALUMNO")
      ->setCellValue("C$f","APELLIDOS Y NOMBRES")
      ->setCellValue("D$f","CEL/TEL")
      ->setCellValue("E$f","1")
      ->setCellValue("F$f","2")
        ->setCellValue("G$f","3")
        ->setCellValue("H$f","4")
        ->setCellValue("I$f","5")
        ->setCellValue("J$f","6")
        ->setCellValue("K$f","7")
        ->setCellValue("L$f","8")
        ->setCellValue("M$f","9")
        ->setCellValue("N$f","10")
        ->setCellValue("O$f","11")
        ->setCellValue("P$f","12")
        ->setCellValue("Q$f","13")
        ->setCellValue("R$f","14")
        ->setCellValue("S$f","15")
        ->setCellValue("T$f","TOT")
        //->setCellValue("O$f",$sql)
        ;

$excel->getStyle("A$f:T$f")->applyFromArray($styleThinBlackBorderAllborders);
$excel->getColumnDimension("A")->setWidth(4);
$excel->getColumnDimension("B")->setWidth(17);
$excel->getColumnDimension("C")->setWidth(23);
$excel->getColumnDimension("D")->setWidth(15);
$excel->getColumnDimension("E")->setWidth(2);
$excel->getColumnDimension("F")->setWidth(2);
$excel->getColumnDimension("G")->setWidth(2);
$excel->getColumnDimension("H")->setWidth(2);
$excel->getColumnDimension("I")->setWidth(2);
$excel->getColumnDimension("J")->setWidth(2);
$excel->getColumnDimension("K")->setWidth(2);
$excel->getColumnDimension("L")->setWidth(2);
$excel->getColumnDimension("M")->setWidth(2);
$excel->getColumnDimension("N")->setWidth(3);
$excel->getColumnDimension("O")->setWidth(3);
$excel->getColumnDimension("P")->setWidth(3);
$excel->getColumnDimension("Q")->setWidth(3);
$excel->getColumnDimension("R")->setWidth(3);
$excel->getColumnDimension("S")->setWidth(3);
$excel->getColumnDimension("T")->setWidth(4);

//FILAS DE LOS ALUMNOS
$c=0;

foreach ($alumnos as $alu){
$f++;
$c++;
$excel->setCellValue("A$f",$c)
	  ->setCellValue("B$f",$alu["dcodlib"])
	  ->setCellValue("C$f", $alu["nombres"]);
$excel->setCellValue("D$f",$alu["telefono"]);
$excel->getStyle("A$f:T$f")->applyFromArray($styleThinBlackBorderAllborders);
//LLENAR ASISTENCIA
if($asistencia){
 $dias = array("E","F","G","H","I","J","K","L","M","N",'O','P','Q','R','S');
 for($A=0;$A < $clase;$A++){
  $asis = ($alu["dia$A"])?$alu["dia$A"] : 0 ;
  $excel->setCellValue( $dias[$A].$f,$asis);
 }
 $excel->setCellValue("T$f","=SUM(D$f:S$f)");
}



}//fin foreach
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($pestana);
$pestana++;
} // Fin FOR
//$objPHPExcel->getActiveSheet()->getStyle("F10:".$az[4+count($cab)].$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);



// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Asistencia_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>