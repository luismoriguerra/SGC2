$(document).ready(function(){	
	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo	
	jqGridPersona.personaIngAlum3();
	carreraDAO.cargarPais(sistema.llenaSelect,'slct_pais_procedencia','173');
	carreraDAO.cargarCiclo2(sistema.llenaSelect,'slct_ciclo','');
	$("#slct_modalidad_ingreso").change(function(){verificarIngreso();});
	$("#validatotal").attr("disabled","true");
})

verificarIngreso=function(){
	var v=$("#slct_modalidad_ingreso").val().split("-")[1];
	$("#slct_concepto_convalida").val("");
		if(v=="S"){		
		$("#valida_pago_convalidacion").css("display","");
		$("#valida_proceso_convalidacion").css("display","");
		}
		else{
		$("#valida_pago_convalidacion").css("display","none");
		$("#valida_proceso_convalidacion").css("display","none");
		}
}

eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var value = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_paterno').val(value.dappape);
		$('#txt_materno').val(value.dapmape);
		$('#txt_nombre').val(value.dnomper);		
		$('#slct_nro_fotos').val(value.nfotos);
		$("#txt_cod_cert_est").val(value.certest);
		$("#txt_cod_part_nac").val(value.partnac);
		$('#slct_rdo_fotoc_dni').val(value.fotodni);
		$('#txt_otro_doc').val(value.otrodni);
		$("#slct_devolucion").val(value.cdevolu);
		cargarModalidadIngreso(VerificaIrregular,value.cmoding);
		/*/////////////DATOS PARA EL PROCESO DE CONVALIDACIÓN ////////////*/
		$("#slct_pais_procedencia").val(value.cpais);
		$("#slct_tipo_institucion").val(value.tinstip);
		$("#txt_institucion").val(value.dinstip);
		$("#txt_carrera_procedencia").val(value.dcarrep);
		$("#slct_ultimo_año").val(value.ultanop);
		$("#slct_ciclo").val(value.dciclop);
		$("#txt_docum_vali").val(value.ddocval);		
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Editar')
	}
}

cargarModalidadIngreso=function(VerificaIrregular,cmoding){
	personaDAO.cargarModalidadIngresoDocumento(VerificaIrregular,cmoding);
}

VerificaIrregular=function(dato){
	$("#valida_proceso_convalidacion").css("display","none");
	if(dato.split('-')[0]=='S'){
		$("#valida_proceso_convalidacion").css("display","");
	}

	var htm='<option value="'+dato.split('-')[1]+'" selected>'+dato.split('-')[2]+'</option>';
	$("#slct_modalidad_ingreso").html(htm);
	$("#idboton").css("display","");
	validarTotalG();	
}

validarTotalG=function(){
	if(($("#slct_rdo_fotoc_dni").val()=="0" && $.trim($("#txt_cod_part_nac").val())=="") || $.trim($("#txt_cod_cert_est").val())==""){	
		$("#validatotal").attr("checked","true");
	}
	else{
		$("#validatotal").removeAttr("checked");
	}
}

Actualizar=function(){  
  var error='';
  if($("#valida_proceso_convalidacion").css('display')!='none'){
	if($("#slct_pais_procendencia").val()==''){
	$("#slct_pais_procendencia").focus();  
	sistema.msjAdvertencia('Seleccione <b>País de Procedencia</b>',5000);
	error="ok";
	}
	else if($("#slct_tipo_institucion").val()==''){
	$("#slct_tipo_institucion").focus();  
	sistema.msjAdvertencia('Seleccione <b>Tipo de Institución</b>',5000);
	error="ok";
	}
	else if($.trim($("#txt_institucion").val())==''){
	$("#txt_institucion").focus();  
	sistema.msjAdvertencia('Ingrese <b>Institución</b> de procedencia',5000);
	error="ok";
	}
	else if($.trim($("#txt_carrera_procedencia").val())==''){
	$("#txt_carrera_procedencia").focus();  
	sistema.msjAdvertencia('Ingrese <b>Carrera</b> de procedencia',5000);
	error="ok";
	}
	else if($.trim($("#slct_ultimo_año").val())==''){
	$("#slct_ultimo_año").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Último año</b> de procedencia',5000);
	error="ok";
	}
	else if($.trim($("#slct_ciclo").val())==''){
	$("#slct_ciclo").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Último Ciclo</b> de procedencia',5000);
	error="ok";
	}
	else if($.trim($("#txt_docum_vali").val())==''){
	$("#txt_docum_vali").focus();  
	sistema.msjAdvertencia('Ingrese <b>Documentos para convalidación</b>',5000);
	error="ok";
	}	
  }

  if(error!='ok'){  	
	personaDAO.ActualizarDocumentos();	
  }
}

Limpiar=function(){
	var htm='<option value="" selected>Seleccione</option>';
	$("slct_modalidad_ingreso").html(htm);
	$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');
	$("#valida_proceso_convalidacion").css('display','none');
}

