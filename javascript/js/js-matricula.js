$(document).ready(function(){
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	
	jqGridPersona.recepcionista();
	
	$('#frmTrabajador').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	
	/*dialog*/	
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridInscrito.inscrito();
	carreraDAO.cargarTipoCarrera(sistema.llenaSelect,'slct_tipo_carrera','');
	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');	
	carreraDAO.cargarSemestre(sistema.llenaSelect,'slct_semestre','');	
	carreraDAO.cargarModalidadIngreso(sistema.llenaSelect,'slct_modalidad_ingreso','');
	carreraDAO.cargarBanco(sistema.llenaSelect,'slct_banco,#slct_banco_pension','');	
	$("#slct_tipo_carrera").change(function(){cargarCarrera("");cargarHorario("");cargarConcepto();cargarConceptoPension();});
	$("#slct_modalidad").change(function(){cargarCarrera("");cargarHorario("");cargarConcepto();cargarConceptoPension();});
	$("#slct_semestre").change(function(){cargarInicio("");cargarHorario("");});
	$("#slct_carrera").change(function(){cargarHorario("");});
	$("#slct_inicio").change(function(){cargarHorario("");});
	$("#slct_condicion_pago").change(function(){cargarConceptoPension();});	
	$("#slct_tipo_pago").change(function(){cargarConcepto();cargarConceptoPension();});
	$("#slct_horario").change(function(){CargarCursos($('#slct_rdo_condic_alum').val());cargarConceptoPension();});
	$(':text[id^="txt_fecha"]').val(sistema.getFechaActual('yyyy-mm-dd'));
})

ListarRecepcionista=function(){
	var dis=$("#mantenimiento_recepcionista").css("display");
	if(dis=='none'){
	$("#mantenimiento_recepcionista").css("display",'');
	}
	else{
	$("#mantenimiento_recepcionista").css("display",'none');
	}
}

