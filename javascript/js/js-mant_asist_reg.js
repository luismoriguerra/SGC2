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
	$("#slct_carrera").change(function(){cargarCurricula("");ListarGrupos();});
	$("#slct_filial").multiselect({
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
        
        //EXPORTACION FORMATO
        $("#btnExportarFormato").click(function(){
            ExportarAsistFormato();
        });
        
         //EXPORTACION reporte
        $("#btnExportarReporte").click(function(){
            ExportarAsistencia();
        });
        
        
        
});

ListarCiclos = function(){
     carreraDAO.cargarCiclosdeModuloa(sistema.llenaSelect,'slct_ciclo','');
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
	carreraDAO.cargarCarreraG(sistema.llenaSelect,'slct_carrera',marcado);
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
	else if($("#slct_curricula").val()==''){
	sistema.msjAdvertencia("Seleccionar Curricula",200);
	$("#slct_curricula").focus();
	}
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
		grupoAcademicoDAO.guardarGruposAcademicos(dias);
		}
	}
	
}

ListarGrupos = function(){
    $("#lista_grupos").html("");
    if( $('#slct_filial').val() && $('#slct_instituto').val() && $('#slct_carrera').val() && $('#slct_semestre').val() ){
        institucionDAO.ListarGrupos(ListarGruposHtml);
    }
    
    getFechasSemetre();
     $(".gru_accion").click(function(){
            institucionDAO.ActualizarGrupo($(this));
        });
	 $(".gru_editar").click(function(){       
	 		abrirEdicionGrupo($(this).attr("gru"))        
	 });
    
}

ListarGruposHtml = function(obj){
    $("#lista_grupos").html("");
    var htm="";
	$.each(obj,function(index,value){

            // VARIABLES PARA LISTAR ALUMNOS
            var listarAlumnos = "<a class='alu_listar btn btn-azul sombra-3d t-blanco' gru='"+value.cgracpr+"'><i class='icon-white  icon-list'></i></a>";
            var aluAsistencia ="<a class='alu_asist btn btn-azul sombra-3d t-blanco' gru='"+value.cgracpr+"'><i class='icon-white  icon-eye-open'></i></a>";
            listarAlumnos='';
            
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
                htm+="<td width='120' class='t-center'>"+listarAlumnos + " " + aluAsistencia+"</td>";
		htm+="</tr>";
	});
	
     $("#lista_grupos ").html(htm);
     $("a.alu_listar").click(function(){
         $("#wrap_iu_asist").hide();
         $("#alu_listado").show();
         var cgrupo = $(this).attr("gru");
          asistenciaDAO.cargarAlumnos(listarAlumnosFilas,cgrupo);
         
     });
     
     //ABRIR INTERFAZ DE ASISTENCIA
     $("a.alu_asist").click(function(){
         window.console.log("inicio registro de asistencia");
          $("#alu_listado").hide();
         $("#wrap_iu_asist").show();
         $("#iu_select_sec").val("A");
         var cgrupo = $(this).attr("gru");
        
         mostrarListadoCheck(cgrupo, "A");
         
         //CAMBIAR DE SECCION
         $("#iu_select_sec").change(function(){
            mostrarListadoCheck(cgrupo, $(this).val() ); 
         });
         
     });
     
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
    $.each(obj,function(index,value){
		htm+="<div><strong>Semestre Inicio:</strong>       "+value.finisem+"</div>";
		htm+="<div><strong>Semestre Fin:</strong>      "+value.ffinsem+"</div>";
	});
    $("#fechas_semestre").html(htm);
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
    //FECHAS
    $("#txt_fecha_inicio_edit").val(obj.finicio);
    window.console.log(obj.finicio);
    $("#txt_fecha_final_edit").val(obj.ffin);
    
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
  }else{
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
    
    if(error=="" && dias!=""){
    grupoAcademicoDAO.ActualizarGrupoAcademico(dias);
    }
  }
  
}

listarAlumnosFilas = function(obj){
    
    var html = "";
    var sec= "";
     $("table.listado_alumnos tr.alu").remove();
    
    $.each(obj,function(i,e){
        var cont = i+1;
        
        if(!e.seccion){
         sec = "--"; 
        }else{
         sec = e.seccion;
        }
        var edit_link = "<a href='#opt-"+i+"' name='opt-"+i+"' class='edit_sec' gru='"+ e.cgruaca +"' cing='"+ e.cingalu +"' cper='"+ e.cperson +"' sec='"+ e.seccion +"'>"+ sec +"</a>";
        
        html +="<tr class='alu'>";
        html +="<td>"+ cont +"</td><td>"+ e.nombres +"</td>";
        html +="<td>"+ edit_link +"</td>";
        html +="</tr>";
    });
     
     
     $("table.listado_alumnos ").append(html);
     $(".edit_sec").click(function(){      editarSeccion($(this));     });
     
}//fin function listarAlumnosFilas

editarSeccion  = function(obj){
  
    var grupo =  $(obj).attr("gru");
    var cper =  $(obj).attr("cper");
    var cing =  $(obj).attr("cing");
    var sec = $(obj).attr("sec");
    var datag = cper+"-" + cing +"-" + grupo;
    var select = "<select id='alu_edit_sec'>\n\\n\
                    <option value=''>--</option>\n\
                    <option value='A-"+ datag+"'>A</option>\n\
                    <option value='B-"+ datag+"'>B</option>\n\
                    <option value='C-"+ datag+"'>C</option>\n\
                    <option value='D-"+ datag+"'>D</option>\n\
                 </select>";
    var cerrar = '<a id="remove_alu_edit_sec" class=\'btn btn-azul sombra-3d t-blanco\' ><i class=\'icon-white  icon-remove\'></i></a>';
    
    $(obj).parent().html(select+cerrar);
    $("#alu_edit_sec").val(sec+"-"+datag);
    
    $("#alu_edit_sec").change(function(){
        
        //ACTUALIZAR SECCION GRUPO ALUMNO
        asistenciaDAO.actualizarSeccionGrupo($(this).val());
        
        //ACTUALIZAR LISTA
        asistenciaDAO.cargarAlumnos(listarAlumnosFilas,grupo);
    });
    
    $("#remove_alu_edit_sec").click(function(){
        asistenciaDAO.cargarAlumnos(listarAlumnosFilas,grupo);
    });
    
}

