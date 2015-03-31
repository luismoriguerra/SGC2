$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	conceptoDAO.cargarCuentaIngresoC(sistema.llenaSelect,'slct_cuenta_ing','');
	$("#slct_cuenta_ing").change(function(){$("#slct_subcta_1").val('');cargarSubCuenta1();$("#btn_NuevaSubCta1").css("display",'');sistema.limpiaSelect('slct_subcta_2');ValidaBotones()});
	$("#slct_subcta_1").change(function(){cargarSubCuenta2();ValidaBotones();});
	$("#slct_subcta_2").change(function(){ValidaBotones();});
})

ValidaBotones=function(){
	$("#btn_EstCtaIng").css("display",'none');
	$("#btn_EstSubCta1").css("display",'none');
	$("#btn_EstSubCta2").css("display",'none');
	$("#btn_NuevaCtaIng").css("display",'');
	$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta2").css("display",'');
	
	if($("#slct_cuenta_ing").val()!=""){
		$("#btn_EstCtaIng").css("display",'');
	}else{
		$("#btn_NuevaSubCta1").css("display",'none');
		$("#btn_NuevaSubCta2").css("display",'none');
	}
	
	if($("#slct_subcta_1").val()!=""){
		$("#btn_EstSubCta1").css("display",'');
	}else{
		$("#btn_NuevaSubCta2").css("display",'none');
	}
	
	if($("#slct_subcta_2").val()!=""){
		$("#btn_EstSubCta2").css("display",'');
	}
}

cargarSubCuenta1=function(){
	$("#slct_subcta_2").val('');
	conceptoDAO.cargarSubCuenta1C(sistema.llenaSelect,'slct_cuenta_ing','slct_subcta_1','');
}

cargarSubCuenta2=function(){
	conceptoDAO.cargarSubCuenta2C(sistema.llenaSelect,'slct_subcta_1','slct_subcta_2','');
}

NuevaCtaIng=function(){
	$("#valNuevaCtaIng").css("display",'');
	$("#btn_NuevaCtaIng").css("display",'none');
	$("#btn_NuevaSubCta1").css("display",'none');
	$("#btn_NuevaSubCta2").css("display",'none');
	ValidaBotones();
}

NuevaSubCta1=function(){
	if($.trim($("#slct_cuenta_ing").val())==""){
  		$("#slct_cuenta_ing").focus();
  		sistema.msjAdvertencia('Seleccione <b>Cuenta de Ingreso</b>');
	}else{
		$("#valNuevaSubCta1").css("display",'');
		$("#btn_NuevaCtaIng").css("display",'none');
		$("#btn_NuevaSubCta1").css("display",'none');
		$("#btn_NuevaSubCta2").css("display",'none');
	}
	ValidaBotones();
}

NuevaSubCta2=function(){
	if($.trim($("#slct_subcta_1").val())==""){
  		$("#slct_subcta_1").focus();
  		sistema.msjAdvertencia('Seleccione <b>Sub Cuenta 1</b>');
	}else{
		$("#valNuevaSubCta2").css("display",'');
		$("#btn_NuevaCtaIng").css("display",'none');
		$("#btn_NuevaSubCta1").css("display",'none');
		$("#btn_NuevaSubCta2").css("display",'none');
	}
	ValidaBotones();
}

CancelarNuevaCtaIng=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaCtaIng").css("display",'');
	$("#valNuevaCtaIng").css("display",'none');
	$("#txt_NuevaCtaIng").val('');
	ValidaBotones();
}

CancelarNuevaSubCta1=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta1").css("display",'');
	$("#valNuevaSubCta1").css("display",'none');
	$("#txt_NuevaSubCta1").val('');
	ValidaBotones();
}

CancelarNuevaSubCta2=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta2").css("display",'');
	$("#valNuevaSubCta2").css("display",'none');
	$("#txt_NuevaSubCta2").val('');
	ValidaBotones();
}

GuardarNuevaCtaIng=function(){
  	var error="";
  	if($.trim($("#txt_NuevaCtaIng").val())==""){
  		$("#txt_NuevaCtaIng").focus();
  		sistema.msjAdvertencia('Ingrese Nueva <b>Cuenta de Ingreso</b> a Registrar');
  		error="ok";
  	}
  	if(error!="ok"){
		conceptoDAO.InsertarCuentaC();
  	}
}

GuardarNuevaSubCta1=function(){
 	var error="";
  	if($.trim($("#txt_NuevaSubCta1").val())==""){
  		$("#txt_NuevaSubCta1").focus();
  		sistema.msjAdvertencia('Ingrese Nueva <b>Sub-Cuenta 1</b> a Registrar');
  		error="ok";
  	}
  	if(error!="ok"){
		conceptoDAO.InsertarSubCuenta1C();
  	}
	ValidaBotones();
}

GuardarNuevaSubCta2=function(){
  	var error="";
  	if($.trim($("#txt_NuevaSubCta2").val())==""){
  		$("#txt_NuevaSubCta2").focus();
  		sistema.msjAdvertencia('Ingrese Nueva <b>Sub-Cuenta 2</b> a Registrar');
  		error="ok";
  	}
 	if(error!="ok"){
		conceptoDAO.InsertarSubCuenta2C();
  	}
	ValidaBotones();
}

CambiarEstCtaIng=function(){
	if($.trim($("#slct_cuenta_ing").val())==""){
  		$("#slct_cuenta_ing").focus();
  		sistema.msjAdvertencia('Seleccione <b>Cuenta de Ingreso</b>');
	}else{
		conceptoDAO.CambEstCtaIng();
	}
}

CambiarEstSubCta1=function(){
	if($.trim($("#slct_subcta_1").val())==""){
  		$("#slct_subcta_1").focus();
  		sistema.msjAdvertencia('Seleccione <b>Sub-Cuenta 1</b>');
	}else{
		conceptoDAO.CambEstSubCta1();
	}
}

CambiarEstSubCta2=function(){
	if($.trim($("#slct_subcta_2").val())==""){
  		$("#slct_subcta_2").focus();
  		sistema.msjAdvertencia('Seleccione <b>Sub-Cuenta 2</b>');
	}else{
		conceptoDAO.CambEstSubCta2();
	}
}

ValidaConcepto=function(){
	ValidaBotones();
}