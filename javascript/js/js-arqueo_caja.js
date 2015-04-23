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
	$("#txt_fechaInicio").val(sistema.getFechaActual("yyyy-mm-dd"));
	$("#txt_fechaFin").val(sistema.getFechaActual("yyyy-mm-dd"));
	
	jqGridReporte.arqueo();

});

validar_fechas=function(){
    if($.trim($('#txt_fechaInicio').val())=='' || $.trim($('#txt_fechaFin').val())==''){//ninguno tenga campo en blanco
         sistema.msjAdvertencia('Indicar Fechas: Inicio - Fin</b>',200,2000);return false;
    }
    return true;
}

Visualizar=function(){
    if(validar_fechas()){
        $("#validalista").css("display","none");
		$("#table_arqueo").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_arqueo&cfilial='+$('#hd_idFilial').val()+'&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()}); 
        $("#table_arqueo").trigger('reloadGrid');
    }    
}

Exportar=function(){
    if(validar_fechas()){
        var f_ini=$('#txt_fechaInicio').val();
        var f_fin=$('#txt_fechaFin').val();
        var cfilial = $("#hd_idFilial").val();
         var dfilial = $("#hd_desFilial").val();
         var nrobol = $("#txt_nro_boleta").val();
         var serbol = $("#txt_serie_boleta").val();
	window.location='../reporte/excel/EXCELarqueoCaja.php?finicio='+f_ini+'&ffin='+f_fin+"&cfilial="+cfilial+"&dfilial="+dfilial+"&nrobol="+nrobol+"&serbol="+serbol;	
    }    
}