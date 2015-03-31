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
	
	$('#btnListar').click(Visualizar);
	
	$("#txt_fechaInicio").val(sistema.getFechaActual("yyyy-mm-dd"));
	$("#txt_fechaFin").val(sistema.getFechaActual("yyyy-mm-dd"));

	jqGridReporte.arqueo_boleta2();

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