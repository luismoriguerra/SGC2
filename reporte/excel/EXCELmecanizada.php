<?php
session_start();
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$sqlfilial="SELECT * FROM filialm WHERE cfilial='".$_REQUEST["filial"]."'";
$cn->setQuery($sqlfilial);
$dfilial=$cn->loadObjectList();

// Redirect output to a client's web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="Pre_Matricula_'.date("Y-m-d_H-i-s").'.xlsx"');
//header('Cache-Control: max-age=0');
//
//INCORPORANDO CABECERAS PARA IMPRESION CORRECTA DE UTF-8 USANDO pack("CCC",0xef,0xbb,0xbf);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header('Content-Disposition: attachment;filename="CajaMecanizada_'.$dfilial[0]['dfilial'].'_'.date("Y-m-d_H-i-s").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");
//echo pack("CCC",0xef,0xbb,0xbf);
//obteniendo datos a exportar

$sql  ="
SELECT
-- datos generales
i.dcodlib codigo,
DAY(r.festfin) dia,
MONTH(r.festfin) mes,
YEAR(r.festfin) ano
,IF( 
(select COUNT(*) from concepp c where c.cctaing like '701.01%' and c.cconcep = r.cconcep ) > 0,'Matric',
IF(
(select COUNT(*) from concepp c where c.cctaing like '701.02%' and c.cconcep = r.cconcep ) > 0,'Ratif',''
)) as tipo_ficha
,con.sermatr nro_ficha_cap
,f.dfilial caja_centro
,CONCAT_WS(' ',usu.dnomper,usu.dappape,usu.dapmape) cajero
,'|'
-- datos alumno

,p.dnomper nombre
,p.dappape paterno
,p.dapmape materno
-- datos academicos
,'|'
,ins.dinstit institucion
,'nivel' nivel
,m.dmoding mod_ingreso
,car.dcarrer carrera
,g.csemaca semestre
,g.cinicio inicio
,g.finicio 
,mo.dmnemod modal
,ci.nromcic ciclo
-- ,( SELECT TIMESTAMPDIFF(MONTH, g.finicio, g.ffin) ) duracion
,'' duracion
,lo.dfilial local_estudio
,(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',',')) ) frecuencia
,CONCAT_WS(' ',h.hinici,h.hfin) horario
-- escala
,'|'
,(SELECT c2.nprecio from recacap r2  left join concepp c2 on c2.cconcep = r2.cconcep  where r2.cingalu = r.cingalu and r2.cgruaca = r.cgruaca and c2.cctaing like '708%' limit 1
) inscripcion
,(SELECT c2.nprecio from recacap r2  left join concepp c2 on c2.cconcep = r2.cconcep  where r2.cingalu = r.cingalu and r2.cgruaca = r.cgruaca and  ( c2.cctaing like '701.01%' or c2.cctaing like '701.02%' )limit 1
) matric_rati
,(Select concat(con.ncuotas,'C_',con.nprecio) From concepp con inner join recacap r2 on (r2.cconcep=con.cconcep) Where r2.cingalu=r.cingalu and con.cctaing like '701.03%' limit 1) pension
-- ,CONCAT(c.ncuotas,'C_',c.nprecio) pension
-- descripcion del ingreso a caja
,'|'
,substring(c.cctaing,1,6) cod_cta
,r.ccuota pension_cuota
,IF(r.ccuota = NULL,i.dproeco,IF(r.ccuota < 2,i.dproeco,'')) observacion
,'C' as tipo_pago
,IF(r.testfin='C' OR (r.cdocpag!='' AND r.testfin='F'),
			  	IF(r.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol) from boletap b where b.cboleta=r.cdocpag),
					IF(r.tdocpag='V',(select concat(b.dabrevi,'-',v.numvou) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=r.cdocpag),''
					)
				)
				,'') as nro_boleta_voucher
