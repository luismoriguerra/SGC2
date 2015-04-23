$(document).ready(function(){
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	/*dialog*/	
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo	
	ubigeoDAO.cargarDepartamento(sistema.llenaSelect,'slct_departamento,#slct_departamento2,#slct_departamento3,#slct_departamento_c,#slct_departamento_c2,#slct_departamento_t','');

	carreraDAO.cargarPais(sistema.llenaSelect,'slct_pais_procedencia','173');
	carreraDAO.cargarMedioCaptacion(sistema.llenaSelect,'slct_medio_captacion','');
	carreraDAO.cargarMedioPrensa(sistema.llenaSelect,'slct_medio_prensa','');
	carreraDAO.cargarBanco(sistema.llenaSelect,'slct_banco,#slct_banco_ins,#slct_banco_pension','');
	carreraDAO.cargarCiclo2(sistema.llenaSelect,'slct_ciclo','');
	cencapDAO.ListarCencap(sistema.llenaSelect,'slct_centro_captacion','');
	cencapDAO.cargarFiliales(sistema.llenaSelect,'slct_local_estudio','');
	cencapDAO.cargarInstitutos(sistema.llenaSelect,'slct_local_instituto','');	
	
	$(':text[id^="txt_fecha"]').val(sistema.getFechaActual('yyyy-mm-dd'));
	
	$("#txt_ode").val($("#hd_desFilial").val());
	$("#slct_condicion_pago").change(function(){PrepararPagos();});	
	$("#slct_tipo_pago").change(function(){cargarConcepto();PrepararPagos();});
	$("#slct_local_instituto,#slct_local_estudio").change(function(){ListarProgramas();PreparaCodLibro();cargarConcepto();listarSemestre();});
	$("#slct_semestre").change(function(){ListarProgramas();});
	$("#slct_local_instituto").change(function(){visualizaBecado(this.value);cargarModalidadIngreso();cargarConceptoIns();});	
	$("#slct_modalidad_ingreso").change(function(){verificarIngreso();});
	$("#txt_promocion_economica").val("Sin Promoción");
	$("#validatotal").attr("disabled","true");
	$("[title^='Agregar'],[title^='Editar']").css("display","none");
	$("[title^='Agregar Persona']").css("display","");
	jqGridPersona.personaConcepto();
	
	/***********************/
	slct_tipo_documento_ins
	
	seleccionarboletas();
	
})

seleccionarboletas= function(){
$("#slct_tipo_documento_ins").val("B");
$("#slct_tipo_documento").val("B");
$("#slct_tipo_documento_pension").val("B");
$("#slct_tipo_documento_convalida").val("B");
$("#txt_nro_boleta_ins").val('0000000');
$("#txt_nro_boleta").val('0000000');
$("#txt_nro_boleta_pension").val('0000000');
$("#txt_nro_boleta_convalida").val('0000000');
$("#txt_serie_boleta_ins").val('000');
$("#txt_serie_boleta").val('000');
$("#txt_serie_boleta_pension").val('000');
$("#txt_serie_boleta_convalida").val('000');
$(".escondeespecial").css("display","none");
}

validarTotalG=function(){
	if(($("#slct_rdo_fotoc_dni").val()=="0" && $.trim($("#txt_cod_part_nac").val())=="") || $.trim($("#txt_cod_cert_est").val())==""){	
		$("#validatotal").attr("checked","true");
	}
	else{
		$("#validatotal").removeAttr("checked");
	}
}

cargarModalidadIngreso=function(){
	carreraDAO.cargarModalidadIngresoIns(sistema.llenaSelect,'slct_modalidad_ingreso','');
}

listarSemestre=function(){
	if($.trim($("#slct_local_instituto").val())!="" && $.trim($("#slct_local_estudio").val())!=""){
	carreraDAO.cargarSemestre(sistema.llenaSelect,'slct_semestre','');
	}
}

PreparaCodLibro=function(){
	var x="";
	if($.trim($("#slct_local_instituto").val().split("-")[2])!=""){
	x=$("#slct_local_instituto").val().split("-")[2]+$("#hd_idFilial").val();
	}
	$("#txt_codigo_libro_cod").val(x);
}

ListarProgramas=function(){
	grupoAcademicoDAO.cargarGrupoAcademicoMatri(ListarGrupoAcademico);
}

