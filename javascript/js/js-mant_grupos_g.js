var dias=1;
$(document).ready(function(){
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});	
//	$("#mreportes").addClass("ui-corner-all active");	

	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
//	carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
	
    //LOS CICLOS DEBEN SALIR DE MODULOA RELACIONADO CON CICLOA 
    //carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
    //ahora sera cargado por ListarCiclos()   

    carreraDAO.cargarTurno(sistema.llenaSelect,'slct_turno,#slct_turno_edit','');
	carreraDAO.cargarDias(sistema.llenaSelect,'slct_dia','');
	$("#slct_dia_1").html($("#slct_dia").html())
	$("#slct_filial").change(function(){cargarCarrera("");cargarSemestre("");cargarInicio("");cargarCurricula("");ListarGrupos();});
	$("#slct_instituto").change(function(){cargarCarrera("");cargarSemestre("");cargarInicio("");cargarCurricula("");ListarGrupos();});
//	$("#slct_modalidad").change(function(){cargarCarrera("");cargarCurricula("");});
	$("#slct_semestre").change(function(){cargarInicio("");ListarGrupos();});
	$("#slct_turno").change(function(){cargarHora("");ListarGrupos();});
	$("#slct_turno_edit").change(function(){ carreraDAO.cargarHoraEdit(sistema.llenaSelect,'slct_horario_edit','');  });
	$("#slct_carrera").change(function(){ListarGrupos();});//cargarCurricula("");
	$("#slct_filial,#slct_carrera").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
        //agregando change a los campos para listado
         $("#slct_curricula").change(function(){ListarGrupos();});
         $("#slct_ciclo").change(function(){ListarGrupos();});
         $("#slct_turno").change(function(){ListarGrupos();});
         $("#slct_inicio").change(function(){ListarGrupos();});
         $("#slct_horario").change(function(){ListarGrupos();});
         //para listar ciclos dependientes
         $("#slct_carrera").change(function(){ListarCiclos();});
	//POP UP DE EDICION
   	$('#frmGruposAca').dialog({
  		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
  	});
	
	$("#btnFormGruposAca").click(function(){
		ActualizarGrupo();
	});
        
});

ListarCiclos = function(){
     carreraDAO.cargarCiclosdeModuloaG(sistema.llenaSelect,'slct_ciclo','');
}


cargarHora=function(){
	carreraDAO.cargarHora(sistema.llenaSelect,'slct_horario','');	
}

cargarSemestre=function(marcado){ //tendra "marcado" en select luego cargar	
	carreraDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre',marcado);	
}

cargarInicio=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarInicioG(sistema.llenaSelect,'slct_inicio',marcado);
}

cargarCarrera=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarCarreraG(sistema.llenaSelectGrupo,'slct_carrera',marcado,'Carrera');
}  

cargarCurricula=function(marcado){ //tendra "marcado" en select luego cargar
	carreraDAO.cargarCurricula(sistema.llenaSelect,'slct_curricula',marcado);
}

AgregarDia=function(){
	var html="";
	dias++;
	html+="<tr id='quita_"+dias+"'><td>"+
			  "<select id='slct_dia_"+dias+"' class='input-mediun'>"+			  
			  "</select>"+
			  "</td><td>"+
			  "<span class='formBotones'>"+
				"<a href='javascript:void(0)' onClick='QuitarDia("+'"'+"quita_"+dias+'"'+");' class='btn btn-azul sombra-3d t-blanco'>"+
				"<i class='icon-white icon-remove-sign'></i>"+
				"</a>"+
			  "</span>"+
			  "</td>"+
		  "</tr>";
	$("#td-dias").append(html);
	$("#slct_dia_"+dias).html($("#slct_dia").html())
}

QuitarDia=function(id){
$("#"+id).remove();
}

limpiarSelects=function(){
	/*$("#fechas_semestre").text("");
	$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');
	$("#slct_filial").multiselect("refresh"); // para limpiar un multiselect
	*/
	ListarGrupos();
}

