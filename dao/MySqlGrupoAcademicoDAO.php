<?
class MySqlGrupoAcademicoDAO{
	public function cargarGrupoAcademicoMatri($data){
	$validaadmin="";
	if($data['cinicio']==''){
		$cinicio=" AND g.cinicio='".$data['cinicio']."'";
	}
	$sql="SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
		(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
		from diasm d 
		where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
		' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id,
		nmetmat
		FROM gracprp g 
		INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
		INNER JOIN filialm f on (f.cfilial=g.cfilial)
		INNER JOIN instita ins on (ins.cinstit=g.cinstit)
		INNER JOIN turnoa t on (g.cturno=t.cturno) 
		INNER JOIN horam h on (h.chora=g.chora) 
		INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 
		WHERE g.cciclo='".$data['cciclo']."' 
		AND g.cfilial='".$data['cfilial']."' 
		and g.cinstit='".$data['cinstit']."'
		AND g.csemaca='".$data['csemaca']."'
		".$cinicio."
		AND g.cesgrpr='3'
		".$validaadmin."
		GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
		order by c.dcarrer,g.cinicio,g.finicio";
		$db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
	}

	public function JQGridCountGrupoAcademico($where){
		$db=creadorConexion::crear('MySql');
        $sql="SELECT  count(count) as count
        	  FROM (SELECT count(*) as count
					FROM gracprp g 	
					inner join carrerm c on (g.ccarrer=c.ccarrer)					
					WHERE g.cesgrpr in ('3')
					 ".$where."	            
		            GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin) a";
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}

	public function JQGRIDRowsGrupoAcademico($sidx, $sord, $start, $limit, $where){		
		$sql = "SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id,
					cu.dtitulo as dcurric, ci.dciclo
				FROM gracprp g 
				INNER JOIN cicloa ci on (ci.cciclo=g.cciclo)
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				INNER JOIN turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 
				INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 		
				WHERE g.cesgrpr in ('3')
				 ".$where."	            
	            GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				ORDER BY ".$sidx." ".$sord." 		  
	            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	
        //var_dump($sql);exit();
        //echo $sql;
        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
	}

	public function cargarGrupoAcademico($data){
        $sql="	SELECT  t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id ,nmetmat,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											where (r2.ccuota='' or r2.ccuota=1)
											and testfin='P'
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as deben
				FROM gracprp g 
				inner join turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 				
				inner JOIN carrerm c on (c.ccarrer=g.ccarrer) 
				inner join cropaga cr on (cr.cgruaca=g.cgracpr) 
				WHERE g.cciclo='".$data['cciclo']."' 
				AND g.cfilial='".$data['cfilial']."' 
				and g.cinstit='".$data['cinstit']."'
				AND g.csemaca='".$data['csemaca']."'				
				AND g.cesgrpr='3' 
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				order by 9 desc ,10 desc";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarGrupoAcademico2($data){
		$fil=str_replace(",","','",$data['cfilial']);
		$ins=str_replace(",","','",$data['cinstit']);
		$sem=str_replace(",","','",$data['csemaca']);
		$fechini=$data['fechini'];
		$fechfin=$data['fechfin'];
		
		$filtro='';
		/*if(strlen($sem)==6){$filtro=" AND g.csemaca='".$sem."' ";}
		elseif(trim($sem)!=''){$filtro=" AND CONCAT(g.csemaca,' | ',g.cinicio) in ('".$sem."') ";}
		*/
		if($data['fechini']!='' and $data['fechfin']!=''){
			$filtro.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
		}
		/*
		$ciclo="";

		if($data['cciclo']!=''){
			$ciclo=" g.cciclo='".$data['cciclo']."' ";
		}*/

        $sql="	SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat(
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-')
				from diasm d
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0),
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(distinct(g.cgracpr)) as id,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,cu.dtitulo as dcurric
				FROM gracprp g
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				inner join turnoa t on (g.cturno=t.cturno)
				INNER JOIN horam h on (h.chora=g.chora)
				inner JOIN carrerm c on (c.ccarrer=g.ccarrer)
				WHERE g.cfilial in ('".$fil."')
				and g.cinstit in ('".$ins."')
				".$filtro."
				AND g.cesgrpr in ('3','4')
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				order by c.dcarrer,g.cinicio,g.finicio";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data,'sql'=>$sql);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
    }


