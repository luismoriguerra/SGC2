$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	$('#form_pagos').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	jqGridPersona.personaIngAlum2();
	$(".esconde").css("display","none");
	$("#btn_registrar_retiro").hide();
	$(".devolucion-seccion").hide();

	$("#txt_dscto").keyup(function(){
		$("#txt_por_des").val($("#txt_dscto").val());
		$("#txt_mon_ret").val($("#txt_monto_retension_retiro").val());
		$("#txt_mon_des").val($("#txt_monto_comision_retiro").val());

	});

})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);
		$('#txt_dfilial').val(data.dfilial);
		$('#txt_dinstit').val(data.dinstit);
		$('#txt_dcarrer').val(data.dcarrer);
		$('#txt_csemaca').val(data.csemaca);
		$('#txt_cinicio').val(data.cinicio);
		$('#txt_finicio').val(data.finicio);
		$('#txt_dhorari').val(data.dhorari);
		pagoDAO.cargarMontoAcumulado();
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Editar')
	}
}

function MostrarDevolucionSeccion(value) {

	if (value == "Si") {
		$(".devolucion-seccion").show();
	} else {
		$(".devolucion-seccion").hide();
	}

}

CalcularComision=function(){
	var por=$("#txt_dscto").val();
	if(por*1>1){
	por=$("#txt_dscto").val()/100;
	}
	var dscto=$("#txt_monto_total").val()-($("#txt_monto_total").val()*1*por);
	$("#txt_monto_dscto").val(dscto.toFixed(2));
	Visualizar($("#slct_operacion").val());

	$("#txt_por_des").val($("#txt_dscto").val());
	$("#txt_mon_ret").val($("#txt_monto_retension_retiro").val());
	$("#txt_mon_des").val($("#txt_monto_comision_retiro").val());
}


CalcularComisionMonto=function(){

	var monto = $("#txt_monto_comision_retiro").val(),
		pagado = $("#txt_monto_total").val(),
		monto_final = pagado - monto,
		porcentaje = (monto / pagado) * 100;


	$("#txt_dscto").val(porcentaje.toFixed(2));
	$("#txt_monto_retension_retiro").val(monto_final);

	$("#txt_por_des").val(porcentaje.toFixed(2));
	$("#txt_mon_ret").val(monto_final);
	$("#txt_mon_des").val(monto);


}


Visualizar=function(val){
	$(".esconde").css("display","none");
	$('.esconde .form input[type="text"],.esconde .form input[type="hidden"],.esconde .form select').val('');
	$("#btn_registrar_retiro").show();
	var cingalu=$("#txt_cingalu").val();
	if(val=="R" && $.trim(cingalu)!=''){
		$("#frmRetiro").css("display","");
	var por=$("#txt_dscto").val();
		if(por*1>1){
		por=$("#txt_dscto").val()/100;
		}
		var dscto=$("#txt_monto_total").val()*1*por;
		$("#txt_monto_comision_retiro").val(dscto.toFixed(2));
		$("#txt_monto_retension_retiro").val($("#txt_monto_dscto").val());
	}
	else if(val=="G" && $.trim(cingalu)!=''){
	
	}
	else if(val=="P" && $.trim(cingalu)!=''){
	
	}
	else if(val!=""){
	sistema.msjAdvertencia("Seleccione un Alumno",3000);
	}
}

RegistrarRetiro=function(){
	if($.trim($("#txt_dscto").val())==''){
	sistema.msjAdvertencia("Ingrese % del descuento");
	}
	else{
		if(confirm("CONFIRMAR OPERACIÓN: Dsct del "+$('#txt_dscto').val()+" %")==true){
		pagoDAO.registrarRetiro();
		}
	}
}