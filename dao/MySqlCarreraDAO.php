<?
class MySqlCarreraDAO{
    public function cargarTipoCarrera(){
        $sql="SELECT ctipcar as id, dtipcar as nombre FROM tipcarm ORDER BY dtipcar";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tipo de Carrera cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Tipos de Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarModalidad(){
        $sql="SELECT cmodali as id, dmodali as nombre FROM modalim ORDER BY dmodali";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modalidad cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Modalidad','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargaAmbiente($cfilial){
        $sql="select cambien id , numamb nombre from ambienm where cfilial = $cfilial";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ambientes cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Ambientes','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCarrera($ctipcar,/*$cmodali,*/$cinstit,$cfilial){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
        $sql="SELECT c.ccarrer as id,c.dcarrer as nombre
			  FROM carrerm c,filcarp f 
			  WHERE c.ccarrer=f.ccarrer 
			  AND f.cfilial='".$cfilial."' 
			  AND c.cestado='1' 
			  AND f.cestado='1' 
			  AND c.cmodali='".$cmodali[0]['cmodali']."' 
			  AND c.ctipcar='".$ctipcar."' 
			  AND c.cinstit='".$cinstit."' 
			  ORDER BY c.dcarrer";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarSemestre($cinstit,$cfilial){
        $sql="SELECT DISTINCT(csemaca) as id,csemaca as nombre
			  FROM semacan 
			  WHERE cestado='1' 
			  AND cfilial='".$cfilial."' 
			  AND cinstit='".$cinstit."' 
			  ORDER BY csemaca";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestres cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Semestres','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarSemestreR($cinstit,$cfilial){
        $sql="select DISTINCT(csemaca) as id,csemaca as nombre 
			from gracprp
			where cfilial='".$cfilial."'
			and cinstit='".$cinstit."'
			order by csemaca desc
			limit 1,5";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestres cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Semestres','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarInicio($cinstit,$cfilial,$csemaca){
        $sql="SELECT DISTINCT(cinicio) as id,cinicio as nombre
			  FROM semacan 
			  WHERE csemaca='".$csemaca."' 
			  AND cestado='1' 
			  AND cfilial='".$cfilial."' 
			  AND cinstit='".$cinstit."' 
			  ORDER BY cinicio";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Inicios cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Inicios','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarInicioR($cinstit,$cfilial,$csemaca){
        $sql="SELECT DISTINCT(cinicio) as id,cinicio as nombre
			  FROM semacan 
			  WHERE csemaca='".$csemaca."'
			  AND cfilial='".$cfilial."' 
			  AND cinstit='".$cinstit."' 
			  AND cestado='1'
			  ORDER BY cinicio";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Inicios cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Inicios','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarModalidadIngreso($cinstit){
        $sql="SELECT cmoding as id,dmoding as nombre
			  FROM modinga 
			  WHERE cinstita='".$cinstit."'";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modalidad Ingreso cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Modalidad Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarModalidadIngresoIns($cinstit){
        $sql="SELECT concat(cmoding,'-',treqcon) as id,dmoding as nombre
			  FROM modinga 
			  WHERE cinstita='".$cinstit."'
			  and cestado=1";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modalidad Ingreso cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Modalidad Ingreso','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarMedioCaptacion(){
        $sql="	SELECT concat(ctipcap,'-',dclacap,'-',didetip) as id,UPPER(dtipcap) as nombre
				FROM tipcapa 
				WHERE cestado=1
				-- AND didetip!='R'
				ORDER BY dclacap,dtipcap";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Medio Captacion cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Medio Captacion','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarMedioPrensa($cfilial){
        $sql="SELECT CONCAT(cmedpre,'|',tmedpre) as id,dmedpre as nombre 
			  FROM medprea 
			  WHERE cfilial='".$cfilial."' 
			  ORDER BY dmedpre";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Medio Captacion cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Medio Captacion','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarBanco(){
        $sql="Select cbanco as id,dbanco as nombre
			  from bancosm 
			  where cbanco not in ('001')";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Bancos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Bancos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCiclo(){
        $sql="Select cciclo as id,dciclo as nombre
			  from cicloa 
			  where cestado=1
			  ORDER BY dciclo";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ciclos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ciclos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCiclo2(){
        $sql="Select cciclo as id,dciclo as nombre
			  from cicloa 
			  ORDER BY dciclo";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ciclos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ciclos','data'=>$data,'sql'=>$sql);
        }
    }
    
    public function cargarCiclosdeModuloa($id_carrera){
        $id_carrera=str_replace(",","','",$id_carrera);
        $sql="  select c.cciclo id , m.dmodulo nombre 
                from moduloa m 
                inner join cicloa c on (c.nromcic = m.nrommod)
                where c.cestado = 1 
                and m.ccarrer in ('".$id_carrera."')
                group by c.cciclo, m.dmodulo";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ciclos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ciclos','data'=>$data,'sql'=>$sql);
        }
    }
    
	
	public function cargarCurricula($r){
		
        $sql="SELECT ccurric as id,dtitulo as nombre
			  FROM curricm 
			  WHERE ccarrer='".$r['ccarrer']."' 
			  AND cestado='1' 
			  ORDER BY dtitulo";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Curriculas cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Curriculas','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarCarreraG($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		
        $sql="SELECT DISTINCT c.ccarrer as id,c.dcarrer as nombre
			  FROM carrerm c
			  INNER JOIN filcarp f 
			  	ON c.ccarrer = f.ccarrer
				AND c.ctipcar = f.ctipcar
				AND f.cestado = '1'
			  WHERE f.cfilial IN ('".str_replace("\\","",$r['cfilial'])."')
			  AND c.cmodali='".$cmodali[0]['cmodali']."' 
			  AND c.ctipcar='".$r['ctipcar']."' 
			  AND c.cinstit='".$r['cinstit']."' 
			  AND c.cestado='1' 
			  ORDER BY c.dcarrer";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarInicioG($r){
        $sql="SELECT DISTINCT(cinicio) as id,cinicio as nombre
			  FROM semacan 
			  WHERE csemaca='".$r['csemaca']."' 
			  AND cfilial IN ('".str_replace("\\","",$r['cfilial'])."')
			  AND cinstit='".$r['cinstit']."' 
			  AND cestado='1' 
			  ORDER BY cinicio";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Inicios cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Inicios','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarSemestreG($r){
		$institucion="";
		if(trim($r['cinstit'])!=''){
			$institucion=" AND cinstit='".$r['cinstit']."' ";
		}
		
        $sql="SELECT DISTINCT(csemaca) as id,csemaca as nombre
			  FROM semacan 
			  WHERE cestado='1' 
			  AND cfilial IN ('".str_replace("\\","",$r['cfilial'])."')
			  ".$institucion."
			  ORDER BY csemaca";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestres cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Semestres','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarTurno(){
        $sql="Select cturno as id,dturno as nombre
			  from turnoa 
			  ORDER BY dturno";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Turnos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Turnos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarHora($r){
        $sql="Select chora as id,concat(hinici,' - ',hfin) as nombre
			  from horam
			  WHERE cturno='".$r['cturno']."' 			  
			  AND cinstit='".$r['cinstit']."'
			  AND thora='".$r['thora']."'
			  AND cestado='1'
			  ORDER BY nombre";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Horas','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarDias(){
        $sql="Select cdia as id,dnomdia as nombre
			  from diasm			 
			  ORDER BY dnomdia";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Dias cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Dias','data'=>$data,'sql'=>$sql);
        }
    }
	
