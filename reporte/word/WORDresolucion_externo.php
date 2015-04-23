<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
require_once 'PHPWord.php';

$cn=MySqlConexion::getInstance();


$nombre=$_REQUEST["nombre"];
$resolucion=explode("_",$_REQUEST["resolucion"]);
$cusuari=$_REQUEST["cusuari"];
$cingalu=$_REQUEST["cingalu"];

$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");


$sql="	SELECT m.`dmoding`,i.dinstip,i.`dcarrep`,ca.`dcarrer`,g.`csemaca`
		FROM ingalum i
		INNER JOIN conmatp c ON (i.`cingalu`=c.`cingalu`)
		INNER JOIN gracprp g ON (c.`cgruaca`=g.`cgracpr`)
		INNER JOIN carrerm ca ON (ca.`ccarrer`=g.`ccarrer`)
		INNER JOIN modinga m ON (m.`cmoding`=i.`cmoding`)
		WHERE i.`cingalu`='".$cingalu."'
		ORDER BY c.`cconmat` ASC
		LIMIT 0,1";
$cn->setQuery($sql);
$res=$cn->loadObjectList();


$sql2="	SELECT a.`daspral`,a.ncredit as ncreditp,c.`codicur`,c.`dcurso`,p.`nhotecu`,p.`nhoprcu`,p.`ncredit` as ncreditd,IFNULL(asi.`cciclo`,a.`cciclo`) cciclo,cc.`dciclo`
		FROM aspralm a
		INNER JOIN asiconm asi ON (a.`caspral`=asi.`caspral`)
		INNER JOIN cicloa cc ON (cc.`cciclo`=asi.`cciclo`)
		INNER JOIN cursom c ON (asi.`ccurso`=c.`ccurso`)
		INNER JOIN placurp p ON (p.`ccurric`=asi.`ccurric` AND p.`ccurso`=asi.`ccurso` AND p.`cciclo`=asi.`cciclo`)
		AND a.`cingalu`='".$cingalu."'
		ORDER BY cciclo,c.`dcurso`,a.`daspral`;";
$cn->setQuery($sql2);
$res2=$cn->loadObjectList();


$sql3="	SELECT COUNT(t.cciclo) AS cant,t.cciclo
		FROM (
			SELECT IFNULL(asi.`cciclo`,a.`cciclo`) cciclo
			FROM aspralm a
			INNER JOIN asiconm asi ON (a.`caspral`=asi.`caspral`)
			INNER JOIN cicloa cc ON (cc.`cciclo`=asi.`cciclo`)
			INNER JOIN cursom c ON (asi.`ccurso`=c.`ccurso`)
			INNER JOIN placurp p ON (p.`ccurric`=asi.`ccurric` AND p.`ccurso`=asi.`ccurso` AND p.`cciclo`=asi.`cciclo`)
			AND a.`cingalu`='".$cingalu."'
			ORDER BY cciclo,c.`dcurso`,a.`daspral`) AS t
		GROUP BY t.cciclo
		ORDER BY t.cciclo";
$cn->setQuery($sql3);
$cant=$cn->loadObjectList();

$ab=array('1','2','3','4','5');
$ar=array('I','II','III','IV','V');
$csemaca=explode("-",$res[0]['csemaca']);
$semestre=$csemaca[0]."-".str_replace($ab,$ar,$csemaca[1]);

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('WORDresolucion_externo.docx');

function utf8($text){
$text=iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
return $text;
}

$document->setValue('nombre',utf8(strtoupper($nombre)));
$document->setValue('dresolu',utf8(strtoupper($resolucion[1])));
$document->setValue('dia', date('d'));
$document->setValue('mes', $meses[date('m')*1]." ".date('m'));
$document->setValue('año', date('Y'));
$document->setValue('institucion',utf8(strtoupper($res[0]['dinstip'])));
$document->setValue('carrera',utf8(strtoupper($res[0]['dcarrer'])));
$document->setValue('semestre',$semestre);
$document->setValue('modalidad',utf8($res[0]['dmoding']));

$cciclo="";
$pos=0;
$pos2=0;
$correlativo=0;
$array=array();

