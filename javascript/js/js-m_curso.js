$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.ListaInstitutos(ListaInst);
	jQGridCurso.Curso();    
});

ListaInst=function(data){
$("#cinstits").val(data)
}