mostrarListadoCheck = function(grupo,seccion){
    window.console.log("mostrarlistadocheck");
    sistema.abreCargando();
    asistenciaDAO.mostrarListadoCheck(mostrarListadoCheckHtml,grupo,seccion);
    
    
}

mostrarListadoCheckHtml = function(obj,cgrupo){
     //window.console.log(obj);
    $("#chgrupo").val(cgrupo);
    //VALIDAR RANGO DE FECHAS DEL GRUPO
    var data = rangoFechasGrupo(cgrupo);
    //window.console.log(data);
    
    //CABECERA DE LA TABLA
    var cabecera = "";
    
    //RANGO DE FECHAS
    $.each(data.fechas,function(i,e){
        cabecera +="<th class='th-row'>"+ e + "<br>"+ (i+1) +"</th>";
    });
    $(".th-row").remove();
    $("table .iu_asis_cab").append(cabecera)
    
    //CUERPO DE LA TABLA
    var cuerpo = '';
    var chk = '';
    $.each(obj,function(i,e){
       
        cuerpo +="<tr class='iu_row'>";
        cuerpo +="<td>"+ (i+1)+"</td><td class='text-left'>"+ e.nombres +"</td>";
        cuerpo +="<td class='text-left'>"+ e.telefono +"</td>"; //TELEFONO
        
        
        //FECHAS REGISTRADAS
        //Fechas registradas de los usuarios
        var codseing =e.id;
        for(var i=0;i < data.registrados; i++){
            var fasist  = data.fechas[i];
            var flatasist = asistenciaAlumno(codseing,fasist);
            
            //validar fechas registradas dentro del rango de fechas permitido para validar
            // hoy , ayer y anteayer
            if( fasist == data.ayer || fasist == data.anteayer  ){
                
                if(flatasist == 1){
                    checked = "checked";
                    flat_hoy_value = 0;}
                else{ 
                    checked = ""; 
                    flat_hoy_value = 1;
                }
                
                
                 chk = '<input class="iu_chk" type="checkbox" idse="'+ codseing +'" f="'+ fasist +'" value="'+flat_hoy_value+'" '+ checked +'>';   
                 cuerpo +="<td>"+ chk +"</td>";
                 
                 
            }else if(flatasist == 1){
                cuerpo +="<td>"+ 1 +"</td>";
            }else{
                cuerpo +="<td>"+ 0 +"</td>";
            }//fin if
            
            
        }//fin for
      
        //FECHA A REGISTRAR
        if(data.registrar == 1){
            var checked = ''
            var flat_hoy = asistenciaAlumno(codseing,data.fhoy);
            var flat_hoy_value = 1;
            if(flat_hoy == 1){
                 checked = "checked";
                 flat_hoy_value = 0;
            }
            
         chk = '<input class="iu_chk" type="checkbox" idse="'+ e.id +'" f="'+ data.fhoy +'" value="'+flat_hoy_value+'" '+ checked +'>';   
         cuerpo +="<td>"+ chk +"</td>";
        }
        
        
        cuerpo +="</tr>";
    });
    
    $("table tr.iu_row").remove();
    $("table.iu_asist ").append(cuerpo);
    $(".iu_chk").click(function(){
         var chk = $(this);
         //window.console.log(chk.val());
         var idse = chk.attr("idse");
         var estasist = chk.val();
         var fecha = chk.attr("f");
         window.console.log("se registrara asistencia del dia "+fecha);
         asistenciaDAO.registrarAsistencia(idse,estasist,fecha);
        
        //CAMBIO DE VALOR AL HACER CLICK
        if(chk.val() == 1){
            chk.val(0);
        }else{
            chk.val(1);
        }
    });//FIN CLICK EN CHK
    
//    var html = "";
//    var sec= "";
//     $("table.iu_asist tr.alu").remove();
//    
//     
//     
//     $("table.iu_asist ").append(html);
//     $(".edit_sec").click(function(){      editarSeccion($(this));     });
    
    sistema.cierraCargando();
}

rangoFechasGrupo = function(cgrupo){
    var fechas= "";
    $.ajax({
            url : '../controlador/controladorSistema.php',
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'rangoFechasGrupo',
		//DATOS
                cgrupo:cgrupo
            },
            success : function ( obj ) {
		 window.console.log(obj);
                 fechas = obj.data;
            }
        });
        return fechas;
}

asistenciaAlumno = function(codseing,fasist){
    var asistencia = 0;
    $.ajax({
            url : '../controlador/controladorSistema.php',
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'asistenciaAlumno',
		//DATOS
                seingalu:codseing,
                fecha:fasist
            },
            success : function ( obj ) {
	 window.console.log(obj);
                 asistencia = obj.data;
            }
        });
        return asistencia;
    
}

ExportarAsistFormato=function(){
	window.location='../reporte/excel/EXCELasistFormato.php?cgrupo='+$("#chgrupo").val()+'&secc='+$("#iu_select_sec").val()
	
}

ExportarAsistencia=function(){
	window.location='../reporte/excel/EXCELasistFormato.php?cgrupo='+$("#chgrupo").val()+'&secc='+$("#iu_select_sec").val()+"&asistencia=1"
	
}