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
	subirDAO.uploadImportar();
	$('#cancelaProcImportar').click(cancelaProcesarImportar);
	$('#ProcImportar').click(procesarImportar);
})
procesarImportar=function(){
    var arch=$('#hddFileImportar').val();//valida si se subio archivo
    if(arch==''){
        sistema.msjAdvertencia('No ha subido Archivo');return false;
    }
    subirDAO.procesaArchivoImportar();
}
cancelaProcesarImportar=function(){
	$('#hddFileImportar').val('');
	$('#spanImportar').html('');
	$('#msg_resultado_importar').css('display', 'none');
}
validar_fechas=function(){
    if($.trim($('#txt_fechaInicio').val())=='' || $.trim($('#txt_fechaFin').val())==''){//ninguno tenga campo en blanco
        _msgAdvertenciaTiempo('Indicar Fechas: Inicio - Fin</b>',200,2000);return false;
    }
    return true;
}