$(document).ready(function(){

    $('#nav-reportes').addClass('active');//aplica estilo al menu activo
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    $("#slct_filial").multiselect({
        selectedList: 4 // 0-based index
    }).multiselectfilter();

    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });

    $("#slct_filial").change(function(){cargarCarrera("");});
    $("#slct_instituto").change(function(){cargarCarrera("");});
//

})


cargarCarrera=function(marcado){ //tendra "marcado" en select luego cargar
    carreraDAO.cargarCarreraG(sistema.llenaSelect,'slct_carrera',marcado);
}



ExportarDatos = function () {
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val();
    var ccarrer=$("#slct_carrera").val();
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();

    window.location='../reporte/excel/EXCELpostulantes.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&ccarrer='+ccarrer+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}