<?php

/* conexion */
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/* crea obj conexion */
require_once 'PHPWord.php';

$cn = MySqlConexion::getInstance();


/* QUERYS */
$cgracpr = $_GET['cgracpr'];
$cingalu = $_GET['cingalu'];
$semestre = $_GET['csemaca'];
$cfilial = $_GET['cfilial'];
$cinstit = $_GET['cinstit'];
$alumno = "";

if (trim($cingalu) != "") {
  $listAlum = str_replace(",", "','", $cingalu);
  $alumno = " AND co.cingalu in ('" . $listAlum . "')";
}

$sql = "	Select i.cingalu,ins.durllog,fi.dfilial,i.dcoduni,replace(i.dcodlib,'-','') as dcodlib,co.cconmat,gr.csemaca,ca.dcarrer,ca.durlcam,pe.dnomper,pe.dappape,pe.dapmape,ci.dciclo,
		GROUP_CONCAT(concat(
			cu.codicur,'|',cu.dcurso,'|',dg.ncredit) SEPARATOR '^^') as cursos,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '701.01%' or co.cctaing like '701.02%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as matricula_fecha,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '708%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as inscripcion,
		(select GROUP_CONCAT(concat(cr.ccuota,'|',cr.fvencim,'|',IF(con.ctaprom>=cr.ccuota,con.mtoprom,con.nprecio)) SEPARATOR '^^') as pagos
		from cropaga cr		
		INNER JOIN concepp con on (con.cconcep=cr.cconcep)		
		where cr.cconcep in 
			( Select rr.cconcep
			FROM recacap rr
			INNER JOIN concepp con2 on (con2.cconcep=rr.cconcep)		
			WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
			and con2.cctaing like '701.03%'
			and rr.testfin in ('C','P')
			)
		and cr.cgruaca=co.cgruaca
		GROUP BY cr.cgruaca,cr.cconcep) as pension,fi.dfilial,gr.finicio,fi.ddirfil,fi2.dfilial as dfilial_est,
		concat(fi2.ddirfil,' | Tel/cel: ',fi2.ntelfil) as direccion_estudio
		from ingalum i
		INNER JOIN postulm po ON (po.cingalu=i.cingalu and po.cperson=i.cperson)
		INNER JOIN filialm fi2 ON (fi2.cfilial=po.cfilial)
		INNER JOIN filialm fi ON (fi.cfilial=i.cfilial)
		INNER JOIN conmatp co ON (i.cingalu=co.cingalu)
		INNER JOIN personm pe ON (pe.cperson=i.cperson)
		INNER JOIN gracprp gr ON (gr.cgracpr=co.cgruaca)
		INNER JOIN instita ins on (ins.cinstit=gr.cinstit)
		LEFT JOIN cuprprp dg ON (dg.cgracpr=gr.cgracpr)
		LEFT JOIN cursom cu ON (cu.ccurso=dg.ccurso)
		INNER JOIN cicloa ci ON (ci.cciclo=gr.cciclo)
		INNER JOIN carrerm ca ON (ca.ccarrer=gr.ccarrer)
		where co.cgruaca in ('" . str_replace(",", "','", $cgracpr) . "')	
		" . $alumno . "
		GROUP BY co.cingalu,co.cgruaca";
$cn->setQuery($sql);
$alumno = $cn->loadObjectList();

// print json_encode($alumno);
// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();


foreach ($alumno as $rs) { // Inicio de Recorrido
  $detfechamatric = explode("|", $rs['matricula_fecha']);
  $rs['matricula'] = $detfechamatric[0];
  $rs['fecha_matric'] = $detfechamatric[1];
  $detfechainscrip = explode("|", $rs['inscripcion']);
  $monto_inscripcion = $detfechainscrip[0];
  $fecha_inscripcion = $detfechainscrip[1];



  $section->addText('CONSTANCIA DE PRE-MATRICULA', array('bold' => true, 'size' => 11, 'name' => 'Calibri',), array('align' => 'center'));
  $section->addText('', array('bold' => true, 'size' => 10, 'name' => 'Calibri',), array('align' => 'center'));
  $section->addText('CODIGO					:' . $rs['dcodlib'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('APELLIDOS Y NOMBRE				:' . $rs['dnomper'] . " " . $rs['dappape'] . " " . $rs['dapmape'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('LOCAL DE ESTUDIOS				:' . $rs['dfilial'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('CARRERA PROFESIONAL			:' . $rs['dcarrer'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('FECHA DE MATRICULA				:' . $rs['fecha_matric'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('FECHA DE INICIO DE CLASES			:' . $rs['finicio'], array('bold' => true, 'size' => 10, 'name' => 'Calibri',));
  $section->addText('', array('bold' => true, 'size' => 10, 'name' => 'Calibri',), array('align' => 'center'));

  $dcursos = explode("^^", $rs['cursos']);
  $detcic = explode(" ", $rs['dciclo']);


  if (trim($rs['cursos']) == "") {
    
  } else {
    $debug = 1;
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(2000)->addText("PROGRAMACION ACADEMICA ".$rs["csemaca"]);
    $table->addRow();
      // Add cells
      $table->addCell(500)->addText("CICLO");
      $table->addCell(500)->addText("CODIG");
      $table->addCell(2000)->addText("ASIG");
      $table->addCell(500)->addText("CRED");
      //SUMA TOTAL DE CREDITOS AL FINAL DE LA TABLA
      $credito = 0;
    for ($i = 11; $i < (11 + count($dcursos)); $i++) { //Antiguo era hasta el 16
      $ddc = explode("|", $dcursos[($i - 11)]);
      
      $table->addRow();
      // Add cells
      $table->addCell(500)->addText($detcic[0]);
      $table->addCell(500)->addText($ddc[0]);
      $table->addCell(2000)->addText($ddc[1]);
      $table->addCell(500)->addText($ddc[2]);
      $credito += $ddc[2];
    }
    $table->addRow();
      // Add cells
      $table->addCell(3000)->addText("TOTAL CREDITOS");
      $table->addCell(500)->addText($credito); 
  } // FIN TABLA CURSOS
  $debug = 1;
  //PAGOS PARA LA MATRICULA
  $table = $section->addTable();
    $table->addRow();
    $table->addCell(2000)->addText("PAGOS PARA LA MATRICULA ");
    $table->addRow();
      // Add cells
      $table->addCell(500)->addText("CONCEPTOS");
      $table->addCell(500)->addText("FECHAS");
      $table->addCell(2000)->addText("IMPORTE");
  $table->addRow();
      // Add cells
      $table->addCell(500)->addText("Inscripción");
      $table->addCell(500)->addText("FECHAS");
      $table->addCell(2000)->addText("IMPORTE");
  $table->addRow();
      // Add cells
      $table->addCell(500)->addText("Derecho de Matrícula");
      $table->addCell(500)->addText("FECHAS");
      $table->addCell(2000)->addText("IMPORTE");
  $table->addRow();
      // Add cells
      $table->addCell(500)->addText("Pensión de la Carrera");
      $table->addCell(500)->addText("FECHAS");
      $table->addCell(2000)->addText("IMPORTE");    
      
      
  
}//FIN ALUMNOS





$nombre = 'PreMatricula.docx';
// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombre . '"');
header('Cache-Control: max-age=0');

$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('php://output');
exit;
?>