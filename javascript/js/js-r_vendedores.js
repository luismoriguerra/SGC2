$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');
	$('#btn_exportar').click(function(){Exportar()});
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor","");
	
    $("#slct_instituto").multiselect({
    selectedList: 4 // 0-based index
    }).multiselectfilter();

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
        
})

ActualizaCentroOpe=function(){
    personaDAO.listarOpeven(sistema.llenaSelect,"slct_opeven","");
}

Exportar=function(){
    if( $.trim($("#slct_vendedor").val())=="" ){
        sistema.msjAdvertencia("Debe seleccionar un tipo vendedor",2000);
        $("#slct_filial").focus();
    }else if( $.trim($("#slct_opeven").val()) == "" ){
        sistema.msjAdvertencia("Debe seleccionar un centro de operaciones",2000);
        $("#slct_instituto").focus();
    }else if( $("#txt_fecha_matric").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Matricula",2000);
        $("#txt_fecha_matric").focus();
    }else if( $("#txt_pago_mensual").val() == "" ){
        sistema.msjAdvertencia("Ingrese Pago Mensual",2000);
        $("#txt_pago_mensual").focus();
    }else{
	window.location='../reporte/excel/EXCELvendedores2.php?cinstit='+$("#slct_instituto").val().join(",")
                    +'&copeven='+$("#slct_opeven").val()
                    +'&dopeven='+$("#slct_opeven option[value='"+$("#slct_opeven").val()+"']").html()
                    +'&tvended='+$("#slct_vendedor").val()
                    +'&dvendedor='+$("#slct_vendedor option[value='"+$("#slct_vendedor").val()+"']").html()
                    +'&fmatric='+$("#txt_fecha_matric").val()
                    +'&pago='+$("#txt_pago_mensual").val()
                    +'&usuario='+$("#hd_idUsuario").val();
    }
}

