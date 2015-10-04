$(document).ready(function(){

    $('#nav-reportes').addClass('active');//aplica estilo al menu activo
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    $("#slct_instituto,#slct_filial").multiselect({
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


CargaSemestre=function(){
    if($("#slct_instituto").val() && $("#slct_filial").val()){
        institucionDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre','');
    }
    //institucionDAO.cargarSemestreG(sistema.llenaSelectGrupo,'slct_semestre','','Semestre');
}



ExportarGrupoG=function(){
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val().join(",");
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();

    window.location='../reporte/excel/EXCELdevoluciones.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}

ExportarRetiros = function () {
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val().join(",");
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();

    window.location='../reporte/excel/EXCELretiros.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}