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
})

Omitir=function(){
  window.location='http://www.google.com';
}

Registrar=function(){
  registroDAO.Insertar();
}

Limpiar=function(){
$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');
}