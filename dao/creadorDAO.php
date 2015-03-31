<?php
class creadorDAO{
	public static function getTransaccionDAO(){
		return new MySqlTransaccionDAO;
	}
	public static function getPagoDAO(){
		return new MySqlPagoDAO;
	}
	public static function getReporteDAO(){
		return new MySqlReporteDAO;
	}
	public static function getLoginDAO(){
		return new MySqlLoginDAO;
	}

	public static function getPersonaDAO(){
		return new MySqlPersonaDAO;
	}
	
	public static function getUbigeoDAO(){
		return new MySqlUbigeoDAO;
	}
	
	public static function getInscritoDAO(){
		return new MySqlInscritoDAO;
	}
	
	public static function getCarreraDAO(){
		return new MySqlCarreraDAO;
	}
	
	public static function getConceptoDAO(){
		return new MySqlConceptoDAO;
	}	
	
	public static function getGrupoAcademicoDAO(){
		return new MySqlGrupoAcademicoDAO;
	}
	
	public static function getMatriculaDAO(){
		return new MySqlMatriculaDAO;
	}
	
	public static function getInstitucionDAO(){
		return new MySqlInstitucionDAO;
	}
	
	public static function getCronogramaDAO(){
		return new MySqlCronogramaDAO;
	}
	
	public static function getCursoDAO(){
		return new MySqlCursoDAO;
	}

	public static function getCuentaDAO(){
		return new MySqlCuentaDAO;
	}
	
	public static function getInstitutoDAO(){
		return new MySqlInstitutoDAO;
	}
	
	public static function getFilialDAO(){
		return new MySqlFilialDAO;
	}
	
	public static function getPlanCurricularDAO(){
		return new MySqlPlanCurricularDAO;
	}
        
    public static function getCencapDAO(){
		return new MySqlCencapDAO;
	}
        public static function getOpevenDAO(){
		return new MySqlOpevenDAO;
	}
		        
    public static function getModSistDAO(){
		return new MySqlModSistDAO;
	}
		        
    public static function getGrupUsuDAO(){
		return new MySqlGrupUsuDAO;
	}
		        
    public static function getOpcSistDAO(){
		return new MySqlOpcSistDAO;
	}
		        
    public static function getModIngDAO(){
		return new MySqlModIngDAO;
	}
		        
    public static function getHoraDAO(){
		return new MySqlHoraDAO;
	}
	
    public static function getMedpreDAO(){
		return new MySqlMedpreDAO;
	}
	
	public static function getTipoCaptacionDAO(){
		return new MySqlTipoCaptacionDAO;
	}
	
	public static function getAsistenciaDAO(){
    	return new MySqlAsistenciaDAO;
	}
	
	public static function getRegistroDAO(){
		return new MySqlRegistroDAO;
	}

	public static function getBoltoleDAO(){
		return new MySqlBoltoleDAO;
	}
        
    public static function getEquivalenciaDAO(){
		return new MySqlEquivalenciaDAO;
	}

	public static function getAmbienteDAO(){
		return new MySqlAmbienteDAO;
	}

	public static function getDocenteDAO(){
		return new MySqlDocenteDAO;
	}

	public static function getHorarioDAO(){
		return new MySqlHorarioDAO;
	}
	public static function getProfesDisponibilidadDAO(){
		return new MySqlProfesDisponibilidadDAO;
	}

}
?>