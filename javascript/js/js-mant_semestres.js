$(document).ready(function(){
	Datepicker();
	
//	$("#mreportes").addClass("ui-corner-all active");	

	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
	institucionDAO.cargarFilialValida(sistema.llenaSelect,'slct_filial_edit','');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto_edit','');
	
	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
	$("#slct_filial").change(function(){validaSemestre();listarSemestres()});
	$("#slct_instituto").change(function(){validaSemestre();listarSemestres()});
	$("#slct_modalidad").change(function(){validaSemestre();listarSemestres()});
	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	$("#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	$('#frmSemestre').dialog({
  		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
  	});
});

Datepicker=function(){
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
}

validaSemestre=function(){
	var htm="";
	$("#valSemestres .ListaSemestre").remove();
		
		$("#txt_ano_1").val("");
		$("#txt_sem_1").val("");
		$("#txt_ini_1").val("");
		$("#txt_fecha_isem_1").val("");
		$("#txt_fecha_fsem_1").val("");
		$("#txt_fecha_imat_1").val("");
		$("#txt_fecha_fmat_1").val("");
		
	if(	$.trim($("#slct_filial")) && $.trim($("#slct_instituto").val()) ){
		//se muestran las tablas
		$("#valSemestres").css("display",'');	
		$("#OperacionSemestres").css("display",'');
		//Agrega primer registro para ingresar datos
		htm+="<tr id='trinicial' class='ListaSemestre ui-widget-content jqgrow ui-row-ltr'>";
		htm+="<td class='t-left'><input type='text' id='txt_ano_1' style='width:50px' maxlength='4' onKeyPress='return sistema.validaNumeros(event)'/>";
		htm+="<input type='text' id='txt_sem_1' style='width:20px' maxlength='1' onKeyPress='return sistema.validaNumeros(event)'/></td>";
		htm+="<td class='t-left'><input type='text' id='txt_ini_1' maxlength='1' onKeyPress='return sistema.validaLetras(event)' style='width:20px'/></td>";
		htm+="<td class='t-left'><input type='text' id='txt_fecha_isem_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_isem_1"+'","'+"txt_fecha_fsem_1"+'"'+");' style='width:65px'></td>";
		htm+="<td class='t-left'><input type='text' id='txt_fecha_fsem_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_isem_1"+'","'+"txt_fecha_fsem_1"+'"'+");' style='width:65px'></td>";
		htm+="<td class='t-left'><input type='text' id='txt_fecha_imat_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_imat_1"+'","'+"txt_fecha_fmat_1"+'"'+");' style='width:65px'></td>";
		htm+="<td class='t-left'><input type='text' id='txt_fecha_fmat_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_imat_1"+'","'+"txt_fecha_fmat_1"+'"'+");' style='width:65px'></td>";		
		htm+="<td class='t-left'><input type='text' id='txt_fecha_fgra_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_fmat_1"+'","'+"txt_fecha_fgra_1"+'"'+");' style='width:65px'></td>";		
		htm+="<td class='t-left'><input type='text' id='txt_fecha_fext_1' onChange='sistema.validaFecha("+'"'+"txt_fecha_fgra_1"+'","'+"txt_fecha_fext_1"+'"'+");' style='width:65px'></td>";		
		htm+="<td class='t-left'><span class='formBotones' style=''>"+
			"<a class='btn btn-azul sombra-3d t-blanco' onclick='"+"$("+'"'+"#trinicial"+'"'+").remove()"+"' href='javascript:void(0)'>"+
			"<i class='icon-white icon-remove'></i>"+			
			"</a>"+
			"</span></td>";
		htm+="</tr>";
		$("#valSemestres").append(htm);
		Datepicker();
		
	}else{
		// se oculta y elimina todo
		$("#valSemestres").css("display",'none');
		$("#OperacionSemestres").css("display",'none');
	}
}

limpiarSelects=function(){
//	institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');
//	institucionDAO.cargarInstitucion(sistema.llenaSelect,'slct_instituto','','Instituto');
//	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
//	validaSemestre();
validaSemestre();
listarSemestres();
}

