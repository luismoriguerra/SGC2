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
header('Content-Disposition: attachment;filename="ContadorPagos_'.date("Y-m-d_H-i-s").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");

?>
<? if($_REQUEST["csemaca"]!=""){ ?>
<table align="center" border="1" cellpadding="1" cellspacing="0" >
<tr bgcolor="#CCCCCC" align="center">
<td colspan="3">&nbsp;</td>
<td colspan="8">Matricula</td>
<td colspan="8">1 Cuota</td>
<td colspan="8">2 Cuota</td>
<td colspan="8">3 Cuota</td>
<td colspan="8">4 Cuota</td>
<td colspan="8">5 Cuota</td>
<td colspan="8">Deudores</td>
</tr>
<tr bgcolor="#CCCCCC">
<td>Filial</td>
<td>Instituto</td>
<td>Carrera</td>
	<? for($i=1;$i<=7;$i++){?>
<td>I</td>
<td>II</td>
<td>III</td>
<td>IV</td>
<td>V</td>
<td>VI</td>
<td>TOTAL</td>
<td>TOTAL RATIF.</td>
	<? }?>
</tr>

<?
	$cfilial="";
	$cinstit="";
	$ccarrer="";
	
      
	if(!empty($_REQUEST['mfiliales'])){
	$sqlfil="Select cfilial,dfilial from filialm where cfilial in (".$_REQUEST['mfiliales'].")";
//	$cfilial=$gen->consultar($sqlfil);
       
        $cn->setQuery($sqlfil);
        $cfilial=$cn->loadObjectList();
	}
	else{
	$sqlfil="Select cfilial,dfilial from filialm where cestado='1' ORDER BY dfilial";
	$cn->setQuery($sqlfil);
        $cfilial=$cn->loadObjectList();
	}
	
	if(!empty($_SESSION['SECON']['cinstit'])){
	$sqlins="Select cinstit,dinstit from instita where cinstit='".$_SESSION['SECON']['cinstit']."'";
//	$cinstit=$gen->consultar($sqlins);
        $cn->setQuery($sqlins);
        $cinstit=$cn->loadObjectList();
	}
	else{
	$sqlins="Select cinstit,dinstit from instita ORDER BY dinstit";
	$cn->setQuery($sqlins);
        $cinstit=$cn->loadObjectList();
	}
	
	if(!empty($_REQUEST["ccarrer"])){
	$sqlcar="SELECT ccarrer,dcarrer FROM carrerm where ccarrer='".$_REQUEST["ccarrer"]."'";
//	$ccarrer=$gen->consultar($sqlcar);
        $cn->setQuery($sqlcar);
        $ccarrer=$cn->loadObjectList();
	}
//	elseif($_SESSION["cod_inti"]!=""){
        elseif(!empty($_SESSION['SECON']['cinstit'])){
	$sqlcar="SELECT ccarrer,dcarrer FROM carrerm where cinstit='".$_SESSION['SECON']['cinstit']."' ORDER BY dcarrer";
//	$ccarrer=$gen->consultar($sqlcar);
        $cn->setQuery($sqlcar);
        $ccarrer=$cn->loadObjectList();
	}
	else{
	$sqlcar="SELECT ccarrer,dcarrer FROM carrerm ORDER BY dcarrer";
	$cn->setQuery($sqlcar);
        $ccarrer=$cn->loadObjectList();
	}
	
	$cinicio=" ";
	if(!empty($_REQUEST["cinicio"])){
	$cinicio=" AND g.cinicio='".$_REQUEST["cinicio"]."' ";
	}
	
	
	foreach($cfilial as $cfil){
          
		foreach($cinstit as $cins){
                   
			foreach($ccarrer as $ccar){	
                            
			$array=array();//Iniciamos el acumulador
			$sqlval="
SELECT ci.dciclo,r.cingalu,MAX(r.testfin),MAX(r.ccuota)
FROM recacap r,gracprp g,cicloa ci
WHERE r.cfilial=g.cfilial
AND r.cgruaca=g.cgracpr
AND ci.cciclo=g.cciclo
AND r.cconcep IN (SELECT cconcep FROM concepp WHERE  cinstit=g.cinstit AND cctaing LIKE '701.%') 
AND g.cfilial='".$cfil['cfilial']."' 
AND g.cinstit='".$cins['cinstit']."' 
AND g.ccarrer='".$ccar['ccarrer']."'
AND g.csemaca='".$_REQUEST["csemaca"]."'"
.$cinicio.
"GROUP BY r.cfilial,g.cciclo,r.cingalu
HAVING MAX(r.testfin)='C'
ORDER BY g.cciclo,r.cingalu";
//			$val=$gen->consultar($sqlval);
                        $cn->setQuery($sqlval);
                        $val=$cn->loadObjectList();
				foreach($val as $r){
                                    
					$ciclo=str_replace(" CICLO","",$r['dciclo']);				
					if($ciclo=="I"){
					$pos=0;
					}
					elseif($ciclo=="II"){
					$pos=1;
					}
					elseif($ciclo=="III"){
					$pos=2;
					}
					elseif($ciclo=="IV"){
					$pos=3;
					}
					elseif($ciclo=="V"){
					$pos=4;
					}
					elseif($ciclo=="VI"){
					$pos=5;
					}
                                        
                                        $icont = $r['MAX(r.ccuota)'] + 1;
                                         
					for( $i=$icont ; $i<=5; $i++ ){
                                           
					if(empty($array[$i][$pos]))
                                            $array[$i][$pos] = 0;
                                            
                                            $array[$i][$pos]++;	
                                            
					}
                                        
				}	
				
					
			$sql="
SELECT ci.dciclo,IF(r.ccuota='',0,r.ccuota),i.cingalu,MAX(r.testfin)
FROM ingalum i,gracprp g,recacap r,cicloa ci 
WHERE i.cingalu=r.cingalu AND i.cfilial=r.cfilial 
AND g.cgracpr=r.cgruaca AND g.cfilial=r.cfilial 
AND g.cciclo=ci.cciclo 
AND r.cconcep IN (SELECT cconcep FROM concepp WHERE  cinstit=g.cinstit AND cctaing LIKE '701.%') 
AND g.cfilial='".$cfil['cfilial']."' 
AND g.cinstit='".$cins['cinstit']."' 
AND g.ccarrer='".$ccar['ccarrer']."'    
AND r.testfin='C' 
AND g.csemaca='".$_REQUEST["csemaca"]."'"
.$cinicio.
"GROUP BY g.cfilial,g.ccarrer,g.cciclo,r.cingalu,r.ccuota 
ORDER BY g.cfilial,g.ccarrer,g.cciclo,r.cingalu,r.ccuota";

//			$dat=$gen->consultar($sql);
                        $cn->setQuery($sql);
                        $dat=$cn->loadObjectList();
			$imp="true";
				
				if(count($dat)>0){
					foreach($dat as $r){
                                            
						if($imp=="true"){
                                                   
						echo "<tr>";
							echo "<td>".$cfil['dfilial']."</td>";
							echo "<td>".$cins['dinstit']."</td>";
							echo "<td>".$ccar['dcarrer']."</td>";	
						$imp="false";										
						}
						$ciclo=str_replace(" CICLO","",$r['dciclo']);
                                                
							if($ciclo=="I"){
                                                        if(empty($array[$r['cingalu']][0]))
                                                            $array[$r['cingalu']][0] = 0;
                                                            
							$array[$r['cingalu']][0]++;
							}
							elseif($ciclo=="II"){
                                                            if(empty($array[$r['cingalu']][1]))
                                                            $array[$r['cingalu']][1] = 0;
							$array[$r['cingalu']][1]++;
							}
							elseif($ciclo=="III"){
                                                            if(empty($array[$r['cingalu']][2]))
                                                            $array[$r['cingalu']][2] = 0;
							$array[$r['cingalu']][2]++;
							}
							elseif($ciclo=="IV"){
                                                            if(empty($array[$r['cingalu']][3]))
                                                            $array[$r['cingalu']][3] = 0;
							$array[$r['cingalu']][3]++;
							}
							elseif($ciclo=="V"){
                                                            if(empty($array[$r['cingalu']][4]))
                                                            $array[$r['cingalu']][4] = 0;
							$array[$r['cingalu']][4]++;
							}
							elseif($ciclo=="VI"){
                                                            if(empty($array[$r['cingalu']][5]))
                                                            $array[$r['cingalu']][5] = 0;
							$array[$r['cingalu']][5]++;
							}
					}
					
				$sql2="
				SELECT ci.dciclo,i.cingalu,r.fvencim ,current_date
				FROM ingalum i,gracprp g,recacap r,cicloa ci 
				WHERE i.cingalu=r.cingalu AND i.cfilial=r.cfilial 
				AND g.cgracpr=r.cgruaca AND g.cfilial=r.cfilial 
				AND g.cciclo=ci.cciclo 
				AND r.cconcep IN (SELECT cconcep FROM concepp WHERE  cinstit=g.cinstit AND cctaing LIKE '701.%') 
				AND g.cfilial='".$cfil['cfilial']."' 
                                AND g.cinstit='".$cins['cinstit']."' 
                                AND g.ccarrer='".$ccar['ccarrer']."'
				AND g.csemaca='".$_REQUEST["csemaca"]."'"
				.$cinicio.
				"AND r.testfin='P'
				AND r.fvencim<=current_date
				GROUP BY g.cfilial,g.ccarrer,g.cciclo,r.cingalu
				ORDER BY g.cfilial,g.ccarrer,g.cciclo,r.cingalu";
//				$dat2=$gen->consultar($sql2);
				$cn->setQuery($sql2);
                                $dat2=$cn->loadObjectList();
					foreach($dat2 as $r){
                                            
						$ciclo=str_replace(" CICLO","",$r['dciclo']);				
							if($ciclo=="I"){
							if(empty($array[6][0]))
                                                            $array[6][0] = 0;
                                                        
                                                            $array[6][0]++;
							}
							elseif($ciclo=="II"){
                                                            if(empty($array[6][1]))
                                                            $array[6][1] = 0;
							$array[6][1]++;
							}
							elseif($ciclo=="III"){
                                                            if(empty($array[6][2]))
                                                            $array[6][2] = 0;
							$array[6][2]++;
							}
							elseif($ciclo=="IV"){
                                                            if(empty($array[6][3]))
                                                            $array[6][3] = 0;
							$array[6][3]++;
							}
							elseif($ciclo=="V"){
                                                            if(empty($array[6][4]))
                                                            $array[6][4] = 0;
							$array[6][4]++;
							}
							elseif($ciclo=="VI"){
                                                            if(empty($array[6][5]))
                                                            $array[6][5] = 0;
							$array[6][5]++;
							}
					}
					
					for($j=0;$j<7;$j++){
					$Stotal=0;
					$dato=0;
						for($i=0;$i<6;$i++){
						$valor=0;
                                                
                                                if( empty($array[$j][$i]) )
                                                    $array[$j][$i] = 0;
                                                
							if($array[$j][$i]>0){
							$valor=$array[$j][$i];
							}
							
						echo "<td>".$valor."</td>";
							if($i==0){
							$dato=$valor;						
							}
						$Stotal=$Stotal+$valor;
                                                
                                                if(empty($Ttotal[$j][$i]))
                                                    $Ttotal[$j][$i] = 0;
                                                
						$Ttotal[$j][$i]=$Ttotal[$j][$i]+$valor;
						}					
					echo "<td>".$Stotal."</td>";
					$Stotalr=$Stotal-$dato;
					echo "<td>".$Stotalr."</td>";
                                        
                                        if(empty($Ttotal[$j][6]))
                                            $Ttotal[$j][6] = 0;
                                        
                                        if(empty($Ttotal[$j][7]))
                                            $Ttotal[$j][7] = 0;
                                        
					$Ttotal[$j][6]=$Ttotal[$j][6]+$Stotal;
					$Ttotal[$j][7]=$Ttotal[$j][7]+$Stotalr;
					}
				echo "</tr>";
				}
			}
		}
	}
	echo "<tr>";
		echo "<td colspan=3 align=center>TOTALES</td>";
			for($j=0;$j<7;$j++){
				for($i=0;$i<=7;$i++){
				echo "<td>".$Ttotal[$j][$i]."</td>";
				}
			}		
	echo "</tr>";
}
else{
echo "<script>alert('Seleccione un semestre');</script>";
}

?>

</table>

