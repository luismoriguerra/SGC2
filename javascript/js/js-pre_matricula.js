$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo
	carreraDAO.cargarTipoCarrera(sistema.llenaSelect,'slct_tipo_carrera','');
	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');	
	carreraDAO.cargarSemestreR(sistema.llenaSelect,'slct_semestre','');	
	carreraDAO.cargarCiclo(sistema.llenaSelect,'cciclo','');	
	
	$("#slct_tipo_carrera").change(function(){cargarCarrera("");cargarHorario("");});
	$("#slct_modalidad").change(function(){cargarCarrera("");cargarHorario("");});
	$("#slct_semestre").change(function(){cargarInicio("");cargarHorario("");});
	$("#slct_carrera").change(function(){cargarHorario("");});
	$("#slct_inicio").change(function(){cargarHorario("");});
	
})

cargarCarrera=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarCarrera(sistema.llenaSelect,'slct_carrera',marcado);
}  

cargarInicio=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarInicioR(sistema.llenaSelect,'slct_inicio',marcado);
} 

cargarHorario=function(marcado){ //tendra "marcado" en select luego cargar
	grupoAcademicoDAO.cargarGrupoAcademico(sistema.llenaSelect,'slct_horario',marcado);
} 

Exportar=function(){
	if($("#slct_tipo_carrera").val()==''){
	sistema.msjAdvertencia('Seleccione <b>Tipo Carrera</b>');
	$("#slct_tipo_carrera").focus();
	}
	else if($("#slct_modalidad").val()==''){
	sistema.msjAdvertencia('Seleccione <b>Modalidad</b>');
	$("#slct_modalidad").focus();
	}
	else if($("#slct_carrera").val()==''){
	sistema.msjAdvertencia('Seleccione <b>Carrera</b>');
	$("#slct_carrera").focus();
	}
	else if($("#slct_semestre").val()==''){
	sistema.msjAdvertencia('Seleccione <b>Semestre</b>');
	$("#slct_semestre").focus();
	}	
	else{
	window.location='../reporte/excel/EXCELpreMatricula.php?cfilial='+$("#hd_idFilial").val()+'&cinstit='+$("#hd_idInstituto").val()+'&csemaca='+$("#slct_semestre").val()+'&ccarrer='+$("#slct_carrera").val()+'&cciclo='+$("#cciclo").val()+'&cinicio='+$("#slct_inicio").val()+'&cgruaca='+$("#slct_horario").val()+'&cmodali='+$("#slct_modalidad").val()+'&ctipcar='+$("#slct_tipo_carrera").val();
	}
}