add_recepcionista_jqgrid=function(){
	$("#frmTrabajador .form i").remove();
	$('#cvended').val('');
	$('#tvended').val('r');
	$('#frmTrabajador input[type="text"],#frmTrabajador select').val('');
	$('#slct_tipo_trabajador_t').val('r');
	$('#txt_fecha_ingreso_t').val(sistema.getFechaActual("yyyy-mm-dd"));
	
	$('#btnFormTrabajador').attr('onclick', 'nuevoTrabajador("recepcionista")');
	$('#spanBtnFormTrabajador').html('Guardar');
	$('#frmTrabajador').dialog('open');	
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
		$('#txt_email_t').val(data.demail);        
        $('#txt_celular_t').val(data.dtelefo);
		$('#txt_dni_t').val(data.ndocper);
		$('#slct_tipo_trabajador_t').val(data.tvended);
		$('#slct_sexo_t').val(data.tsexo);		
		$('#txt_fecha_ingreso_t').val(data.fingven);
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

nuevoTrabajador=function(trab){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_paterno_t');
	a[1] = sistema.requeridoTxt('txt_materno_t');
	a[2] = sistema.requeridoTxt('txt_nombre_t');
	a[3] = sistema.requeridoTxt('txt_email_t');
	a[4] = sistema.requeridoTxt('txt_celular_t');
	a[5] = sistema.requeridoTxt('txt_dni_t');
	a[6]= sistema.requeridoSlct('slct_sexo_t');
	for(var i=0;i<7;i++){
		if(!a[i]){
		return false;		
		break;		
		}
	}
	personaDAO.InsertarTrabajador(trab);
}

modificarTrabajador=function(trab){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_paterno_t');
	a[1] = sistema.requeridoTxt('txt_materno_t');
	a[2] = sistema.requeridoTxt('txt_nombre_t');
	a[3] = sistema.requeridoTxt('txt_email_t');
	a[4] = sistema.requeridoTxt('txt_celular_t');
	a[5] = sistema.requeridoTxt('txt_dni_t');
	a[6]= sistema.requeridoSlct('slct_sexo_t');
	for(var i=0;i<7;i++){
		if(!a[i]){
		return false;		
		break;		
		}
	}
	personaDAO.ActualizarTrabajador(trab);
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

CargarCursos=function(id){
	var htm="";
	htm+="<tr>"+
		"<td class='t-center label' width='50'>N°</td>"+
		"<td class='t-center label' width='200'>COD. ASIGNATURA</td>"+
		"<td class='t-center label' width='400'>NOMBRE ASIGNATURA</td>"+
		"<td class='t-center label' width='200'>CICLO</td>"+
		"<td class='t-center label' width='70'>N° CRED.</td>"+
		"</tr>";
	if(id=="IR"){	
	var total=0;		
	
	htm+="<tr>"+
         "<td class='t-center label' colspan='4'><font size='+3'>ALUMNO IRREGULAR</font></td>"+
		 "<td class='t-center label'>0</td>"+
		 "</tr>";
	$("#lista_cursos").html(htm);		
	}
	else if(id=="TE"){
	var total=0;		
	
	htm+="<tr>"+
         "<td class='t-center label' colspan='4'><font size='+3'>ALUMNO TRAS. EXTERNO</font></td>"+
		 "<td class='t-center label'>0</td>"+
		 "</tr>";
	$("#lista_cursos").html(htm);		
	}
	else if(id=="RE"){
	grupoAcademicoDAO.cargarCursosProgramados(ListarCursos);
	}
}

ListarCursos=function(obj){
var htm="";
htm+="<tr>"+
		"<td class='t-center label' width='50'>N°</td>"+
		"<td class='t-center label' width='200'>COD. ASIGNATURA</td>"+
		"<td class='t-center label' width='400'>NOMBRE ASIGNATURA</td>"+
		"<td class='t-center label' width='200'>CICLO</td>"+
		"<td class='t-center label' width='70'>N° CRED.</td>"+
		"</tr>";
var total=0;
	$.each(obj,function(index,value){
		htm+="<tr class='ui-widget-content jqgrow ui-row-ltr'>";
		htm+="<td>"+(index+1)+"</td>";
		htm+="<td>"+value.ccuprpr+"</td>";
		htm+="<td class='t-left'>"+value.dcurso+"</td>";
		htm+="<td>"+value.dciclo+"</td>";
		htm+="<td>"+value.ncredit+"</td>";
		htm+="</tr>";
		total=total+(value.ncredit*1);
	})
	htm+="<tr>"+
         "<td class='t-right label' colspan='4'>TOTAL CREDITOS MATRICULADOS</td>"+
		 "<td class='t-center label'>"+total+"</td>"+
		 "</tr>";
	$("#lista_cursos").html(htm);
}

mostrarInscripcion=function(){
	//$('#form_matricula').fadeOut('slow');
	
	$('#txt_ode').val($('#hd_idFilial').val());	

	var id=$("#table_inscrito").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_inscrito").jqGrid('getRowData',id);
        $('#txtIdInscrito').val(id.split("-")[0]);
        $('#slct_tipo_carrera').val(data.ctipcar);
        $('#slct_modalidad').val(data.cmodali);
        cargarCarrera(data.ccarrer);//muestra carreras, y le pone val=""
        $('#slct_semestre').val(data.csemadm);
        cargarInicio(data.cinicio);//muestra inicio, y le pone val=""
        $('#txt_paterno').val(data.dappape);
        $('#txt_materno').val(data.dapmape);
        $('#txt_nombre').val(data.dnomper);
		$('#txt_ficha_insc_post').val(data.dcodlib);
		$('#txt_email').val(data.email1);
		$('#txt_celular').val(data.ntelpe2);
		$('#txt_tel_casa_trab').val(data.ntelper+" / "+data.ntellab);		
		$('#txt_direccion').val(data.ddirper);
		$('#txt_referencia').val(data.ddirref);
		$('#txt_departamento').val(data.ddepart);
		$('#txt_provincia').val(data.dprovin);
		$('#txt_distrito').val(data.ddistri);
		$('#txt_direccion2').val(data.ddirlab);
		$('#txt_nombre_trabajo').val(data.dnomlab);
		$('#txt_ficha_insc_post').val(data.serinsc);	
		$('#txt_cod_cert_est').val(data.certest);
		$('#txt_cod_part_nac').val(data.partnac);
		$('#slct_rdo_fotoc_dni').val(data.fotodni);
		$('#txt_otro_doc').val(data.otrodni);
		cargarHorario("");
		cargarConcepto();
		cargarConceptoPension();
		
        $('#slct_modalidad_ingreso').val(data.tmodpos);

		//$('#form_matricula').fadeIn('fast');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Registro</b> a Mostrar')
	}
}

ValidaMontoPagado=function(){
	var mp=$("#txt_monto_pagado").val();
	var md=$("#slct_concepto").val().split("-")[1];
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado").val('');
	}
	else{
	$("#txt_monto_deuda").val((md*1-mp*1));
	}
}

ValidaMontoPagadoPension=function(){
	var mp=$("#txt_monto_pagado_pension").val();
	var md=$("#slct_concepto_pension").val().split("-")[1];
	if(mp*1>md*1){
	sistema.msjAdvertencia('El monto a pagar '+mp+' no puede ser mayor al detalle a pagar '+md,4000);
	$("#txt_monto_pagado_pension").val('');
	}
	else{
	$("#txt_monto_deuda_pension").val((md*1-mp*1));
	}
}

