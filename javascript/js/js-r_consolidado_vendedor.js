$(document).ready(function(){
    
    $('#nav-reportes').addClass('active');
    $('#btn_exportar').click(function(){Exportar()});

    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });
        
})

Exportar=function(){
    if( $("#txt_fecha_matric").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Matricula",2000);
        $("#txt_fecha_matric").focus();
    }else{
    window.location='../reporte/excel/EXCELconsolidadoVendedor.php?'
                    +'fmatric='+$("#txt_fecha_matric").val()
                    +'&usuario='+$("#hd_idUsuario").val();
    }
}

