$(document).ready(function(){	
	jqGridPersona.persona();
	//jqGridPersona.persona2();
	jqGridPersona.promotor();
	jqGridPersona.teleoperadora();
	jqGridPersona.recepcionista();
	jqGridPersona.exAlumno();
	jqGridPersona.dataWEB();
	jqGridPersona.docAut();	
	
	$('#frmPersona').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	
	$('#frmTrabajador').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	
	 //AGREGADO PARA EL MANTENIMIENTO DE PERSONAL
    $(':text[id^="txt_fecha"]').datepicker({
    dateFormat:'yy-mm-dd',
    dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
    monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    nextText:'Siguiente',
    prevText:'Anterior'
  	});
})

ListarPersona=function(){
	var dis=$("#mantenimiento_persona").css("display");
	if(dis=='none'){
	$("#mantenimiento_persona").css("display",'');
	}
	else{
	$("#mantenimiento_persona").css("display",'none');
	}
}

ListarRecepcionista=function(){
	var dis=$("#mantenimiento_recepcionista").css("display");
	if(dis=='none'){
	$("#mantenimiento_recepcionista").css("display",'');
	}
	else{
	$("#mantenimiento_recepcionista").css("display",'none');
	}
}

ListarTeleoperadora=function(){
	var dis=$("#mantenimiento_teleoperadora").css("display");
	if(dis=='none'){
	$("#mantenimiento_teleoperadora").css("display",'');
	}
	else{
	$("#mantenimiento_teleoperadora").css("display",'none');
	}
}

ListarPromotor=function(){
	var dis=$("#mantenimiento_promotor").css("display");
	if(dis=='none'){
	$("#mantenimiento_promotor").css("display",'');
	}
	else{
	$("#mantenimiento_promotor").css("display",'none');
	}
}

ListarExAlumno=function(){
	var dis=$("#mantenimiento_exalumno").css("display");
	if(dis=='none'){
	$("#mantenimiento_exalumno").css("display",'');
	}
	else{
	$("#mantenimiento_exalumno").css("display",'none');
	}
}

ListarWEB=function(){
	var dis=$("#mantenimiento_web").css("display");
	if(dis=='none'){
	$("#mantenimiento_web").css("display",'');
	}
	else{
	$("#mantenimiento_web").css("display",'none');
	}
}

ListarDocAut=function(){
	var dis=$("#mantenimiento_doc_aut").css("display");
	if(dis=='none'){
	$("#mantenimiento_doc_aut").css("display",'');
	}
	else{
	$("#mantenimiento_doc_aut").css("display",'none');
	}
}

ListarJqgridVended=function(){
	var dis=$("#mantenimiento_jqgrid_vended").css("display");
	if(dis=='none'){	
	$("#mantenimiento_jqgrid_vended").css("display",'');	
	}
	else{
	$("#mantenimiento_jqgrid_vended").css("display",'none');
	}
}