AgregarSemestre=function(){
	var tot=0;
	var htm="";	
	tot = $("#txt_cant_sem").val()*1 + 1;
	$("#txt_cant_sem").val(tot);
	
	htm+="<tr id='trel"+tot+"' class='ListaSemestre ui-widget-content jqgrow ui-row-ltr'>";
	htm+="<td class='t-left'><input type='text' id='txt_ano_"+tot+"' style='width:50px' maxlength='4' onKeyPress='return sistema.validaNumeros(event)'>";
	htm+="<input type='text' id='txt_sem_"+tot+"' style='width:20px' maxlength='1' onKeyPress='return sistema.validaNumeros(event)'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_ini_"+tot+"' maxlength='1' onKeyPress='return sistema.validaLetras(event)' style='width:20px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_isem_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_isem_"+tot+'","'+"txt_fecha_fsem_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_fsem_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_isem_"+tot+'","'+"txt_fecha_fsem_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_imat_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_imat_"+tot+'","'+"txt_fecha_fmat_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_fmat_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_imat_"+tot+'","'+"txt_fecha_fmat_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_fgra_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_fmat_"+tot+'","'+"txt_fecha_fgra_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><input type='text' id='txt_fecha_fext_"+tot+"' onChange='sistema.validaFecha("+'"'+"txt_fecha_fgra_"+tot+'","'+"txt_fecha_fext_"+tot+'"'+");' style='width:65px'></td>";
	htm+="<td class='t-left'><span class='formBotones' style=''>"+
			"<a class='btn btn-azul sombra-3d t-blanco' onclick='"+"$("+'"'+"#trel"+tot+'"'+").remove();' href='javascript:void(0)'>"+
			"<i class='icon-white icon-remove'></i>"+			
			"</a>"+
			"</span></td>";
	htm+="</tr>";
	
	$("#valSemestres").append(htm);
	Datepicker();
}

GuardarCambiosSem=function(){
	var error="";
	var codigo="";
	var contador=0;
	var	datoscjto;
	datoscjto=$("#valSemestres input[id^='txt_ano_']").map(function(index,data){
		contador = contador + 1;
			codigo = this.id.split('_')[2];
			if(error==""){
				if($.trim($("#txt_ano_"+codigo).val())==""){
					sistema.msjAdvertencia("Los campos de Semestre del registro " + contador + " no pueden ser vacios.");
					$("#txt_ano_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_sem_"+codigo).val())==""){
					sistema.msjAdvertencia("Los campos de Semestre del registro " + contador + " no pueden ser vacios.");
					$("#txt_sem_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_ini_"+codigo).val())==""){
					sistema.msjAdvertencia("Los campos de Semestre del registro " + contador + " no pueden ser vacios.");
					$("#txt_ini_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_isem_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha de Inicio de Semestre para el registro " + contador + ".");
					$("#txt_fecha_isem_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_fsem_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha de Fin de Semestre para el registro " + contador + ".");
					$("#txt_fecha_fsem_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_imat_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha de Inicio de Matricula para el registro " + contador + ".");
					$("#txt_fecha_imat_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_fmat_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha de Fin de Matricula para el registro " + contador + ".");
					$("#txt_fecha_fmat_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_fgra_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha de Gracia para el registro " + contador + ".");
					$("#txt_fecha_fgra_"+codigo).focus();
					error="ok";
				}else if($.trim($("#txt_fecha_fext_"+codigo).val())==""){
					sistema.msjAdvertencia("Debe seleccionar una fecha Extemporanea para el registro " + contador + ".");
					$("#txt_fecha_fext_"+codigo).focus();
					error="ok";
				}else{
					return  $.trim($("#txt_ano_"+codigo).val()) + "-" + $.trim($("#txt_sem_"+codigo).val()) + "|" +
							$.trim($("#txt_ini_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_isem_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_fsem_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_imat_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_fmat_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_fgra_"+codigo).val()) + "|" +
							$.trim($("#txt_fecha_fext_"+codigo).val());
				}
			}
			
	}).get().join("^");
	if(datoscjto==""){
	sistema.msjAdvertencia("Debe ingresar mínimo un semestre");
	}
	if(error=="" && datoscjto!=""){
		carreraDAO.GuardarCambiosSemestre(datoscjto);
	}
}

listarSemestres = function(){
    
    if( $('#slct_filial').val() && $('#slct_instituto').val() ){
        carreraDAO.listarSemestres(listarSemestreHtml);
    }else{
         $("#lista_grupos").html("");
    }
    
   		$(".sem_accion").click(function(){            
            carreraDAO.ActualizarSemestre($(this));
        });
		$(".sem_editar").click(function(){            
            abrirEdicionSemestre($(this).attr("sem"));
        });
    
}

abrirEdicionSemestre = function(csemaca){   
    //CARGAR DATOS DEL GRUPO
    carreraDAO.GetDatosSemestre(csemaca,EditarSemestreLLenarDatos);   
    $('#frmSemestre').dialog('open');
}
EditarSemestreLLenarDatos = function(obj){
    window.console.log(obj);
    $("#csemaca").val(obj.csemaca+'|'+obj.cfilial+'|'+obj.cinstit+'|'+obj.cinicio+'|'+obj.finisem);
    $("#slct_filial_edit").val(obj.cfilial);
	$("#slct_instituto_edit").val(obj.cinstit);
	$("#txt_inicio_edit").val(obj.cinicio);
	$("#txt_semestre1_edit").val(obj.csemaca.split("-")[0]);
	$("#txt_semestre2_edit").val(obj.csemaca.split("-")[1]);
    $("#txt_fecha_inicio_sem_edit").val(obj.finisem);
    window.console.log(obj.finisem);
	$("#txt_fecha_inicio_mat_edit").val(obj.finimat);
    $("#txt_fecha_final_sem_edit").val(obj.ffinsem);
	$("#txt_fecha_final_mat_edit").val(obj.ffinmat);    
	$("#txt_fecha_gra_edit").val(obj.fechgra);    
	$("#txt_fecha_ext_edit").val(obj.fechext);    
}

