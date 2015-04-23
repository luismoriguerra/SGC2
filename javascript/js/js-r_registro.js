$(document).ready(function(){	
	
	$('#btn_exportar').click(function(){Exportar()});
	$('#btn_mostar').click(function(){Listar()});
})

Exportar=function(){
	window.location='../reporte/excel/EXCELregistro.php?paterno='
                	+$("#txt_paterno").val()+'&materno='+$("#txt_materno").val()+'&nombre='+$("#txt_nombre").val()+'&dni='+$("#txt_dni").val();
}

Listar= function(){
	registroDAO.Cargar(CargarHtml);    
}

CargarHtml = function(obj){
    
    $("tr.tbody").remove();
    
    var html = "";
    $.each(obj,function(index,value){       
    html +="<tr class='tbody'>";
    html +="<td>"+ (index+1)  +"</td>";
    html +="<td>"+ value.paterno  +"</td>";
    html +="<td>"+ value.materno +"</td>";
    html +="<td>"+ value.nombre +"</td>";
    html +="<td>"+ value.dni +"</td>";
    html +="<td>"+ value.email+"</td>";
    html +="<td>"+ value.tel +"</td>";
    html +="<td>"+ value.cel+"</td>";
    html +="<td>"+ value.carrera+"</td>";
    html +="</tr>";        
    });
    
	$(".table-listado").css("display","");
    $(".table-listado").append(html);
    
}