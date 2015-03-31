$(document).ready(function(){	
	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	ubigeoDAO.cargarDepartamento(sistema.llenaSelect,'slct_departamento,#slct_departamento2,#slct_departamento_c,#slct_departamento_t','');
	personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor,#slct_tipo_trabajador_t","");
})

ActVisualiza=function(){	
	$("#mantenimiento_jqgrid_vended").html('<div style="margin-right:3px">'+
												'<table id="table_jqgrid_vended"></table>'+
												'<div id="pager_table_jqgrid_vended"></div>'+
											'</div >');
	jqGridPersona.jqgridVended();
    
    //CARGAR SELECT OPEVEN
   
    personaDAO.listarOpeven(sistema.llenaSelect,"slct_opeven","");
    
    
}

cargarProvincia=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento','slct_provincia','');	
}

cargarDistrito=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento','slct_provincia','slct_distrito','');
}

cargarProvincia2=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento2','slct_provincia2','');	
}

cargarDistrito2=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento2','slct_provincia2','slct_distrito2','');
}

cargarProvinciat=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','');	
}

cargarDistritot=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t','');
}