listarSemestreHtml = function(obj){
    $("#lista_grupos").html("");
    var htm="";
	$.each(obj,function(index,value){
            var estado = "";
            var accion = "";
			var editar = "";
            switch(value.estado){
                    case "1":
                     estado = "Programado";
					 editar = "<a class='sem_editar btn btn-azul sombra-3d t-blanco' ces='4' sem='"+value.csemaca+"|"+value.cfilial+"|"+value.cinstit+"|"+value.inicio+"|"+value.fisem+"'><i class='icon-white icon-edit'></i></a>";
                      accion = "<a class='sem_accion btn btn-azul sombra-3d t-blanco' ces='4' cfilial='"+value.cfilial+"' cinstit='"+value.cinstit+"' semestre='"+value.semestre+"' cinicio='"+value.inicio+"' finisem='"+value.fisem+"'><i class='icon-white icon-remove'></i></a>";
                      break;
                    case "2":
                      estado = "Ejecutandose";
                       accion = "--";
                      break;
                    case "3":
                      estado = "Finalizado";
                       accion = "--";
                      break;
                     case "4":
                      estado = "Anulado";
                       accion = "<a class='sem_accion btn btn-azul sombra-3d t-blanco' ces='1'  cfilial='"+value.cfilial+"' cinstit='"+value.cinstit+"' semestre='"+value.semestre+"' cinicio='"+value.inicio+"' finisem='"+value.fisem+"'><i class='icon-white icon-check'></i></a>";
                      break;
                    default:
                      estado = "Sin especificar"
                    }
                // actualizar estados
                
                
                
                
		htm+="<tr id='trg-"+value.semestre  +"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
                htm+="<td width='120' class='t-center'>"+value.filial+"</td>";
		htm+="<td width='184' class='t-center'>"+value.institucion+"</td>";
		htm+="<td width='169' class='t-center'>"+value.semestre+"</td>";
		htm+="<td width='158' class='t-center'>"+value.inicio+"</td>";
		htm+="<td width='120' class='t-center'>"+value.fisem+"</td>";
		htm+="<td width='118' class='t-center'>"+value.ffsem+"</td>";
		htm+="<td width='120' class='t-center'>"+value.fimat+"</td>";
		htm+="<td width='120' class='t-center'>"+value.ffmat+"</td>";
		htm+="<td width='120' class='t-center'>"+value.fegra+"</td>";
		htm+="<td width='120' class='t-center'>"+value.feext+"</td>";
                htm+="<td width='145' class='t-center'>"+estado.toUpperCase()+"</td>";
                htm+="<td width='145' class='t-center'>"+editar+accion+"</td>";
		htm+="</tr>";
	});
	
     $("#lista_grupos ").html(htm);
}

Actualizar=function(){
    
  if($("#slct_filial_edit").val()==''){
  sistema.msjAdvertencia("Seleccionar Filial",200);
  $("#slct_filial_edit").focus();
  }
  else if($("#slct_instituto_edit").val()==''){
  sistema.msjAdvertencia("Seleccionar Instituto",200);
  $("#slct_instituto_edit").focus();
  }
  else if($("#txt_semestre1_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Año Semestre",200);
  $("#txt_semestre1_edit").focus();
  }
  else if($("#txt_semestre2_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Nivel Semestre",200);
  $("#txt_semestre2_edit").focus();
  }
  else if($("#txt_inicio_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Inicio",200);
  $("#txt_inicio_edit").focus();
  }
  else if($("#txt_fecha_inicio_sem_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Inicio Semestre",200);
  $("#txt_fecha_inicio_sem_edit").focus();
  }
  else if($("#txt_fecha_final_sem_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Final Semestre",200);
  $("#txt_fecha_final_sem_edit").focus();
  }
  else if($("#txt_fecha_inicio_mat_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Inicio Matricula",200);
  $("#txt_fecha_inicio_mat_edit").focus();
  }
  else if($("#txt_fecha_final_mat_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Final Matricula",200);
  $("#txt_fecha_final_mat_edit").focus();
  }
   else if($("#txt_fecha_gra_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha de Gracia",200);
  $("#txt_fecha_gra_edit").focus();
  }
   else if($("#txt_fecha_ext_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Extemporanea",200);
  $("#txt_fecha_ext_edit").focus();
  }
  else{    
    carreraDAO.ModificarSemestre();
  }  
}