ListarGrupoAcademico=function(obj){
	var htm="";
	var totalmatriculados,vacantes,indices;
	$.each(obj,function(index,value){
		htm+="<tr id='trg-"+value.id+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");cargarConcepto();cargarConceptoIns();PrepararPagos();Limpiarpagos();' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
		htm+="<td width='80px' class='t-center'>"+value.dturno+"</td>";
		htm+="<td width='205px' class='t-left'>"+value.dcarrer+"</td>";
		htm+="<td width='100px' class='t-center'>"+value.csemaca+"</td>";
		htm+="<td width='55px' class='t-center'>"+value.cinicio+"</td>";
		htm+="<td width='100px' class='t-center'>"+value.finicio+"</td>";
		htm+="<td width='210px' class='t-left'>"+value.horario+"</td>";
		htm+="<td width='80px' class='t-center'>"+value.nmetmat+"</td>";
		htm+="<td width='80px' class='t-center'>"+value.menor+"</td>";
		htm+="<td width='80px' class='t-center'>"+value.mayor+"</td>";
		totalmatriculados=value.total-(value.mayor*1+value.menor*1);
		vacantes=value.nmetmat-totalmatriculados-(value.mayor/2);
		indices=Math.round((1-(vacantes/value.nmetmat))*100);
		htm+="<td width='80px' class='t-center'>"+totalmatriculados+"</td>";
		htm+="<td width='80px' class='t-center'>"+vacantes+"</td>";
		htm+="<td width='80px' class='t-center'>"+indices+" %"+"</td>";
		htm+="</tr>";
	});
	$("#lista_grupos").html(htm);
}

PrepararPagos=function(){
	var id="";
	if($.trim($("#lista_grupos .ui-state-highlight").text())!=""){
	id=$("#lista_grupos .ui-state-highlight").attr("id").split("-")[1];	
	}
	
	cargarConceptoPension(id);
}

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
	validaRestoPago('');
	ValidaMontoPagado();
}

ValidaMontoPagadoIns=function(){
	var mp=$("#txt_monto_pagado_ins").val();
	var md=$("#slct_concepto_ins").val().split("-")[1];
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado_ins").val('');
	}
	else{
		var dato=(md*1-mp*1);
		dato=dato.toFixed(2);
	$("#txt_monto_deuda_ins").val(dato);
	}
	
	if((md*1-mp*1)>0){
	$("#txt_monto_pagado").attr("disabled","true");
	$("#slct_tipo_documento").attr("disabled","true");
	$("#txt_nro_boleta").attr("disabled","true");
	$("#txt_serie_boleta").attr("disabled","true");	
	/**********************************************/
	$("#txt_monto_pagado_pension").attr("disabled","true");
	$("#slct_tipo_documento_pension").attr("disabled","true");
	$("#txt_nro_boleta_pension").attr("disabled","true");
	$("#txt_serie_boleta_pension").attr("disabled","true");
	/**********************************************/
	$("#txt_monto_pagado_convalida").attr("disabled","true");
	$("#slct_tipo_documento_convalida").attr("disabled","true");
	$("#txt_nro_boleta_convalida").attr("disabled","true");
	$("#txt_serie_boleta_convalida").attr("disabled","true");
	}
	else{
	$("#txt_monto_pagado").removeAttr("disabled");
	$("#slct_tipo_documento").removeAttr("disabled");
	$("#txt_nro_boleta").removeAttr("disabled");
	$("#txt_serie_boleta").removeAttr("disabled");
	$("#val_boleta").css("display","none");
	$("#slct_tipo_documento").val("");
	$("#txt_nro_boleta").val("");
	$("#txt_serie_boleta").val("");
	}
}

cargarConceptoIns=function(){
	conceptoDAO.cargarConcepto(sistema.llenaSelect,'slct_concepto_ins','','708','',$("#slct_tipo_pago_ins").val());
}

visualizaBecado=function(valor){
   if(valor.split("-")[1]==2){
    $("#postula_beca").css("display","none");
	$("#slct_solo_beca").val("0");
   }
   else{
	$("#postula_beca").css("display","");
   }
}

ValidaTipoPagoIns=function(){
	$("#val_boleta_ins").css("display","none");
	$("#val_voucher_ins").css("display","none");
	if($("#slct_tipo_documento_ins").val()=='B'){
	$("#val_boleta_ins").css("display","");
	}
	else if($("#slct_tipo_documento_ins").val()=='V'){
	$("#val_voucher_ins").css("display","");
	}
}

//Inicia
ValidaMontoPagado=function(){
	var mp=$("#txt_monto_pagado").val();
	var md=$("#slct_concepto").val().split("-")[1];
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado").val('');
	}
	else{
		var dato=(md*1-mp*1);
		dato=dato.toFixed(2);
	$("#txt_monto_deuda").val(dato);
	}
	
	if((md*1-mp*1)>0){
	$("#txt_monto_pagado_pension").attr("disabled","true");
	$("#slct_tipo_documento_pension").attr("disabled","true");
	$("#txt_nro_boleta_pension").attr("disabled","true");
	$("#txt_serie_boleta_pension").attr("disabled","true");
	/**********************************************/
	$("#txt_monto_pagado_convalida").attr("disabled","true");
	$("#slct_tipo_documento_convalida").attr("disabled","true");
	$("#txt_nro_boleta_convalida").attr("disabled","true");
	$("#txt_serie_boleta_convalida").attr("disabled","true");
	}
	else{
	$("#txt_monto_pagado_pension").removeAttr("disabled");
	$("#slct_tipo_documento_pension").removeAttr("disabled");
	$("#txt_nro_boleta_pension").removeAttr("disabled");
	$("#txt_serie_boleta_pension").removeAttr("disabled");
	$("#val_boleta_pension").css("display","none");
	$("#slct_tipo_documento_pension").val("");
	$("#txt_nro_boleta_pension").val("");
	$("#txt_serie_boleta_pension").val("");
	}	
}