	public function cargarPostulantes ($data) {

		$fil=str_replace(",","','",$data['cfilial']);
		$ins=str_replace(",","','",$data['cinstit']);
		$fechini=$data['fechini'];
		$fechfin=$data['fechfin'];

		$filtro='';

		if($data['fechini']!='' and $data['fechfin']!=''){
			$filtro.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
		}

		$sql="	select
				p.cpostul , p.cingalu , p.cgruaca , notaalu,notacar, ca.nota_min ,postest , g.finicio
				,CONCAT(pe.dappape, ' ',pe.dapmape, ' ', pe.dnomper) nombre
				, ca.dcarrer carrera
				from postulm p
				inner join gracprp g on g.cgracpr = p.cgruaca
				inner join personm pe on pe.cperson = p.cperson
				inner join gracprp gr on gr.cgracpr = p.cgruaca
				inner join carrerm ca on ca.ccarrer = gr.ccarrer
				where 1 = 1
				AND g.cfilial in ('".$fil."')
				and g.cinstit in ('".$ins."')
				".$filtro."
				order by ca.dcarrer asc, pe.dappape asc";
		$db=creadorConexion::crear('MySql');

		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if(count($data)>0){
			return array('rst'=>'1','msj'=>'Postulantes cargados','data'=>$data,'sql'=>$sql);
		}
		else{
			return array('rst'=>'2','msj'=>'No existen Postulantes','data'=>$data,'sql'=>$sql);
		}
	}
	
