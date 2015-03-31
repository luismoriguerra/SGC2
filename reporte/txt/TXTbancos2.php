<?
header("Content-Type: plain/text;charset=utf-8");
header("Content-Disposition: Attachment; filename=SCKOTIABANK_".date("Y_m_d_h_i_s").".txt");
header("Pragma: no-cache");
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();  

$cfilial=str_replace(",","','",trim($_GET['cfilial']));
$cinstit=str_replace(",","','",trim($_GET['cinstit']));
$csemaca=str_replace(",","','",trim($_GET['csemaca']));
$ccarrer=str_replace(",","','",trim($_GET['ccarrer']));
//$mora=trim($_GET['mora']);
$mora=0;

$dmm=explode(".",$mora);
	if(count($dmm)>1){
		$mora=str_pad($dmm[0],13,'0',0).substr("00".$dmm[1],-2);
	}
	else{
		$mora=str_pad($mora,15,'0',0);
	}

$sql="	select left(concat_ws(' ',p.dappape,p.dapmape,substr(p.dnomper,1,6),'          '),20) as nombre,concat(substr(r.crecaca,1,8),right(substr(r.crecaca,12),7)) as recibo,concat(replace(i.dcodlib,'-',''),'     ') as codalu
		,if(substr(c.cctaing,1,3)='708'
				,concat_ws(' ','Inscripci','|semestre',g.csemaca,g.cinicio,'          '),
				if(substr(c.cctaing,1,6)='701.01'
				,concat_ws(' ','Matricula','|semestre',g.csemaca,g.cinicio,'          '),
				concat_ws(' ','Cuota N',r.ccuota,'| semestre',g.csemaca,g.cinicio,'          ')	
				)
		 ) as descripcion
		,if(substr(c.cctaing,1,3)='708','01',
			if(substr(c.cctaing,1,6)='701.01','02',
				if(substr(c.cctaing,1,6)='701.02','05',
					if(substr(c.cctaing,1,6)='701.03','07','00')
				)
			)
		 ) as codconcep,
		replace(r.fvencim,'-','') as vencimiento,r.nmonrec as monto
		from recacap r
		INNER JOIN ingalum i on (r.cingalu=i.cingalu)
		inner join personm p on (p.cperson=i.cperson)
		inner join gracprp g on (g.cgracpr=r.cgruaca)
		inner JOIN concepp c on (c.cconcep=r.cconcep)		
		where r.testfin='P'
		and (substr(c.cctaing,1,6) in ('701.01','701.02','701.03')
		or substr(c.cctaing,1,3)='708')
		AND r.cfilial in ('".$cfilial."')		
		AND concat(g.csemaca,' | ',g.cinicio) in ('".$csemaca."')
		AND g.cinstit in ('".$cinstit."')
		AND g.ccarrer in ('".$ccarrer."')";
$cn->setQuery($sql);
$banco=$cn->loadObjectList();
$cuenta="00000000000000";// cuenta empresa
$dolares="00000000000000000";
$ruc="00000000000";
$fecha=date("Ymd");
$cantidad_registros=0;
$monto_envio=0;
$busca=array('á','é','í','ó','Á','É','Í','Ó','Ú','Ñ','ñ');
$reemplaza=array('a','e','i','o','u','A','E','I','O','U','N','n');
$codconcep2="  ";
$montoconcepto="000000000";

if(count($banco)>0){
	$detalle="";
	$contador=0;
	foreach ($banco as $r) {
		$contador++;
				
		$monto_envio+=$r['monto'];
		$monto_pago=$r['monto'];
		$monto_min=$r['monto'];
		$dmp=explode(".",$monto_pago);
		if(count($dmp)>1){
			$monto_pago=str_pad($dmp[0],7,'0',0).str_pad($dmp[1],2,"0");
		}
		else{
			$monto_pago=str_pad($monto_pago,7,'0',0)."00";
		}
		$dmm=explode(".",$monto_min);
		if(count($dmm)>1){
			$monto_min=str_pad($dmm[0],13,'0',0).str_pad($dmm[1],2,"0");
		}
		else{
			$monto_min=str_pad($monto_min,13,'0',0)."00";
		}

		$r['nombre']=str_replace($busca,$reemplaza,utf8_encode(substr(str_pad(utf8_decode($r['nombre']),20),0,20)));
		if($r['vencimiento']=="00000000"){
			$r['vencimiento']=date("Ymd");
		}
		$detalle.="D".$cuenta."000".$r['codalu'].$r['recibo']."           "."0"."0000".$r['nombre'].substr($r['descripcion'],0,30).$r['codconcep'].$monto_pago.$codconcep2.$montoconcepto.$codconcep2.$montoconcepto.$codconcep2.$montoconcepto.$codconcep2.$montoconcepto.$codconcep2.$montoconcepto.$monto_min.$monto_min."00000000"."0".$fecha.$r['vencimiento']."025"."               *\n";

	}


	$dmp=explode(".",$monto_envio);
		if(count($dmp)>1){
			$monto_envio=str_pad("$dmp[0]",15,'0',0).str_pad("$dmp[1]",2,"0");
		}
		else{
			$monto_envio=str_pad("$monto_envio",15,'0',0)."00";
		}
	$cantidad_registros=str_pad("$contador",7,'0',0);

	$cuentaabono="              ";// preguntar por la cuenta de abono...
	$concepto ="C".$cuenta."000"."01"."INSCRIPCION                   0".$cuentaabono."                                                                                                                                                                                            *\n";
	$concepto.="C".$cuenta."000"."02"."MATRICULA                     0".$cuentaabono."                                                                                                                                                                                            *\n";
	$concepto.="C".$cuenta."000"."05"."RATIFICACION DE MATRICULA     0".$cuentaabono."                                                                                                                                                                                            *\n";
	$concepto.="C".$cuenta."000"."07"."PENSION DEL ALUMNO            0".$cuentaabono."                                                                                                                                                                                            *";

	$cabecera="H".$cuenta."000".$cantidad_registros.$monto_envio.$dolares.$ruc.$fecha.$fecha."000"."00000000000000000000000000000000000000000000000000000"."                                                                                                               *";
	echo $cabecera."\n";
	echo $detalle;
	echo $concepto;
	exit(0);
}
else{
	echo "No existen datos con los filtros seleccionados";	
}
?>



D00000000000000000IT01499999     106ACRUZ0000001           00000RUIZ GARCIA MARILU  Cuota N° 2 |semestre 2013-2 C07000010000  000000000  000000000  000000000  000000000  0000000000000000000100000000000000100000000000002013121020131129025               *