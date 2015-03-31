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
	window.location='../reporte/excel/EXCELmatriculamedios.php?cfilial='
                	+$("#slct_filial").val().join(",")+'&fechini='+$("#txt_fecha_inicio").val()+'&fechfin='+$("#txt_fecha_fin").val()+'&cinstit='+$("#slct_instituto").val().join(",")+'&usuario='+$("#hd_idUsuario").val();
	}
}

listarIndiceMatricula = function(){
    
    //validaciones de campos vacios
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
        //institucionDAO.listarIndiceMatricula2(listarIndiceMatriculaHtml);
        
    }
    
    
}

/*listarIndiceMatriculaHtml = function(obj){
    
    $("tr.tbody").remove();
    
    var html = "";
    $.each(obj,function(index,value){
     var totalmatriculados =    parseInt(value.total) -( parseInt(value.mayor) + parseInt(value.menor) );
     var mayor = value.mayor;
     var nmetmat = value.nmetmat;
     var vacantes= nmetmat - totalmatriculados - ( parseInt(mayor)/2 );
     var indice=Math.round((1 - (parseInt(vacantes)/parseInt(nmetmat)))*100);
        
       
    html +="<tr class='tbody'>";
    html +="<td>"+ (index+1)  +"</td>";
    html +="<td>"+ value.dfilial  +"</td>";
    html +="<td>"+ value.dinstit +"</td>";
    html +="<td>"+ value.dturno +"</td>";
    html +="<td>"+ value.dcarrer +"</td>";
    html +="<td>"+ value.csemaca +"</td>";
    html +="<td>"+ value.cinicio +"</td>";
    html +="<td>"+ value.finicio +"</td>";
    html +="<td>"+ value.horario +"</td>";
    html +="<td>"+ value.nmetmat +"</td>";
    html +="<td>"+ value.menor +"</td>";
    html +="<td>"+ value.mayor +"</td>";
    html +="<td>"+ totalmatriculados +"</td>";
    html +="<td>"+ vacantes +"</td>";
    html +="<td>"+ indice +"%</td>";
    html +="</tr>";
        
    });
    
    $(".table-indicematricula").append(html);
    
}*/