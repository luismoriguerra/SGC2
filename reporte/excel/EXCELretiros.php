<?php
/*conexion*/
set_time_limit(3000);
ini_set('memory_limit','3072M');

//
//error_reporting(E_ALL);
//ini_set("display_errors", 1);


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

$sql="
  select
-- datos de identificacion
 f.dfilial ode
 -- ,'' estado
-- datos personales
,p.dappape ape
,p.dapmape mat
,p.dnomper nom
-- datos domiciliarios
,p.ntelper tel
,p.ntelpe2 tel2
,p.email1 mail
-- datos academicos
,it.dinstit ins
, IF(i.posbeca, 'SI','NO') posbeca
, mo.dmoding modin
, c.dcarrer car
, g.csemaca sem
, g.cinicio ini
, g.finicio fin
, m.dmodali modali
, ci.dciclo
,'' duracion
,f.dfilial local_estudio
,(select GROUP_CONCAT(d.dnemdia SEPARATOR '-')
				from diasm d
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',',')) ) frecuencia
,CONCAT_WS(' ',h.hinici,h.hfin) horario
-- datos asistencia
, IF((select max(estasist) asistio from aluasist where idseing=s.id), 'SI', 'NO') asistio
, s.seccion
-- dinero devuelto
, d.devoluc
, d.monretir
, DATE(d.fecretiro) fretiro
, d.descripc
from devolucim d
left join gracprp g on g.cgracpr=d.gruaca
left join filialm f on f.cfilial=g.cfilial
left join ingalum i on i.cingalu = d.codalu
left join personm p on p.cperson = i.cperson
left join instita it on it.cinstit = g.cinstit
left join carrerm c on c.ccarrer = g.ccarrer
left join modalim m on m.cmodali=g.cmodali
left join cicloa ci on ci.cciclo=g.cciclo
left join horam h on h.chora=g.chora
left JOIN seinggr s On (s.cgrupo = g.cgracpr and s.cingalu = i.cingalu)
inner join modinga mo on mo.cmoding = i.cmoding

where 1 = 1

 ". $where;

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

function colrow($az, $col, $row) {
    return $az[$col].$row;
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

// titulo principal
$az;
$row=1;
$col=0;
$objPHPExcel->getActiveSheet()->setCellValue(colrow($az, $col, $row) ,"REPORTE DE DEVOLUCIONES");
$objPHPExcel->getActiveSheet()->getStyle(colrow($az, $col, $row))->getFont()->setSize(12);

//$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
//$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleAlignmentBold);

// fila titulo cabecera

$cabecera = array(
    "DATOS DE INDENTIFICACION"=>array(
        "NRO",
        "CAJA - ODE - CENT. DE CAPTACION",
        //"ESTADO"
    ),
    "DATOS PERSONALES"=>array(
        "AP PATERNO",
        "AP MATERNO",
        "NOMBRES"
    ),
    "DATOS DOMICILIARIO"=>array(
        "TELEFONO",
        "CELULAR",
        "CORREO ELECTRONICO"
    ),
    "DATOS ACADEMICOS"=>array(
        "INSTITUCION",
        "SOLO POR BECA",
        "MOD INGRE",
        "CARRERA PROFESIONAL",
        "SEMESTRE",
        "INICIO",
        "FECHA INICIO",
        "MODAL",
        "CICLO / MODULO",
        "DURACION",
        "LOCAL DE ESTUDIO",
        "FRECUENCIA",
        "HORARIO",
    ),
    "DATOS DE ASISTENCIA"=>array(
        "ASISTIO",
        "SECCION",
    ),
    "DINERO DEVUELTO"=>array(
        "DINERO DEVUELTO",
        "MONTO DEVUELTO",
        "FECHA",
        "MOTIVO",
    ),
);
$row=2;
$col=0;

$colors = array(
    "FFDDD9C4",
    "FFC65911",
    "FFEBF1DE",
    "FF92D050",
    "FF8EA9DB",
    "FF3399FF",
);
$countColor = 0;
foreach($cabecera as $titulo => $subtitulos ) {
    foreach ($subtitulos as $tit) {
        $row = 3; // subtitulos siempre en el 3
        $objPHPExcel->getActiveSheet()->setCellValue(colrow($az, $col, $row), $tit);
        $objPHPExcel->getActiveSheet()->getStyle(colrow($az, $col, $row))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle(colrow($az, $col, $row))->applyFromArray($styleAlignmentBold);

        $col++;
    }
    $row--; // titulos principales simpre en el
    $countgroup = count($subtitulos);
    $gruColIni = $col - $countgroup;
    $objPHPExcel->getActiveSheet()->mergeCells(colrow($az, $gruColIni, $row) . ":" .  colrow($az, ($col - 1), $row));
    $objPHPExcel->getActiveSheet()->setCellValue(colrow($az, $gruColIni, $row), $titulo);
    $objPHPExcel->getActiveSheet()->getStyle(colrow($az, $gruColIni, $row), $titulo)->applyFromArray($styleAlignmentBold);
    $objPHPExcel->getActiveSheet()->getStyle(colrow($az, $gruColIni, $row) . ":" .  colrow($az, ($col - 1), ($row + 1)))
        ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($colors[$countColor]);
    $countColor++;

}

//final columna de todo el excel
$finalCol = $col - 1;


// estilos para el titulo principal
$objPHPExcel->getActiveSheet()->mergeCells(colrow($az, 0, 1) . ":" .  colrow($az, $finalCol, 1));
$objPHPExcel->getActiveSheet()->getStyle(colrow($az, 0, 1) . ":" .  colrow($az, $finalCol, 1))->applyFromArray($styleAlignmentBold);

// rows body del excel

$row = 3;
$col = 0;
$cont = 0;
foreach($control As $r){
    $row++; // INICIA EN 4
    $paz=0; // columna
    $cont++;

    $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$row,$cont); $paz++;
    foreach ($r as $value)  {
        $objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$row, $value); $paz++;

    }
}

$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[$finalCol].$row)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Retiros');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RETIROS'.date("Y-m-d_His").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>