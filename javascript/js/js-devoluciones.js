$(document).ready(function(){

    $('#nav-reportes').addClass('active');//aplica estilo al menu activo
    carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
    //institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    //institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    $("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});
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
    var csemaca=$("#slct_semestre").val();
    var cciclo=$("#slct_ciclo").val();
    window.location='../reporte/excel/EXCELdevoluciones.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&csemaca='+csemaca+'&cciclo='+cciclo+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}