,r.nmonrec as importe
-- datos del alumno matriculado o ratificado
,'|'
,t.dtipcap tipo_captacion
,If(i.cpromot!='',(Select concat(v.dapepat,' ',v.dapemat,', ',v.dnombre) From vendedm v Where v.cvended=i.cpromot),
			If(i.cmedpre!='',(Select m.dmedpre From medprea m Where m.cmedpre=i.cmedpre limit 1),
				If(i.destica!='',i.destica,''))) As detalle_captacion
-- ,CONCAT_WS(' ',v.dapepat,v.dapemat,v.dnombre) teleoperadora
,IF(p.ntelpe2!='',p.ntelpe2,p.ntelper) telefono
,p.email1 email
,CONCAT_WS(' ',usu.dnomper,usu.dappape,usu.dapmape) recepcionista

			from recacap r 
			INNER JOIN concepp c  on (r.cconcep=c.cconcep)
			left join gracprp  g  on (g.cgracpr=r.cgruaca)
			left join cicloa   ci on (ci.cciclo=g.cciclo)
			inner JOIN personm p  on p.cperson = r.cperson
			left JOIN carrerm  car on car.ccarrer = g.ccarrer
			inner JOIN ingalum i  on i.cingalu = r.cingalu
			left join conmatp  con on (con.cingalu = r.cingalu and con.cgruaca = r.cgruaca)
			inner JOIN personm usu on usu.dlogper = r.cusuari
			LEFT JOIN filialm  f  on f.cfilial = r.cfilial
			left join filialm  lo on lo.cfilial = g.cfilial
			left JOIN instita  ins on ins.cinstit = g.cinstit
			inner join modinga m  on m.cmoding = i.cmoding
			left join modalim  mo on mo.cmodali = ins.cmodali
			left join	horam	   h  on h.chora = g.chora
			inner join tipcapa t  on t.ctipcap = i.ctipcap
			left JOIN vendedm v  on v.cvended = i.cpromot
where 1=1
and r.testfin IN ( 'C','F')
AND r.tdocpag='B' 
and r.cfilial = '".$_REQUEST["filial"]."' 
and r.festfin BETWEEN '".$_REQUEST["fini"]."' and '".$_REQUEST["ffin"]."'
order by r.festfin desc";
$cn->setQuery($sql);
$pagos=$cn->loadObjectList();

?>

<table align="center" border="1" cellpadding="1" cellspacing="0" >
    <tr bgcolor="blue" align="left">
        <td colspan="34">CAJA MECANIZADA</td>
    </tr>
    <tr bgcolor="" align="center">
        <td colspan="8">DATOS GENERALES</td>
        <td colspan="3">DATOS BASICOS DEL ALUMNO</td>
        <td colspan="13">DATOS ACADEMICOS</td>
        <td colspan="3">ESCALA</td>
        <td colspan="6">DESCRIPCION DEL INGRESO A ESCALA</td>
      
    </tr>
<tr bgcolor="#CCCCCC" align="center">
    <th>CODIGO</th>
    <th>DIA</th>
    <th>Mes</th>
    <th>año</th>
    <th>Tipo ficha</th>
    <th>NRO DE FICHA</th>
    <th>Caja centro captacion</th>
    <th>Cajero</th>
    <!--datos basicos del alumno-->
<th >APELL PATERNO</th>
<th >APELL MATERNO</th>
<th >NOMBRES</th>
<!--DATOS ACADEMICOS-->
<th >INSTITUCION</th>
<th >NIVEL</th>
<th >MOD INGRE</th>
<th >CARRERA PROFESIONAL</th>
<th >SEMESTRE</th>
<th >INICIO</th>
<th >FECHA INICIO</th>
<th >MODAL</th>
<th >CICLO/MODULO</th>
<th >DURACION</th>
<th >LOCAL DE ESTUDIO</th>
<th >FRECUENCIA</th>
<th>HORARIO</th>
<!--ESCALA-->
<th >INSCRIPCION</th>
<th >MATRICULA O RATIF</th>
<th>PENSION</th>
<!--DESCRIPCION DEL INGRESO A ESCALA-->
<th> COD CUENTA INGRESO</th>
<th >PENSION/CUOTA</th>
<th >OBSERVACIONES</th>
<th >TIPO PAGO</th>
<th >SERIE</th>
<th >NRO DE BOLETA/VOUCHER</th>
<th>IMPORTE</th>
<!--DATOS DEL ALUMNO MATRICULADO-->
<th> MEDIO DE CAPTACION</th>
<th >RESPONSABLE DE CAPTACION</th>
<th >TEL FIJO/CELULAR</th>
<th >E-MAIL</th>
<th >RECEPCIONISTA</th>
</tr>
<!--listando los pagos-->
<?php
$registros = count($pagos);

