$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarInstitucion(sistema.llenaSelect,'slct_instituto','');	
	$("#slct_instituto").change(function(){CargaCursos("")});
})

CargaCursos=function(id_slect){
	cursoDAO.cargarCursos(sistema.llenaSelect,'slct_curso','');
}

NuevoCurso=function(){
	$("#valNuevoCurso").css("display",'');
	$("#valNuevoCurso2").css("display",'');
	$("#btn_NuevoCurso").css("display",'none');
	$("#btn_ActualizaCurso").css("display",'none');
}

ModificaCurso=function(){
	if($.trim($("#slct_curso").val())==""){
  		$("#slct_curso").focus();
  		sistema.msjAdvertencia('Seleccione <b>Curso a Modificar</b>');
	}else{
		$("#valModificaCurso").css("display",'');
		$("#btn_NuevoCurso").css("display",'none');
		$("#btn_ActualizaCurso").css("display",'none');
	}
}

CancelarNuevoCurso=function(){
	$("#btn_NuevoCurso").css("display",'');
	$("#btn_ActualizaCurso").css("display",'');
	$("#valNuevoCurso").css("display",'none');
	$("#valNuevoCurso2").css("display",'none');
	$("#txt_NuevoCurso").val('');
	$("#txt_NuevoAbrev").val('');
}

CancelarModifCurso=function(){
	$("#btn_NuevoCurso").css("display",'');
	$("#btn_ActualizaCurso").css("display",'');
	$("#valModificaCurso").css("display",'none');
	$("#txt_ModifCurso").val('');
	$("#txt_ModifAbrev").val('');
}

GuardarNuevoCurso=function(){
  var error="";
  if($.trim($("#txt_NuevoCurso").val())==""){
  $("#txt_NuevoCurso").focus();
  sistema.msjAdvertencia('Ingrese Nuevo <b>Curso</b> a Registrar');
  error="ok";
  }
  if(error!="ok"){
	cursoDAO.InsertarCurso();
  }
}

GuardarModifCurso=function(){
  var error="";
  if($.trim($("#txt_ModifCurso").val())==""){
  $("#txt_ModifCurso").focus();
  sistema.msjAdvertencia('Ingrese Nueva <b>Descripcion del Curso</b>');
  error="ok";
  }
  if(error!="ok"){
	cursoDAO.ActualizarCurso();
  }
}