add_persona_jqgrid=function(){
	$("#frmPersona .form i").remove();
	$('#cperson').val('');
	$('#frmPersona input[type="text"],#frmPersona select').val('');
	
	$('#txt_paterno').removeAttr("disabled");
    $('#txt_materno').removeAttr("disabled");
	$('#txt_nombre').removeAttr("disabled");
	$('#slct_estado_civil').val("S");
	
	$('#btnFormPersona').attr('onclick', 'nuevoPersona()');
	$('#spanBtnFormPersona').html('Guardar');
	$('#frmPersona').dialog('open');	
}
nuevoPersona=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_paterno');
	a[1] = sistema.requeridoTxt('txt_materno');
	a[2] = sistema.requeridoTxt('txt_nombre');
	a[3] = sistema.requeridoTxt('txt_email');
	a[4] = sistema.requeridoTxt('txt_celular');
	//a[5]= sistema.requeridoTxt('txt_telefono_casa');
	//a[6]= sistema.requeridoSlct('slct_estado_civil');
	a[5] = sistema.requeridoTxt('txt_dni');
	a[6]= sistema.requeridoSlct('slct_sexo');
	for(var i=0;i<7;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
	personaDAO.InsertarPersona();
}
edit_persona_jqgrid=function(){
	var id=$("#table_persona").jqGrid("getGridParam",'selrow');
	$("#frmPersona .form i").remove();
    if (id) {
        var data = $("#table_persona").jqGrid('getRowData',id);
        $('#cperson').val(id);
        $('#txt_paterno').val(data.dappape);
        $('#txt_materno').val(data.dapmape);
		$('#txt_nombre').val(data.dnomper);
//		$('#txt_paterno').attr("disabled","true");
//        $('#txt_materno').attr("disabled","true");
//		$('#txt_nombre').attr("disabled","true");
		
		$('#txt_email').val(data.email1);        
        $('#txt_celular').val(data.ntelpe2);
		$('#txt_telefono_casa').val(data.ntelper);
		$('#txt_telefono_oficina').val(data.ntellab);
		$('#slct_estado_civil').val(data.cestciv);
		$('#txt_dni').val(data.ndniper);
		$('#slct_sexo').val(data.tsexo);
		$('#txt_fecha_nacimiento').val(data.fnacper);
		$('#slct_departamento').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento','slct_provincia',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento','slct_provincia','slct_distrito',data.coddist);		
		}		
		$('#txt_direccion').val(data.ddirper);
		$('#txt_referencia').val(data.ddirref);
		$('#slct_departamento2').val(data.cdptlab);
		if(data.cdptlab!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento2','slct_provincia2',data.cprvlab);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento2','slct_provincia2','slct_distrito2',data.cdislab);		
		}
		alert(data.cdptcol)
		$('#slct_departamento3').val(data.cdptcol);
		//if(data.cdptcol!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento3','slct_provincia3',data.cprvcol);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento3','slct_provincia3','slct_distrito3',data.cdiscol);		
		//}
		$('#txt_direccion2').val(data.ddirlab);
		$('#txt_nombre_trabajo').val(data.dnomlab);
		$('#txt_colegio').val(data.dcolpro);
		$('#slct_Tipo').val(data.tcolegi);
		
		
        $('#btnFormPersona').attr('onclick', 'modificarPersona()');
		$('#spanBtnFormPersona').html('Modificar');
		$('#frmPersona').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Editar')
	}
}
edit_persona2_jqgrid=function(){
	var id=$("#table_persona2").jqGrid("getGridParam",'selrow');
	$("#frmPersona .form i").remove();
    if (id) {
        var data = $("#table_persona2").jqGrid('getRowData',id);
        $('#cperson').val(id);
        $('#txt_paterno').val(data.dappape);
        $('#txt_materno').val(data.dapmape);
		$('#txt_nombre').val(data.dnomper);		
		$('#txt_email').val(data.email1);        
        $('#txt_celular').val(data.ntelpe2);
		$('#txt_telefono_casa').val(data.ntelper);
		$('#txt_telefono_oficina').val(data.ntellab);
		$('#slct_estado_civil').val(data.cestciv);
		$('#txt_dni').val(data.ndniper);
		$('#slct_sexo').val(data.tsexo);
		$('#txt_fecha_nacimiento').val(data.fnacper);
		$('#slct_departamento').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento','slct_provincia',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento','slct_provincia','slct_distrito',data.coddist);		
		}		
		$('#txt_direccion').val(data.ddirper);
		$('#txt_referencia').val(data.ddirref);
		$('#slct_departamento2').val(data.cdptlab);
		if(data.cdptlab!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento2','slct_provincia2',data.cprvlab);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento2','slct_provincia2','slct_distrito2',data.cdislab);		
		}
		$('#slct_departamento3').val(data.cdptcol);
		if(data.cdptcol!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento3','slct_provincia3',data.cprvcol);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento3','slct_provincia3','slct_distrito3',data.cdiscol);		
		}
		$('#txt_direccion2').val(data.ddirlab);
		$('#txt_nombre_trabajo').val(data.dnomlab);
		$('#txt_colegio').val(data.dcolpro);
		$('#slct_Tipo').val(data.tcolegi);
		
		
        $('#btnFormPersona').attr('onclick', 'modificarPersona()');
		$('#spanBtnFormPersona').html('Modificar');
		$('#frmPersona').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Editar')
	}
}
modificarPersona=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_paterno');
	a[1] = sistema.requeridoTxt('txt_materno');
	a[2] = sistema.requeridoTxt('txt_nombre');
	a[3] = sistema.requeridoTxt('txt_email');
	a[4] = sistema.requeridoTxt('txt_celular');
	//a[5]= sistema.requeridoTxt('txt_telefono_casa');
	//a[6]= sistema.requeridoSlct('slct_estado_civil');
	a[5] = sistema.requeridoTxt('txt_dni');
	a[6]= sistema.requeridoSlct('slct_sexo');
	for(var i=0;i<7;i++){
		if(!a[i]){
		return false;
		break;		
		}
	}
	personaDAO.ActualizarPersona();
}


