$().ready(function(){

$("#HorarioDisponible").hide();
jqGridDocente.DocenteHorario();

window.templatesHtml = {}
templatesHtml.nuevoRow =  _.template( $("#TemplateDisponible").html() );



});


/*
Exporta datos del docente en pdf
*/
function Exportar_Disponibilidad(){
// capturo 1 $("#table_docente").jqGrid("getGridParam",'selrow');
//captura varios $('#table_docente').jqGrid('getGridParam','selarrrow');

var ids=$('#table_docente').jqGrid('getGridParam','selarrrow');
    if (ids.length !== 0 ) {

    var grupos = $('#table_docente').jqGrid('getGridParam','selarrrow');
    var lista_grupos = grupos.join(',');
    window.open('../reporte/pdf/PDFProfesDisponibilidad.php?'+ "docentes="+lista_grupos , "_blank");  

    }else {
        sistema.msjAdvertencia('Seleccione un registro a Exportar');
    }

}
