	public function cargarAlumnos($r){
	$sql="	select c.cgruaca as id,i.cingalu,UPPER(p.dappape) as dappape,UPPER(p.dapmape) as dapmape,UPPER(p.dnomper) as dnomper,if(i.cestado='1','Activo','Retirado') as cestado
			from personm p
			INNER JOIN ingalum i on (p.cperson=i.cperson)
			INNER JOIN conmatp c on (c.cingalu=i.cingalu)
			where c.cgruaca in 
			('".str_replace(",","','",$r['id'])."');";
		$db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Alumno Cargado','data'=>$data,'sql'=>$sql);
        }
		else{
            return array('rst'=>'2','msj'=>'No cargaron los alumnos','data'=>$data,'sql'=>$sql);
        }
	}
	
	public function cargarCursosProgramados($data){
		$sql="	select cu.ccuprpr,c.dcurso,ci.dciclo,cu.ncredit
				from cuprprp cu,cursom c,gracprp gr,cicloa ci
				where cu.ccurso=c.ccurso 
				and gr.cgracpr=cu.cgracpr
				and ci.cciclo=gr.cciclo
				and cu.cgracpr='".$data['cgracpr']."'
				order by c.dcurso;";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
	}


	public function guardarPuntajePostulantes ($data) {
		$db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();

		$rows = json_decode($data['data']);
		foreach($rows as $pos) {
			$sql = "UPDATE postulm set notaalu = " . $pos->nota
				. " , notacar = ". $pos->minima
				. " , postest = '". $pos->estado . "'"
				. " where cpostul = '".$pos->id."'";
			$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar postulantes','sql'=>$sql);exit();
			}
		}
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Postulantes actualizados');exit();
	}

	
	public function GuardarGruposAcademicos($data){
            $db=creadorConexion::crear('MySql');
            $sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$data['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObject();
                $data['cmodali'] = $cmodali->cmodali;
                
		$filiales=explode(',',$data['cfilial']);
		$carreras=explode(',',$data['ccarrer']);
		$respuesta="";
		$valorvalidado=false;
		$fechasinicio=explode(",",$data['fechainiciosemestre']);
		$fechasfin=explode(",",$data['fechafinsemestre']);
		for($i=0;$i<=count($fechasinicio);$i++){
			if($fechasinicio[$i]<=$data["finicio"] and $data["ffinal"]<=$fechasfin[$i]){
			$valorvalidado=true;
			break;
			}
		}		

		$db->iniciaTransaccion();
		if($valorvalidado==true){
			for($j=0;$j<count($carreras);$j++){
				$sqlcurricula="	SELECT ccurric
								FROM curricm
								where ccarrer='".$carreras[$j]."'
								and cestado=1
								order by ccurric desc
								limit 0,1";
				$db->setQuery($sqlcurricula);
				$datacurric=$db->loadObjectList();

				for($i=0;$i<count($filiales);$i++){
					$validagrupo="SELECT * 
								  FROM gracprp 
								  WHERE cfilial='".$filiales[$i]."' 
								  and csemaca='".$data["csemaca"]."' 
								  and cinstit='".$data['cinstit']."' 
								  and ctipcar='".$data['ctipcar']."' 
								  and cmodali='".$data['cmodali']."' 
								  and cinicio='".$data["cinicio"]."' 
								  and cfrecue='".$data['dias']."' 
								  and chora='".$data["chora"]."' 
								  and ccarrer='".$carreras[$j]."' 
								  and cciclo='".$data['cciclo']."' 
								  and ccurric='".$datacurric[0]["ccurric"]."'
								  and trgrupo='R'";
												
				$db->setQuery($validagrupo);
				$datag=$db->loadObjectList();		
					if(count($datag)==0){
						$grupos=$db->generarCodigo('gracprp','cgracpr',12,$data['usuario']);
						$sql="INSERT INTO gracprp (cgracpr,csemaca,cfilial,cinstit,ctipcar,cmodali,cinicio,cturno,cfrecue,chora,ccarrer,cciclo,dseccio,ccurric,cesgrpr,fingrpr,finicio,ffin,dmotest,fesgrpr,cperson,cusuari,fusuari,ttiptra,trgrupo,nmetmat,nmetmin,observacion) VALUES
							('$grupos',
							'".$data["csemaca"]."',
							'".$filiales[$i]."',
							'".$data['cinstit']."',
							'".$data['ctipcar']."',
							'".$data['cmodali']."',
							'".$data["cinicio"]."',
							'".$data["cturno"]."',
							'".$data['dias']."',
							'".$data["chora"]."',
							'".$carreras[$j]."',
							'".$data['cciclo']."',
							'1',
							'".$datacurric[0]["ccurric"]."',
							'3',
							'".$data["finicio"]."',
							'".$data["finicio"]."',
							'".$data["ffinal"]."',
							'".$data['usuario']."',
							'".$data['ffinal']."',
							'','".$data['usuario']."',now(),'I','R',
							'".$data['nmetmat']."','".$data['nmetmin']."','".$data['observacion']."');";
						$db->setQuery($sql);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
						}

						$sql="INSERT into detgrap (cgracpr,ncapaci,dseccio,fusucre,cusucre) VALUES 
							('$grupos',							
							'".$data['nmetmat']."',
							'A',
							now(),
							'".$data['usuario']."');";
						$db->setQuery($sql);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
						}

						$cursos="SELECT ccurso,ncredit 
								FROM placurp 
								WHERE cciclo = '".$data['cciclo']."' 
								AND ccurric = '".$datacurric[0]["ccurric"]."'
								AND cestado='1'";
						$db->setQuery($cursos);
						$datac=$db->loadObjectList();
						if(count($datac)>0){
							foreach($datac as $c){
							$cursos=$db->generarCodigo('cuprprp','ccuprpr',12,$data['usuario']);
							$sql="INSERT INTO cuprprp (ccuprpr,cgracpr,ccurric,ccurso,finipre,ffinpre,finivir,ffinvir,cusuari,fusuari,cfilial,ncredit) 
								VALUES ('$cursos', 
								'".$grupos."',
								'".$datacurric[0]["ccurric"]."',
								'".$c["ccurso"]."',";
								if($data2[0]['cmodali']=='1'){
							$sql.="
								'".$data["finicio"]."',
								'".$data["ffinal"]."',
								null,
								null,";
								}
								else{
							$sql.="
								null,
								null,
								'".$data["finicio"]."',
								'".$data["ffinal"]."',";
								}
							
							$sql.="
								'".$data["usuario"]."',
								now(),
								'".$filiales[$i]."',
								'".$c["ncredit"]."')";
							$db->setQuery($sql);
								if(!$db->executeQuery()){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
								}
								if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
								}
							}
						}
						else{
							$db->rollbackTransaccion();
							return array('rst'=>'2','msj'=>'No hay Plan Curricular para el Ciclo y Curricula seleccionada.','sql'=>$cursos." => ".$sqlcurricula);exit();
						}
					}
					else{
					$db->rollbackTransaccion();
					return array('rst'=>'2','msj'=>'Grupo Academico Existente.','sql'=>$cursos);exit();
					}
				}
			}
		}
		else{		
		$db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>'Fechas del grupo no se encuentran dentro del rango de las fechas del semestre.','sql'=>$cursos);exit();
		}
			
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Se registro correctamente',"sql"=>$sql);exit();		
	}
	
	public function ActualizarGrupoAcademico($data){
	$db=creadorConexion::crear('MySql');
	$valorvalidado=false;
	$fechasinicio=explode(",",$data['fechainiciosemestre']);
	$fechasfin=explode(",",$data['fechafinsemestre']);
		for($i=0;$i<=count($fechasinicio);$i++){
			if($fechasinicio[$i]<=$data["finicio"] and $data["ffinal"]<=$fechasfin[$i]){
			$valorvalidado=true;
			break;
			}
		}

		$arraydatos=explode(",",",A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T");

		if($data['valores']!=''){


		$valores=explode("|",$data['valores']);
			for($i=1;$i<count($valores);$i++){
				$dval=explode("-",$valores[$i]);
				if($dval[0]=="si"){
					$sql="insert into detgrap (cgracpr,ncapaci,dseccio,cusucre,fusucre) 
						  values('".$data["cgruaca"]."','".$dval[1]."','".$arraydatos[$i]."','".$data["usuario"]."',now())";
				}
				else{
					$sql="UPDATE detgrap 
						  SET ncapaci='".$dval[1]."'
						  ,cestado='".$dval[2]."'
						  ,cusumod='".$data['usuario']."'
						  ,fusumod=now() 
						  WHERE dseccio='".$arraydatos[$i]."'
						  AND cgracpr='".$data['cgruaca']."'";
				}
				$db->setQuery($sql);	
			
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
				}
			}

		}


	//if($valorvalidado==true){
		//DATOS DEL GRUPO ACTUAL
		// fase 2
		$sqlGrupo = "select * from gracprp where cgracpr = '".$data["cgruaca"]."'";
		$db->setQuery($sqlGrupo);
		$grupo=$db->loadObject();
		//PREGUNTAR SI EL GRUPO NUEVO YA EXISTE
		$validagrupo = "select count(*) as cant from gracprp where csemaca = '".$grupo->csemaca."' ";
		$validagrupo .=" and cfilial ='".$grupo->cfilial."'  ";
		$validagrupo .=" and cinstit = '".$grupo->cinstit."' ";
		$validagrupo .=" and ctipcar = '".$grupo->ctipcar."' ";
		$validagrupo .=" and cmodali = '".$grupo->cmodali."' ";
		$validagrupo .=" and cinicio = '".$grupo->cinicio."' ";
		$validagrupo .=" and cturno = '".$data["cturno"]."' ";
		$validagrupo .=" and cfrecue = '".$data["dias"]."' ";
		$validagrupo .=" and chora = '".$data["chora"]."' ";
		$validagrupo .=" and ccarrer = '".$grupo->ccarrer."' ";
		$validagrupo .=" and cciclo = '".$grupo->cciclo."' ";
		$validagrupo .=" and ccurric = '".$grupo->ccurric."' ";
		$validagrupo .=" and finicio = '".$data["finicio"]."' ";
		$validagrupo .=" and ffin = '".$data["ffinal"]."' ";
		$validagrupo .=" and nmetmat = '".$data["nmetmat"]."' ";
		$validagrupo .=" and nmetmin = '".$data["nmetmin"]."' ";
		$validagrupo .=" and observacion = '".$data["observacion"]."' ";

		$db->setQuery($validagrupo);
		$datag=$db->loadObjectList();		
			if( $datag[0]['cant']>0 ){			
				$db->commitTransaccion();
   				return array('rst'=>'1','msj'=>'Cambios guardados correctamente', 'fase'=>'fase 2');exit();
			}
		//Actualizar curso primero antes de cambiar grupos.	
		$sql = "UPDATE cuprprp SET  ";
		$sql .="  finipre = '".$data["finicio"]."' ,";
		$sql .="  ffinpre = '".$data["ffinal"]."' ,";
		$sql .="  finivir = '".$data["finicio"]."' ,";
		$sql .="  ffinvir = '".$data["ffinal"]."' ,";	
		$sql .="  cusuari = '".$data["usuario"]."' ,";	
		$sql .="  fusuari = NOW() ";
		$sql .= "where cgracpr in (	select cgracpr 
									from gracprp
									WHERE csemaca = '".$grupo->csemaca."' ";
							$sql .=" and cfilial ='".$grupo->cfilial."'  ";
							$sql .=" and cinstit = '".$grupo->cinstit."' ";
							$sql .=" and ctipcar = '".$grupo->ctipcar."' ";
							$sql .=" and cmodali = '".$grupo->cmodali."' ";
							$sql .=" and cinicio = '".$grupo->cinicio."' ";
							$sql .=" and cturno = '".$grupo->cturno."' ";
							$sql .=" and cfrecue = '".$grupo->cfrecue."' ";
							$sql .=" and chora = '".$grupo->chora."' ";
							$sql .=" and ccarrer = '".$grupo->ccarrer."' ";
							$sql .=" and cciclo = '".$grupo->cciclo."' ";
							$sql .=" and ccurric = '".$grupo->ccurric."' ";
							$sql .=" and finicio = '".$grupo->finicio."' ";
							$sql .=" and ffin = '".$grupo->ffin."' )";
		$db->setQuery($sql);	
		
		if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
		
		//ACTUALIZAR GRUPO
		$sql = "UPDATE gracprp SET  ";
		$sql .="  cturno = '".$data["cturno"]."' ,";
		$sql .="  cfrecue = '".$data["dias"]."' ,";
		$sql .="  chora = '".$data["chora"]."' ,";
		$sql .="  finicio = '".$data["finicio"]."' ,";
		$sql .="  ffin = '".$data["ffinal"]."' , ";
		$sql .="  fingrpr = '".$data["finicio"]."' ,";
		$sql .="  fesgrpr = '".$data["ffinal"]."' , ";
		$sql .="  nmetmat = '".$data["nmetmat"]."' ,";
		$sql .="  nmetmin = '".$data["nmetmin"]."' ,";
		$sql .="  observacion = '".$data["observacion"]."' ,";
		$sql .="  cusuari = '".$data["usuario"]."' ,";
		$sql .="  fusuari = NOW() ";
		$sql .= "where csemaca = '".$grupo->csemaca."' ";
		$sql .=" and cfilial ='".$grupo->cfilial."'  ";
		$sql .=" and cinstit = '".$grupo->cinstit."' ";
		$sql .=" and ctipcar = '".$grupo->ctipcar."' ";
		$sql .=" and cmodali = '".$grupo->cmodali."' ";
		$sql .=" and cinicio = '".$grupo->cinicio."' ";
		$sql .=" and cturno = '".$grupo->cturno."' ";
		$sql .=" and cfrecue = '".$grupo->cfrecue."' ";
		$sql .=" and chora = '".$grupo->chora."' ";
		$sql .=" and ccarrer = '".$grupo->ccarrer."' ";
		$sql .=" and cciclo = '".$grupo->cciclo."' ";
		$sql .=" and ccurric = '".$grupo->ccurric."' ";
		$sql .=" and finicio = '".$grupo->finicio."' ";
		$sql .=" and ffin = '".$grupo->ffin."' ";
		$db->setQuery($sql);
		$db->iniciaTransaccion();
		
		if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
	/*}
	else{
		$db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>'Fechas del grupo no se encuentran dentro del rango de las fechas del semestre.','sql'=>$cursos);exit();
	}*/
	
   $db->commitTransaccion();
   return array('rst'=>'1','msj'=>'Cambios guardados correctamente;', 'fase'=>'final');exit();
  }

  public function cargarCursosAcademicos($array){
  		$array['cgracpr']=str_replace(',',"','",$array['cgracpr']);
		$sql="	SELECT c.`ccuprpr`,cu.`dcurso`,ifnull(c.`finipre`,'') as finipre,ifnull(c.`ffinpre`,'') as ffinpre,ifnull(c.`finivir`,'') as finivir,ifnull(c.`ffinvir`,'') as ffinvir,
				IFNULL(CONCAT(pe.`dappape`,' ',pe.`dapmape`,', ',pe.`dnomper`),'') AS nombre,IFNULL(c.cprofes,'') cprofes,
				g.cinstit,g.cfilial 
				FROM gracprp g
				INNER JOIN cuprprp c ON (c.`cgracpr`=g.`cgracpr`)
				INNER JOIN cursom cu ON (cu.`ccurso`=c.`ccurso`)
				LEFT JOIN profesm p ON (p.`cprofes`=c.`cprofes`)
				LEFT JOIN personm pe ON (pe.`cperson`=p.`cperson`)
				WHERE g.cgracpr IN ('".$array['cgracpr']."')
				AND trgrupo='R'
				order by cu.dcurso";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Cursos Academicos','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarHorarioProgramado($array){  		
		$sql="	SELECT h.`chorpro`,h.`ccurpro`,h.ctietol,h.ctipcla,h.`chora`,h.`cdia`,a.`ctipamb`,h.`cambien`,
				concat(d.dnemdia,' | ',ho.hinici,' - ',ho.hfin,' | Turno: ',tu.dnemtur) as horario,
				IF(h.ctipcla='T','Teorico','Practica') AS tipo,ti.`mintol`,t.`dtipamb`,a.`numamb`, 
				concat(dappape,' ',dapmape,', ',dnomper) as dprofes,h.cprofes,h.cestado
				FROM horprop h
				INNER JOIN diasm d ON (d.`cdia`=h.`cdia`)
				INNER JOIN horam ho ON (ho.`chora`=h.`chora`)
				inner join turnoa tu on (tu.cturno=ho.cturno)
				INNER JOIN ambienm a ON (a.`cambien`=h.`cambien`)
				INNER JOIN tipamba t ON (t.`ctipamb`=a.`ctipamb`)
				INNER JOIN tietolm ti ON (ti.`ctietol`=h.`ctietol`)
				INNER JOIN profesm p ON (h.cprofes=p.cprofes)
				INNER JOIN personm pe ON (pe.cperson=p.cperson)
				WHERE h.ccurpro='".$array['ccuprpr']."'
				AND h.cdetgra='".$array['cdetgra']."'";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horarios cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Horarios','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarDetalleGrupo($array){
  		$array['cgracpr']=str_replace(',',"','",$array['cgracpr']);
		$sql="	SELECT cdetgra as id, dseccio as nombre 
				FROM detgrap
				WHERE cgracpr in ('".$array['cgracpr']."')";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Secciones cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Secciones','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarDiasdelGrupo($array){
  		$array['cgracpr']=str_replace(',',"','",$array['cgracpr']);
		$sql="	SELECT replace(cfrecue,'-',',') as dias
				FROM gracprp
				WHERE cgracpr in ('".$array['cgracpr']."')";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Dias del Grupo cargados','data'=>$data[0]['dias']);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Secciones','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarCursosAcademicosAlumno($array){
  		$db=creadorConexion::crear('MySql');
  		
		$sql2=" select g.ccurric
                from ingalum i
                inner join conmatp c on (i.cingalu=c.cingalu)
                inner join gracprp g on (c.cgruaca=g.cgracpr)
                where i.cingalu='".$array['cingalu']."'
                order by fmatric DESC
                limit 0,1 ";
        $db->setQuery($sql2);
        $data2=$db->loadObjectList();


		$sql="select t3.ccuprpr,t3.ccurricf,t3.ccursof,t3.dcursof,t3.ncredit,t3.gruequi,t3.ccurric,t3.ccurso,t3.dcurso
from (
	select ccuprpr,ccurricf,ccursof,dcursof,ncredit,gruequi,ccurric,ccurso,dcurso
	from (
		select ccuprpr,if(ccurria is not null,ccurria,ccurric) as ccurricf,if(ccursoa is not null, ccursoa,ccurso) as ccursof,if(dcurso2 is not null,dcurso2,dcurso) as dcursof,ncredit,gruequi,ccurric,ccurso,dcurso
		from (
			select c.ccuprpr,c.ccurric,c.ccurso,cu.dcurso,c.ncredit,eq.ccurria,eq.ccursoa,cu2.dcurso as dcurso2,eq.gruequi
			from cuprprp c
			inner join cursom cu on (cu.ccurso=c.ccurso)
			left join equisag eq on (eq.ccurric=c.ccurric and eq.ccurso=c.ccurso and eq.cestado='1')
			left join cursom cu2 on (cu2.ccurso=eq.ccursoa)
			-- inner join horprop h on (c.ccuprpr=h.ccurpro)
			where c.cgracpr='".$array['cgracpr']."'
			-- and h.cestado='1'
			and c.ccurso not in (
				select cu.ccurso
				from decomap d 
				inner join conmatp c on c.cconmat=d.cconmat
				INNER JOIN ingalum i on i.cingalu=c.cingalu
				inner join cuprprp cu on (cu.ccuprpr=d.ccurpro) 
				where i.cingalu='".$array['cingalu']."'
				and d.nnoficu>=11)
			GROUP BY c.ccurso,eq.ccurria,eq.ccursoa
			union
			select c.ccuprpr,c.ccurric,c.ccurso,cu.dcurso,c.ncredit,null ccurria,null ccursoa,null dcurso2,null gruequi			
			from cuprprp c
			inner join cursom cu on (cu.ccurso=c.ccurso)
			-- inner join horprop h on (c.ccuprpr=h.ccurpro)
			where c.cgracpr='".$array['cgracpr']."'
			-- and h.cestado='1'
			and c.ccurso not in (
				select cu.ccurso
				from decomap d 
				inner join conmatp c on c.cconmat=d.cconmat
				INNER JOIN ingalum i on i.cingalu=c.cingalu
				inner join cuprprp cu on (cu.ccuprpr=d.ccurpro) 
				where i.cingalu='".$array['cingalu']."'
				and d.nnoficu>=11)
			GROUP BY c.ccurso
		) t
	) t2
	GROUP BY t2.ccurric,t2.ccurso,t2.gruequi
) t3
inner join 
(
	select ccurric,ccurso,estado
	from (
		select p.ccurric,p.ccurso,
	    ifnull((select GROUP_CONCAT(cu.codicur SEPARATOR '<br>') 
	    from cursom cu 
	    where FIND_IN_SET (cu.ccurso,replace(p.dreqcur,'|',','))  >  0),'') as requisito,
	    IFNULL(cu.estado,'') as estado
	    from placurp p
	    inner join moduloa m on (p.cmodulo=m.cmodulo)
	    inner join cursom c on (p.ccurso=c.ccurso)
	    inner join cicloa ci on (ci.cciclo=p.cciclo)
	    left join ( select cu.ccurso,'Ok' as estado
	                from decomap d
	                inner join conmatp c on d.cconmat=c.cconmat
	                inner join ingalum i  on i.cingalu=c.cingalu
	                inner join cuprprp cu on cu.ccuprpr=d.ccurpro
	                where i.cingalu='".$array['cingalu']."'
	                and d.cestado='1'
	                and d.nnoficu>=11) cu on (cu.ccurso=c.ccurso)
		WHERE p.cestado='1' AND p.ccurric='".$data2[0]['ccurric']."'
	) z
	where z.estado!='Ok'
) t4 on (t3.ccurricf=t4.ccurric and t3.ccursof=t4.ccurso)	";
		$db->setQuery($sql);
        $data=$db->loadObjectList();

        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos Academicos Cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No Hay Cursos Academicos','data'=>$data,'sql'=>$sql);
        }

  }

  public function validarPasarRegistro($array){
  		$db=creadorConexion::crear('MySql');

  		$sql="	select  replace(p.dreqcur,'|',',')
				from cuprprp c
				inner join placurp p on c.ccurso=p.ccurso and c.ccurric=p.ccurric
				where c.ccuprpr='".$array['ccuprpr']."'";

  		if($array['gruequi']!=''){
  			$sql="	select  GROUP_CONCAT(replace(p.dreqcur,'|',',') SEPARATOR ',')
					from equisag e
					inner join placurp p on e.ccursoa=p.ccurso and e.ccurria=p.ccurric
					where e.gruequi='".$array['gruequi']."'
					GROUP BY e.gruequi";
  		}

  		$sqlcurso=" SELECT ccurso 
  					FROM cuprprp
  					WHERE ccuprpr='".$array['ccuprpr']."' ";

  		$sql="	SELECT count(c.ccurso) cantidad
				from decomap d
				inner join conmatp co on co.cconmat=d.cconmat
				inner join ingalum i on i.cingalu=co.cingalu
				inner join cuprprp c on c.ccuprpr=d.ccurpro
				where d.cestado='1'
				and i.cingalu='".$array['cingalu']."'
				AND c.ccurso in (".$sqlcurso.") 
				GROUP BY c.ccurso ";
		$db->setQuery($sql);
        $data=$db->loadObjectList();

  		
		$sql2="	SELECT count(c.ccurso) cantidad,max(d.nnoficu) notafinal
				from decomap d
				inner join conmatp co on co.cconmat=d.cconmat
				inner join ingalum i on i.cingalu=co.cingalu
				inner join cuprprp c on c.ccuprpr=d.ccurpro
				where d.cestado='1'
				and i.cingalu='".$array['cingalu']."'
				and FIND_IN_SET(c.ccurso,
					(".$sql.")
				)>0
				GROUP BY c.ccurso;";
        $db->setQuery($sql2);
        $data2=$db->loadObjectList();

        $cantidad=0;

        if(count($data)==0){
        	$cantidad=0;
        }
        else{
        	$cantidad=$data[0]['cantidad'];
        }

        if(count($data2)>0){
            return array('rst'=>'1','msj'=>'Cursos Academicos Cargados','data'=>$data2[0]['notafinal'],'data2'=>$cantidad);
        }
		else{
            return array('rst'=>'2','msj'=>'No Hay Cursos Academicos','data'=>$data2,'sql'=>$sql);
        }
  }

  public function crearPonderado($array){
  		$db=creadorConexion::crear('MySql');
  		$creditos=26;
  		$sql2=" select sum(d.nnoficu) suma,count(d.nnoficu) cantidad,round(sum(d.nnoficu)/count(d.nnoficu)) as notafinal,c.fmatric
				from personm p
				inner JOIN ingalum i on i.cperson=p.cperson
				inner JOIN conmatp c on c.cingalu=i.cingalu
				inner join decomap d on d.cconmat=c.cconmat
				where i.cingalu='".$array["cingalu"]."'
				and d.cestado='1'
				GROUP BY c.cconmat
				HAVING c.fmatric=max(c.fmatric);";
        $db->setQuery($sql2);
        $data2=$db->loadObjectList();

        if($data2[0]['notafinal']<11){
        	$creditos=16;
        }
        elseif($data2[0]['notafinal']>14){
        	$creditos=26;
        }


        return array('rst'=>'1','msj'=>'Creditos cargados','creditos'=>$creditos);

  }
  
}
?>
