$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.cargarFilialG(sistema.llenaSelectGrupo,'slct_ufilial','','');
        
});

mostrarUsuario = function(){
    $(".editar-usuario").click(function(){
        institucionDAO.mostrarUsuarios($(this).attr("cperson"),mostrarUsuarioHtml);
    });
}

mostrarUsuarioHtml = function(obj){
    
    //Llenando datos
    $("#ucperson").val(obj.cperson);
    $("#full-name").text(obj.nombres+" "+obj.paterno+" "+obj.materno);
    $("#slct_estado").val(obj.estado);
    $("#login").val(obj.login);
    $("#pass").val(obj.clave);
    $("#slct_ufilial").val(obj.cfilial);
    $(".UsuarioGrupos").html("");
    $("#dnivusu").val(obj.dnivusu);
    $.each(obj.grupos, function(index, value){
        //el value contiene a cfilial y cgrupo value.cfilial
        agergarGrupo(value.cgrupo,value.cfilial);
    });
    
    $(".UsuariosCampos").show();
}

agergarGrupo = function(gru_id,cfilial){
    var html  ="<tr><td class='t-left label'>Grupo:</td><td colspan='5' class='t-left'>";
   // html +="<select id='slct_grupo' class='input-xlarge' onchange='validarGrupo(this)'>";
    html +="<select id='slct_grupo' class='input-xlarge'>";
    html +="<option value=''>--Selecione--</option>";
    html +="</select></td>";
    //agregando cfilial
    html +="<td colspan='5' class='t-left'><select id='slct_gfilial' class='input-xlarge'>";
    html +="<option value=''>--Selecione--</option>";
    html +="</select></td>";
    
    html +="<td class='BorrarGru'>";
    html +="<span class='formBotones' id='btn_BorrarGru'>";
    html +="<a href='javascript:void(0)' onClick='BorrarGrupo($(this));' class='btn btn-azul sombra-3d t-blanco'>";
    html +="<i class='icon-white icon-minus'></i>";
    html +="<span></span>";
    html +="</a></span>";
    html +="</td></tr>";
    
    $(".UsuarioGrupos").append(html);
    if(gru_id == "")
    CargaGrupos('slct_grupo','');
    else
    CargaGrupos('slct_grupo',gru_id );
    $('#slct_grupo').attr("id","slct_grupo[]")
    
    //agregando los valores a los gfilial
    if(cfilial == "")
    institucionDAO.cargarFilial(sistema.llenaSelect,"slct_gfilial","");
    else
    institucionDAO.cargarFilial(sistema.llenaSelect,"slct_gfilial",cfilial);
    $('#slct_gfilial').attr("id","slct_gfilial[]")
    
}

validarGrupo = function(req){
   
    $(req).removeClass("v");
    var cont = 0;
    var count_req = $(".UsuarioGrupos select").length;
    if( count_req > 1 ){
        
    //si hay mas de un grupo recien hago la validacion
    $(".UsuarioGrupos select.v").each(function(i,e){
           if($(e).val() == req.value ){
            cont++;
            sistema.msjAdvertencia("Debe escoger un grupo que no haya escogido antes");
            $(req).val("").focus();
            return false;
            }
        });
    }
    
    
    if( cont == 0)
    $(req).addClass("v");
}

CargaGrupos=function(slct,id_slect){
	institucionDAO.cargarGrupos(sistema.llenaSelect,slct,id_slect);
}

BorrarGrupo = function(e){
     $(e).parent().parent().parent().remove();
}

ActualizarGrupo = function(){
     var cont = 0;
    //validar campos
    //que todos los grupos agregados haya seleccionado
    $(".UsuarioGrupos select").each(function(i,e){
           if($(e).val() == "" ){
            cont++;
            sistema.msjAdvertencia("Debe escoger un grupo de la lista antes de actualizar");
            $(e).val("").focus();
            return false;
            }
        });
    //si no han habido errores actualizar datos del usuario
    //Por motivos de cese de usuario total en la institucion , un usuario puede guardarse sin grupo
//    var count_req = $(".UsuarioGrupos select").length;
//    if( count_req == 0 ){
//            cont++;
//            sistema.msjAdvertencia("Debe escoger al menos un grupo para actualizar");
//            $(e).val("").focus();
//            return false;
//    }
    
    
    if(cont == 0){
        institucionDAO.actualizarUsuario();
    }
    
    
    
}

DescartaCambiosGrupo = function(){
    $(".UsuariosCampos").hide();
}


btn_buscarUsuarios = function(){
    
    
    if( $('#slct_filial').val() || $("#cape").val() || $("#came").val() || $("#cnom").val() ){
        institucionDAO.listarUsuarios(listarUsuariosHtml);
        mostrarUsuario();
    }else{
         sistema.msjAdvertencia("Debe usar al menos un filtro.",3000);
         $("#lista_usuarios").html("");
         $(".UsuariosCampos").hide();
    }
    
}

listarUsuariosHtml = function(obj){
    $("#lista_usuarios").html("");
    var htm="";
	$.each(obj,function(index,value){
            var estado = "";
            var accion = accion = "<a class='editar-usuario btn btn-azul sombra-3d t-blanco' ces='4' cfilial='"+value.cfilial+"' cperson='"+value.cperson+"' ><i class='icon-white icon-edit'></i></a>";
            switch(value.estado){
                    case "1":
                     estado = "Activo";
                      break;
                    default:
                      estado = "Inactivo";
                    }
                // actualizar estados

		htm+="<tr id='trg-"+value.cperson  +"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
                htm+="<td width='130' class='t-center'>"+value.paterno+"</td>";
		htm+="<td width='130' class='t-center'>"+value.materno+"</td>";
		htm+="<td width='130' class='t-center'>"+value.nombres+"</td>";
		htm+="<td width='130' class='t-center'>"+value.login+"</td>";
		htm+="<td width='130' class='t-center'>"+value.clave+"</td>";
                
                htm+="<td width='130' class='t-left' style='font-size:11px;'>"+value.grupos+"</td>";
               
                htm+="<td width='130' class='t-center'>"+accion+"</td>";
		htm+="</tr>";
	});
	
     $("#lista_usuarios ").html(htm);
}