cargar_persona_jqgrid=function(){
	var id="";	
	id=$("#table_persona").jqGrid("getGridParam",'selrow');
	
    if (id) {
        var data = $("#table_persona").jqGrid('getRowData',id);
        $('#id_cperson').val(id);
        $('#txt_paterno_c').val(data.dappape);
        $('#txt_materno_c').val(data.dapmape);
		$('#txt_nombre_c').val(data.dnomper);
		$('#txt_email_c').val(data.email1);        
        $('#txt_celular_c').val(data.ntelpe2);
		$('#txt_telefono_casa_c').val(data.ntelper);
		$('#txt_telefono_oficina_c').val(data.ntellab);
		$('#slct_estado_civil_c').val(data.cestciv);
		$('#txt_dni_c').val(data.ndniper);
		$('#slct_sexo_c').val(data.tsexo);
		$('#txt_fecha_nacimiento_c').val(data.fnacper);
		$('#slct_departamento_c').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c','slct_distrito_c',data.coddist);		
		}
		$('#txt_colegio_c').val(data.dcolpro);
		$('#slct_Tipo_c').val(data.tcolegi);
		$("#mantenimiento_persona").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Cargar')
	}
}

add_promotor_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('p');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('p');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("promotor")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}
add_teleoperadora_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('t');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('t');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("teleoperadora")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}
add_recepcionista_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('r');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('r');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("recepcionista")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}
add_web_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('w');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('w');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("web")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}
add_doc_aut_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('d');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('d');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("doc_aut")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}
add_exalumno_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('e');
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('e');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("exalumno")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}

add_vended_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val($("#slct_vendedor").val());
	$('#txt_paterno_t').removeAttr("disabled");
	$('#txt_materno_t').removeAttr("disabled");
	$('#txt_nombre_t').removeAttr("disabled");
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val($("#slct_vendedor").val());
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	$('#slct_estado_t').val("1");
	$('#slct_estado_t').attr("disabled",'true');
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("jqgrid_vended")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
}

