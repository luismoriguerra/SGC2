$(document).ready(function(){
	//curricula == plan_curricular + curricula
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
        
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
        
	$("#slct_instituto").change(function(){cargaCarrera();cargaCurricula();});
	
	$("#slct_carrera").change(function(){cargaCurricula();});
        
        $("#slct_curricula").change(function(){cargaModulo();ValidaPlancurricular(); });
        
//        jQGridPlancurricular.Plancurricular($("#slct_curricula").val() , $("#slct_modulo").val());
        $("#slct_modulo").change(function(){ ValidaPlancurricular();  });
         
        
})

cargaCarrera=function(){
	if($.trim($("#slct_instituto").val())=="" ){
            sistema.limpiaSelect('slct_carrera');
        }else{ 
            carreraDAO.cargarCarreraM(sistema.llenaSelect,'slct_carrera','');	}
	
}

cargaCurricula=function(){
	if($.trim($("#slct_instituto").val())=="" || $.trim($("#slct_carrera").val())==""){		
            sistema.limpiaSelect('slct_curricula');	}
	else{
            $("#btn_nuevaCurricula").show();
            carreraDAO.cargarCurricula(sistema.llenaSelect,'slct_curricula','');
        }
}


cargaModulo=function(){
	if($.trim($("#slct_instituto").val())==""  || $.trim($("#slct_carrera").val())=="" || $.trim($("#slct_curricula").val())=="")
	{		sistema.limpiaSelect('slct_modulo');	}
	else{	carreraDAO.cargarModulo(sistema.llenaSelect,'slct_modulo','');	}
//	ValidaModulo();
}


ValidaPlancurricular=function(){
  var error="";
  if($.trim($("#slct_modulo").val())=="" ){
		$('#valPlancurricularTot').css("display",'none');
		$('#OperacionModulos').css("display",'none');
                $('#btn_cancelar').css("display",'none');
                
                $("#btn_NuevoModulo").css("display",'none');
  		error="ok";
  }else{
      	 $('#btn_cancelar').css("display",'');
         $('#btn_NuevoModulo').css("display",'');
        $('#valPlancurricularTot').css("display",'');
      	$('#OperacionModulos').css("display",'');
	curriculaDAO.cargarPlancurricular(ListarPlancurricular);
  }
	 $(".PlanCurCampos").css("display",'none');
         $("#btn_nuevaCurricula").css("display",'');
}



AgregarModulo=function(){
	$("#btn_NuevoModulo").css("display",'none');
	$("#btn_GuardaNuevo").css("display",'');
	var htm="";
	
	htm+="<tr class='ListaCursos ui-widget-content jqgrow ui-row-ltr'>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'><input type='text' id='txt_des_nuevo' value='' class='input-xxlarge' onKeyPress='return sistema.validaAlfanumerico(event)'/></td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="<td class='t-left'>&nbsp;</td>";
	htm+="</tr>";
	
	$("#valModulos").append(htm);
}

DescartaCambiosCurso=function(){
        $("#btn_Actualizar").css("display",'none');
	$("#btn_GuardaNuevo").css("display",'none');
	$("#btn_NuevoModulo").css("display",'');
        $("#btn_AgregarReq").css("display",'none');
        $(".PlanCurRequerimientos tr").remove();
	ValidaPlancurricular();
}

GuardarNuevoModulo=function(){
	if($.trim($("#txt_des_nuevo").val())==""){
		sistema.msjAdvertencia("El campo Descripcion NO puede ser vacio.");
		$("#txt_des_nuevo").focus();
		error="ok";
	}else{
		carreraDAO.GuardarModulo();
		$("#btn_GuardaNuevo").css("display",'none');
		$("#btn_NuevoModulo").css("display",'');
	}
}

SubirOrden=function(codigo){   
	carreraDAO.actualizaNroMmod(codigo);
}


ActuaDesc=function(codigo,req,nrocre,estado,teoria,practica){
    $(".PlanCurRequerimientos tr").remove();
    CargaCursos('slct_curso',codigo);
    $('#slct_curso').attr("disabled","disabled");
    
    $('#txt_nro_creditos').val(nrocre);
    $('#txt_nro_teo').val(teoria);
    $('#txt_nro_pra').val(practica);
    
    if(estado == 1){
         $('#slct_estado').val(1);
    }else{
         $('#slct_estado').val(0);
    }
   
   //cargando datos de cursos de requerimientos
   var regs = req.split("|");
   CargarReq(regs);
   
    $("#btn_GuardaNuevo").css("display",'none');
    $("#btn_NuevoModulo").css("display",'none');
    $("#btn_Actualizar").css("display",'');
    
    $(".PlanCurCampos").css("display",'');
    $("#btn_AgregarReq").css("display",'');
//carreraDAO.mostrarEdicion(codigo);
}

