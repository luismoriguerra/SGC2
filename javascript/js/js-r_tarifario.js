$(document).ready(function(){
    $('#nav-reportes').addClass('active');
    $('#btn_exportar').click(function(){Exportar()});
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    $("#slct_filial").multiselect({
    selectedList: 4 // 0-based index
    }).multiselectfilter();
    $("#slct_instituto").multiselect({
    selectedList: 4 // 0-based index
    }).multiselectfilter();

    $('#btn_mostar').click(function(){listarIndiceMatricula()});
    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });
})

Exportar=function(){
    if( $.trim($("#slct_filial").val())=="" ){
        sistema.msjAdvertencia("Debe seleccionar una filial",2000);
        $("#slct_filial").focus();
    }else if( $.trim($("#slct_instituto").val()) == "" ){
        sistema.msjAdvertencia("Debe seleccionar una Institucion",2000);
        $("#slct_instituto").focus();
    }else if( $("#txt_fecha_inicio").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Inicio",2000);
        $("#txt_fecha_inicio").focus();
    }else if( $("#txt_fecha_fin").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Fin",2000);
        $("#txt_fecha_fin").focus();
    }else{
    window.location='../reporte/excel/EXCELtarifario.php?cfilial='+$("#slct_filial").val().join(",")
                    +'&fechini='+$("#txt_fecha_inicio").val()+'&fechfin='+$("#txt_fecha_fin").val()
                    +'&cinstit='+$("#slct_instituto").val().join(",")+'&usuario='+$("#hd_idUsuario").val();
    }
}