cargarConcepto=function(){
	conceptoDAO.cargarConcepto(sistema.llenaSelect,'slct_concepto','','701.01','');
}

cargarConceptoPension=function(){
	var precio="";
	if($("#slct_condicion_pago").val()=="1"){
	precio="0"
	}
	conceptoDAO.cargarConceptoPension(sistema.llenaSelect,'slct_concepto_pension','','701.03',precio);
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

cargarCarrera=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarCarrera(sistema.llenaSelect,'slct_carrera',marcado);
}  

cargarInicio=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarInicio(sistema.llenaSelect,'slct_inicio',marcado);
} 

cargarHorario=function(marcado){ //tendra "marcado" en select luego cargar
	grupoAcademicoDAO.cargarGrupoAcademico(sistema.llenaSelect,'slct_horario',marcado);
} 

Registrar=function(){
  var error="";
  var tipodoc="";
  var captacion="";
  if($.trim($("#txtIdInscrito").val())==""){
  sistema.msjAdvertencia('Busque y seleccione <b>Persona</b> a Matricular');
  error="ok";
  }
  else if($.trim($("#txt_cod_libro").val())==""){
  $("#txt_cod_libro").focus();
  sistema.msjAdvertencia('Ingrese <b>Código del Libro</b> a Matricular');
  error="ok";
  }
  else if($.trim($("#txt_cod_fic_mat1").val())==""){
  $("#txt_cod_fic_mat1").focus();
  sistema.msjAdvertencia('Ingrese <b>Código Serie Ficha de Matrícula</b>');
  error="ok";
  }
  else if($.trim($("#txt_cod_fic_mat2").val())==""){
  $("#txt_cod_fic_mat2").focus();
  sistema.msjAdvertencia('Ingrese <b>Código NRO Ficha de Matrícula</b>');
  error="ok";
  }
  else if($("#slct_tipo_carrera").val()==""){
  $("#slct_tipo_carrera").focus();
  sistema.msjAdvertencia('Seleccione <b>Tipo Carrera</b>');
  error="ok";
  }
  else if($("#slct_modalidad").val()==""){
  $("#slct_modalidad").focus();
  sistema.msjAdvertencia('Seleccione <b>Modalidad</b>');
  error="ok";
  }
  else if($("#slct_carrera").val()==""){
  $("#slct_carrera").focus();
  sistema.msjAdvertencia('Seleccione <b>Carrera</b>');
  error="ok";
  }
  else if($("#slct_semestre").val()==""){
  $("#slct_semestre").focus();
  sistema.msjAdvertencia('Seleccione <b>Semestre</b>');
  error="ok";
  }
  else if($("#slct_inicio").val()==""){
  $("#slct_inicio").focus();
  sistema.msjAdvertencia('Seleccione <b>Inicio</b>');
  error="ok";
  }
  else if($("#slct_modalidad_ingreso").val()==""){
  $("#slct_modalidad_ingreso").focus();
  sistema.msjAdvertencia('Seleccione <b>Modalidad Ingreso</b>');
  error="ok";
  }
  else if($("#slct_horario").val()==""){
  $("#slct_horario").focus();
  sistema.msjAdvertencia('Seleccione <b>Horario</b>');
  error="ok";
  }
  else if($("#txt_cod_univers").val()==""){
  $("#txt_cod_univers").focus();  
  sistema.msjAdvertencia('Ingrese <b>Código de Universidad</b>');
  error="ok";
  }/*
  else if($("#txt_cod_cert_est").val()==""){
  $("#txt_cod_cert_est").focus();  
  sistema.msjAdvertencia('Ingrese <b>Código de Certificado de Estudio</b>');
  error="ok";
  }
  else if($("#txt_cod_part_nac").val()==""){
  $("#txt_cod_part_nac").focus();  
  sistema.msjAdvertencia('Ingrese <b>Código de Partida de Nacimiento</b>');
  error="ok";
  }
  else if($.trim($('#slct_rdo_fotoc_dni').val())==""){
  $('#slct_rdo_fotoc_dni').focus();  
  sistema.msjAdvertencia('Seleccione <b>Fotocópia de DNI</b>');
  error="ok";
  }*/
  else if($("#id_cvended_r").val()==""){
  $("#id_cvended_r").focus();  
  sistema.msjAdvertencia('Busque y seleccione <b>Recepcionista</b>');
  error="ok";
  }
  
  if(error!="ok"){	  
	if($("#slct_condicion_pago").val()==''){
	$("#slct_condicion_pago").focus();  
	sistema.msjAdvertencia('Seleccione <b>Condición de Pago</b>');
	error="ok";
	}
  	else if($("#slct_tipo_pago").val()==''){
	$("#slct_tipo_pago").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Pago</b>');
	error="ok";
	}
	else if($("#slct_concepto").val()==''){
	$("#slct_concepto").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle</b>');
	error="ok";
	}
	else if($.trim($("#txt_monto_pagado").val())==''){
	$("#txt_monto_pagado").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado</b>');
	error="ok";
	}
	else if($.trim($("#txt_fecha_pago").val())==''){
	$("#txt_fecha_pago").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago</b>');
	error="ok";
	}
	else if($("#slct_tipo_documento").val()==''){
	$("#slct_tipo_documento").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento</b>');
	error="ok";
	}
	else if($.trim($("#txt_serie_boleta").val())=='' && $("#slct_tipo_documento").val()=='B'){
	$("#txt_serie_boleta").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta</b>');
	error="ok";
	}
	else if($.trim($("#txt_nro_boleta").val())=='' && $("#slct_tipo_documento").val()=='B'){
	$("#txt_nro_boleta").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta</b>');
	error="ok";
	}
	else if($.trim($("#txt_nro_voucher").val())=='' && $("#slct_tipo_documento").val()=='V'){
	$("#txt_nro_voucher").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher</b>');
	error="ok";
	}
	else if($.trim($("#slct_banco").val())=='' && $("#slct_tipo_documento").val()=='V'){
	$("#slct_banco").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco</b>');
	error="ok";
	}
	else if($("#slct_concepto_pension").val()==''){
	$("#slct_concepto_pension").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Detalle Pensión</b>');
	error="ok";
	}
	else if($.trim($("#txt_monto_pagado_pension").val())==''){
	$("#txt_monto_pagado_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Monto Pagado Pensión</b>');
	error="ok";
	}
	else if($.trim($("#txt_fecha_pago_pension").val())==''){
	$("#txt_fecha_pago_pension").focus();  
	sistema.msjAdvertencia('Seleccione <b>Fecha de Pago Pensión</b>');
	error="ok";
	}
	else if($("#slct_tipo_documento_pension").val()==''){
	$("#slct_tipo_documento_pension").focus();  
	sistema.msjAdvertencia('Seleccione el <b>Tipo de Documento Pensión</b>');
	error="ok";
	}
	else if($.trim($("#txt_serie_boleta_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='B'){
	$("#txt_serie_boleta_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Serie de la Boleta Pensión</b>');
	error="ok";
	}
	else if($.trim($("#txt_nro_boleta_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='B'){
	$("#txt_nro_boleta_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de la Boleta Pensión</b>');
	error="ok";
	}
	else if($.trim($("#txt_nro_voucher_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='V'){
	$("#txt_nro_voucher_pension").focus();  
	sistema.msjAdvertencia('Ingrese <b>Número de Voucher Pensión</b>');
	error="ok";
	}
	else if($.trim($("#slct_banco_pension").val())=='' && $("#slct_tipo_documento_pension").val()=='V'){
	$("#slct_banco_pension").focus();  
	sistema.msjAdvertencia('Seleccione <b>Banco Pensión</b>');
	error="ok";
	}
	else{
	matriculaDAO.InsertarMatricula();	
	}
  }
}

LimpiarMatricula=function(){
$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');
$("#txt_fecha_matri").val(sistema.getFechaActual("yyyy-mm-dd"));
$("#txt_fecha_pago").val(sistema.getFechaActual("yyyy-mm-dd"));
$("#txt_fecha_pago_pension").val(sistema.getFechaActual("yyyy-mm-dd"));

$("#slct_rdo_fotoc_dni").val("0");
$("#slct_rdo_condic_alum").val("RE");

$("#txt_fecha_matri").focus();
$("#val_boleta").css("display","none");
$("#val_voucher").css("display","none");
$("#val_boleta_pension").css("display","none");
$("#val_voucher_pension").css("display","none");
var htm="";
htm+="<tr>"+
		"<td class='t-center label' width='50'>N°</td>"+
		"<td class='t-center label' width='200'>COD. ASIGNATURA</td>"+
		"<td class='t-center label' width='400'>NOMBRE ASIGNATURA</td>"+
		"<td class='t-center label' width='200'>CICLO</td>"+
		"<td class='t-center label' width='70'>N° CRED.</td>"+
		"</tr>";
$("#lista_cursos").html(htm);
}