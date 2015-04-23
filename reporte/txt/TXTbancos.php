<?
header("Content-Type: plain/text;charset=utf-8");
header("Content-Disposition: Attachment; filename=CREP_BANCO_".date("Y_m_d_h_i_s").".txt");
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
$cuenta=explode("|",$_GET['cuenta']);
$codfil=$cuenta['0'].$cuenta['1'].$cuenta['2'];
// 193 | 0 | 35216546 | 0 | banco2
//$mora=trim($_GET['mora']);
$mora=0;
if($_GET['3']*1>0){
$mora=$_GET['3'];
}


$dmm=explode(".",$mora);
	if(count($dmm)>1){
		$mora=str_pad($dmm[0],13,'0',0).substr("00".$dmm[1],-2);
	}
	else{
		$mora=str_pad($mora,15,'0',0);
	}

$sql="	select concat('    ',replace(i.dcodlib,'-','')) as codigo,
		concat_ws(' ',p.dappape,p.dapmape,p.dnomper) as nombre,
		left(concat(r.crecaca,'                              '),30) as retorno,
		replace(r.fvencim,'-','') as vencimiento,
		r.nmonrec as monto
		from recacap r
		INNER JOIN gracprp g on (r.cgruaca=g.cgracpr)
		inner join ingalum i on (i.cingalu=r.cingalu)
		inner join personm p on (p.cperson=i.cperson)
		where r.cfilial in ('".$cfilial."')
		and r.testfin='P'
		and concat(g.csemaca,' | ',g.cinicio) in ('".$csemaca."')
		AND g.cinstit in ('".$cinstit."')
		AND g.ccarrer in ('".$ccarrer."')";
$cn->setQuery($sql);
$banco=$cn->loadObjectList();

$fecha=date("Ymd");
$cantidad_registros=0;
$monto_envio=0;
$busca=array('á','é','í','ó','Á','É','Í','Ó','Ú','Ñ','ñ');
$reemplaza=array('a','e','i','o','u','A','E','I','O','U','N','n');

if(count($banco)>0){
	$detalle="";
	$contador=0;
	foreach ($banco as $r) {
		$contador++;
			if($contador>1){
				$detalle.="\n";
			}	
		$monto_envio+=$r['monto'];
		$monto_pago=$r['monto'];
		$monto_min=$r['monto'];
		$dmp=explode(".",$monto_pago);
		if(count($dmp)>1){
			$monto_pago=str_pad($dmp[0],13,'0',0).str_pad($dmp[1],2,"0");
		}
		else{
			$monto_pago=str_pad($monto_pago,13,'0',0)."00";
		}
		$dmm=explode(".",$monto_min);
		if(count($dmm)>1){
			$monto_min=str_pad($dmm[0],7,'0',0).str_pad($dmm[1],2,"0");
		}
		else{
			$monto_min=str_pad($monto_min,7,'0',0)."00";
		}

		$r['nombre']=str_replace($busca,$reemplaza,utf8_encode(substr(str_pad(utf8_decode($r['nombre']),40),0,40)));
		if($r['vencimiento']=="00000000"){
			$r['vencimiento']=date("Ymd");
		}
		$detalle.="DD".$codfil.$r['codigo'].$r['nombre'].$r['retorno'].$fecha.$r['vencimiento'].$monto_pago.$mora.$monto_min."A"."00000000000000000000000000000000000000000000000";
		
	}

	$dmp=explode(".",$monto_envio);
		if(count($dmp)>1){
			$monto_envio=str_pad("$dmp[0]",13,'0',0).str_pad("$dmp[1]",2,"0");
		}
		else{
			$monto_envio=str_pad("$monto_envio",13,'0',0)."00";
		}
	$cantidad_registros=str_pad("$contador",9,'0',0);

	$cabecera="CC".$codfil."CUNIVERSIDAD PRIVADA TELESUP SAC         ".$fecha.$cantidad_registros.$monto_envio."R                                                                                                               10";
	echo $cabecera."\n";
	echo $detalle;
	exit(0);
}
else{
	echo "No existen datos con los filtros seleccionados.";	
}
?>



