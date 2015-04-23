$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo		    
	$('#btn_exportar').click(function(){Exportar()});
	$("#slct_filial").change(function(){CargaSemestre()});
	$("#slct_instituto").change(function(){CargaSemestre()});
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
        $('#btn_mostar').click(function(){listarIndiceMatricula()});
        
})

CargaSemestre=function(){	
	carreraDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre','');	
}


Exportar=function(){
	window.location='../reporte/excel/EXCELindicematricula.php?cfilial='
                	+$("#slct_filial").val().join(",")+'&csemaca='+$("#slct_semestre").val()+'&cinstit='+$("#slct_instituto").val();
}

listarIndiceMatricula = function(){
    
    //validaciones de campos vacios
    if( $("slct_filial").val() ){
        sistema.msjAdvertencia("Debe seleccionar una filial",2000);
    }else if( $("#slct_instituto").val() == "" ){
        sistema.msjAdvertencia("Debe seleccionar una Institucion",2000);
    }else if( $("#slct_semestre").val() == "" ){
        sistema.msjAdvertencia("Debe seleccionar un Semestre",2000);
    }else{
        institucionDAO.listarIndiceMatricula(listarIndiceMatriculaHtml);
        
    }
    
    
}

listarIndiceMatriculaHtml = function(obj){
    
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
    
}