CargaCursos=function(slct,id_slect){
	cursoDAO.cargarCursos(sistema.llenaSelect,slct,id_slect);
}

ListarPlancurricular = function(obj){
    
        var htm="";
	var total=0;
	var comilla='"';
	$("#valPlancurricular .ListaCursos").remove();
        
        $.each(obj,function(index,value){
            var label_estado = "";
              if( value.estado == 1){
                   label_estado = "Activo";
              }else{
                   label_estado = "Inactivo";
              }
            
		htm+="<tr class='ListaCursos ui-widget-content jqgrow ui-row-ltr' id='"+value.curso+"'>";
		htm+="<td class='t-left'>&nbsp;</td>";
		htm+="<td class='t-left'>"+$.trim(value.codicur)+"</td>";
		htm+="<td class='t-left'>"+value.nombre+"</td>";
                
                htm+="<td class='t-left'>"+value.ncredit+"</td>";
                htm+="<td class='t-left'>"+value.nhotecu+"</td>";
                htm+="<td class='t-left'>"+value.nhoprcu+"</td>";
		 htm+="<td class='t-left'>"+$.trim(value.reqs)+"</td>";
		htm+="<td class='t-left'>"+label_estado+"</td>";
		
		htm+=" <td class='t-left'>";
		htm+="		<span class='formBotones' id='btn_Act_"+value.ccur+"-"+value.cmod+"-"+value.curso+"'>";
		htm+="      <a href='javascript:void(0)' onClick='ActuaDesc("+comilla+value.curso+comilla+","+comilla+value.req+comilla+","+comilla+value.creditos+comilla+","+comilla+value.estado+comilla+","+comilla+value.hteoria+comilla+","+comilla+value.hpractica+comilla+");' class='btn btn-azul sombra-3d t-blanco'>";
		htm+="      <i class='icon-white icon-refresh'></i>";
		htm+="      <span></span>";
		htm+="      </a>";
		htm+="      </span>";
		htm+="</td>";
		htm+="</tr>";
	})
	$("#valPlancurricular").append(htm);
        
        
        
}

ActualizarCurso=function(){
		curriculaDAO.ActualizarPlancurricular();
		$("#btn_GuardaNuevo").css("display",'none');
                $("#btn_Actualizar").css("display",'none');
		$("#btn_NuevoModulo").css("display",'');
                 $("#btn_AgregarReq").css("display",'none');
                 $(".PlanCurRequerimientos tr").remove();
          //       ValidaPlancurricular();       
}

//muestra los campos para insertar un nuevo curso al plan
AgregarCurso = function(){
    
    CargaCursos('slct_curso','');
    $('#slct_curso').removeAttr("disabled");
    
    CargaCursos('slct_curso_req',''); 
    
    $('#txt_nro_creditos').val(0);
     $('#txt_nro_teo').val(0);
      $('#txt_nro_pra').val(0);
    $('#slct_estado').val(1);
    
    
    
    
     $(".PlanCurCampos").css("display",'');
     
     $("#btn_NuevoModulo").css("display",'none');
     $("#btn_Actualizar").css("display",'none');
     $("#btn_GuardaNuevo").css("display",'');
     $("#btn_AgregarReq").css("display",'');
}

//manda los datos a la base de datos.
GuardarNuevoCurso=function(){
    
    
        if( $("#slct_curso").val() == ""){
            sistema.msjAdvertencia("El campo curso NO puede ser vacio.");
            $("#slct_curso").focus();
        }else{
            var cont = 0;
            jQuery('#slct_req\\[\\]').each(function(i,e){
                if(e.value == ""){
                    sistema.msjAdvertencia("El campo requisito NO puede ser vacio.");
                    $(e).focus();
                   cont++;
                }
            });
            if(cont == 0){
                    curriculaDAO.GuardarPlancurricular();
                    $("#btn_GuardaNuevo").css("display",'none');
                    $("#btn_Actualizar").css("display",'none');
                    $("#btn_NuevoModulo").css("display",'');
                    $(".PlanCurRequerimientos tr").remove();
            }
        }    
}


