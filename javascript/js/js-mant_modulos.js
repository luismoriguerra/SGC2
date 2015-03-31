$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	//carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
	$("#slct_instituto").change(function(){cargaCarrera();});
	//$("#slct_modalidad").change(function(){cargaCarrera();});
	$("#slct_carrera").change(function(){ValidaModulo();});
})

cargaCarrera=function(){
	if($.trim($("#slct_instituto").val())=="")	{		
	sistema.limpiaSelect('slct_carrera');	
	}else{	
	carreraDAO.cargarCarreraM(sistema.llenaSelect,'slct_carrera','');	
	}
	ValidaModulo();	
}

ValidaModulo=function(){
  var error="";  
  if($.trim($("#slct_carrera").val())=="" ){
		$('#valModulosTot').css("display",'none');
		$('#OperacionModulos').css("display",'none');
  		error="ok";
  }else{
	  	carreraDAO.ValidaCuadroModulo(ListarModulos);
      	$('#valModulosTot').css("display",'');
      	$('#OperacionModulos').css("display",'');
		$("#btn_GuardaNuevo").css("display",'none');
	    $("#btn_NuevoModulo").css("display",'');	  	
  }
	
}

ListarModulos=function(obj){
	var htm="";
	var total=0;
	var comilla='"';
	$("#valModulos .ListaModulos").remove();
	
	$.each(obj,function(index,value){
		htm+="<tr class='ListaModulos ui-widget-content jqgrow ui-row-ltr'>";
		htm+="<td class='t-left'>&nbsp;</td>";
		htm+="<td class='t-left'>"+value.nrommod+"</td>";
		htm+="<td class='t-left'><input type='text' id='txt_des_"+value.cmodulo+"' value='"+value.dmodulo+"' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
		if(value.nrommod!="1"){
			htm+=" <td class='t-left'>";
			htm+="		<span class='formBotones' id='btn_Subir_"+value.cmodulo+"'>";
			htm+="      <a href='javascript:void(0)' onClick='SubirOrden("+comilla+value.cmodulo+comilla+");' class='btn btn-azul sombra-3d t-blanco'>";
			htm+="      <i class='icon-white icon-arrow-up'></i>";
			htm+="      <span></span>";
			htm+="      </a>";
			htm+="      </span>";
			htm+="</td>";
		}else{
			htm+="<td class='t-left'>&nbsp;</td>";
		}
		htm+=" <td class='t-left'>";
		htm+="		<span class='formBotones' id='btn_Act_"+value.cmodulo+"'>";
		htm+="      <a href='javascript:void(0)' onClick='ActuaDesc("+comilla+value.cmodulo+comilla+");' class='btn btn-azul sombra-3d t-blanco'>";
		htm+="      <i class='icon-white icon-refresh'></i>";
		htm+="      <span></span>";
		htm+="      </a>";
		htm+="      </span>";
		htm+="</td>";
		htm+="</tr>";
	})
	$("#valModulos").append(htm);
}

AgregarModulo=function(){
	$("#btn_NuevoModulo").css("display",'none');
	$("#btn_GuardaNuevo").css("display",'');
	var htm="";
	
	htm+="<tr class='ListaModulos ui-widget-content jqgrow ui-row-ltr'>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'><input type='text' id='txt_des_nuevo' value='' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="</tr>";
	
	$("#valModulos").append(htm);
}

DescartaCambiosModulo=function(){
	$("#btn_GuardaNuevo").css("display",'none');
	$("#btn_NuevoModulo").css("display",'');
	ValidaModulo();
}

GuardarNuevoModulo=function(){
	if($.trim($("#txt_des_nuevo").val())==""){
		sistema.msjAdvertencia("El campo Descripcion NO puede ser vacio.");
		$("#txt_des_nuevo").focus();
		error="ok";
	}else{
		carreraDAO.GuardarModulo();		
	}
}

SubirOrden=function(codigo){
	carreraDAO.actualizaNroMmod(codigo);
}

ActuaDesc=function(codigo){
	carreraDAO.actualizaDescModulo(codigo);
}