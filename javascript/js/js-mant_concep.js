$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	//carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');	
	carreraDAO.cargarTipoCarrera(sistema.llenaSelect,'slct_tipo_carrera','2');
	conceptoDAO.cargarCuentaIngreso(sistema.llenaSelect,'slct_cuenta_ing','');
	$("#slct_filial").change(function(){ValidaCarrera();ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_instituto").change(function(){ValidaCarrera();ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	//$("#slct_modalidad").change(function(){ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_tipo_carrera").change(function(){ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_tipo_pago").change(function(){ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_cuenta_ing").change(function(){cargarSubCuenta1();ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_subcta_1").change(function(){cargarSubCuenta2();ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_subcta_2").change(function(){ValidaConcepto();$("#btn_NuevoConcepto").css("display",'');});
	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	$("#slct_carrera").multiselect({
		selectedList: 4 // 0-based index
		}).multiselectfilter();
	$(".escondecar").css("display","none");
})

VisualizarCarreras=function(){
	$("#slct_carrera").multiselect("refresh");
	if($("#slct_todas_carreras").val()=="SI"){
	$(".escondecar").css('display','none');
	}
	else{
	$(".escondecar").css('display','');
	}
}

cargarSubCuenta1=function(){
	$("#slct_subcta_2").val('');
	conceptoDAO.cargarSubCuenta1(sistema.llenaSelect,'slct_cuenta_ing','slct_subcta_1','');
}

cargarSubCuenta2=function(){
	conceptoDAO.cargarSubCuenta2(sistema.llenaSelect,'slct_subcta_1','slct_subcta_2','');
}

NuevaCtaIng=function(){
	$("#valNuevaCtaIng").css("display",'');
	$("#btn_NuevaCtaIng").css("display",'none');
	$("#btn_NuevaSubCta1").css("display",'none');
	$("#btn_NuevaSubCta2").css("display",'none');
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
}

CancelarNuevaCtaIng=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta2").css("display",'');
	$("#valNuevaCtaIng").css("display",'none');
	$("#txt_NuevaCtaIng").val('');
}

CancelarNuevaSubCta1=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta2").css("display",'');
	$("#valNuevaSubCta1").css("display",'none');
	$("#txt_NuevaSubCta1").val('');
}

CancelarNuevaSubCta2=function(){
	//$("#btn_NuevaCtaIng").css("display",'');
	//$("#btn_NuevaSubCta1").css("display",'');
	$("#btn_NuevaSubCta2").css("display",'');
	$("#valNuevaSubCta2").css("display",'none');
	$("#txt_NuevaSubCta2").val('');
}

GuardarNuevaCtaIng=function(){
  var error="";
  if($.trim($("#txt_NuevaCtaIng").val())==""){
  $("#txt_NuevaCtaIng").focus();
  sistema.msjAdvertencia('Ingrese Nueva <b>Cuenta de Ingreso</b> a Registrar');
  error="ok";
  }
  if(error!="ok"){
	conceptoDAO.InsertarCuenta();
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
	conceptoDAO.InsertarSubCuenta1();
  }
}

GuardarNuevaSubCta2=function(){
  var error="";
  if($.trim($("#txt_NuevaSubCta2").val())==""){
  $("#txt_NuevaSubCta2").focus();
  sistema.msjAdvertencia('Ingrese Nueva <b>Sub-Cuenta 2</b> a Registrar');
  error="ok";
  }
  if(error!="ok"){
	conceptoDAO.InsertarSubCuenta2();
  }
}

ValidaCarrera=function(){
	if($.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!=""){	
	carreraDAO.cargarCarreraG(sistema.llenaSelectGrupo,'slct_carrera','','Carrera');
	$("#slct_carrera").multiselect("refresh");;
	}
}

