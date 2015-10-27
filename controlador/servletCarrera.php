<?
class servletCarrera extends controladorComandos{
	public function doPost(){
		$daoCarrera=creadorDAO::getCarreraDAO();
    	switch ($_POST['accion']){
            case 'cargar_tipo_carrera':
                echo json_encode($daoCarrera->cargarTipoCarrera());
            break;			
			case 'cargar_modalidad':				
				echo json_encode($daoCarrera->cargarModalidad());
			break;
			case 'cargaAmbiente':
				$cfilial=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargaAmbiente($cfilial));
			break;
			case 'cargar_carrera':
				$ctipcar=trim($_POST['ctipcar']);
				//$cmodali=trim($_POST['cmodali']);
				$cinstit=trim($_POST['cinstit']);
				$cfilial=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargarCarrera($ctipcar/*,$cmodali*/,$cinstit,$cfilial));
			break;
			case 'cargar_semestre':
				$cinstit=trim($_POST['cinstit']);
				$cfilial=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargarSemestre($cinstit,$cfilial));			
			break;
			case 'cargar_semestre_r':
				$cinstit=trim($_POST['cinstit']);
				$cfilial=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargarSemestreR($cinstit,$cfilial));			
			break;
			case 'cargar_inicio':
				$cinstit=trim($_POST['cinstit']);
				$cfilial=trim($_POST['cfilial']);
				$csemaca=trim($_POST['csemaca']);
				echo json_encode($daoCarrera->cargarInicio($cinstit,$cfilial,$csemaca));
			break;
			case 'cargar_inicio_r':
				$cinstit=trim($_POST['cinstit']);
				$cfilial=trim($_POST['cfilial']);
				$csemaca=trim($_POST['csemaca']);
				echo json_encode($daoCarrera->cargarInicioR($cinstit,$cfilial,$csemaca));
			break;
			case 'cargar_modalidad_ingreso':
				$cinstit=trim($_POST['cinstit']);
				echo json_encode($daoCarrera->cargarModalidadIngreso($cinstit));
			break;
			case 'cargar_modalidad_ingreso_ins':
				$cinstit=trim($_POST['cinstit']);
				echo json_encode($daoCarrera->cargarModalidadIngresoIns($cinstit));
			break;
			case 'cargar_medio_captacion':
				echo json_encode($daoCarrera->cargarMedioCaptacion());
			break;
			case 'cargar_medio_prensa':
				$cfilial=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargarMedioPrensa($cfilial));
			break;
			case 'cargar_banco':
				echo json_encode($daoCarrera->cargarBanco());
			break;
			case 'cargar_ciclo':
				echo json_encode($daoCarrera->cargarCiclo());
			break;
			case 'cargar_ciclo2':
				echo json_encode($daoCarrera->cargarCiclo2());
			break;                    
			case 'cargarCiclosdeModuloa':
			$ccarrer=trim($_POST['ccarrer']);
			echo json_encode($daoCarrera->cargarCiclosdeModuloa($ccarrer));
			break;
                    
            case 'cargar_curricula':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
                echo json_encode($daoCarrera->cargarCurricula($data));
            break;
            case 'cargar_carrera_g':
			$data=array();
				$data['ctipcar']=trim($_POST['ctipcar']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
                echo json_encode($daoCarrera->cargarCarreraG($data));
            break;
			case 'cargarCarreraInstitucionMultiple':
				$data=array();
				$data['ctipcar']=trim($_POST['ctipcar']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoCarrera->cargarCarreraInstitucionMultiple($data));
				break;
            case 'cargar_semestre_g':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
                echo json_encode($daoCarrera->cargarSemestreG($data));
            break;
            case 'cargar_inicio_g':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['csemaca']=trim($_POST['csemaca']);
                echo json_encode($daoCarrera->cargarInicioG($data));
            break;
			case 'cargar_turno':
				echo json_encode($daoCarrera->cargarTurno());
			break;
			case 'cargar_dias':
				echo json_encode($daoCarrera->cargarDias());
			break;
			case 'cargar_hora':
			$data=array();
				$data['cturno']=trim($_POST['cturno']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['thora']=trim($_POST['thora']);
				echo json_encode($daoCarrera->cargarHora($data));
			break;
			case 'guardar_semestre':
			$data=array();
				$data['datos']=trim($_POST['datos']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cmodali']=trim($_POST['cmodali']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->guardarSemestre($data));
            break;
        	case 'actualizar_semestre':
			$data=array();				
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['csemaca']=trim($_POST['csemaca']);
				$data['cinicio']=trim($_POST['cinicio']);
				$data['finisem']=trim($_POST['finisem']);
				$data['cestado']=trim($_POST['cestado']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->atualizarSemestre($data));
            break;
			case 'ModificarSemestre':
			$data=array();				
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['csemaca']=trim($_POST['csemaca']);
				$data['cinicio']=trim($_POST['cinicio']);
				$data['finisem']=trim($_POST['finisem']);
				$data['ffinsem']=trim($_POST['ffinsem']);
				$data['finimat']=trim($_POST['finimat']);
				$data['ffinmat']=trim($_POST['ffinmat']);
				$data['fechgra']=trim($_POST['fechgra']);
				$data['fechext']=trim($_POST['fechext']);
				$data['resoluc']=trim($_POST['resoluc']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
				$data['datos']=trim($_POST['datos']);
                echo json_encode($daoCarrera->ModificarSemestre($data));
            break;
            case 'cargar_carrera_m':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				
				$data['ctipcar']=trim($_POST['ctipcar']);
                echo json_encode($daoCarrera->cargarCarreraM($data));
            break;
            case 'valida_modulos':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->validaModulos($data));
            break;
			case 'cargar_modulos':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->cargarModulos($data));
            break;
            case 'guardar_modulo':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['dmodulo']=trim($_POST['dmodulo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->guardarModulo($data));
            break;
            case 'act_nro_modulo':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['cmodulo']=trim($_POST['cmodulo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->actuaNroModulo($data));
            break;
            case 'act_desc_modulo':
			$data=array();
				$data['ccarrer']=trim($_POST['ccarrer']);
				$data['cmodulo']=trim($_POST['cmodulo']);
				$data['dmodulo']=trim($_POST['dmodulo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->actuaDescModulo($data));
            break;
            case 'valida_carreras':
			$data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->validaCarreras($data));
            break;
            case 'guardar_cambio_carrera':
			$data=array();
				$data['datos']=trim($_POST['datos']);
				$data['cinstit']=trim($_POST['cinstit']);
				//$data['cmodali']=trim($_POST['cmodali']);
				$data['ctipcar']=trim($_POST['ctipcar']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilialx']=trim($_POST['cfilialx']);
                echo json_encode($daoCarrera->guardarCambiosCarreras($data));
            break;
			case 'cargar_pais':				
				echo json_encode($daoCarrera->cargarPais());
			break;
			case 'GetDatosGrupo':
                $data['cgruaca']=trim($_POST['cgruaca']);
	        	echo json_encode($daoCarrera->GetDatosGrupo( $data['cgruaca']));
	        break;
			case 'GetDatosSemestre':
                $data['csemaca']=trim($_POST['csemaca']);
	        	echo json_encode($daoCarrera->GetDatosSemestre( $data['csemaca']));
	        break;
            case "listar_semestres":
                $data=array();
				$data['cinstit']=trim($_POST['cinstit']);
				$data['cfilial']=trim($_POST['cfilial']);
                echo  json_encode($daoCarrera->listarSemestres($data));
                break;
			case "actualizarHeader":
				$cfilial=explode("|",trim($_POST['cfilial']));
				$_SESSION['SECON']['cfilial']=$cfilial[0];
				$_SESSION['SECON']['dfilial']=$cfilial[1];
				echo  json_encode(array('rst'=>1,'msj'=>'Se cambio la filial'));
				break;
			case "cargarHeader":
                $data=array();
				$data['cgrupos']=trim($_POST['cgrupo']);
				$detdet=explode("|",$data['cgrupos']);
				$data['cgrupo']=$detdet[2];
				$_SESSION['SECON']['cfilial']=$detdet[0];
				$_SESSION['SECON']['dfilial']=$detdet[1];
				$_SESSION['SECON']['cinstit']=$detdet[4];
				$_SESSION['SECON']['dinstit']=$detdet[5];
				$_SESSION['SECON']['cgrupo']=$data['cgrupos'];
				$_SESSION['SECON']['menu']='';
				$detfil=explode("^^",$data['cgrupos']);
				foreach($detfil as $df){
					$ddf=explode("|",$df);
					$codigofiliales.=$ddf[0].",";
					$option.="<option value='".$ddf[0]."|".$ddf[1]."'><b>".$ddf[1]."</b></option>";
				}
				$ordenar=explode(",",$codigofiliales."9999");
				sort($ordenar);
				$_SESSION['SECON']['cfilials']=implode(",",$ordenar);
				$_SESSION['SECON']['slct_filial_cabecera']=$option;
					
				$menu=$daoCarrera->listarMenuDinamico($data);
				if(count($menu)>0){
					$cab="";
					$detmenu="";
					foreach($menu as $m){
						if($m['dcagrop']!=$cab){
							if($cab!=""){
						$detmenu.='	</ul>'.
								  '</li>';	
							}
						$detmenu.='<li id="nav-'.$m['dcagrop'].'" class="nav-sub">'.
								  '	<a> '.$m['dcagrop'].' <i class="icon-white icon-aba"></i></a>'.
								  '	<ul>';
						$cab=$m['dcagrop'];
						}
						$detmenu.='		<li id="'.$m['durlopc'].'"><a>'.$m['dopcion'].'</a></li>';
					}
						$detmenu.='	</ul>'.
								  '</li>';
				$_SESSION['SECON']['menu']=$detmenu;
				echo  json_encode(array('rst'=>1,'msj'=>'Se actualizó correctamente','menu'=>$detmenu));
				}
				else{
				echo  json_encode(array('rst'=>2,'msj'=>'Opciones desabilitadas'));
				}
                break;
    		default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoCarrera=creadorDAO::getCarreraDAO();
		switch ($_GET['accion']){
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>