<?php
	abstract class controladorComandos{
		public function procesaRequest(){
			switch ($_SERVER['REQUEST_METHOD']){
				case 'POST':
					$this->doPost();
					break;
				case 'GET':
					$this->doGet();
					break;
			}
		}
		
		public function doPost(){}
		public function doGet(){}

		public static function getComando(){
			$classControlador=null;			
			switch ($_REQUEST['comando']) {
				case 'registro':
					$classControlador=new servletRegistro;
					break;
				case 'transaccion':
					$classControlador=new servletTransaccion;
					break;
				case 'pago':
					$classControlador=new servletPago;
					break;
				case 'reporte':
					$classControlador=new servletReporte;
					break;	
				case 'login':
					$classControlador=new servletLogin;
					break;
				case 'persona':
					$classControlador=new servletPersona;
					break;
				case 'ubigeo':
					$classControlador=new servletUbigeo;
					break;
				case 'inscrito':
					$classControlador=new servletInscrito;
					break;
				case 'carrera':
					$classControlador=new servletCarrera;
					break;
				case 'concepto':
					$classControlador=new servletConcepto;
					break;
				case 'grupo_academico':
					$classControlador=new servletGrupoAcademico;
					break;
				case 'matricula':
					$classControlador=new servletMatricula;
					break;
				case 'institucion':
					$classControlador=new servletInstitucion;
					break;
				case 'cronograma':
					$classControlador=new servletCronograma;
					break;
				case 'curso':
					$classControlador=new servletCurso;
					break;
				case 'cuenta':
					$classControlador=new servletCuenta;
					break;
				case 'instituto':
					$classControlador=new servletInstituto;
					break;
				case 'filial':
					$classControlador=new servletFilial;
					break;
				case 'curricula':
					$classControlador=new servletPlanCurricular;
					break;
                case 'cencap':
					$classControlador=new servletCencap;
					break;
                case 'opeven':
					$classControlador=new servletOpeven;
					break;
                case 'modsist':
					$classControlador=new servletModSist;
					break;
                case 'grupusu':
					$classControlador=new servletGrupUsu;
					break;
                case 'opcsist':
					$classControlador=new servletOpcSist;
					break;
                case 'moding':
					$classControlador=new servletModIng;
					break;
                case 'hora':
					$classControlador=new servletHora;
					break;
                case 'medpre':
					$classControlador=new servletMedpre;
					break;
				 case 'tipo_captacion':
					$classControlador=new servletTipoCaptacion;
					break;
				case "asistencia":
					$classControlador = new servletAsistencia;
	                break;
	           	case "boltole":
					$classControlador = new servletBoltole;
					break;
				case 'equivalencia':
					$classControlador=new servletEquivalencia;
					break;
				case 'ambiente':
					$classControlador=new servletAmbiente;
					break;
				case 'docente':
					$classControlador=new servletDocente;
					break;
				case 'horario':
					$classControlador=new servletHorario;
					break;
				case 'profesDisponibilidad':
					$classControlador=new servletProfesDisponibilidad;
					break;
				default:
                    echo json_encode(array('rst'=>3,'msj'=>'Comando no encontrado'));
                    exit();
			}
			return $classControlador;
		}

	}
?>