$(document).ready(function(){	
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo	
	personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor","");
	$('#btn_exportar').click(function(){Exportar()});
	$('#btn_mostar').click(function(){Listar()});
})

Exportar=function(){
	window.location='../reporte/excel/EXCELvendedores.php?dapepat='
                	+$("#txt_paterno").val()+'&dapemat='+$("#txt_materno").val()+'&dnombre='+$("#txt_nombre").val()+'&tvended='+$("#slct_vendedor").val();
}

Listar= function(){
	personaDAO.ListarVendedor(ListarHtml);    
}

ListarHtml = function(obj){
    
    $("tr.tbody").remove();
    
    var html = "";
    $.each(obj,function(index,value){       
    html +="<tr class='tbody'>";
    html +="<td>"+ (index+1)  +"</td>";
    html +="<td>"+ value.dapepat  +"</td>";
    html +="<td>"+ value.dapemat +"</td>";
    html +="<td>"+ value.dnombre +"</td>";
    html +="<td>"+ value.ndocper +"</td>";
    html +="<td>"+ value.dtelefo +"</td>";
    html +="<td>"+ value.demail +"</td>";
    html +="<td>"+ value.ddirecc+"</td>";
    html +="<td>"+ value.distrito+"</td>";
    html +="<td>"+ value.fingven +"</td>";
	html +="<td>"+ value.tvended +"</td>";
	html +="<td>"+ value.codintv +"</td>";
    html +="</tr>";        
    });
    
	$(".table-listado").css("display","");
    $(".table-listado").append(html);
    
}