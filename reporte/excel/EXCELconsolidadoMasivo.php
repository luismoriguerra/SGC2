<?php
/*conexion*/
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

ini_set("memory_limit", "128M");
ini_set("max_execution_time", 300);
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$azcount=array(5,24.5,9,9,11,11,7,9,8,6,6,6,11,4,4,4,4,4,11,11,11,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,
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

$cinstit=str_replace(",","','",$_GET['cinstit']);

$fechainicio =$_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-" . $_GET["ini"];
$fechafin = $_GET['anio'] . "-" . str_pad((int)$_GET["mes"] + 1 , 2, '0',STR_PAD_LEFT) . "-" . $_GET["fin"];

$diastotales = date("Y-m-d" , strtotime("+1 month",strtotime($fechainicio)));
$diastotales = date("d" , strtotime("-1 day",strtotime($diastotales)));

$ayer = date("Y-m-d" , strtotime("-1 day",strtotime($fechafin)));
$anteayer = date("Y-m-d" , strtotime("-2 day",strtotime($fechafin)));

$diaspromedio=explode("-",$fechafin);

/*
$sql="   SELECT t.dtipcap,t.ctipcap,m.dmedpre,
            count(g.ft) c0
            ,count(g.f1) c1
            ,count(g.f2) c2
        FROM tipcapa t
        INNER JOIN medprea m ON (t.didetip=m.tmedpre)
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cmedpre,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,           
            c.fmatric
            ,g2.cfilial f1,g2.cinstit i1
            ,g3.cfilial f2,g3.cinstit i2
            FROM conmatp c
            INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN recacap r  ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca)
            INNER JOIN concepp co ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
            INNER JOIN filialm f ON f.cfilial=g.cfilial

            LEFT JOIN conmatp c2 ON (c2.cconmat=c.cconmat AND c2.fmatric='$ayer')
            LEFT JOIN gracprp g2 ON g2.cgracpr=c2.cgruaca
            LEFT JOIN conmatp c3 ON (c3.cconmat=c.cconmat AND c3.fmatric='$anteayer')
            LEFT JOIN gracprp g3 ON g3.cgracpr=c3.cgruaca

            WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
            GROUP BY c.cconmat
        ) g ON (g.ctipcap=t.ctipcap AND m.cmedpre=g.cmedpre)
        WHERE t.dclacap=3
        GROUP BY t.dtipcap,m.dmedpre
        ORDER BY t.dtipcap,m.dmedpre
";
*/

    //***************/
        // query dinamico
$sql_dias = "";
$sql_dias_column = "";
$sql_column_count = "";
$query1 = "";
$query2 = "";
$cantidadDias = $_GET["fin"] - $_GET["ini"] + 1;
for ($i = 0; $i < $cantidadDias ; $i++) {
    $cam = $i + 1;
    $dia = date("Y-m-d" , strtotime("-$i day",strtotime($fechafin)));
    $sql_dias .="
        LEFT JOIN conmatp c$i ON (c$i.cconmat=c.cconmat AND c$i.fmatric='$dia')
        LEFT JOIN gracprp g$i ON g$i.cgracpr=c$i.cgruaca ";
    $sql_dias_column .=" ,g$i.cfilial f$cam, g$i.cinstit i$cam ";
    $sql_column_count .= " ,count(g.f$cam) c$cam ";
    if( $i <=  20) {
        $query1 = "

            SELECT t.dtipcap,t.ctipcap,m.dmedpre,i.cinstit,i.dinstit
            ,count(g.ft) c0
            $sql_column_count
        FROM tipcapa t
        INNER JOIN medprea m ON (t.didetip=m.tmedpre)
        INNER JOIN instita i
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cmedpre,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,
            c.fmatric
           $sql_dias_column
            FROM conmatp c
            INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN recacap r  ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca)
            INNER JOIN concepp co ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
            INNER JOIN filialm f ON f.cfilial=g.cfilial
            $sql_dias
            WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
            GROUP BY c.cconmat
        ) g ON (g.ctipcap=t.ctipcap AND m.cmedpre=g.cmedpre AND i.cinstit=g.it)
        WHERE t.dclacap=3
        AND i.cinstit IN ('$cinstit')
        GROUP BY t.dtipcap,m.dmedpre,i.cinstit
        ORDER BY t.dtipcap,m.dmedpre,i.dinstit
        ";
        if ($i == 20) {
            $sql_dias = "";
            $sql_dias_column = "";
            $sql_column_count = "";
        }
    } elseif ($i < 40) {
        $query2 = "

            SELECT t.dtipcap,t.ctipcap,m.dmedpre,i.cinstit,i.dinstit,
            count(g.ft) c0
            $sql_column_count
        FROM tipcapa t
        INNER JOIN medprea m ON (t.didetip=m.tmedpre)
        INNER JOIN instita i
        LEFT JOIN
        (
            SELECT c.cconmat,i.ctipcap,i.cmedpre,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,
            c.fmatric
           $sql_dias_column
            FROM conmatp c
            INNER JOIN ingalum i ON c.cingalu=i.cingalu
            INNER JOIN recacap r  ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca)
            INNER JOIN concepp co ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
            INNER JOIN filialm f ON f.cfilial=g.cfilial
            $sql_dias
            WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
            GROUP BY c.cconmat
        ) g ON (g.ctipcap=t.ctipcap AND m.cmedpre=g.cmedpre AND i.cinstit=g.it)
        WHERE t.dclacap=3
         AND i.cinstit IN ('$cinstit')
        GROUP BY t.dtipcap,m.dmedpre,i.cinstit
        ORDER BY t.dtipcap,m.dmedpre,i.dinstit
        ";
    }



}