ValidaMontoPagadoPension=function(){
	var mp=$("#txt_monto_pagado_pension").val();
	var md=$("#slct_concepto_pension").val().split("-")[1];
		if($("#slct_concepto_pension").val().split("-")[2]*1>0){
		md=$("#slct_concepto_pension").val().split("-")[3];
		}
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado_pension").val('');
	}
	else{
		var dato=(md*1-mp*1);
		dato=dato.toFixed(2);
	$("#txt_monto_deuda_pension").val(dato);
	}	
	
	if((md*1-mp*1)>0){	
	$("#txt_monto_pagado_convalida").attr("disabled","true");
	$("#slct_tipo_documento_convalida").attr("disabled","true");
	$("#txt_nro_boleta_convalida").attr("disabled","true");
	$("#txt_serie_boleta_convalida").attr("disabled","true");	
	}
	else{
	$("#txt_monto_pagado_convalida").removeAttr("disabled");
	$("#slct_tipo_documento_convalida").removeAttr("disabled");
	$("#txt_nro_boleta_convalida").removeAttr("disabled");
	$("#txt_serie_boleta_convalida").removeAttr("disabled");
	$("#val_boleta_convalida").css("display","none");
	$("#slct_tipo_documento_convalida").val("");
	$("#txt_nro_boleta_convalida").val("");
	$("#txt_serie_boleta_convalida").val("");	
	}
}

ValidaMontoPagadoConvalida=function(){
	var mp=$("#txt_monto_pagado_convalida").val();
	var md=$("#slct_concepto_convalida").val().split("-")[1];
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado_convalida").val('');
	}
	else{
		var dato=(md*1-mp*1);
		dato=dato.toFixed(2);
	$("#txt_monto_deuda_convalida").val(dato);
	}	
}

validaRestoPago=function(d1){
	var mp=$("#txt_monto_pagado"+d1).val();
	var md=$("#slct_concepto"+d1).val().split("-")[1];
	
		if(d1=="_pension" && $("#slct_concepto_pension").val().split("-")[2]*1>0){ // solo validara para pension
		md=$("#slct_concepto_pension").val().split("-")[3];
		}		
	
	if((md*1-mp*1)>0){	
		if(d1=="_ins"){
		ValidaTipoPago();
		$("#txt_monto_pagado").val("0");
		
			if($("#slct_concepto").val()!=''){
			$("#txt_monto_deuda").val($("#slct_concepto").val().split("-")[1]);
			}
			else{
			$("#txt_monto_deuda").val("0");
			}
		
		$("#val_boleta").css("display","");
		$("#slct_tipo_documento").val("B");
		$("#txt_nro_boleta").val("0");
		$("#txt_serie_boleta").val("0");
		sistema.lpad("txt_serie_boleta","0",3);
		sistema.lpad("txt_nro_boleta","0",7);		
		/***************************************************/
		ValidaTipoPagoPension();
		$("#txt_monto_pagado_pension").val("0");		
		
			if($("#slct_concepto_pension").val()!=''){
			$("#txt_monto_deuda_pension").val($("#slct_concepto_pension").val().split("-")[1]);
				if($("#slct_concepto_pension").val().split("-")[2]*1>0){
				$("#txt_monto_deuda_pension").val($("#slct_concepto_pension").val().split("-")[3]);
				}			
			}
			else{
			$("#txt_monto_deuda_pension").val("0");
			}
		
		$("#val_boleta_pension").css("display","");
		$("#slct_tipo_documento_pension").val("B");
		$("#txt_nro_boleta_pension").val("0");
		$("#txt_serie_boleta_pension").val("0");
		sistema.lpad("txt_serie_boleta_pension","0",3);
		sistema.lpad("txt_nro_boleta_pension","0",7);
		/***************************************************/
		ValidaTipoPagoConvalida();
		$("#txt_monto_pagado_convalida").val("0");
		
			if($("#slct_concepto_convalida").val()!=''){
			$("#txt_monto_deuda_convalida").val($("#slct_concepto_convalida").val().split("-")[1]);
			}
			else{
			$("#txt_monto_deuda_convalida").val("0");
			}
		
		$("#val_boleta_convalida").css("display","");
		$("#slct_tipo_documento_convalida").val("B");
		$("#txt_nro_boleta_convalida").val("0");
		$("#txt_serie_boleta_convalida").val("0");
		sistema.lpad("txt_serie_boleta_convalida","0",3);
		sistema.lpad("txt_nro_boleta_convalida","0",7);
		}
		else if(d1==""){
		ValidaTipoPagoPension();
		$("#txt_monto_pagado_pension").val("0");
		
			if($("#slct_concepto_pension").val()!=''){				
			$("#txt_monto_deuda_pension").val($("#slct_concepto_pension").val().split("-")[1]);
				if($("#slct_concepto_pension").val().split("-")[2]*1>0){
				$("#txt_monto_deuda_pension").val($("#slct_concepto_pension").val().split("-")[3]);
				}
			}
			else{
			$("#txt_monto_deuda_pension").val("0");
			}
		
		$("#val_boleta_pension").css("display","");		
		$("#slct_tipo_documento_pension").val("B");
		$("#txt_nro_boleta_pension").val("0");
		$("#txt_serie_boleta_pension").val("0");
		sistema.lpad("txt_serie_boleta_pension","0",3);
		sistema.lpad("txt_nro_boleta_pension","0",7);
		/*******************************************************/
		ValidaTipoPagoConvalida();
		$("#txt_monto_pagado_convalida").val("0");
		
			if($("#slct_concepto_convalida").val()!=''){
			$("#txt_monto_deuda_convalida").val($("#slct_concepto_convalida").val().split("-")[1]);
			}
			else{
			$("#txt_monto_deuda_convalida").val("0");
			}
		
		$("#val_boleta_convalida").css("display","");
		$("#slct_tipo_documento_convalida").val("B");
		$("#txt_nro_boleta_convalida").val("0");
		$("#txt_serie_boleta_convalida").val("0");
		sistema.lpad("txt_serie_boleta_convalida","0",3);
		sistema.lpad("txt_nro_boleta_convalida","0",7);
		}
		else if(d1=="_pension"){
		ValidaTipoPagoConvalida();
		$("#txt_monto_pagado_convalida").val("0");
		
			if($("#slct_concepto_convalida").val()!=''){
			$("#txt_monto_deuda_convalida").val($("#slct_concepto_convalida").val().split("-")[1]);
			}
			else{
			$("#txt_monto_deuda_convalida").val("0");
			}
		
		$("#val_boleta_convalida").css("display","");
		$("#slct_tipo_documento_convalida").val("B");
		$("#txt_nro_boleta_convalida").val("0");
		$("#txt_serie_boleta_convalida").val("0");
		sistema.lpad("txt_serie_boleta_convalida","0",3);
		sistema.lpad("txt_nro_boleta_convalida","0",7);		
		}	
	}
}

