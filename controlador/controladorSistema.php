<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
    session_start();
    date_default_timezone_set('America/Lima');
    // error_reporting(0);
    require_once('../controlador/controladorComandos.php');

    require_once('../controlador/servletLogin.php');
	require_once('../controlador/servletPersona.php');
	require_once('../controlador/servletUbigeo.php');
    require_once('../controlador/servletInscrito.php');
	require_once('../controlador/servletCarrera.php');
	require_once('../controlador/servletConcepto.php');
	require_once('../controlador/servletGrupoAcademico.php');
	require_once('../controlador/servletMatricula.php');
    require_once('../controlador/servletPago.php');
    require_once('../controlador/servletInstitucion.php');
    require_once('../controlador/servletCronograma.php');
    require_once('../controlador/servletTransaccion.php');
	require_once('../controlador/servletCurso.php');
    require_once('../controlador/servletBancoCuenta.php');
	require_once('../controlador/servletInstituto.php');
	require_once('../controlador/servletFilial.php');
	require_once('../controlador/servletPlanCurricular.php');
    require_once('../controlador/servletCencap.php');
    require_once('../controlador/servletOpevenDAO.php');
    require_once('../controlador/servletModSist.php');
    require_once('../controlador/servletGrupUsu.php');
    require_once('../controlador/servletOpcSist.php');
    require_once('../controlador/servletModIng.php');
    require_once('../controlador/servletHora.php');
    require_once('../controlador/servletEquivalencia.php');
    require_once('../controlador/servletMedpre.php');
	require_once('../controlador/servletReporte.php');
	require_once('../controlador/servletTipoCaptacion.php');
	require_once('../controlador/servletAsistencia.php');	
	require_once('../controlador/servletRegistro.php');
    require_once('../controlador/servletBoltole.php');
    require_once('../controlador/servletAmbiente.php');
    require_once('../controlador/servletDocente.php');
    require_once('../controlador/servletHorario.php');
    require_once('../controlador/servletProfesDisponibilidad.php');   
    
    require_once('../conexion/creadorConexion.php');
    require_once('../conexion/MySqlConexion.php');
    require_once('../conexion/configMySql.php');
    
    require_once('../dao/creadorDAO.php');    
    require_once('../dao/MySqlLoginDAO.php');
	require_once('../dao/MySqlPersonaDAO.php');
	require_once('../dao/MySqlUbigeoDAO.php');
    require_once('../dao/MySqlInscritoDAO.php');
	require_once('../dao/MySqlCarreraDAO.php');
	require_once('../dao/MySqlConceptoDAO.php');
	require_once('../dao/MySqlGrupoAcademicoDAO.php');
	require_once('../dao/MySqlMatriculaDAO.php');
    require_once('../dao/MySqlPagoDAO.php');
    require_once('../dao/MySqlInstitucionDAO.php');
    require_once('../dao/MySqlCronogramaDAO.php');
    require_once('../dao/MySqlTransaccionDAO.php');
	require_once('../dao/MySqlCursoDAO.php');
    require_once('../dao/MySqlBancoCuentaDAO.php');
	require_once('../dao/MySqlInstitutoDAO.php');
	require_once('../dao/MySqlFilialDAO.php');
	require_once('../dao/MySqlPlanCurricularDAO.php');
    require_once('../dao/MySqlCencapDAO.php');
    require_once('../dao/MySqlOpevenDAO.php');
    require_once('../dao/MySqlModSistDAO.php');
    require_once('../dao/MySqlGrupUsuDAO.php');
    require_once('../dao/MySqlOpcSistDAO.php');
    require_once('../dao/MySqlModIngDAO.php');
    require_once('../dao/MySqlHoraDAO.php');
    require_once('../dao/MySqlEquivalenciaDAO.php');
    require_once('../dao/MySqlMedpreDAO.php');
	require_once('../dao/MySqlReporteDAO.php');
	require_once('../dao/MySqlTipoCaptacionDAO.php');
	require_once('../dao/MySqlAsistenciaDAO.php');
	require_once('../dao/MySqlRegistroDAO.php');
    require_once('../dao/MySqlBoltoleDAO.php');
    require_once('../dao/MySqlAmbienteDAO.php');
    require_once('../dao/MySqlDocenteDAO.php');
    require_once('../dao/MySqlHorarioDAO.php');
    require_once('../dao/MySqlProfesDisponibilidadDAO.php');
    
    require_once('../dto/dto_usuario.php');    
    
    /*phpexcel*/
    require_once '../php/includes/phpexcel/Classes/PHPExcel.php';
    require_once '../php/includes/phpexcel/Classes/PHPExcel/IOFactory.php';

    /*phpmailer*/
    require_once '../php/includes/phpmailer/class.phpmailer.php';
    /*funciones personales*/
    require_once '../php/funciones.php';

    $cn=controladorComandos::getComando();
    $cn->procesaRequest();
?>