if($registros == 0){
    echo "<td>No se encontraron registros en el rango de fechas escogidas para esta filial</td>";
}else{
    foreach($pagos as $pago){
        print "<tr>";
   //datos generales
print "<td>".  str_replace("-", "", $pago["codigo"])."</td>";
print "<td>".$pago["dia"]."</td>";
print "<td>".$pago["mes"]."</td>";
print "<td>".substr($pago["ano"], -2)."</td>";
print "<td>".  strtoupper($pago["tipo_ficha"])."</td>";
print "<td>".$pago["nro_ficha_cap"]."</td>";
print "<td>".$pago["caja_centro"]."</td>"; 
print "<td>".$pago["cajero"]."</td>"; 
   //datos basicos del alumno     
print "<td>".$pago["paterno"]."</td>";
print "<td>".$pago["materno"]."</td>";
print "<td>".$pago["nombre"]."</td>"; 
   // datos academicos     
print "<td>".$pago["institucion"]."</td>";
print "<td>".$pago["nivel-"]."</td>";
print "<td>".$pago["mod_ingreso"]."</td>";
print "<td>".$pago["carrera"]."</td>";
print "<td>".$pago["semestre"]."</td>";
print "<td>".$pago["inicio"]."</td>";
print "<td>".$pago["finicio"]."</td>";
print "<td>".$pago["modal"]."</td>";
print "<td>".$pago["ciclo"]."</td>";
print "<td>".$pago["duracion"]."</td>";
print "<td>".$pago["local_estudio"]."</td>";
print "<td>".$pago["frecuencia"]."</td>";
print "<td>".  str_replace(" ", "-", $pago["horario"] )."</td>";
//ESCALA
print "<td>".$pago["inscripcion"]."</td>";
print "<td>".$pago["matric_rati"]."</td>";
print "<td>".  substr($pago["pension"] , 0, -3 )."</td>";
//DESCRIPCION DE INGRESO A ESCALA
print "<td>".$pago["cod_cta"]."</td>";
$cuota="";
$observa="";
if(substr($pago['cod_cta'],0,6)=="701.03"){
	$cuota=$pago["pension_cuota"];
	$observa=$pago["observacion"];
}
elseif(substr($pago['cod_cta'],0,6)=="701.01" or substr($pago['cod_cta'],0,6)=="701.02"){
	$cuota="-1";
}
elseif(substr($pago['cod_cta'],0,3)=="708"){
	$cuota="-2";
}
print "<td>".$cuota."</td>";
print "<td>".$observa."</td>";
print "<td>".$pago["tipo_pago"]."</td>";
list($serie,$numero) = explode("-",$pago["nro_boleta_voucher"]);
print "<td>".str_pad($serie,3,"0",STR_PAD_LEFT)."</td>";
print "<td>".str_pad($numero,7,"0",STR_PAD_LEFT)."</td>";
print "<td>".$pago["importe"]."</td>";
//DATOS DEL ALUMNO MATRICULADO O RATIFICADO
print "<td>".$pago["tipo_captacion"]."</td>";
print "<td>".$pago["detalle_captacion"]."</td>";
print "<td>".$pago["telefono"]."</td>";
print "<td>".$pago["email"]."</td>";
print "<td>".$pago["recepcionista"]."</td>";
 print "</tr>";
    }
}
?>
</table>

