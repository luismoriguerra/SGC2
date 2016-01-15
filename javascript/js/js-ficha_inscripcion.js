$(document).ready(function(){
    $('#nav-servicios').addClass('active');//aplica estilo al menu activo
    
    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });

    jqGridPersona.personaIngAlum2();
    
})

eventoClick=function(){
    var ids=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');
    var data = $("#table_persona_ingalum").jqGrid('getRowData',ids);
    console.log(data);
    var params = decodeURIComponent($.param(data));
    window.open('../reporte/pdf/PDFFichaInscripcion.php?' + params, "_blank");
}