    public function atualizarSemestre($r){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        $sql="UPDATE semacan
          SET cestado= '".$r['cestado']."',
              fusuari= 'now()',
              cusuari= '".$r['cusuari']."'
          WHERE     cfilial='".$r['cfilial']."' 
                AND cinstit='".$r['cinstit']."'
                AND csemaca='".$r['csemaca']."'
                and cinicio='".$r["cinicio"]."'
                and finisem='".$r["finisem"]."'
";
            $db->setQuery($sql);
            if(!$db->executeQuery()){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
                }
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
                }else{
                        $db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente','sql'=>$sql);exit();
                    
                }
 	}
	
	public function ModificarSemestre($r){
		$d=explode("|",$r["datos"]);
        $db=creadorConexion::crear('MySql');
		 $sql="	SELECT *
				FROM semacan
          		WHERE cfilial= '".$r['cfilial']."'
				AND cinstit='".$d[2]."'
				AND cinicio = '".$r['cinicio']."'
				AND csemaca= '".$r['csemaca']."'
				AND finisem= '".$r['finisem']."'
				AND finimat= '".$r['finimat']."'
				AND ffinsem= '".$r['ffinsem']."'
                AND ffinmat= '".$r['ffinmat']."'
                AND fechgra= '".$r['fechgra']."'
				AND fechext= '".$r['fechext']."'";
	        $db->setQuery($sql);
			$data=$db->loadObjectList();
			if(count($data)>0){	
			return array('rst'=>'2','msj'=>'Actualizacion no realizado ya existe Semestre','sql2'=>$sql);exit();						
			}
			else{				
				$db->iniciaTransaccion();
				$sql="	UPDATE semacan
						SET cfilial= '".$r['cfilial']."',				
						cinicio = '".$r['cinicio']."',
						csemaca= '".$r['csemaca']."',
						finisem= '".$r['finisem']."',
						finimat= '".$r['finimat']."',
						ffinsem= '".$r['ffinsem']."',
                        ffinmat= '".$r['ffinmat']."',
                        fechgra= '".$r['fechgra']."',
						fechext= '".$r['fechext']."',
						fusuari= 'now()',
						cusuari= '".$r['cusuari']."'
						WHERE csemaca='".$d[0]."' 
						AND cfilial='".$d[1]."'
						AND cinstit='".$d[2]."'
						and cinicio='".$d[3]."'
						and finisem='".$d[4]."'";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
					else{
						$db->commitTransaccion();
						return array('rst'=>'1','msj'=>'Cambios guardados correctamente','sql'=>$sql);exit();							
					}
			}
 	}	
    
	public function guardarSemestre($r){
        $db=creadorConexion::crear('MySql');
	//seleccionar modalidad
        $mod_sql = "select cmodali from instita where cinstit ='".$r['cinstit']."' ";
        $db->setQuery($mod_sql);
	$data=$db->loadObject();
        $r['cmodali'] = $data->cmodali;
        
		$repetidas="no";
		$arrfil = explode(",",$r['cfilial']);
		$arrins = explode(",",$r['cinstit']);
		
		$cjtodatos = explode('^',$r['datos']);
		
		$db->iniciaTransaccion();
		foreach($arrfil as $cfilial){
			foreach($arrins as $cinstit){
				foreach($cjtodatos as $datalinea){
				
					$datalimpia = explode('|',$datalinea);
								
							$sql="SELECT * 
								  FROM semacan 
								  WHERE cfilial='".$cfilial."' 
									AND cinstit='".$cinstit."'
									AND cmodali='".$r['cmodali']."'
									AND cinicio='".$datalimpia[1]."'
									AND ctipcar='2'
									AND csemaca='".$datalimpia[0]."'";
							$db->setQuery($sql);
							$data=$db->loadObjectList();
							
							if(count($data)>0){
									$repetidas="si";
									$sql="UPDATE semacan
										  SET finisem= '".$datalimpia[2]."',
										      ffinsem= '".$datalimpia[3]."',
										      finimat= '".$datalimpia[4]."',
                                              ffinmat= '".$datalimpia[5]."',
                                              fechgra= '".$datalimpia[6]."',
										      fechext= '".$datalimpia[7]."',
										      fusuari= 'now()',
										  	  cusuari= '".$r['cusuari']."'
										  WHERE cfilial='".$cfilial."' 
											AND cinstit='".$cinstit."'
											AND cmodali='".$r['cmodali']."'
											AND cinicio='".strtoupper($datalimpia[1])."'
											AND ctipcar='2'
											AND csemaca='".$datalimpia[0]."'";
									$db->setQuery($sql);
									if(!$db->executeQuery()){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
									}
									if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
									}	
							}else{
								
									$sql="INSERT INTO semacan  (csemaca, cfilial, ctipcar, cmodali, cinicio, cinstit, finisem, ffinsem, finimat, ffinmat , fechgra , fechext, cestado, fusuari,cusuari )
										  VALUES ('".$datalimpia[0]."',
												  '".$cfilial."',
												  '2',
												  '".$r['cmodali']."',
												  '".strtoupper($datalimpia[1])."',
												  '".$cinstit."',
												  '".$datalimpia[2]."',
												  '".$datalimpia[3]."',
												  '".$datalimpia[4]."',
                                                  '".$datalimpia[5]."',
                                                  '".$datalimpia[6]."',
												  '".$datalimpia[7]."',
												  '1',
												  now(),
												  '".$r['cusuari']."')";	
									$db->setQuery($sql);
									if(!$db->executeQuery()){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos: ','sql'=>$sql);exit();
									}
									if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
										$db->rollbackTransaccion();
										return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
									}
							}
				}// foreach datos
			}// foreach instituto
		}// foreach filial
		if($repetidas=="si"){
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente; Se actualizaron los Semestres registrados anteriormente.');exit();
		}else{
			$db->commitTransaccion();
			return array('rst'=>'1','msj'=>'Cambios guardados correctamente');exit();
		}
	}
	
	public function cargarCarreraM($r){
         $db=creadorConexion::crear('MySql');
        //obteniendo modalidad
        $sql = "select cmodali as m from instita where cinstit =".$r['cinstit'];
        $db->setQuery($sql);
        $data=$db->loadObject();  
            
        $sql="SELECT DISTINCT ccarrer as id,dcarrer as nombre
			  FROM carrerm
			  WHERE cmodali='".$data->m."' 
			  AND ctipcar='".$r['ctipcar']."' 
			  AND cinstit='".$r['cinstit']."' 
			  AND cestado='1' 
			  ORDER BY dcarrer";
        

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function validaModulos($r){
			
        $sql="SELECT 
				cmodulo As cmodulo,
				dmodulo As dmodulo,
				Cast(nrommod As Decimal) As nrommod
			  FROM moduloa
			  WHERE ccarrer = '".$r['ccarrer']."'
			  ORDER BY 3";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modulos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Modulos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarModulos($r){
        $sql="SELECT 
				cmodulo As id,
				dmodulo As nombre,
				Cast(nrommod As Decimal) As nrommod
			  FROM moduloa
			  WHERE ccarrer = '".$r['ccarrer']."'
			  ORDER BY 3";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Modulos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Modulos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function guardarModulo($r){
        $sql="SELECT *
			  FROM moduloa
			  WHERE ccarrer = '".$r['ccarrer']."'
			  	AND dmodulo = '".$r['dmodulo']."'";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
		if(count($data)>0){
			return array('rst'=>'2','msj'=>"El modulo ya ha sido registrado Anteriormente",'sql'=>$sql);exit();
        }else{
			$sqlcod="SELECT RIGHT(CONCAT('000',CONVERT( IFNULL(MAX(cmodulo),'0')+1, CHAR)),3) As cmodulo
					 FROM moduloa";
			$db->setQuery($sqlcod);
			$cmodulo=$db->loadObjectList();
			
			$sqlnro="SELECT IFNULL(COUNT(cmodulo),0)+1 As nrommod
					 FROM moduloa
					 WHERE ccarrer='".$r['ccarrer']."'";
			$db->setQuery($sqlnro);
			$nrommod=$db->loadObjectList();
			
			$sql="INSERT INTO moduloa (cmodulo,dmodulo,nrommod,ccarrer)
				  VALUES('".$cmodulo[0]['cmodulo']."',
						 '".$r['dmodulo']."',
						 '".$nrommod[0]['nrommod']."',
						 '".$r['ccarrer']."')";
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Modulo Registrado correctamente','cmodulo'=>$cmodulo[0]['cmodulo']);exit();
			}
        }
    }
	
	public function actuaNroModulo($r){
        $db=creadorConexion::crear('MySql');
        
		$sqlnro="SELECT nrommod
				 FROM moduloa
				 WHERE ccarrer='".$r['ccarrer']."'
				   AND cmodulo='".$r['cmodulo']."'";

        $db->setQuery($sqlnro);
        $data=$db->loadObjectList();
		if($data[0]['nrommod']=='1'){
			return array('rst'=>'2','msj'=>"Este modulo ya tiene el menor Numero de Orden, NO se puede disminuir.".$data[0]['nrommod'],'sql'=>$sqlnro);exit();
        }else{
			$sqlcod2="SELECT cmodulo
					 FROM moduloa
					 WHERE ccarrer='".$r['ccarrer']."'
					   AND nrommod='".($data[0]['nrommod']-1)."'";
			$db->setQuery($sqlcod2);
			$cmodulo2=$db->loadObjectList();
			
			$sqlact1="UPDATE moduloa
					 SET nrommod = '".($data[0]['nrommod']-1)."'
					 WHERE ccarrer='".$r['ccarrer']."'
					   AND cmodulo='".$r['cmodulo']."'";
			$db->iniciaTransaccion();
			$db->setQuery($sqlact1);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlact1);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sqlact1,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlact1);exit();
			}else{
				$sqlact2="UPDATE moduloa
						 SET nrommod = '".($data[0]['nrommod'])."'
						 WHERE ccarrer='".$r['ccarrer']."'
						   AND cmodulo='".$cmodulo2[0]['cmodulo']."'";
				$db->setQuery($sqlact2);
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlact2);exit();
				}else if(!MySqlTransaccionDAO::insertarTransaccion($sqlact2,$r['cfilialx']) ){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlact2);exit();
				}else{
					$db->commitTransaccion();
					return array('rst'=>'1','msj'=>'Modulo actualizado Correctamente','cmodulo2'=>$cmodulo2[0]['cmodulo']);exit();
				}
			}
        }
    }
	
	public function actuaDescModulo($r){
        $sql="SELECT *
			  FROM moduloa
			  WHERE ccarrer = '".$r['ccarrer']."'
			  	AND dmodulo = '".$r['dmodulo']."'";

        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
		if(count($data)>0){
			return array('rst'=>'2','msj'=>"El modulo ya ha sido registrado Anteriormente",'sql'=>$sql);exit();
        }else{
			$sql="UPDATE moduloa
				  SET dmodulo = '".$r['dmodulo']."'
				  WHERE ccarrer='".$r['ccarrer']."'
					AND cmodulo='".$r['cmodulo']."'";
					   
			$db->iniciaTransaccion();
			$db->setQuery($sql);
			
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}else if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
			}else{
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Modulo actualizado Correctamente');exit();
			}
        }
    }
	
	public function validaCarreras($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
        $sql="SELECT 
				GROUP_CONCAT(fc.cfilial SEPARATOR '|') as filiales,
				c.ccarrer,
				c.dcarrer,
				c.dabrcar,
				c.cestado
			  FROM carrerm c
			  INNER JOIN filcarp fc on (fc.ccarrer=c.ccarrer)  
			  WHERE c.cinstit = '".$r['cinstit']."' 
			  	AND c.ctipcar = '".$r['ctipcar']."' 
				And c.cmodali = '".$cmodali[0]['cmodali']."' 
			  GROUP BY c.ccarrer
			  ORDER BY c.dcarrer";

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function guardarCambiosCarreras($r){
        $db=creadorConexion::crear('MySql');
		
		$sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$r['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObjectList();
		
		$error = "";
		$cctaing="";
		$valestado="";
		
		$cjtodatos = explode('^',$r['datos']);
		$mensajenew="";
		$mensajeupd="";
		$db->iniciaTransaccion();
		foreach($cjtodatos as $datalinea){
			
			$datalimpia = explode('|',$datalinea);
			
			if($datalimpia[0]!="nuevo"){
				$valestado = " AND cestado='".$datalimpia[4]."'";
			}
			
			$imprime="";
			
			if($datalimpia[0]=="nuevo"){
	        $sql="SELECT *
				  FROM carrerm 
				  WHERE cinstit='".$r['cinstit']."'
				  AND (dcarrer='".$datalimpia[2]."' OR dabrcar='".$datalimpia[3]."')";
	        $db->setQuery($sql);
			$data=$db->loadObjectList();
				if(count($data)>0){
				$imprime="no";
				$mensajenew="| Nuevo no realizado ya existe Descripcion o Abreviatura";
				}
			}
			elseif($datalimpia[0]!="nuevo"){				
	        $sql="SELECT *
				  FROM carrerm 
				  WHERE cinstit='".$r['cinstit']."'
				  AND (dcarrer='".$datalimpia[2]."' OR dabrcar='".$datalimpia[3]."')
				  AND ccarrer!='".$datalimpia[0]."'";
	        $db->setQuery($sql);
			$data=$db->loadObjectList();
				if(count($data)>0){
				$imprime="no";
				$mensajeupd="| Actualizacion no realizado ya existe Descripcion o Abreviatura";
				}
			}
	        /*$data=$db->loadObjectList();
	        if(count($data)>0){
				//return array('rst'=>'2','msj'=>"La Carrera ya ha sido registrada Anteriormente",'sql'=>$sql);exit();
	        }else{*/
			
				if($datalimpia[0]!="nuevo" and $imprime==""){
					$sql="UPDATE carrerm
						  SET dcarrer = '".$datalimpia[2]."',
							  dabrcar = '".$datalimpia[3]."',
							  cestado = '".$datalimpia[4]."',
							  cusuari = '".$r['cusuari']."',
							  ttiptra = 'M',
							  fusuari = now()
						  WHERE ccarrer = '".$datalimpia[0]."'";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Actualizar Datos: '.$datalimpia[0],'sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
					
					$codcarrer=$datalimpia[0];
					
				}elseif($imprime==""){
					$sqlver1="SELECT right(concat('000',(max(ccarrer)+1)),3) as ccarrer
							  FROM carrerm";
					$db->setQuery($sqlver1);
					$ccarrer=$db->loadObjectList();
					
					$sql="INSERT INTO carrerm (ccarrer, dcarrer, cinstit, cmodali, ctipcar, dabrcar, fcreaci, cestado, cusuari, fusuari, ttiptra)
						  VALUES ('".$ccarrer[0]['ccarrer']."',
								  '".$datalimpia[2]."',
								  '".$r['cinstit']."',
								  '".$cmodali[0]['cmodali']."',
								  '".$r['ctipcar']."',
								  '".$datalimpia[3]."',
								  now(),
								  '1',
								  '".$r['cusuari']."',
								  now(),
								  'I')";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos: ','sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
					$codcarrer=$ccarrer[0]['ccarrer'];
				}
				
				//////////////Insert a FILCARP//////////////
				if($imprime==""){
					$sql="DELETE FROM filcarp
						  WHERe ccarrer = '".$codcarrer."'";
					$db->setQuery($sql);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Actualizar Datos:','sql'=>$sql);exit();
					}
					if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
					}
					
					$datfil = explode('~',$datalimpia[1]);
					
					foreach ($datfil as $cfilial){
						$sqlver1="SELECT concat(substring(year(now()),2),right(Concat('0000',convert((substring(IFNULL(max(cfilcar),0),4)+1),Char)),4)) As cfilcar
								  FROM filcarp
								  WHERE substring(cfilcar,1,3) = substring(year(now()),2)";
						$db->setQuery($sqlver1);
						$cfilcar=$db->loadObjectList();
		
						$sql="INSERT INTO filcarp (cfilcar, cfilial, ccarrer, ctipcar, cestado, festado, cusuari, fusuari, ttiptra)
							  VALUES ('".$cfilcar[0]['cfilcar']."',
									  '".$cfilial."',
									  '".$codcarrer."',
									  '".$r['ctipcar']."',
									  '1',
									  now(),
									  '".$r['cusuari']."',
									  now(),
									  'I')";
						$db->setQuery($sql);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Actualizar Datos','sql'=>$sql);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sql,$r['cfilialx']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
						}
					}
				}// fin de validaciones
			//}// fin valida repeticion
		}// fin foreach
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Cambios guardados correctamente.'."  <b>".$mensajenew.".    ".$mensajeupd.".</b>");exit();
	}
	
	public function cargarPais(){
        $sql="SELECT cpais as id, concat(iso,' - ',dpais) as nombre FROM paism ORDER BY dpais";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Pais cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Pais','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function GetDatosGrupo($cgruaca){
        $sql="  select g.* , GROUP_CONCAT(concat(d.ncapaci,'|',d.dseccio,'|',d.cestado) SEPARATOR '_') as detalle_grupo,count(d.cgracpr) as cantidad 
                from gracprp g
                inner join detgrap d on (g.cgracpr=d.cgracpr)
                where g.cgracpr='$cgruaca'
                group by g.cgracpr";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObject();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupo cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No cargo datos del grupo','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function GetDatosSemestre($csemaca){
		$d=explode("|",$csemaca);
        $sql="	select * from semacan 
				where csemaca ='".$d[0]."'
				AND cfilial='".$d[1]."'
				AND cinstit='".$d[2]."'
				AND cinicio='".$d[3]."'
				AND finisem='".$d[4]."'";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObject();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestre cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No cargo datos del semestre','data'=>$data,'sql'=>$sql);
        }
    }

    public function listarSemestres($data){
        $db=creadorConexion::crear('MySql');
		
$sql="SELECT 
(select f.dfilial from filialm as f where f.cfilial = s.cfilial) as filial,
(select i.dinstit from instita as i where i.cinstit = s.cinstit) as institucion,
s.cfilial,
s.cinstit,
s.csemaca as semestre, 
s.cinicio  as inicio, 
s.finisem as fisem, 
s.ffinsem as ffsem, 
s.finimat as fimat, 
s.ffinmat as ffmat,
s.fechgra as fegra,
s.fechext as feext,
s.cestado as estado,s.csemaca
FROM semacan  as s    
    WHERE s.cfilial in (".$data['cfilial'].") AND s.cinstit in (".$data['cinstit'].")"; 
$db->setQuery($sql);
$data=$db->loadObjectList();
if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestres cargado','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Semestres','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function listarMenuDinamico($r){
	$db=creadorConexion::crear('MySql');
	$sql="	select c.dcagrop,o.dopcion,o.durlopc
			from gruopcp g
			INNER JOIN opcionm o on (g.copcion=o.copcion) 
			INNER JOIN cagropp c on (g.ccagrop=c.ccagrop)
			where g.cgrupo='".$r['cgrupo']."'
			and o.cestado=1
			and c.cestado=1
			and g.cestado=1
			order by c.dcagrop,o.dopcion";
	$db->setQuery($sql);
	$data=$db->loadObjectList();
	return $data;
	}    
}
?>