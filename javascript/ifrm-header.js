$(document).ready(function(){
	$('.nav-sub').navDesplegable();
	$('#secc-divi').ocultaSeccIzq();
	$('#cerrarSesion').click(cerrarSesion);
	$('#select_temas').selectorTemas();
	$('#GaleriaTemas').dialog({
       autoOpen : false,
       width : 380,
       height : 280,
       show : 'fade',
       hide : 'scale'       
    });
	$("#slct_grupo_cabecera").change(function(){CargarMenu();});
	$("#slct_filial_cabecera").change(function(){ActualizaFilial();});
	$("#slct_grupo_cabecera").val($("#hd_idGrupo").val());
	$("#slct_filial_cabecera").val($("#hd_idFilial").val()+"|"+$("#hd_desFilial").val());	
})
cerrarSesion=function(){
	window.location.href='close.php';
}

CargarMenu=function(){
	headerDAO.cargarHeader();
}

ActualizaFilial=function(){
	headerDAO.actualizarHeader();
}