nuevoTrabajador=function(trab){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_nombre_t');
	a[1] = sistema.requeridoTxt('txt_codigo_interno_t');

	for(var i=0;i<2;i++){
		if(!a[i]){
		return false;		
		break;		
		}
	}
	personaDAO.InsertarTrabajador(trab);
}
edit_promotor_jqgrid=function(){
	var id=$("#table_promotor").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_promotor").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('p');
		
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
//		$('#txt_paterno_t').attr("disabled","true");
//		$('#txt_materno_t').attr("disabled","true");
//		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("promotor")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

edit_teleoperadora_jqgrid=function(){
	var id=$("#table_teleoperadora").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_teleoperadora").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('t');
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
		$('#txt_paterno_t').attr("disabled","true");
		$('#txt_materno_t').attr("disabled","true");
		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("teleoperadora")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

edit_recepcionista_jqgrid=function(){
	var id=$("#table_recepcionista").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_recepcionista").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('r');
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
		$('#txt_paterno_t').attr("disabled","true");
		$('#txt_materno_t').attr("disabled","true");
		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("recepcionista")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

edit_web_jqgrid=function(){
	var id=$("#table_web").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_web").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('w');
		
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
		$('#txt_paterno_t').attr("disabled","true");
		$('#txt_materno_t').attr("disabled","true");
		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("web")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Data Web</b> a Editar')
	}
}

edit_doc_aut_jqgrid=function(){
	var id=$("#table_doc_aut").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_doc_aut").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('d');
		
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
		$('#txt_paterno_t').attr("disabled","true");
		$('#txt_materno_t').attr("disabled","true");
		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("doc_aut")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

edit_exalumno_jqgrid=function(){
	var id=$("#table_exalumno").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_exalumno").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val('e');
		
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
		$('#txt_paterno_t').attr("disabled","true");
		$('#txt_materno_t').attr("disabled","true");
		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("exalumno")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

edit_vended_jqgrid=function(){
	var id=$("#table_jqgrid_vended").jqGrid("getGridParam",'selrow');
	$("#frmTrabajador .form i").remove();
    if (id) {
        var data = $("#table_jqgrid_vended").jqGrid('getRowData',id);
        $('#cvended').val(id);
		$('#tvended').val($("#slct_vendedor").val());
        $('#slct_opeven').val(data.copeven);	
		
        $('#txt_paterno_t').val(data.dapepat);
        $('#txt_materno_t').val(data.dapemat);
		$('#txt_nombre_t').val(data.dnombre);
//		$('#txt_paterno_t').attr("disabled","true");
//		$('#txt_materno_t').attr("disabled","true");
//		$('#txt_nombre_t').attr("disabled","true");
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
		$('#txt_fecha_retiro_t').val(data.fretven);
		$('#slct_departamento_t').val(data.coddpto);
		$('#txt_codigo_interno_t').val(data.codintv);
		if(data.coddpto!=''){
		ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t',data.codprov);	
		ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t',data.coddist);		
		}		
		$('#txt_direccion_t').val(data.ddirecc);
		$('#slct_estado_t').removeAttr("disabled");
		$('#slct_estado_t').val("1");
		if(data.cestado!='Activo'){
		$('#slct_estado_t').val("0");
		}
	
		
		
        $('#btnFormTrabajador').attr('onclick', 'modificarTrabajador("jqgrid_vended")');
		$('#spanBtnFormTrabajador').html('Modificar');
		$('#frmTrabajador').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Trabajador</b> a Editar')
	}
}

modificarTrabajador=function(trab){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_nombre_t');
	a[1] = sistema.requeridoTxt('txt_codigo_interno_t');

	for(var i=0;i<2;i++){
		if(!a[i]){
		return false;		
		break;		
		}
	}
	personaDAO.ActualizarTrabajador(trab);
}


cargar_promotor_jqgrid=function(){
	var id=$("#table_promotor").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_promotor").jqGrid('getRowData',id);
        $('#id_cvended_p').val(id);
        $('#txt_promotor').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_promotor").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Promotor</b> a cargar')
	}
}

cargar_teleoperadora_jqgrid=function(){
	var id=$("#table_teleoperadora").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_teleoperadora").jqGrid('getRowData',id);
        $('#id_cvended_t').val(id);
        $('#txt_teleoperadora').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_teleoperadora").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Teleoperador(a)</b> a cargar')
	}
}

cargar_recepcionista_jqgrid=function(){
	var id=$("#table_recepcionista").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_recepcionista").jqGrid('getRowData',id);
        $('#id_cvended_r').val(id);
        $('#txt_recepcionista').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_recepcionista").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Recepcionista</b> a cargar')
	}
}

cargar_web_jqgrid=function(){
	var id=$("#table_web").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_web").jqGrid('getRowData',id);
        $('#id_cvended_w').val(id);
        $('#txt_web').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_web").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Data WEB</b> a cargar')
	}
}

cargar_doc_aut_jqgrid=function(){
	var id=$("#table_doc_aut").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_doc_aut").jqGrid('getRowData',id);
        $('#id_cvended_doa').val(id);
        $('#txt_doc_aut').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_doc_aut").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Docente o Autoridad</b> a cargar')
	}
}

cargar_exalumno_jqgrid=function(){
	var id=$("#table_exalumno").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_exalumno").jqGrid('getRowData',id);
        $('#id_cvended_exa').val(id);
        $('#txt_exalumno').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_exalumno").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Ex Alumno</b> a cargar')
	}
}

cargar_vended_jqgrid=function(){
	var id=$("#table_jqgrid_vended").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_jqgrid_vended").jqGrid('getRowData',id);
        $('#id_cvended_jqgrid').val(id);
        $('#txt_jqgrid_vended').val(data.dapepat+' '+data.dapemat+', '+data.dnombre);
		        
		$("#mantenimiento_jqgrid_vended").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione un registro a cargar')
	}
}