cargarConcepto=function(){
	conceptoDAO.cargarConcepto(sistema.llenaSelect,'slct_concepto','','701.01','',$("#slct_tipo_pago").val());
	conceptoDAO.cargarConcepto(sistema.llenaSelect,'slct_concepto_convalida','','707.07','',$("#slct_tipo_pago").val());
}

cargarConceptoPension=function(gr){
	var precio="";
	if($("#slct_condicion_pago").val()=="1"){
	precio="0"
	}
	conceptoDAO.cargarConceptoPension(sistema.llenaSelect,'slct_concepto_pension','','701.03',precio,$("#slct_tipo_pago").val(),gr);
}

ValidaTipoPago=function(){
	$("#val_boleta").css("display","none");
	$("#val_voucher").css("display","none");
	if($("#slct_tipo_documento").val()=='B'){
	$("#val_boleta").css("display","");
	}
	else if($("#slct_tipo_documento").val()=='V'){
	$("#val_voucher").css("display","");
	}
}

ValidaTipoPagoConvalida=function(){
	$("#val_boleta_convalida").css("display","none");
	$("#val_voucher_convalida").css("display","none");
	if($("#slct_tipo_documento_convalida").val()=='B'){
	$("#val_boleta_convalida").css("display","");
	}
	else if($("#slct_tipo_documento_convalida").val()=='V'){
	$("#val_voucher_convalida").css("display","");
	}
}

ValidaTipoPagoPension=function(){
	$("#val_boleta_pension").css("display","none");
	$("#val_voucher_pension").css("display","none");
	if($("#slct_tipo_documento_pension").val()=='B'){
	$("#val_boleta_pension").css("display","");
	}
	else if($("#slct_tipo_documento_pension").val()=='V'){
	$("#val_voucher_pension").css("display","");
	}
}

ValidaMedioCaptacion=function(){
	var tipo=$("#slct_medio_captacion").val().split("-")[1];
	var iden=$("#slct_medio_captacion").val().split("-")[2];
	$("#val_medio_prensa").css("display","none");
	$("#val_captacion").css("display","none");
	$("#val_jqgrid_vended").css("display","none");
	$("#mantenimiento_jqgrid_vended").css("display","none");
	$('#slct_medio_prensa').val('');
	if(tipo=='1'){
	$("#val_captacion").css("display","");
	}
	else if(tipo=='2'){
	$('#id_cvended_jqgrid,#txt_jqgrid_vended').val('');
	$("#val_jqgrid_vended").css("display","");
	$("#mantenimiento_jqgrid_vended").html('<td colspan="2">'+
											  '<div style="margin-right:3px">'+
												'<table id="table_jqgrid_vended"></table>'+
												'<div id="pager_table_jqgrid_vended"></div>'+
											  '</div >'+
											'</td>');
	jqGridPersona.jqgridVended();
	$("[title^='Agregar'],[title^='Editar']").css("display","none");
	$("[title^='Agregar Persona']").css("display","");
	}
	else if(tipo=='3'){
	$("#val_medio_prensa").css("display","");
	$('#slct_medio_prensa').find('option').css('display','none');
	$('#slct_medio_prensa option:contains("--Seleccione--")').css('display','');
	$('#slct_medio_prensa option').map(function(index, element) {
        if(this.value.split("|")[1]==iden){
		$(this).css('display','');
		}
    });	
	//
	//$('#slct_medio_prensa option:contains("'+iden+'|")').css('display','');
	}
}

