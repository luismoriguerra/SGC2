<?
class MySqlReporteDAO{	
	public function ArqueoCaja($array){
		$db=creadorConexion::crear('MySql');		
		$sql="	select r.crecaca,date(r.festfin) as festfin,c.cctaing,i.dinstit,r.nmonrec,
IF(r.testfin='C',
			  	IF(r.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol) from boletap b where b.cboleta=r.cdocpag),
					IF(r.tdocpag='V',(select concat('-',v.numvou,'<br>',b.dbanco) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=r.cdocpag),''
					)
				)
				,'') as pago
				from recacap r
				INNER JOIN concepp c on (r.cconcep=c.cconcep)
				INNER JOIN instita i on (i.cinstit=c.cinstit)				
				where date(r.festfin) between '".$array['finicio']."' and '".$array['ffin']."'
				AND r.cfilial='".$array['cfilial']."'
				and r.testfin='C'
				order by r.festfin";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if(count($data)>0){
		return array('rst'=>'1','msj'=>'Listado Finalizado','data'=>$data,'sql'=>$sql);
		}
		else{
		return array('rst'=>'2','msj'=>'No hay Registro(s)','data'=>$data,'sql'=>$sql);
		}
	}
	
	public function JQGridCountArqueo($where,$array){
		$db=creadorConexion::crear('MySql');
		$cfilial="";
		if($array['cfilial']!='000' and $array['cfilial']!=''){
			$cfilial=" AND r.cfilial='".$array['cfilial']."' ";
		}

		$nrobol='';
		if($array['nrobol']!='000' && $array['nrobol']!=''){
			$nrobol=" AND b.dnumbol='".$array['nrobol']."' ";
		}

		$serbol='';
		if($array['serbol']!='000' && $array['serbol']!=''){
			$serbol=" AND b.dserbol='".$array['serbol']."' ";
		}

		$visible='';
		if($array['visible']!='NO'){
			$visible=" AND date(r.festfin) between '".$array['finicio']."' and '".$array['ffin']."' ";
		}

		$sql="	Select count(*) as count,sum(r.nmonrec) as suma
				from recacap r
				INNER JOIN concepp c on (r.cconcep=c.cconcep)
				INNER JOIN instita i on (i.cinstit=c.cinstit)
				INNER JOIN boletap b on (b.cboleta=r.cdocpag) 				
				where r.testfin='C'
				AND r.tdocpag='B' ".$cfilial.$visible.$where.$serbol.$nrobol;
			//echo($sql);exit;
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('count'=>'0'));
        }
	}
	
	public function JQGRIDRowsArqueo( $sidx, $sord, $start, $limit, $where,$array) {
		$cfilial="";
		if($array['cfilial']!='000'  and $array['cfilial']!=''){
			$cfilial=" AND r.cfilial='".$array['cfilial']."' ";
		}

		$nrobol='';
		if($array['nrobol']!='000' && $array['nrobol']!=''){
			$nrobol=" AND b.dnumbol='".$array['nrobol']."' ";
		}

		$serbol='';
		if($array['serbol']!='000' && $array['serbol']!=''){
			$serbol=" AND b.dserbol='".$array['serbol']."' ";
		}

		$visible='';
		if($array['visible']!='NO'){
			$visible=" AND date(r.festfin) between '".$array['finicio']."' and '".$array['ffin']."' ";
		}

		$sql="	select r.crecaca,date(r.festfin) as festfin,c.cctaing,i.dinstit,r.nmonrec,
	concat(b.dserbol,'-',b.dnumbol)  as pago,CONCAT(p.dappape,' ',p.dapmape,', ',p.dnomper) AS alumno,
	(select concat(p.dappape,' ',p.dapmape,', ',p.dnomper) from personm p where p.dlogper=r.cusuari) as cajero
				from recacap r
				INNER JOIN ingalum ii ON (ii.`cingalu`=r.`cingalu`)
				INNER JOIN personm p ON (p.`cperson`=ii.`cperson`)
				INNER JOIN concepp c on (r.cconcep=c.cconcep)
				INNER JOIN instita i on (i.cinstit=c.cinstit)
				INNER JOIN boletap b on (b.cboleta=r.cdocpag)				
				where r.testfin='C'
				AND r.tdocpag='B' ".$cfilial.$visible.$where.$serbol.$nrobol." 
				ORDER BY $sidx $sord			
		  		LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data; 
    }

    public function JQGridCountBitBol($where,$array){
		$db=creadorConexion::crear('MySql');
		$cfilial="";
		if($array['cfilial']!='000' && $array['cfilial']!=""){
			$cfilial=" AND b.cfilial='".$array['cfilial']."' ";
		}

		$nrobol='';
		if($array['nrobol']!='000' && $array['nrobol']!=''){
			$nrobol=" AND (b.dnumbol='".$array['nrobol']."' OR b.cboleta like '%".$array['nrobol']."%') ";
		}

		$serbol='';
		if($array['serbol']!='000' && $array['serbol']!=''){
			$serbol=" AND (b.dserbol='".$array['serbol']."' OR b.cboleta like '%".$array['serbol']."%') ";
		}

		$sql="	SELECT count(*) as count
				FROM bitbolm b
				INNER JOIN filialm f ON (b.`cfilial`=f.`cfilial`)
				INNER JOIN personm p ON (b.`cperson`=p.`cperson`)
				where date(b.fusuari) between '".$array['finicio']."' and '".$array['ffin']."' ".
				$cfilial.$where.$serbol.$nrobol;
			//echo($sql);exit;
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		//echo $sql;
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('count'=>0,'sql'=>$sql));
        }
	}

	public function JQGRIDRowsBitBol( $sidx, $sord, $start, $limit, $where,$array) {
		$cfilial="";
		if($array['cfilial']!='000'  && $array['cfilial']!=""){
			$cfilial=" AND b.cfilial='".$array['cfilial']."' ";
		}

		$nrobol='';
		if($array['nrobol']!='000' && $array['nrobol']!=''){
			$nrobol=" AND (b.dnumbol='".$array['nrobol']."' OR b.cboleta like '%".$array['nrobol']."%') ";
		}

		$serbol='';
		if($array['serbol']!='000' && $array['serbol']!=''){
			$serbol=" AND (b.dserbol='".$array['serbol']."' OR b.cboleta like '%".$array['serbol']."%') ";
		}

		$sql="	SELECT b.cbitbol,f.`dfilial`,CONCAT_WS(' ',p.`dnomper`,p.`dappape`,p.`dapmape`) AS nombre,b.`cboleta`,b.`fechaan`,
				CONCAT(b.`dserbol`,'-',b.`dnumbol`) AS cboletanu,b.`fechanu`,b.`fusuari`
				FROM bitbolm b
				INNER JOIN filialm f ON (b.`cfilial`=f.`cfilial`)
				INNER JOIN personm p ON (b.`cperson`=p.`cperson`)
				where date(b.fusuari) between '".$array['finicio']."' and '".$array['ffin']."' ".
				$cfilial.$where.$serbol.$nrobol.
				" ORDER BY nombre,b.fusuari 					
		  		LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data; 
    }

}
?>