ValidaConcepto=function(){
  var error="";
  
  if($.trim($("#slct_filial").val())=="" || $.trim($("#slct_instituto").val())=="" || 
	 $.trim($("#slct_tipo_carrera").val())=="" || $.trim($("#slct_subcta_1").val())=="" || 
	 $.trim($("#slct_tipo_pago").val())=="" || $.trim($("#slct_cuenta_ing").val())==""){
	 //$.trim($("#slct_modalidad").val())=="" || 
		$('#valConceptos').css("display",'none');
		$('#OperacionConceptos').css("display",'none');
  		error="ok";
  }else{
      	$('#valConceptos').css("display",'');
      	$('#OperacionConceptos').css("display",'');
	  	conceptoDAO.ValidaCuadroConcepto(ListarConceptos);
  }
	
}

ListarConceptos=function(obj){
	var htm="";
	var total=0;
	$("#valConceptos .ListaConceptos").remove();
	
	$.each(obj,function(index,value){
		total = total + 1 ;
		htm+="<tr class='ListaConceptos ui-widget-content jqgrow ui-row-ltr'>";
		htm+="<td class='t-left'>"+total+"</td>";
		htm+="<td class='t-left'><input type='hidden' id='txt_fil_"+value.cconcep+"' value='"+value.cfilial+"'>"+value.dfilial+"</td>";
		htm+="<td class='t-left'><input type='hidden' id='txt_car_"+value.cconcep+"' value='"+value.ccarrer+"'>"+value.dcarrer+"</td>";
		htm+="<td class='t-left'><input type='text' id='txt_des_"+value.cconcep+"' value='"+value.dconcep+"' disabled class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
		htm+="<td class='t-center'><input type='text' id='txt_cuo_"+value.cconcep+"' value='"+value.ncuotas+"' disabled class='input-mini' onKeyPress='return sistema.validaNumeros(event)' /></td>";
		htm+="<td class='t-center'><input type='text' id='txt_pre_"+value.cconcep+"' value='"+value.nprecio+"' disabled class='input-mini' onKeyPress='return sistema.validaNumeros(event)' /></td>";
		htm+="<td class='t-center'><input type='text' id='txt_cta_"+value.cconcep+"' value='"+value.ctaprom+"' disabled class='input-mini' onKeyPress='return sistema.validaNumeros(event)' onKeyUp='sistema.validaNumeroMayor("+'"'+"txt_cuo_"+value.cconcep+'","'+"txt_cta_"+value.cconcep+'"'+");' /></td>";
		htm+="<td class='t-center'><input type='text' id='txt_mto_"+value.cconcep+"' value='"+value.mtoprom+"' disabled class='input-mini' onKeyPress='return sistema.validaNumeros(event)' onKeyUp='sistema.validaNumeroMayor("+'"'+"txt_pre_"+value.cconcep+'","'+"txt_mto_"+value.cconcep+'"'+");' /></td>";
		htm+="<td class='t-center'>";
		htm+="	<select id='slct_est_"+value.cconcep+"' class='input-medium'>";
		if(value.cestado == "1"){
		htm+="	<option value='1' selected='selected'>Activado</option>";
		htm+="	<option value='0'>Desactivado</option>";
		}else{
		htm+="	<option value='1'>Activado</option>";
		htm+="	<option value='0' selected='selected'>Desactivado</option>";	}
		htm+="	</select></td>";
		htm+="<td class='t-center'><input type = 'Checkbox' id='chk_mod_"+value.cconcep+"' ></td>";
		htm+="</tr>";
	})
	$("#valConceptos").append(htm);
}

