$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo
	/*institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');
        $("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();*/
        
        
	carreraDAO.cargarSemestre(sistema.llenaSelect,'slct_semestre','');	
	carreraDAO.cargarCarreraTodasDisponibles(sistema.llenaSelect,'slct_carrera','');	
	$("#slct_semestre").change(function(){cargarInicio("")});          
        
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
	
	if($("#slct_semestre").val()==''){
	sistema.msjAdvertencia('Seleccione <b>Semestre</b>');
	$("#slct_semestre").focus();
	}	
	else{
	window.location='../reporte/excel/EXCELcontadorpago.php?\n\
                cfilial='+$("#hd_idFilial").val()+
                '&cinstit='+$("#hd_idInstituto").val()+
                '&csemaca='+$("#slct_semestre").val()+
                '&ccarrer='+$("#slct_carrera").val()+
                '&cciclo='+$("#cciclo").val()+
                '&cinicio='+$("#slct_inicio").val()+
                '&cgruaca='+$("#slct_horario").val()+
                '&cmodali='+$("#slct_modalidad").val()+
                '&ctipcar=2';
	}
}