$sql = " select * from ($query1) q1 ";
if ($query2) {	$sql.= " inner join	($query2) q2 ON q2.dtipcap=q1.dtipcap AND q2.dmedpre=q1.dmedpre AND q2.dinstit=q1.dinstit ";}
$sql .= " order BY q1.dtipcap,q1.dmedpre,q1.dinstit  ";


/********/


//$sql="   SELECT t.dtipcap,t.ctipcap,m.dmedpre,
//            count(g.ft) c0
//            $sql_column_count
//        FROM tipcapa t
//        INNER JOIN medprea m ON (t.didetip=m.tmedpre)
//        LEFT JOIN
//        (
//            SELECT c.cconmat,i.ctipcap,i.cmedpre,i.cpromot,f.dfilial,g.cfilial ft,g.cinstit it,
//            c.fmatric
//           $sql_dias_column
//            FROM conmatp c
//            INNER JOIN ingalum i ON c.cingalu=i.cingalu
//            INNER JOIN recacap r  ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca)
//            INNER JOIN concepp co ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
//            INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
//            INNER JOIN filialm f ON f.cfilial=g.cfilial
//            $sql_dias
//            WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
//            GROUP BY c.cconmat
//        ) g ON (g.ctipcap=t.ctipcap AND m.cmedpre=g.cmedpre)
//        WHERE t.dclacap=3
//        GROUP BY t.dtipcap,m.dmedpre
//        ORDER BY t.dtipcap,m.dmedpre
//";




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
$color = 'FFEBF1DE';

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
$objPHPExcel->getActiveSheet()->setCellValue("A2","CONSOLIDADO MASIVO");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);

// LLENANDO LAS CABECERAS
$cabecera=array('N°','TIPO','CAPTACION');

$colActual = 0; // columna donde se agrega el nro
$filaActual = 6; // fila para cabeceras
$countGrupos = 0;
// corre toda la cantida de dias  + una vuelta mas para consolidado
for ($i=0; $i <= $cantidadDias * 1; $i++) {
    array_push($cabecera, 'TOTAL');
    // instituciones
    foreach($rpt3 as $r){
        array_push($cabecera, $r['dinstit']);
    }
}
    for ($i = $colActual; $i < count($cabecera); $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue($az[$i].$filaActual,$cabecera[$i]);
        $objPHPExcel->getActiveSheet()->getStyle($az[$i].$filaActual)->getAlignment()->setWrapText(true);
        if ($i > 2) { // a partir de los totales
            $objPHPExcel->getActiveSheet()->getStyle($az[$i].$filaActual)->getAlignment()->setTextRotation(90);
        }
        // agregar cabecera principal
        if ($cabecera[$i] == "TOTAL" || $i + 1 == count($cabecera)) { // entraren cada columna cabecera y en la columna final tambien
            $countGrupos++;
            $colInicioGrupoAnterior = $colInicioGrupo;
            $colInicioGrupo = $i;
            if ($countGrupos == 2) { // si va a empezar el segundo grupo , agrego la cabecera principal al primero
                $objPHPExcel->getActiveSheet()->setCellValue($az[$colInicioGrupoAnterior].($filaActual - 1) , 'CONSOLIDADO');
                $objPHPExcel->getActiveSheet()->mergeCells($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i - 1)].($filaActual - 1));
            } else if ($countGrupos > 2 && $i + 1 != count($cabecera) ) { // si va a empezar el segundo grupo , agrego la cabecera principal al primero
                $fechaGrupo = date("Y-m-d" , strtotime("-".($countGrupos - 1)." day",strtotime($fechafin)));
                $objPHPExcel->getActiveSheet()->setCellValue($az[$colInicioGrupoAnterior].($filaActual - 1) , $fechaGrupo);
                $objPHPExcel->getActiveSheet()->mergeCells($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i - 1)].($filaActual - 1));

                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i - 1)].($filaActual - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual).":".$az[($i - 1)].($filaActual))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i - 1)].($filaActual - 1))->applyFromArray($styleThinBlackBorderAllborders);

            } else if ( $i + 1 == count($cabecera) ) { // para el grupo final
                $fechaGrupo = date("Y-m-d" , strtotime("-".($countGrupos - 1)." day",strtotime($fechafin)));
                $objPHPExcel->getActiveSheet()->setCellValue($az[$colInicioGrupoAnterior].($filaActual - 1) , $fechaGrupo);
                $objPHPExcel->getActiveSheet()->mergeCells($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i)].($filaActual - 1));

                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i)].($filaActual - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual).":".$az[($i)].($filaActual))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
                $objPHPExcel->getActiveSheet()->getStyle($az[$colInicioGrupoAnterior].($filaActual - 1).":".$az[($i)].($filaActual - 1))->applyFromArray($styleThinBlackBorderAllborders);

            }
        }



    }
    $colActual = $i;



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