limpiaReg=function(dato){
	var calculo=0;
	var valor=0;
	var acumula=0;
	/*if(dato=="_ins" && $("#slct_concepto_ins").val()!="" && $("#slct_concepto_ins").val().split("-")[1]*1==0){
	$("#txt_monto_pagado"+dato).val("0");	
	$("#txt_monto_deuda"+dato).val("0");
	ValidaMontoPagadoIns();
	validaRestoPago("_ins");
	}
	else */if(dato=="_ins"){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado"+dato).val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_pension").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		
		$("#slct_concepto").val('');
		$("#txt_monto_pagado").val('0');
		$("#txt_monto_deuda").val('0');
		$("#slct_concepto_pension").val('');
		$("#txt_monto_pagado_pension").val('0');
		$("#txt_monto_deuda_pension").val('0');
		$("#slct_concepto_convalida").val('');
		$("#txt_monto_pagado_convalida").val('0');
		$("#txt_monto_deuda_convalida").val('0');
		
		valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;
		$("#txt_nmonrec_concepto").val('0')
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		}
		ValidaMontoPagadoIns();
		validaRestoPago("_ins");
	}
	/*else if(dato=="" && $("#slct_concepto").val()!="" && $("#slct_concepto").val().split("-")[1]*1==0){
	$("#txt_monto_pagado"+dato).val("0");
	$("#txt_monto_deuda"+dato).val("0");	
	ValidaMontoPagado();
	validaRestoPago("");
	}*/
	else if(dato=="" && !$("#txt_monto_pagado").attr("disabled")){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_pension").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		
		$("#slct_concepto_pension").val('');
		$("#txt_monto_pagado_pension").val('0');
		$("#txt_monto_deuda_pension").val('0');
		$("#slct_concepto_convalida").val('');
		$("#txt_monto_pagado_convalida").val('0');
		$("#txt_monto_deuda_convalida").val('0');
		
		valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0')
		}
		ValidaMontoPagado();
		validaRestoPago("");
	}
	else if(dato=="" && $("#slct_concepto").val()!=""){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_pension").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		
		$("#slct_concepto_pension").val('');
		$("#txt_monto_pagado_pension").val('0');
		$("#txt_monto_deuda_pension").val('0');
		$("#slct_concepto_convalida").val('');
		$("#txt_monto_pagado_convalida").val('0');
		$("#txt_monto_deuda_convalida").val('0');
		
		valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0')
		}
		ValidaMontoPagado();
		validaRestoPago("");
	}	
	/*else if(dato=="_pension" && $("#slct_concepto_pension").val()!="" && $("#slct_concepto_pension").val().split("-")[1]*1==0){
	$("#txt_monto_pagado"+dato).val("0");
	$("#txt_monto_deuda"+dato).val("0");
	ValidaMontoPagadoPension();
	validaRestoPago("_pension");
	$("#txt_promocion_economica").val("Sin Promoción");
	}*/
	else if(dato=="_pension" && !$("#txt_monto_pagado_pension").attr("disabled")){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_pension").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		
		$("#slct_concepto_convalida").val('');
		$("#txt_monto_pagado_convalida").val('0');
		$("#txt_monto_deuda_convalida").val('0');
		
	$("#txt_promocion_economica").val("Sin Promoción");
	valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if($("#slct_concepto_pension").val().split("-")[2]*1>0){		
		$("#txt_promocion_economica").val("Promoción de la(s) "+$("#slct_concepto_pension").val().split("-")[2]+" primera(s) cuota(s) a S/. "+$("#slct_concepto_pension").val().split("-")[3]);
			valor=$("#slct_concepto"+dato).val().split("-")[3]*1;			
		}
		
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0');
		}
		ValidaMontoPagadoPension();
		validaRestoPago("_pension");
	}
	else if(dato=="_pension" && $("#slct_concepto_pension").val()!=""){	
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_pension").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		$("#slct_concepto_convalida").val('');
		$("#txt_monto_pagado_convalida").val('0');
		$("#txt_monto_deuda_convalida").val('0');
		
	$("#txt_promocion_economica").val("Sin Promoción");
	valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if($("#slct_concepto_pension").val().split("-")[2]*1>0){
		$("#txt_monto_deuda"+dato).val($("#slct_concepto_pension").val().split("-")[3]);
		$("#txt_promocion_economica").val("Promoción de la(s) "+$("#slct_concepto_pension").val().split("-")[2]+" primera(s) cuota(s) a S/. "+$("#slct_concepto_pension").val().split("-")[3]);
			valor=$("#slct_concepto"+dato).val().split("-")[3]*1;			
		}
		
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0');
		}
		ValidaMontoPagadoPension();
		validaRestoPago("_pension");
	}
	/*else if(dato=="_convalida" && $("#slct_concepto_convalida").val()!="" && $("#slct_concepto_convalida").val().split("-")[1]*1==0){
	$("#txt_monto_pagado"+dato).val("0");
	$("#txt_monto_deuda"+dato).val("0");
	ValidaMontoPagadoConvalida();
	validaRestoPago("_convalida");
	}*/
	else if(dato=="_convalida" && !$("#txt_monto_pagado_convalida").attr("disabled")){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
	
		valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0');
		}	
		ValidaMontoPagadoConvalida();
		validaRestoPago("_convalida");	
	}
	else if(dato=="_convalida" && $("#slct_concepto_convalida").val()!=""){
		acumula=$("#txt_nmonrec_concepto").val()*1+$("#txt_monto_pagado_convalida").val()*1;
		$("#txt_nmonrec_concepto").val(acumula);
		
		valor=$("#slct_concepto"+dato).val().split("-")[1]*1;
		if(valor<=$("#txt_nmonrec_concepto").val()*1){
		$("#txt_monto_pagado"+dato).val(valor);
		$("#txt_monto_deuda"+dato).val("0");
		calculo=$("#txt_nmonrec_concepto").val()*1-valor;
		$("#txt_nmonrec_concepto").val(calculo)
		}
		else{
		calculo=valor-$("#txt_nmonrec_concepto").val()*1;		
		$("#txt_monto_pagado"+dato).val($("#txt_nmonrec_concepto").val()*1);
		$("#txt_monto_deuda"+dato).val(calculo);
		$("#txt_nmonrec_concepto").val('0');
		}
		ValidaMontoPagadoConvalida();
		validaRestoPago("_convalida");
	}
	var valorobtenido=$("#txt_nmonrec_concepto").val()*1;
	valorobtenido=valorobtenido.toFixed(2);
	$("#txt_nmonrec_concepto").val(valorobtenido);
	seleccionarboletas();
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

