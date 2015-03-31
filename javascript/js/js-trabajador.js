$(document).ready(function(){	
	jqGridPersona.persona();
	
	$('#frmPersona').dialog({
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
		$('#txt_paterno').attr("disabled","true");
        $('#txt_materno').attr("disabled","true");
		$('#txt_nombre').attr("disabled","true");
		
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
