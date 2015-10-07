$(document).ready(function(){

    $('#nav-reportes').addClass('active');//aplica estilo al menu activo
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    $("#slct_instituto, #slct_filial").multiselect({
        selectedList: 4,
        click: function(event, ui){
            cargarCarrera("");
        },
        checkAll: function(){
            cargarCarrera("");
        },
        uncheckAll: function(){
            cargarCarrera("");
        }, // 0-based index
        optgrouptoggle: function(){
            cargarCarrera("");
        },
        afterSelect: function(value){
            cargarCarrera("");
        }
    }).multiselectfilter();

    $("#slct_carrera").multiselect({
        selectedList: 4 // 0-based index
    }).multiselectfilter();

    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });

    //$("#slct_filial").change(function(){cargarCarrera("");});
    //$("#slct_instituto").change(function(){cargarCarrera("");});


})


cargarCarrera=function(marcado){
    var cfilial=$("#slct_filial").multiselect("getChecked").map(function(){return this.value;}).get();
    var cinstit=$("#slct_instituto").multiselect("getChecked").map(function(){return this.value;}).get();

    if (cfilial && cinstit) {
        carreraDAO.cargarCarreraInstitucionMultiple(sistema.llenaSelectGrupo,'slct_carrera', "", "Carreras");

    }
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

ExportarDatosIngresantes = function () {
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val();
    var ccarrer=$("#slct_carrera").val();
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();

    window.location='../reporte/excel/EXCELingresantes.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&ccarrer='+ccarrer+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}


ExportarDatosResultados = function () {
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val().join(",");
    var ccarrer=$("#slct_carrera").val().join(",");
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();

    window.location='../reporte/excel/EXCELresultados.php?cfilial='
    +cfilial+'&cinstit='+cinstit+'&ccarrer='+ccarrer+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}