CrearGrupos=function(){
	if($("#slct_filial").val()==''){
	sistema.msjAdvertencia("Seleccionar Filial",200);
	$("#slct_filial").focus();
	}
	else if($("#slct_instituto").val()==''){
	sistema.msjAdvertencia("Seleccionar Instituto",200);
	$("#slct_instituto").focus();
	}
//	else if($("#slct_modalidad").val()==''){
//	sistema.msjAdvertencia("Seleccionar Modalidad",200);
//	$("#slct_modalidad").focus();
//	}
	else if($("#slct_carrera").val()==''){
	sistema.msjAdvertencia("Seleccionar Carrera",200);
	$("#slct_carrera").focus();
	}
	/*else if($("#slct_curricula").val()==''){
	sistema.msjAdvertencia("Seleccionar Curricula",200);
	$("#slct_curricula").focus();
	}*/
	else if($("#slct_semestre").val()==''){
	sistema.msjAdvertencia("Seleccionar Semestre",200);
	$("#slct_semestre").focus();
	}
	else if($("#slct_ciclo").val()==''){
	sistema.msjAdvertencia("Seleccionar Ciclo",200);
	$("#slct_ciclo").focus();
	}
	else if($("#slct_inicio").val()==''){
	sistema.msjAdvertencia("Seleccionar Inicio",200);
	$("#slct_inicio").focus();
	}
	else if($("#slct_turno").val()==''){
	sistema.msjAdvertencia("Seleccionar Turno",200);
	$("#slct_turno").focus();
	}
	else if($("#slct_horario").val()==''){
	sistema.msjAdvertencia("Seleccionar Horario",200);
	$("#slct_horario").focus();
	}
	else if($("#txt_fecha_inicio").val()==''){
	sistema.msjAdvertencia("Ingresar Fecha Inicio",200);
	$("#txt_fecha_inicio").focus();
	}
	else if($("#txt_fecha_final").val()==''){
	sistema.msjAdvertencia("Ingresar Fecha Final",200);
	$("#txt_fecha_final").focus();
	}
	else if($("#txt_meta_mat").val()==''){
	sistema.msjAdvertencia("Ingresar la Meta a matricular",200);
	$("#txt_meta_mat").focus();
	}
	else if($("#txt_meta_min").val()==''){
	sistema.msjAdvertencia("Ingresar la Meta mínima",200);
	$("#txt_meta_min").focus();
	}
	else{
		var error="";
		var dias="";
		dias=$("#td-dias select").map(function(index, element) {
            if(this.value=="" && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Día",200);
			$("#"+this.id).focus();
			}
			else{
			return this.value;
			}
        }).get().join("-");
		
		if(error=="" && dias!=""){
		grupoAcademicoDAO.guardarGruposAcademicosG(dias);
		}
	}
	
}

ListarGrupos = function(){
    $("#lista_grupos").html("");
    if( $('#slct_filial').val() && $('#slct_instituto').val() && $('#slct_carrera').length>0 && $('#slct_semestre').val() ){
        institucionDAO.ListarGruposG(ListarGruposHtml);
    }
    
    getFechasSemetre();
     $(".gru_accion").click(function(){
            institucionDAO.ActualizarGrupo($(this));
        });
	 $(".gru_editar").click(function(){       
	 		abrirEdicionGrupo($(this).attr("gru"))        
	 });
    
}

editarFechas=function(){
    $('#frmGruposAcaFecha').dialog('open');
}

ListarGruposHtml = function(obj){
    $("#lista_grupos").html("");
    var htm="";
	$.each(obj,function(index,value){
            
            var estado = "";
            var accion = "";
            var editar = "";
            var check = "";
            switch(value.cesgrpr){
					case "5":
                      estado = "CANCELADO GENERAL";
                       accion = "<a class='gru_accion btn btn-azul sombra-3d t-blanco' ces='3' gru='"+value.cgracpr+"'><i class='icon-white icon-check'></i></a>";
                      break;
                    case "2":
                      estado = "CANCELADO";
                       accion = "<a class='gru_accion btn btn-azul sombra-3d t-blanco' ces='3' gru='"+value.cgracpr+"'><i class='icon-white icon-check'></i></a>";
                      break;
                    case "3":
                      estado = "EN EJECUCION";
                      check = "<input type='checkbox' class='check' id='"+value.cgracpr+"'>";
					  editar = "<a class='gru_editar btn btn-azul sombra-3d t-blanco' gru='"+value.cgracpr+"'><i class='icon-white icon-edit'></i></a>";
                      accion = "<a class='gru_accion btn btn-azul sombra-3d t-blanco' ces='5' gru='"+value.cgracpr+"'><i class='icon-white icon-remove'></i></a>";
                      break;
                    default:
                      estado = "Sin especificar"
                    }
            
            
            
		htm+="<tr id='trg-"+value.cgracpr  +"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
                htm+="<td width='120' class='t-center'>"+value.filial+"</td>";
		htm+="<td width='184' class='t-center'>"+value.institucion+"</td>";
		htm+="<td width='169' class='t-center'>"+value.curricula+"</td>";
		htm+="<td width='158' class='t-center'>"+value.carrera+"</td>";
		htm+="<td width='120' class='t-center'>"+value.ciclo+"</td>";
		htm+="<td width='118' class='t-center'>"+value.turno+"</td>";
		htm+="<td width='120' class='t-center'>"+value.csemaca+"</td>";
		htm+="<td width='120' class='t-center'>"+value.cinicio+"</td>";
                htm+="<td width='120' class='t-center'>"+value.finicio+"</td>";
		htm+="<td width='118' class='t-center'>"+value.ffin+"</td>";
		htm+="<td width='120' class='t-center'>"+value.hora+"</td>";
		htm+="<td width='120' class='t-center'>"+value.dias+"</td>";
                htm+="<td width='120' class='t-center'>"+value.gestado+"</td>";
                htm+="<td width='120' class='t-center'>"+check+" "+editar + " " + accion+"</td>";
		htm+="</tr>";
	});
	
     $("#lista_grupos ").html(htm);
}