cargarProvincia3=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento3','slct_provincia3','');	
}

cargarDistrito3=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento3','slct_provincia3','slct_distrito3','');
}

cargarProvinciat=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','');	
}

cargarDistritot=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t','');
}

/*cargarHorario=function(marcado){ //tendra "marcado" en select luego cargar
	$("#slct_horario").html("<option value=''>--Seleccione--</option>");
	grupoAcademicoDAO.cargarGrupoAcademico(sistema.llenaSelect,'slct_horario',marcado);
}*/

ValidaModalidad=function(){
	$("#txt_nueva_modalidad").val("");
	if($("#slct_modalidad_ingreso").val()!=""){
	$(".nueva_modalidad").css("display","none");
	}
	else{
	$(".nueva_modalidad").css("display","");
	}
}

RegistrarInscrito=function(){
seleccionarboletas();
  var error="";
  var tipodoc="";
  var captacion="";
  if($.trim($("#txt_persona_elegida").val())==""){
  $("#txt_persona_elegida").focus();
  sistema.msjAdvertencia('Seleccione <b>Persona para devolucion</b>');
  error="ok";
  }
  else if($.trim($("#slct_centro_captacion").val())==""){
  $("#slct_centro_captacion").focus();
  sistema.msjAdvertencia('Seleccione <b>Centro de Captacion</b>');
  error="ok";
  }
  else if($.trim($("#slct_local_estudio").val())==""){
  $("#slct_local_estudio").focus();
  sistema.msjAdvertencia('Seleccione <b>Local de Estudio</b>');
  error="ok";
  }
  else if($.trim($("#slct_local_instituto").val())==""){
  $("#slct_local_instituto").focus();
  sistema.msjAdvertencia('Seleccione <b>Instituto</b>');
  error="ok";
  }
  else if($.trim($("#slct_semestre").val())==""){
  $("#slct_semestre").focus();
  sistema.msjAdvertencia('Seleccione <b>Semestre</b>');
  error="ok";
  }
  else if(!$("#lista_grupos .ui-state-highlight").attr("id")){
  sistema.msjAdvertencia('Seleccione <b>Grupo Académico</b>');
  error="ok";
  }
  else if($.trim($("#txt_codigo_libro").val())==""){
  $("#txt_codigo_libro").focus();
  sistema.msjAdvertencia('Ingrese <b>Código del Libro</b> a inscribir');
  error="ok";
  }
  else if($.trim($("#txt_codigo_ficha_insc1").val())==""){
  $("#txt_codigo_ficha_insc1").focus();
  sistema.msjAdvertencia('Ingrese <b>Serie : Código Ficha de Inscripción</b> a inscribir');
  error="ok";
  }
  else if($.trim($("#txt_codigo_ficha_insc2").val())==""){
  $("#txt_codigo_ficha_insc2").focus();
  sistema.msjAdvertencia('Ingrese <b>Número : Código Ficha de Inscripción</b> a inscribir');
  error="ok";
  }
  else if($.trim($("#id_cperson").val())==""){
  sistema.msjAdvertencia('Busque y seleccione <b>Persona</b> a inscribir');
  error="ok";
  }   
  /*else if($("#txt_cod_cert_est").val()==""){
  $("#txt_cod_cert_est").focus();  
  sistema.msjAdvertencia('Ingrese <b>Código de Certificado de Estudio</b>');
  error="ok";
  }
  else if($("#txt_cod_part_nac").val()==""){
  $("#txt_cod_part_nac").focus();  
  sistema.msjAdvertencia('Ingrese <b>Código de Partida de Nacimiento</b>');
  error="ok";
  }*/
  else if($.trim($('#slct_rdo_fotoc_dni').val())==""){
  $('#slct_rdo_fotoc_dni').focus();  
  sistema.msjAdvertencia('Seleccione <b>Fotocópia de DNI</b>');
  error="ok";
  }
  else if($("#slct_modalidad_ingreso").val()==""){
  $("#slct_modalidad_ingreso").focus();
  sistema.msjAdvertencia('Seleccione <b>Modalidad Ingreso</b>');
  error="ok";
  } 
  else if($("#slct_solo_beca").val()=="" && $.trim($("#slct_local_instituto").val().split("-")[1])=="1"){
  $("#slct_solo_beca").focus();
  sistema.msjAdvertencia('Indicar si <b>¿postula a la beca?</b>');
  error="ok";
  }
  
  /*Datos Adicionales*/
  var valmodalidad=$("#slct_modalidad_ingreso").val().split("-")[1];
  if(error!="ok" && valmodalidad=="S"){
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
  
  if(error!="ok"){//validacion para pagos
	if($.trim($("#slct_tipo_pago_ins").val())==''){
	$("#slct_tipo_pago_ins").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Pago de Inscripción</b>');
	error="ok";
	}
	else if($("#slct_concepto_ins").val()==''){
	$("#slct_concepto_ins").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle de Pago</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#txt_monto_pagado_ins").val())==''){
	$("#txt_monto_pagado_ins").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#txt_fecha_pago_ins").val())==''){
	$("#txt_fecha_pago_ins").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago</b> de Inscripción');
	error="ok";
	}
	else if($("#slct_tipo_documento_ins").val()==''){
	$("#slct_tipo_documento_ins").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#txt_serie_boleta_ins").val())=='' && $("#slct_tipo_documento_ins").val()=='B'){
	$("#txt_serie_boleta_ins").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#txt_nro_boleta_ins").val())=='' && $("#slct_tipo_documento_ins").val()=='B'){
	$("#txt_nro_boleta_ins").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#txt_nro_voucher_ins").val())=='' && $("#slct_tipo_documento_ins").val()=='V'){
	$("#txt_nro_voucher_ins").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher</b> de Inscripción');
	error="ok";
	}
	else if($.trim($("#slct_banco_ins").val())=='' && $("#slct_tipo_documento_ins").val()=='V'){
	$("#slct_banco_ins").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco</b> de Inscripción');
	error="ok";
	}
	/*Matricula*/
	else if($.trim($("#slct_condicion_pago").val())==''){
	$("#slct_condicion_pago").focus();  
	sistema.msjAdvertencia('Seleccione <b>Condición de Pago </b>');
	error="ok";
	}
	else if($("#slct_tipo_pago").val()==''){
	$("#slct_tipo_pago").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Pago</b> de Matrícula');
	error="ok";
	}
	else if($("#slct_concepto").val()==''){
	$("#slct_concepto").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle de Pago</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#txt_monto_pagado").val())==''){
	$("#txt_monto_pagado").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#txt_fecha_pago").val())==''){
	$("#txt_fecha_pago").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago</b> de Matrícula');
	error="ok";
	}
	else if($("#slct_tipo_documento").val()==''){
	$("#slct_tipo_documento").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#txt_serie_boleta").val())=='' && $("#slct_tipo_documento").val()=='B'){
	$("#txt_serie_boleta").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#txt_nro_boleta").val())=='' && $("#slct_tipo_documento").val()=='B'){
	$("#txt_nro_boleta").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#txt_nro_voucher").val())=='' && $("#slct_tipo_documento").val()=='V'){
	$("#txt_nro_voucher").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher</b> de Matrícula');
	error="ok";
	}
	else if($.trim($("#slct_banco").val())=='' && $("#slct_tipo_documento").val()=='V'){
	$("#slct_banco").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco</b> de Matrícula');
	error="ok";
	}
	/*Pensión*/
	else if($("#slct_concepto_pension").val()==''){
	$("#slct_concepto_pension").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle de Pago</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#txt_monto_pagado_pension").val())==''){
	$("#txt_monto_pagado_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#txt_fecha_pago_pension").val())==''){
	$("#txt_fecha_pago_pension").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago</b> de Pensión');
	error="ok";
	}
	else if($("#slct_tipo_documento_pension").val()==''){
	$("#slct_tipo_documento_pension").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#txt_serie_boleta_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='B'){
	$("#txt_serie_boleta_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#txt_nro_boleta_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='B'){
	$("#txt_nro_boleta_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#txt_nro_voucher_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='V'){
	$("#txt_nro_voucher_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher</b> de Pensión');
	error="ok";
	}
	else if($.trim($("#slct_banco_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='V'){
	$("#slct_banco_pension").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco</b> de Pensión');
	error="ok";
	}
	else if($("#txt_promocion_economica").val()==""){
	$("#txt_promocion_economica").focus();
	sistema.msjAdvertencia('Ingrese <b>Promoción Económica de la Admisión</b>');
	error="ok";
	}
	/*Convalidación*/ 
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $("#slct_concepto_convalida").val()==''){
	$("#slct_concepto_convalida").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle de Pago</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#txt_monto_pagado_convalida").val())==''){
	$("#txt_monto_pagado_convalida").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#txt_fecha_pago_convalida").val())==''){
	$("#txt_fecha_pago_convalida").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $("#slct_tipo_documento_convalida").val()==''){
	$("#slct_tipo_documento_convalida").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#txt_serie_boleta_convalida").val())=='' && $("#slct_tipo_documento_convalida").val()=='B'){
	$("#txt_serie_boleta_convalida").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#txt_nro_boleta_convalida").val())=='' && $("#slct_tipo_documento_convalida").val()=='B'){
	$("#txt_nro_boleta_convalida").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#txt_nro_voucher_convalida").val())=='' && $("#slct_tipo_documento_convalida").val()=='V'){
	$("#txt_nro_voucher_convalida").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher</b> de Convalidación');
	error="ok";
	}
	else if($("#slct_modalidad_ingreso").val().split("-")[1]=="S" && $.trim($("#slct_banco_convalida").val())=='' && $("#slct_tipo_documento_convalida").val()=='V'){
	$("#slct_banco_convalida").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco</b> de Convalidación');
	error="ok";
	}
  }
  /*Medio de captación*/
  if(error!="ok"){	
	var tipo=$("#slct_medio_captacion").val().split("-")[1];
	var iden=$("#slct_medio_captacion").val().split("-")[2];
	
	if($("#slct_medio_captacion").val()==""){
    $("#slct_medio_captacion").focus();
    sistema.msjAdvertencia('Seleccione <b>Medio de Captación</b>');
    error="ok";
    }	
	else if(tipo=='1' && $("#txt_medio_captacion").val()==""){
	$("#txt_medio_captacion").focus();
    sistema.msjAdvertencia('Ingrese <b>Descripción del Medio de Captación</b>');
    error="ok";
	}
	else if(tipo=='2' && $("#id_cvended_jqgrid").val()==''){	
    sistema.msjAdvertencia('Busque y seleccione <b>'+$("#slct_medio_captacion option[value='"+$("#slct_medio_captacion").val()+"']").text()+'</b>');
    error="ok";
	}
	else if(tipo=='3' && $("#slct_medio_prensa").val()==""){
	$("#slct_medio_prensa").focus();
	sistema.msjAdvertencia('Seleccione <b>Medios Masivos</b>');
    error="ok";
	}
    else if($("#id_cvended_r").val()==""){
    $("#id_cvended_r").focus();  
    sistema.msjAdvertencia('Busque y seleccione <b>Recepcionista</b>');
    error="ok";
    }
	else{
	inscripcionDAO.InsertarInscripcion();
	}
  }
}

Limpiarpagos=function(){
$("#txt_monto_pagado_ins").val("0");	
$("#txt_monto_pagado").val("0");
$("#txt_monto_pagado_pension").val("0");
$("#txt_monto_pagado_convalida").val("0");
}

LimpiarInscripcion=function(){
$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');
$("#postula_beca").css("display","none");
$("#slct_solo_beca").val("0");
$("#txt_fecha").val(sistema.getFechaActual("yyyy-mm-dd"));
$("#txt_fecha_pago").val(sistema.getFechaActual("yyyy-mm-dd"));
$("#txt_fecha").focus();
$("#val_boleta").css("display","none");
$("#val_voucher").css("display","none");
$("#lista_grupos").html("");
$('#slct_pais_procedencia').val('173');
validarTotalG();
$(':text[id^="txt_fecha"]').val(sistema.getFechaActual('yyyy-mm-dd'));
$("#txt_ode").val($("#hd_desFilial").val());	
$("#txt_promocion_economica").val("Sin Promoción");
$("#validatotal").attr("disabled","true");
$("#cciclo").val("01");
$("#txt_docum_vali").val("");
$("#valida_pago_convalidacion").css("display","none");
$("#valida_proceso_convalidacion").css("display","none");

seleccionarboletas();
$("#table_jqgrid_concep").trigger('reloadGrid');
}