<?php
session_start();
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

// INCORPORANDO CABECERAS PARA IMPRESION CORRECTA DE UTF-8 USANDO pack("CCC",0xef,0xbb,0xbf);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header('Content-Disposition: attachment;filename="Ambientes'.'_'.date("Y-m-d_H-i-s").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");
//echo pack("CCC",0xef,0xbb,0xbf);
//obteniendo datos a exportar

//OBTENIENDO DATOS
$filial = $_GET["filial"];
$ambientes = $_GET["ambientes"];
$institucion = $_GET["institucion"];
$where = ''; 

$sql = "SELECT dfilial from filialm where cfilial='$filial'";
$cn->setQuery($sql);
$obj=$cn->loadObject();
$dfilial = $obj->dfilial;

$tableInstitucion = '';
if(!empty($institucion)){
$sql = "select dinstit from instita where cinstit='$institucion'";
$cn->setQuery($sql);
$obj=$cn->loadObject();
$dinstit = $obj->dinstit; 
$tableInstitucion = '<tr><td colspan="2">Institucion :'.$dinstit.' </td></tr>';

}


if(!empty($ambientes))
	$where .= " and ho.cambien in ($ambientes) ";



if(!empty($institucion))
	$where .= " and ins.cinstit = '$institucion' ";


$sql  ="
select  
hora.chora ,
CONCAT(hora.hinici,' - ',hora.hfin) dhora ,dia.cdia ,dia.dnomdia ,ho.cambien ,amb.numamb 
,ins.dinstit 
,ins.cinstit 
,gra.csemaca
,gra.cinicio
,cur.dcurso
,car.dcarrer
,CONCAT_WS(' ',per.dappape,per.dapmape,per.dnomper) nombre
,tia.dtipamb
from horprop ho 
inner join cuprprp cupr on cupr.ccuprpr = ho.ccurpro 
inner join gracprp gra on gra.cgracpr = cupr.cgracpr 
inner join diasm   dia on dia.cdia = ho.cdia 
inner join horam   hora on hora.chora = ho.chora 
inner join instita ins on ins.cinstit = hora.cinstit 
inner join ambienm amb on amb.cambien = ho.cambien 
inner join tipamba tia on tia.ctipamb = amb.ctipamb
inner join cursom  cur on cur.ccurso = cupr.ccurso
inner join carrerm car on car.ccarrer = gra.ccarrer
inner join profesm pro on pro.cprofes = ho.cprofes
inner join personm per on per.cperson = pro.cperson
where  1=1
and amb.cfilial = $filial
$where
and ho.cestado = 1
and gra.ffin >= now()
order by hora.hinici asc";
$cn->setQuery($sql);
$horarios=$cn->loadObjectList();



foreach ($horarios as $row ) {
	# code...

	$grilla[$row['chora']]['texto']= $row['dhora'];
	$grilla[$row['chora']]['dias'][$row['dnomdia']][] = $row["dinstit"] 
								. '<br>SEMESTRE: ' . $row["csemaca"]. '/'.$row["cinicio"]
								. '<br>'.$row["dcarrer"]
								. '<br>'.$row["dcurso"]
								. '<br>'.$row["nombre"]
								. '<br>'.$row["numamb"]
								. '<br>'.$row["dtipamb"]
								;


}



foreach ($grilla as  $row) {
	$tr_horario .="<tr><td style=\"text-align:center;vertical-align:middle;\">".$row['texto']."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['LUNES']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['MARTES']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['MIERCOLES']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['JUEVES']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['VIERNES']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['SABADO']) ."</td><td style=\"text-align:center;vertical-align:middle;\">"
	. @implode('<hr>', $row['dias']['DOMINGO']) ."</td></tr>";
	
}
$mes = array("","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");


$fecha = "Lima, ".date("d").' de '.$mes[date('m')]. ' del '.date("Y");
$html = <<<EOD

<table>
<tr><td colspan="8" style="font-size:2em;text-align:center">GRUPO EDUCATIVO TELESUP</td></tr>
<tr><td colspan="8" style="font-size:1.5em;text-align:center" >DISPONIBILIDAD DE AMBIENTES</td></tr>
<tr>
<td colspan="2" style="text-align:left">ODE: {$dfilial}</td>
<td colspan="2" style="text-align:left"></td>
<td colspan="2" style="text-align:left"></td>
<td colspan="2" style="text-align:right">{$fecha}</td>
</tr>
</table>

<p></p>
<table border=1>
<tr style="text-align:center; background:#A6D2F7;font-weight:bold">
<td style="width:300px">Hora</td><td style="width:300px">LUNES</td><td style="width:300px">MARTES</td><td style="width:300px">MIERCOLES</td><td style="width:300px">JUEVES</td><td style="width:300px">VIERNES</td><td style="width:300px">SABADO</td><td style="width:300px">DOMINGO</td>
</tr>
{$tr_horario}
</table>

EOD;


print $html;






