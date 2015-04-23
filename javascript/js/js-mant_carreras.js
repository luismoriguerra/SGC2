$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');	
	$("#slct_instituto").change(function(){ValidaCarrera()});
	//$("#slct_modalidad").change(function(){ValidaCarrera()});
})


ValidaCarrera=function(){
  var error="";
  
  if($.trim($("#slct_instituto").val())==""){
	  // || $.trim($("#slct_modalidad").val())==""
		$('#valCarreras').css("display",'none');
		$('#OperacionCarreras').css("display",'none');
  		error="ok";
  }else{
      	$('#valCarreras').css("display",'');
      	$('#OperacionCarreras').css("display",'');
	  	carreraDAO.ValidaCuadroCarrera(ListarCarreras);
  }
	
}

CargarFiliales=function(){
	$("#valCarreras select[id^='slct_filial_']").map(function(index,data){
		//$("#ids_"+this.id).val().split("|")  es para convertir en array y pueda visualizarse.		
		institucionDAO.cargarFilialG(sistema.llenaSelectGrupo,this.id,$("#ids_"+this.id).val().split("|"),'Filial');
		$("#"+this.id).multiselect({
   		selectedList: 4, // 0-based index		
		}).multiselectfilter();
	})
}

ListarCarreras=function(obj){
	var htm="";
	var total=0;
	$("#valCarreras .ListaCarreras").remove();
	
	$.each(obj,function(index,value){
		total = total + 1 ;
		htm+="<tr class='ListaCarreras ui-widget-content jqgrow ui-row-ltr'>";
		htm+="<td class='t-left'>"+total+"</td>";
		htm+="<td class='t-left'><select id='slct_filial_"+value.ccarrer+"' class='input-xlarge' style='width: 370px; display: none;' multiple><optgroup label='Filial'><option value=''>--Selecione--</option></optgroup></select><input type='hidden' id='ids_slct_filial_"+value.ccarrer+"' value='"+value.filiales+"'></td>";
		htm+="<td class='t-left'><input type='text' id='txt_des_"+value.ccarrer+"' value='"+value.dcarrer+"' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
		htm+="<td class='t-center'><input type='text' id='txt_abr_"+value.ccarrer+"' value='"+value.dabrcar+"' class='input-large' onKeyPress='return sistema.validaAlfanumerico(event)' /></td>";
		htm+="<td class='t-center'>";
		htm+="	<select id='slct_est_"+value.ccarrer+"' class='input-medium'>";
		if(value.cestado == "1"){
		htm+="	<option value='1' selected='selected'>Activado</option>";
		htm+="	<option value='0'>Desactivado</option>";
		}else{
		htm+="	<option value='1'>Activado</option>";
		htm+="	<option value='0' selected='selected'>Desactivado</option>";	
		}
		htm+="	</select></td>";
		htm+="<td class='t-center'><input type = 'Checkbox' id='chk_mod_"+value.ccarrer+"' ></td>";
		htm+="</tr>";
	})
	$("#valCarreras").append(htm);
	
	CargarFiliales();
}

AgregarCarrera=function(){
	$("#btn_NuevaCarrera").css("display",'none');
	var htm="";
	
	htm+="<tr class='ListaCarreras ui-widget-content jqgrow ui-row-ltr'>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'><select id='slct_filial_nuevo' class='input-xlarge' style='width: 370px; display: none;' multiple><optgroup label='Filial'><option value=''>--Selecione--</option></optgroup></select><input type='hidden' id='ids_slct_filial_nuevo' value=''></td>";
	htm+="<td class='t-left'><input type='text' id='txt_des_nuevo' value='' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
	htm+="<td class='t-center'><input type='text' id='txt_abr_nuevo' value='' class='input-mini' onKeyPress='return sistema.validaAlfanumerico(event)' /></td>";
	htm+="<td class='t-center'> Activado </td>";
	htm+="<td class='t-center'><input type = 'Checkbox' id='chk_mod_nuevo' checked readonly disabled></td>";
	htm+="</tr>";
	
	$("#valCarreras").append(htm);
	
	CargarFiliales();	
}

DescartaCambiosCarrera=function(){
	$("#btn_NuevaCarrera").css("display",'');
	ValidaCarrera();
}

GuardarCambiosCarrera=function(){
	var error="";
	var codigo="";
	var contador=0;
	var	datoscjto;
	datoscjto=$("#valCarreras input[id^='chk_mod_']").map(function(index,data){
		contador = contador + 1;
		if($("#"+this.id).attr('checked')){
			codigo = this.id.split('_')[2];
			if(error==""){
				if($.trim($("#txt_des_"+codigo).val())==""){
					sistema.msjAdvertencia("El campo Descripcion de la carrera numero " + contador + " no puede ser vacio.");
					$("#txt_des_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_abr_"+codigo).val())==""){
					sistema.msjAdvertencia("El campo Abreviatura de la carrera numero " + contador + " no puede ser vacio.");
					$("#txt_abr"+codigo).focus();
					error="ok";
				}else if($.trim($("#slct_filial_"+codigo).val())==""){
					sistema.msjAdvertencia("Es necesario Seleccionar la(s) Filial(es) para la carrera numero " + contador + ".");
					$("#slct_filial_"+codigo).focus();
					error="ok";
				}else{
					return  codigo + "|" +
							$.trim($("#slct_filial_"+codigo).val().join("~")) + "|" +
							$.trim($("#txt_des_"+codigo).val()) + "|" +
							$.trim($("#txt_abr_"+codigo).val()) + "|" +
							$.trim($("#slct_est_"+codigo).val());
				}
			}
		}
	}).get().join("^");
	if(error==""){
		if(datoscjto==""){
			sistema.msjAdvertencia("Debe Seleccionar las carreras a Modificar.");
		}else{
		carreraDAO.GuardarCambiosCarreras(datoscjto);
		}
	}
}