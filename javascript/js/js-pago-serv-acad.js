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
	jqGridPersona.personaIngAlum();
	jqGridPago.pago();
	$('#txt_fecha_pago').val(sistema.getFechaActual('yyyy-mm-dd'));
	carreraDAO.cargarBanco(sistema.llenaSelect,'slct_banco_pension','');
	$('#btn_registrar_pago').click(registrarPago);
})
registrarPago=function(){
	if($('#txt_fecha_pago').val()=="" || $('#txt_monto_pagado').val()=="" || $('#slct_tipo_documento_pension').val()=="" ){
		sistema.msjAdvertencia("Ingrese campos obligatorios");
		return false;
	}
	if($('#slct_tipo_documento_pension').val()=="B"){
		$('#txt_nro_voucher_pension,#slct_banco_pension').val()=="";//limpio los otros campos de "V"

		if($('#txt_serie_boleta_pension').val()=="" || $('#txt_nro_boleta_pension').val()==""){
			sistema.msjAdvertencia("Ingrese campos obligatorios");
			return false;
		}	
	}else if($('#slct_tipo_documento_pension').val()=="V"){
		$('#txt_serie_boleta_pension,#txt_nro_boleta_pension').val()=="";//limpio los otros campos de "B"

		if($('#txt_nro_voucher_pension').val()=="" || $('#slct_banco_pension').val()==""){
			sistema.msjAdvertencia("Ingrese campos obligatorios");
			return false;
		}	
	}
	
	if($('#txt_monto_pagado').val()*1<$('#txt_monto_minimo').val()*1){
		sistema.msjAdvertencia("Monto minimo a pagar=<b>"+$('#txt_monto_minimo').val()+"</b>");
		return false;
	}
	
	if($('#txt_monto_pagado').val()*1>$('#txt_monto_por_pagar').val()*1){		
		$('#txt_monto_pagado').focus();
		sistema.msjAdvertencia("Monto maximo a pagar=<b>"+$('#txt_monto_por_pagar').val()+"</b>");
		return false;
	}
	
	//ids=$('#table_pago').jqGrid('getGridParam','selarrrow');
	ids=$("#table_pago tr.ui-state-highlight").map(function(index, element) {					
		return element.id;
	}).get();
	pagoDAO.registrarPago(ids);
}

CalculaDeuda=function(){
	var r=$('#txt_monto_por_pagar').val()*1-$('#txt_monto_pagado').val()*1;
	
	if(r>=0){
	$('#txt_monto_deuda').val(r);
	}
	else{
	$('#txt_monto_pagado').val("0");
	$('#txt_monto_pagado').focus();
	$('#txt_monto_deuda').val($('#txt_monto_por_pagar').val());
	sistema.msjAdvertencia('El monto a pagar no puede exeder los: <b>'+$('#txt_monto_por_pagar').val()+'</b>',2000);
	}
	
}

cargarMontoPago=function(){
	//ids=$('#table_pago').jqGrid('getGridParam','selarrrow');
	ids=$("#table_pago tr.ui-state-highlight").map(function(index, element) {					
		return element.id;
	}).get();
	if(ids.length>0){
		pagoDAO.cargarMontoPago(ids,function(obj,est){//mando array de ids (crecaca noseq) y me devuelve registros en json
			total=0;
			totalmin=0;
			for(i=0;i<obj.length;i++){
				total+=parseFloat(obj[i].nmonrec);
				if(i<(obj.length-1)){
					totalmin+=parseFloat(obj[i].nmonrec);
				}
			}
			$('#txt_monto_por_pagar').val(total);
			$('#txt_monto_minimo').val(totalmin+1);
			$('#txt_monto_pagado').val("0");
			$('#txt_monto_deuda').val(total);
			if(est!=""){
			$('#form_pagos').dialog('close');
			}
			else{
			$('#form_pagos').dialog('open');
			}
		});
	}
	else{
	sistema.msjAdvertencia('Seleccione <b>Registros de Pago</b>');
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