AllCheck=function(){
    if($("#checkall").attr('class')=='todo'){
        $(".check").attr('checked','checked');
        $("#checkall").removeClass('todo').addClass('vacio');
    }
    else{
        $(".check").removeAttr('checked');
        $("#checkall").removeClass('vacio').addClass('todo');
    }
}

/*
 *  consigue las fechas inicio y fin del semestre
 */
getFechasSemetre = function(){
    if( $('#slct_filial').val() && $('#slct_instituto').val() && $('#slct_inicio').val() && $('#slct_semestre').val() ){
         institucionDAO.getFechasSemetre(getFechasSemetreHtml);
    }else{
        $("#fechas_semestre").html("");
    }  
}

getFechasSemetreHtml = function(obj){
     $("#fechas_semestre").html("");
    var htm="";
	var pos=0;
	var fechas_inicio=new Array();
	var fechas_fin=new Array();
    $.each(obj,function(index,value){		
		fechas_inicio[pos]=value.finisem;
		fechas_fin[pos]=value.ffinsem;
		htm+="<div><strong>Semestre Inicio:</strong>       "+value.finisem+"</div>";
		htm+="<div><strong>Semestre Fin:</strong>      "+value.ffinsem+"</div>";
		pos++;
	});
	htm+="<input type=hidden id='fechainiciosemestre' value='"+fechas_inicio.join(',')+"'>"+
		 "<input type=hidden id='fechafinsemestre' value='"+fechas_fin.join(',')+"'>";
    $("#fechas_semestre").html(htm);
}

AgregarSeccion= function(){	
	var abc="A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T";
	var i=$('#n_capacidad').val();	
	var htm="";
	$("#secciones table .btnelimina").css("display","none");
	htm+="<tr id='tr_elimina_"+i+"'>";
	htm+="<td>"+abc.split(",")[i]+"</td>";
	htm+="<td><input type='text' id='txt_capacidad_"+i+"'  value='0' class='input-mini' onkeypress='return sistema.validaNumeros(event)' onKeyUp='validaCapacidadMaxima(this.id);'>";
	htm+="<td>Activo"+
			'<a class="btnelimina btn btn-azul sombra-3d t-blanco" onclick="QuitarSeccion('+i+');" href="javascript:void(0)">'+
				'<i class="icon-white icon-remove-sign"></i>'+
			'</a>'+
		 "</td>";
	htm+="</tr>";
	$("#secciones table").append(htm);
	$('#n_capacidad').val(i*1+1);
}

QuitarSeccion=function(id){
	var i=id-1;
	$("#tr_elimina_"+id).remove();
	$("#tr_elimina_"+i+" .btnelimina").css("display","");
	$('#n_capacidad').val(id);
}

abrirEdicionGrupo = function(cgruaca){   
    //CARGAR DATOS DEL GRUPO
    carreraDAO.GetDatosGrupo(cgruaca,EditarGrupoLLenarDatos);   
    $('#frmGruposAca').dialog('open');
}
EditarGrupoLLenarDatos = function(obj){
    window.console.log(obj);
    $("#cgruaca").val(obj.cgracpr);
    $('#slct_turno_edit').val(obj.cturno);
    carreraDAO.cargarHoraEdit(sistema.llenaSelect,'slct_horario_edit',obj.chora);
    //CARGAR DIAS
    $("#td-dias_edit tr").remove();
    var dias =obj.cfrecue.split("-");
    $.each(dias,function(i,e){
       AgregarDiaEdit(e);
    });
	//META A MATRIC	
	$("#txt_meta_mat_edit").val(obj.nmetmat);
	$("#txt_meta_min_edit").val(obj.nmetmin);console.log(observacion);
	$("#observacion").val(obj.observacion);
    //FECHAS
    $("#txt_fecha_inicio_edit").val(obj.finicio);
    window.console.log(obj.finicio);
    $("#txt_fecha_final_edit").val(obj.ffin);
    $("#txt_secc_mat_edit").val(obj.cantidad);
    var d=obj.detalle_grupo.split("_");
    var htm="<table border=1><tr>"+
	    		"<th class='label'>Seccion</th>"+
	    		"<th class='label'>Capacidad</th>"+
	    		"<th class='label'>Estado</th>"+
	    		"</tr>";

    for(i=0;i<d.length;i++){
    	htm+="<tr>";
    	htm+="<td>"+d[i].split("|")[1]+"</td>";
    	htm+="<td><input type='text' id='txt_capacidad_"+i+"' class='input-mini' value='"+d[i].split("|")[0]+"' onkeypress='return sistema.validaNumeros(event)' onKeyUp='validaCapacidadMaxima(this.id);'></td>";

    	htm+="<td><select id='slct_estado_"+i+"'>";
    			if(d[i].split("|")[2]=='1'){
    	htm+="		<option value='1' selected=selected>Activo</option>";
    	htm+="		<option value='0'>Desactivado</option>";
    			}
    			else{
    	htm+="		<option value='1'>Activo</option>";
    	htm+="		<option value='0' selected=selected>Desactivado</option>";			
    			}    				
    	htm+="	  </select></td>";
    	htm+="</tr>";
    }
    htm+="</table>";
    htm+="<input type='hidden' id='n_capacidad' value='"+d.length+"'>";
    $("#secciones").html(htm);
}

