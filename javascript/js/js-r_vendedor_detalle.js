$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo		    
	$('#btn_exportar').click(function(){Exportar()});
	//$("#slct_filial").change(function(){CargaSemestre()});
	//$("#slct_instituto").change(function(){CargaSemestre()});
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
/*
CargaSemestre=function(){	
	carreraDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre','');	
}
*/

Exportar=function(){
	if($("#slct_filial").val()==null){
	sistema.msjAdvertencia('Seleccione Filial',2000);
	}
	else if($("#slct_instituto").val()==null){
	sistema.msjAdvertencia('Seleccione Instituto',2000);
	}
	else if($("#txt_fecha_inicio").val()==''){
	sistema.msjAdvertencia('Ingrese Fecha Rango Inicio',2000);
	}
	else if($("#txt_fecha_fin").val()==''){
	sistema.msjAdvertencia('Ingrese Fecha Rango Final',2000);
	}
	else{
    var cfilial=$("#slct_filial").val().join(",");
    var cinstit=$("#slct_instituto").val().join(",");
    var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();
    window.location='../reporte/excel/EXCELvendedordetalle.php?cfilial='
                    +cfilial+'&cinstit='+cinstit+'&usuario='+$('#hd_idUsuario').val()+'&fechini='+fechini+'&fechfin='+fechfin+'&orden=g.cfilial,g.cinstit,ca.dcarrer';
	}
}