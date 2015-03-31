$(document).ready(function(){
	/*dialog*/	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo

	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	$('#btnExportar').click(Exportar);
	$('#btnListar').click(Visualizar);
	$('#btn_actualizar_boleta').click(modificarBoleta);	
	$("#txt_fechaInicio").val(sistema.getFechaActual("yyyy-mm-dd"));
	$("#txt_fechaFin").val(sistema.getFechaActual("yyyy-mm-dd"));

	$('#form_act_boleta').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	
	jqGridReporte.arqueo_boleta();

});

validavisiblefecha=function(val){
	$("#fechas").css("display",'none');
	if(val=='SI'){
		$("#fechas").css("display",'');
	}
}

validar_fechas=function(){
    if(($.trim($('#txt_fechaInicio').val())=='' || $.trim($('#txt_fechaFin').val())=='') && $("#slct_valida_fecha").val()=='SI'){//ninguno tenga campo en blanco
         sistema.msjAdvertencia('Indicar Fechas: Inicio - Fin</b>',200,2000);return false;
    }
    return true;
}

Visualizar=function(){
    if(validar_fechas()){
        $("#validalista").css("display","none");
		$("#table_arqueo").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_arqueo&visible='+$("#slct_valida_fecha").val()+'&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()+'&serbol='+$("#txt_serie_boleta").val()+'&nrobol='+$("#txt_nro_boleta").val()}); 
        $("#table_arqueo").trigger('reloadGrid');
    }    
}

Exportar=function(){
    if(validar_fechas()){
        var f_ini=$('#txt_fechaInicio').val();
        var f_fin=$('#txt_fechaFin').val();
        var cfilial = $("#hd_idFilial").val();
         var dfilial = $("#hd_desFilial").val();
	window.location='../reporte/excel/EXCELarqueoCaja.php?finicio='+f_ini+'&ffin='+f_fin+"&cfilial="+cfilial+"&dfilial="+dfilial;	
    }    
}

ActualizarBoleta=function(){
	//ids=$('#table_pago').jqGrid('getGridParam','selarrrow');
	var id=$("#table_arqueo").jqGrid("getGridParam",'selrow');
	$("#form_act_boleta .form i").remove();
    if (id) {
        var data = $("#table_arqueo").jqGrid('getRowData',id);
        $('#id_boleta').val(id);
        $('#txt_nro_boleta_edit').val(data.nnrobol);
        $('#txt_serie_boleta_edit').val(data.nserbol);
        $('#txt_fecha_edit').val(data.festfin);
        $('#txt_fecha_edit2').val(data.festfin);
        $('#txt_nro_boleta_edit2').val(data.nnrobol);
        $('#txt_serie_boleta_edit2').val(data.nserbol);
        $('#div_alumno').html(data.alumno);
        $('#form_act_boleta').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Registro</b> a Editar')
	}
}

modificarBoleta=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_serie_boleta_edit');
	a[1] = sistema.requeridoTxt('txt_nro_boleta_edit');
	/*a[1] = sistema.requeridoSlct('slct_instituto');*/
	for(var i=0;i<2;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        pagoDAO.editBoleta();
}