validaCapacidadMaxima=function(id){
	var acu=0;
	for(i=0;i<$("#n_capacidad").val();i++){
		acu+=$("#txt_capacidad_"+i).val()*1;
	}

	if(acu>$("#txt_meta_mat_edit").val()){
		$("#"+id).val('');
		sistema.msjAdvertencia("El total:"+acu+" no puede ser mayor a meta matricula:"+$("#txt_meta_mat_edit").val(),200);
	}
}


AgregarDiaEdit=function(dia){
  var html="";
  dias++;
  html+="<tr id='quita_edit_"+dias+"'><td>"+
        "<select id='slct_dia_edit_"+dias+"' class='input-mediun'>"+        
        "</select>"+
        "</td><td>"+
        "<span class='formBotones'>"+
        "<a href='javascript:void(0)' onClick='QuitarDia("+'"'+"quita_edit_"+dias+'"'+");' class='btn btn-azul sombra-3d t-blanco'>"+
       "<i class='icon-white icon-remove-sign'></i>"+
        "</a>"+
        "</span>"+
        "</td>"+
      "</tr>";
  $("#td-dias_edit").append(html);
  $("#slct_dia_edit_"+dias).html($("#slct_dia").html())
  $("#slct_dia_edit_"+dias).val(dia);
}

ActualizarGrupo=function(){
    
  if($("#slct_turno_edit").val()==''){
  sistema.msjAdvertencia("Seleccionar Turno",200);
  $("#slct_turno_edit").focus();
  }
  else if($("#slct_horario_edit").val()==''){
  sistema.msjAdvertencia("Seleccionar Horario",200);
  $("#slct_horario_edit").focus();
  }
  else if($("#txt_fecha_inicio_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Inicio",200);
  $("#txt_fecha_inicio_edit").focus();
  }
  else if($("#txt_fecha_final_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Fecha Final",200);
  $("#txt_fecha_final_edit").focus();
  }
  else if($("#txt_meta_mat_edit").val()==''){
  sistema.msjAdvertencia("Ingresar Meta a Matricular",200);
  $("#txt_meta_mat_edit").focus();
  }
  else if($("#txt_meta_min_edit").val()==''){
  sistema.msjAdvertencia("Ingresar la Meta mínima",200);
  $("#txt_meta_min_edit").focus(); 
  }
  else{
    var error="";
    var dias="";
  dias=$("#td-dias_edit select").map(function(index, element) {
            if(this.value=="" && error==""){
      error="ok";
      sistema.msjAdvertencia("Seleccionar Día",200);
      $("#"+this.id).focus();
      }
      else{
      return this.value;
      }
        }).get().join("-");

  	var valores="";

  	for(i=0;i<$("#n_capacidad").val();i++){
		if($("#txt_capacidad_"+i).val()==''){
			sistema.msjAdvertencia("Ingresar almenos 0 en caso no tener valor",200);
			$("#txt_capacidad_"+i).focus();
			error="ok";
			break;
		}
		else{
			valores+="|";
			if($("#tr_elimina_"+i+" a").attr("class")){
				valores+="si-"+$("#txt_capacidad_"+i).val()+"-1";
			}
			else{
				valores+="no-"+$("#txt_capacidad_"+i).val()+"-"+$("#slct_estado_"+i).val();	
			}

		}
	}	
    
    if(error=="" && dias!=""){    	
    grupoAcademicoDAO.ActualizarGrupoAcademico(dias,valores);
    }
  }
  
}