AgregarConcepto=function(){
	$("#btn_NuevoConcepto").css("display",'none');
	var htm="";
	var valorText=$("#slct_subcta_2 option[value='"+$("#slct_subcta_2").val()+"']").text();
	if(valorText.toUpperCase()=='--SELECCIONE--'){
	valorText=$("#slct_subcta_1 option[value='"+$("#slct_subcta_1").val()+"']").text();
	}
	
	htm+="<tr class='ListaConceptos ui-widget-content jqgrow ui-row-ltr'>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'><input type='text' id='txt_des_nuevo' value='"+valorText+"' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
	htm+="<td class='t-center'><input type='text' id='txt_cuo_nuevo' value='' class='input-mini' onKeyPress='return sistema.validaNumeros(event)' /></td>";
	htm+="<td class='t-center'><input type='text' id='txt_pre_nuevo' value='' class='input-mini' onKeyPress='return sistema.validaNumeros(event)' /></td>";
	htm+="<td class='t-center'><input type='text' id='txt_cta_nuevo' value='' class='input-mini' onKeyPress='return sistema.validaNumeros(event);' onKeyUp='sistema.validaNumeroMayor("+'"'+"txt_cuo_nuevo"+'","'+"txt_cta_nuevo"+'"'+");'  /></td>";
	htm+="<td class='t-center'><input type='text' id='txt_mto_nuevo' value='' class='input-mini' onKeyPress='return sistema.validaNumeros(event);' onKeyUp='sistema.validaNumeroMayor("+'"'+"txt_pre_nuevo"+'","'+"txt_mto_nuevo"+'"'+");'/></td>";
	htm+="<td class='t-center'> Activado </td>";
	htm+="<td class='t-center'><input type = 'Checkbox' id='chk_mod_nuevo' checked readonly disabled></td>";
	htm+="</tr>";
	
	$("#valConceptos").append(htm);
}

DescartaCambiosConcep=function(){
	$("#btn_NuevoConcepto").css("display",'');
	ValidaConcepto();
}

GuardarCambiosConcep=function(){
	var error="";
	var codigo="";
	var contador=0;
	var	datoscjto;
	
	if($("#slct_todas_carreras").val()=="NO" && $.trim($("#slct_carrera").val())==""){
		sistema.msjAdvertencia("Seleccione almenos una Carrera");
		$("#slct_carrera").focus();
		error="ok";
	}
	else{
		datoscjto=$("#valConceptos input[id^='chk_mod_']").map(function(index,data){
			contador = contador + 1;
			if($("#"+this.id).attr('checked')){
				codigo = this.id.split('_')[2];
				if(error==""){
					if($.trim($("#txt_des_"+codigo).val())==""){
						sistema.msjAdvertencia("Los campos Descripcion y Precio del concepto numero " + contador + " no pueden ser vacios.");
						$("#txt_des_"+codigo).focus();
						error="ok";
					}else if($.trim($("#txt_pre_"+codigo).val())==""){
						sistema.msjAdvertencia("Los campos Descripcion y Precio del concepto numero " + contador + " no pueden ser vacios.");
						$("#txt_pre_"+codigo).focus();
						error="ok";				
					}
					else if($.trim($("#txt_cta_"+codigo).val())==""){
						sistema.msjAdvertencia("Los campos de Cuenta y Monto de promocion numero " + contador + " no pueden ser vacios. Ingresar 0 sino hay promocion");
						$("#txt_cta_"+codigo).focus();
						error="ok";
					}
					else if($.trim($("#txt_mto_"+codigo).val())==""){
						sistema.msjAdvertencia("Los campos de Cuenta y Monto de promocion numero " + contador + " no pueden ser vacios. Ingresar 0 sino hay promocion");
						$("#txt_mto_"+codigo).focus();
						error="ok";
					}else{
						return  codigo + "|" +
								$.trim($("#txt_des_"+codigo).val()) + "|" +
								$.trim($("#txt_cuo_"+codigo).val()) + "|" +
								$.trim($("#txt_pre_"+codigo).val()) + "|" +
								$.trim($("#slct_est_"+codigo).val()) + "|" +
								$.trim($("#txt_fil_"+codigo).val()) + "|" +
								$.trim($("#txt_cta_"+codigo).val()) + "|" +
								$.trim($("#txt_mto_"+codigo).val()) + "|" +
								$.trim($("#txt_car_"+codigo).val());
					}
				}
			}
		}).get().join("^");
	}
	if(error==""){
		if(datoscjto==""){
			sistema.msjAdvertencia("Debe Seleccionar los conceptos a Modificar.");
		}else{
		conceptoDAO.GuardarCambiosConceptos(datoscjto);
		}
	}
}