// reinicio de fila contadores
$fila=6; // filas
$row=0;
$posicionaz=0;  //$colActual
$countrpt3=0; // contador de  instituciones
$actualCaptacion = "";
$colAcuInicio = 3;
$actualMedio = "";
$contadorCaptacion = 0;
$filasTotales = [];
foreach($rpt as $r){
    if ($actualMedio != $r['dtipcap']) {
        $actualMedio = $r['dtipcap'];
        if ($fila != 6) {
            $fila++;
            array_push($filasTotales,$fila);
            $posicionaz = $colAcuInicio;
            for ($i = 0; $i <= $cantidadDias; $i++) {
                for ($j = -1; $j < count($rpt3); $j++) {
                    $ubicacionFinalGrupo = $az[$posicionaz].($fila*1 - 1);
                    $ubicacionInicialGrupo = $az[$posicionaz].($fila*1 - $contadorCaptacion);
                    $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$fila, "=SUM($ubicacionInicialGrupo:$ubicacionFinalGrupo)");
                    $posicionaz++;
                }
            }
            $objPHPExcel->getActiveSheet()->getStyle("A$fila:".$az[$posicionaz - 1].$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
            // reiniciamos el contador de captacion
            $contadorCaptacion = 0;

        }
    }

    if ($actualCaptacion != $r['dmedpre']) {
        $actualCaptacion = $r['dmedpre'];
        $fila++;
        $contadorCaptacion++;
        $posicionaz=0;
        $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz++].$fila, ++$row);
        $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz++].$fila, $r['dtipcap']);
        $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz++].$fila, $r['dmedpre']);
    } else {
        //cuando sigue siendo el mismo tipo de captacion se debe acutalizar la misma fila y desde la inicio de la columna dinamico
        $posicionaz = $colAcuInicio;
    }

    // colocamos columnas de acumulados por institucion
    for ($i = 0; $i <= $cantidadDias; $i++) {
        for ($j = -1; $j < count($rpt3); $j++) {
            $ubicacionActual = $az[$posicionaz].$fila;
            if ($j == -1) { // columna sumatoria
                $ubicacionInicialGrupo = $az[$posicionaz + 1].$fila;
                $ubicacionFinalGrupo = $az[$posicionaz + count($rpt3)].$fila;
                $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$fila, "=SUM($ubicacionInicialGrupo:$ubicacionFinalGrupo)");
            }

            if ($rpt3[$j]["dinstit"] == $r["dinstit"]) {
                $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$fila, $r['c'.$i]);
            }
            $posicionaz++;
        }
    }
}
// GENERANDO LAS 2 ULTIMAS LINEAS DEL ACUMULADO
$fila++;
array_push($filasTotales,$fila);
$posicionaz = $colAcuInicio;
for ($i = 0; $i <= $cantidadDias; $i++) {
    for ($j = -1; $j < count($rpt3); $j++) {
        $ubicacionFinalGrupo = $az[$posicionaz].($fila*1 - 1);
        $ubicacionInicialGrupo = $az[$posicionaz].($fila*1 - $contadorCaptacion);
        $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$fila, "=SUM($ubicacionInicialGrupo:$ubicacionFinalGrupo)");
        $posicionaz++;
    }
}
$objPHPExcel->getActiveSheet()->getStyle("A$fila:".$az[$posicionaz - 1].$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);


// TOTAL GENERAL
$fila+=2;
$posicionaz = $colAcuInicio;
$objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz -1 ].$fila, "TOTALES");
for ($i = 0; $i <= $cantidadDias; $i++) {
    for ($j = -1; $j < count($rpt3); $j++) {
        $CampoAcululado = array();
        foreach ($filasTotales as $totalFila) {
            $CampoAcululado[] = $az[$posicionaz].$totalFila;
        }
        $objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$fila, "=".implode("+",$CampoAcululado)."");
        $posicionaz++;
    }
}
$objPHPExcel->getActiveSheet()->getStyle("C$fila:".$az[$posicionaz - 1].$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);


$objPHPExcel->getActiveSheet()->getStyle($az['0']."6:".$az[($posicionaz-1)].($fila))->applyFromArray($styleThinBlackBorderAllborders);
//$objPHPExcel->getActiveSheet()->getStyle($az[$iniciadinamica].$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleBold);

////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Reporte_Consolidado_Masivo');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Consolidado_Masivo_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