AgregarCurricula = function(){
    
    $("#txt_nc_titulo").val("");
    $("#txt_nro_resolu").val("");
    $("#btn_nuevaCurricula").hide();
    $(".nuevaCurricula.campos").show("slow");
    
}

ActualizarCurricula = function(){
     if($("#slct_curricula").val() == ""  ){
        sistema.msjAdvertencia("Debe seleccionar una curricula.");
	$("#slct_curricula").focus();
        return false;
    }else{
        
        
        
        $(".nuevaCurricula.campos").show("slow");
    }
}

validarCurricula = function(){
    
    if($("#slct_carrera").val() == ""  ){
        sistema.msjAdvertencia("Debe seleccionar una carrera.");
	$("#slct_carrera").focus();
        return false;
    }
    
    
    if($("#txt_nc_titulo").val() == ""  ){
        sistema.msjAdvertencia("Debe escribir un titulo.");
	$("#txt_nc_titulo").focus();
        return false;
    }
    
    if($("#txt_nro_resolu").val() == ""  ){
        sistema.msjAdvertencia("Debe escribir una resolucion.");
	$("#txt_nro_resolu").focus();
        return false;
    }
    
    
    return true;
}

GuardarCurricula = function(){
    
   if(  validarCurricula() == true ){
       
       //guardar
       curriculaDAO.GuardarCurricular();
       
       //esconder opcines 
       $("#btn_nuevaCurricula").show();
       $(".nuevaCurricula.campos").hide("fast");
       $("#valPlancurricularTot").hide();
       //volver a cargar curricula
       carreraDAO.cargarCurricula(sistema.llenaSelect,'slct_curricula','');

   }
}

DescartarCurricula = function(){
    
    $("#btn_nuevaCurricula").show();
    $(".nuevaCurricula.campos").hide("fast");
}


//Funciones para manipulacion de requerimientos.
AgregarReq = function( req_id ){
var html  ="<tr><td class='t-left label'>Requisito:</td><td colspan='5' class='t-left'>";
    html +="<select id='slct_req' class='input-xlarge' onchange='validarCurReq(this)'>";
    html +="<option value=''>--Selecione--</option>";
    html +="</select></td>";
    html +="<td class='BorrarReq'>";
    html +="<span class='formBotones' id='btn_BorrarReq'>";
    html +="<a href='javascript:void(0)' onClick='BorrarReq($(this));' class='btn btn-azul sombra-3d t-blanco'>";
    html +="<i class='icon-white icon-minus'></i>";
    html +="<span></span>";
    html +="</a></span>";
    html +="</td></tr>";
    
    $(".PlanCurRequerimientos").append(html);
    if(req_id == "")
    CargaCursos('slct_req','');
    else
        CargaCursos('slct_req',req_id );
    $('#slct_req').attr("id","slct_req[]")
}

EditarReq = function(){
  
}

BorrarReq = function(e){
     $(e).parent().parent().parent().remove();
}

CargarReq = function (regs) {
    $.each(regs,function(i,e){
       if( e != ""){
           AgregarReq( e );
       } 
    });
}

validarCurReq = function(req){
    $(req).removeClass("v");
    var cont = 0;
    $("#valPlancurricular tr.ListaCursos").each(function(i,e){
        if($(e).attr("id") == req.value ){
            cont++;
            sistema.msjAdvertencia("Debe escoger un curso que no pertenesca al plan curricular");
            $(req).val("").focus();
            return false;
        }
    });
    
    var count_req = $(".PlanCurRequerimientos select").length;
    if( count_req > 1 ){
        
    //si hay mas de un curso requerido recien hago la validacion
    $(".PlanCurRequerimientos select.v").each(function(i,e){
           if($(e).val() == req.value ){
            cont++;
            sistema.msjAdvertencia("Debe escoger un curso que no haya escogido como requsito");
            $(req).val("").focus();
            return false;
            }
        });
    }
    
    //Validando con el curso princiapl
    if($("#slct_curso").val() == req.value){
            cont++;
            sistema.msjAdvertencia("Debe escoger un requisito diferente al curso que deseas agregar.");
            $(req).val("").focus();
            return false;
    }
    
    
    if( cont == 0)
    $(req).addClass("v");
}