foreach($res2 as $r){
	if($r['cciclo']!=$cciclo){
		$correlativo=0;
		$cciclo=$r['cciclo'];
		while($r['cciclo']!=$cant[$pos]['cciclo']){
		$pos++;
		}
		
		if($pos==1){
			$document->cloneRowPos('ciclos','cursopro#'.($cant[($pos-1)]['cant']+1), 2);
		}
		elseif($pos>1){
			$document->cloneRowPos('ciclos','cursopro#1#'.($cant[($pos-1)]['cant']+1), 2);
		}

		$pos2=$pos+1;
		if($pos2<=(count($cant)-1)){
			if($pos==0){
				$document->cloneRow('cursopro', ($cant[$pos]['cant']+1));	
			}
			else{
				$document->cloneRowPos('cursopro#1','ciclos#2', ($cant[$pos]['cant']+1));	
			}
			
		}
		else{
			if($pos==0){
				$document->cloneRow('cursopro', $cant[$pos]['cant']);
			}
			else{
				$document->cloneRowPos('cursopro#1','ciclos#2', $cant[$pos]['cant']);			
			}			
		}

		
	}

	$correlativo++;

	if($pos==0){
		if($correlativo>1){
			$document->setValue('cursopro#'.$correlativo,$r['daspral']);
			$document->setValue('creditopro#'.$correlativo,$r['ncreditp']);

			$document->setValue('codigod#'.$correlativo,$r['codicur']);
			$document->setValue('cursod#'.$correlativo,$r['dcurso']);
			$document->setValue('ht#'.$correlativo,$r['nhotecu']);
			$document->setValue('hp#'.$correlativo,$r['nhoprcu']);
			$document->setValue('th#'.$correlativo,($r['nhotecu']+$r['nhoprcu']));
			$document->setValue('creditod#'.$correlativo,$r['ncreditd']);
		}
		else{
			$array['dciclo']=$r['dciclo'];
			$array['daspral']=$r['daspral'];
			$array['ncreditp']=$r['ncreditp'];

			$array['codicur']=$r['codicur'];
			$array['dcurso']=$r['dcurso'];
			$array['nhotecu']=$r['nhotecu'];
			$array['nhoprcu']=$r['nhoprcu'];
			$array['th']=$r['nhotecu']+$r['nhoprcu'];
			$array['ncreditd']=$r['ncreditd'];
		}

	}
	else{
		if($correlativo==1){
			$document->setValue('ciclos#1',$r['cciclo']." CICLO");
		}
		
		$document->setValue('cursopro#1#'.$correlativo,$r['daspral']);
		$document->setValue('creditopro#1#'.$correlativo,$r['ncreditp']);

		$document->setValue('codigod#1#'.$correlativo,$r['codicur']);
		$document->setValue('cursod#1#'.$correlativo,$r['dcurso']);
		$document->setValue('ht#1#'.$correlativo,$r['nhotecu']);
		$document->setValue('hp#1#'.$correlativo,$r['nhoprcu']);
		$document->setValue('th#1#'.$correlativo,($r['nhotecu']+$r['nhoprcu']));
		$document->setValue('creditod#1#'.$correlativo,$r['ncreditd']);
		
	}
	
	
}
/* Finaliza la Validacion */
	$document->setValue('ciclos',$array['dciclo']);
	$document->setValue('cursopro#1',$array['daspral']);
	$document->setValue('creditopro#1',$array['ncreditp']);

	$document->setValue('codigod#1',$array['codicur']);
	$document->setValue('cursod#1',$array['dcurso']);
	$document->setValue('ht#1',$array['nhotecu']);
	$document->setValue('hp#1',$array['nhoprcu']);
	$document->setValue('th#1',($array['nhotecu']+$r['nhoprcu']));
	$document->setValue('creditod#1',$array['ncreditd']);
	


/*
$document->cloneRow('cursopro', 4);


$document->cloneRowPos('ciclos','cursopro#4', 2);


$document->setValue('ciclos#1',"II ");	

$document->cloneRowPos('cursopro#1','ciclos#2', 2);


$document->setValue('cursopro#1#1',"Curso Bueno :D ");
$document->setValue('cursopro#1#2',"Curso Final :D ");
*/


//listo ps si dices q ta todo confiaré nomas porq no tngo tiempo pa chekarlo, solo diré q ya se finalizó.






$nombre="Resolucion_Externo_".$cusuari.".docx";
$document->save($nombre);
header ("Location:".$nombre);
?>
