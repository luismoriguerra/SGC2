<?php
session_start();
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();



// Redirect output to a client's web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="Pre_Matricula_'.date("Y-m-d_H-i-s").'.xlsx"');
//header('Cache-Control: max-age=0');
//
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ListadoAlumnos_'.date("Y-m-d_H-i-s").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");


//query inicial

//validando data que ingresa con la data que deberia recibir
$_SESSION["cod_filial"] = $_REQUEST['mfiliales'];

$_SESSION["cod_perso"] = $_SESSION['SECON']['cperson'];
$_SESSION["cod_inti"] = $_SESSION['SECON']['cinstit'];
$_SESSION["usu"] =  $_SESSION['SECON']['dlogper'];


$_REQUEST["cboccarrer"] = $_REQUEST['ccarrer'];
$_REQUEST["cbocciclo"] = $_REQUEST['cciclo'];
$_REQUEST["cbocinicio"] = $_REQUEST['cinicio'];

$_REQUEST["cbocfrecue"] = !empty($_REQUEST['fre'])? $_REQUEST['fre']: "";

$_REQUEST["cbochorario"] = $_REQUEST['cgruaca'];

$_REQUEST["persona1"] =!empty($_REQUEST['cape'])? $_REQUEST['cape']: "";
$_REQUEST["persona2"]  = !empty($_REQUEST['came'])? $_REQUEST['came']: '';  
$_REQUEST["persona3"] = !empty($_REQUEST['cnom'])? $_REQUEST['cnom']: ''; 

$_REQUEST["cbocsemaca"] = $_REQUEST['csemaca'];

$_REQUEST["pago"] = $_REQUEST["tpagante"];



	$fil_usu=$_SESSION["cod_filial"];
	$persona=$_SESSION["cod_perso"];
	$cod_insti=$_SESSION["cod_inti"];
	$usu=$_SESSION["usu"];
	$password=$_SESSION["password"]; 
	$d_grupo=$_SESSION["grupo"];
        
        $_SESSION["cod_filial"]=$fil_usu;
	$_SESSION["cod_perso"]=$persona;
	$_SESSION["cod_inti"]=$cod_insti;
	$_SESSION["usu"]=$usu;
	$_SESSION["password"]=$password;
	$_SESSION["grupo"]=$d_grupo;

$cfilial="";
$cinstit="";
$ccarrer="";

if($_SESSION["cod_filial"]!=""){
$cfilial=" AND g.cfilial in (".$_SESSION["cod_filial"].") ";
}

if($_SESSION["cod_inti"]!=""){
$cinstit=" AND g.cinstit='".$_SESSION["cod_inti"]."' ";
}

if($_REQUEST["cboccarrer"]!=""){
$ccarrer=" AND i.ccarrer='".$_REQUEST["cboccarrer"]."'";
}

if($_REQUEST["pago"]!=""){
$pagos="HAVING MAX(r.testfin)='".$_REQUEST["pago"]."'";	
}

if($_REQUEST["persona1"]!=""){
$per1=" AND p.dappape like '".$_REQUEST["persona1"]."%' ";	
}
if($_REQUEST["persona2"]!=""){
$per2=" AND p.dapmape like '".$_REQUEST["persona2"]."%' ";	
}
if($_REQUEST["persona3"]!=""){
$per3=" AND p.dnomper like '".$_REQUEST["persona3"]."%' ";	
}

$sql="SELECT f.dfilial,ins.dinstit,u.dlogalu,p.dappape,p.dapmape,p.dnomper,p.tsexo,p.demail,p.ndniper,p.ntelper,p.ntelpe2,p.fnacper,
(SELECT nombre FROM ubigeo
WHERE coddpto=p.coddpto AND codprov=0 AND coddist=0 
GROUP BY nombre)
,(SELECT nombre FROM ubigeo
WHERE coddpto=p.coddpto AND codprov=p.codprov AND coddist=0
GROUP BY nombre)
,(SELECT nombre FROM ubigeo
WHERE coddpto=p.coddpto AND codprov=p.codprov AND coddist=p.coddist
GROUP BY nombre)
,p.tcolegi,p.dcolpro,p.ddirref,p.drefer1,p.drefer2,p.drefer3,
MAX(r.testfin)
FROM ingalum i,gracprp g,recacap r,personm p,filialm f,usualum u,instita ins
WHERE i.cingalu=r.cingalu 
AND r.cgruaca=g.cgracpr 
AND p.cperson=i.cperson 
AND i.cfilial=f.cfilial 
AND u.cperson=i.cperson AND u.cingalu=i.cingalu
AND ins.cinstit=i.cinstit
AND r.cconcep IN (SELECT cconcep FROM concepp WHERE  cinstit=g.cinstit AND cctaing LIKE '701.%') 
AND r.testfin IN ('C','P')
AND g.csemaca='".$_REQUEST["cbocsemaca"]."'
AND r.fvencim<=CURRENT_DATE 
".$cfilial.$cinstit.$ccarrer.$per1.$per2.$per3."
GROUP BY r.cfilial,r.cingalu ".$pagos."
 ORDER BY f.dfilial,ins.dinstit,p.dappape,p.dapmape,p.dnomper";


if(trim($_REQUEST["persona1"])!="" or trim($_REQUEST["persona2"])!="" or trim($_REQUEST["persona3"])!=""){
	$validaper="act";
	
}
if(isset($_REQUEST["btncargar"]) or $validaper=="act"){
	

//$persona=$gen->consultar($sql);

$cn->setQuery($sql);
$persona=$cn->loadObjectListArray();


echo "<table border=1 cellpadding=0 cellspacing=0 bordercolor=#330033>";	
$cabecera=array('','FILIAL-#C24723','INSTITUCION-#C24723','COD ALUMNO-#C24723','A. PATERNO-#C24723','A. MATERNO-#C24723','NOMBRE-#C24723','SEXO-#C24723','EMAIL-#C24723','DNI-#C24723','TELEFONO-#C24723','CELULAR-#C24723','FECHA NAC.-#C24723','DEPARTAMENTO-#160EBC','PROVINCIA-#160EBC','DISTRITO-#160EBC','TIPO COLEGIO-#160EBC','DESC COLEGIO-#160EBC','DIR COLEGIO-#160EBC','DIRECCION-#160EBC','NUMERO-#160EBC','REFERENCIA-#160EBC','PAGANTE/DEUDOR-#160EBC');
//$gen->crearCabeceras($cabecera); // Genere todo tipo de cabecera
		for($i=0;$i<count($cabecera);$i++){
			$cab=explode('-',$cabecera[$i]);
			echo "<th align='center' bgcolor=".$cab[1]."><font color=#FFFFFF>".$cab[0]."</font></th>";
		}
		
$cantcabe=count($cabecera);
//$persona=$gen->consultar($sql);

$cn->setQuery($sql);
$persona=$cn->loadObjectListArray();

$f=0;
	foreach($persona as $r){
		$f++;
		echo "<tr>";
			echo "<td>".$f."</td>";
			for($i=0;$i<21;$i++){
				$valor=$r[$i];
				if(trim($r[$i])==""){
					$valor="&nbsp;";
				}
			echo "<td>".$valor."</td>";
			}	
			if($r[21]=="P"){
			echo "<td><font color=red>DEUDOR</font></td>";	
			}
			else{
			echo "<td><font color=blue>PAGANTE</font></td>";		
			}
		echo "</tr>";
	}
echo "</table>";
}


?>
