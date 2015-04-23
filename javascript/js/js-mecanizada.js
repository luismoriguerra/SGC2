$(document).ready(function(){
	/*dialog*/	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo	
	institucionDAO.cargarFilialValida(sistema.llenaSelect,'slct_filial',$("#hd_idFilial").val(),'Filial');
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	$('#btnExportar').click(ExportarCajaMecanizada);

});

validar_fechas=function(){
    if($.trim($('#txt_fechaInicio').val())=='' || $.trim($('#txt_fechaFin').val())==''){//ninguno tenga campo en blanco
         sistema.msjAdvertencia('Indicar Fechas: Inicio - Fin</b>',200,2000);return false;
    }
    return true;
}

ExportarCajaMecanizada=function(){
    if(validar_fechas()){
        var f_ini=$('#txt_fechaInicio').val();
        var f_fin=$('#txt_fechaFin').val();
        var cfilial = $("#slct_filial").val();
         var dfilial = $("#hd_desFilial").val();
	window.location='../reporte/excel/EXCELmecanizada.php?fini='+f_ini+'&ffin='+f_fin+"&filial="+cfilial+"&dfilial="+dfilial;	
    }    
}