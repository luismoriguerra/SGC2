var pos_global=0;
$(document).ready(function(){

	$('#nav-reportes').addClass('active');//aplica estilo al menu activo				
	institucionDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');	
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	    

    
    horarioDAO.cargarTipoAmbiente(sistema.llenaSelect,'slct_tipo_ambiente','');
	horarioDAO.cargarTiempoTolerancia(sistema.llenaSelect,'slct_tiempo_tolerancia','');

	$('#btn_listar').click(function(){VisualizarGrupos()});
	
	$("#slct_filial,#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();

	$("#btnFormHorario").click(function(){guardarHorario()});
	$("#btnAgregarHorario").click(function(){AgregarHorario('')});
	

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});

	$('#frmDocente').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});

	jqGridDocente.Docente();
	jqGridDocente.Docente2();
})

VisualizarGrupos=function(){
	$("#v_lista_grupo").css("display","none");
	$("#v_lista_alumnos").css("display","none");
	grupoAcademicoDAO.cargarGrupoAcademicoR2(VisualizarGruposHTML);
}

VisualizarGruposHTML=function(obj){
	var htm="";	
	for(i=0;i<obj.length;i++){
	htm+="<tr id='trg-"+obj[i].id.split(",").join("-")+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='20' class='t-center chk'>"+
			'<input class="check" id="chk-'+ obj[i].id +'" type="checkbox" value='+"'"+ obj[i].id +"'"+'>'+(i+1) +'</td>';		 
	htm+="<td width='90' class='t-center'>"+obj[i].dfilial+"</td>";
	htm+="<td width='90' class='t-center'>"+obj[i].dfilial+"</td>";
	htm+="<td width='100' class='t-center'>"+obj[i].dinstit+"</td>";
	htm+="<td width='210' class='t-center'>"+obj[i].dcurric+"</td>";
	htm+="<td width='170' class='t-left'>"+obj[i].dcarrer+"</td>";
	htm+="<td width='120' class='t-center'>"+obj[i].dturno+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].cinicio+"</td>";
	htm+="<td width='160' class='t-center'>"+obj[i].finicio+" / "+obj[i].ffin+"</td>";
	htm+="<td width='160' class='t-left'>"+obj[i].horario+"</td>";
	htm+="<td width='30' class='t-left'>"+obj[i].total+"</td>";
	htm+="<td width='30' class='t-left view'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="GenerarHorario('+"'"+obj[i].id+"',''"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-zoom-in"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_grupo").css("display","");
	}
	$("#lista_grupos").html(htm);	
}

GenerarHorario=function(ids){
grupoAcademicoDAO.cargarDetalleGrupo(sistema.llenaSelect,'slct_detalle_grupo','',ids);
grupoAcademicoDAO.cargarDiasdelGrupo(ids);
grupoAcademicoDAO.cargarCursosAcademicos(VisualizarCursosHTML,ids);
ToogleFiltro();
}

RegresarGrupo=function(){
ToogleFiltro();
}

ToogleFiltro=function(){
$('#filtro').toggle("slow");
$('#horario').toggle("slow");
$("#actualizacion").css("display","none");
}

VisualizarCursosHTML=function(obj){
var htm="";	
var datos="";	
	for(i=0;i<obj.length;i++){
	datos=obj[i].dcurso+'_'+obj[i].nombre+'_'+obj[i].cprofes+'_'+obj[i].finipre+'_'+obj[i].ffinpre+'_'+obj[i].finivir+'_'+obj[i].ffinvir+'_'+obj[i].cinstit+'_'+obj[i].cfilial;
	htm+="<tr id='trg-"+obj[i].ccuprpr+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_cursos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='250' class='t-center'>"+obj[i].dcurso+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].finipre+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].ffinpre+"</td>";
	htm+="<td width='80' class='t-left'>"+obj[i].finivir+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].ffinvir+"</td>";
	htm+="<td width='250' class='t-center'>"+obj[i].nombre+"</td>";
	htm+="<td width='30' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ActualizaHorario('+"'"+obj[i].ccuprpr+"','"+datos+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-pencil"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_curso").css("display","");
	}
	$("#lista_cursos").html(htm);
}

ActualizaHorario=function(id,datos){
	var d=new Array();
	d=datos.split('_');

	$("#detalle_actualizacion .agregado").remove();
	$("#detalle_actualizacion .fijo").remove();

	if($("#slct_detalle_grupo").val()!=''){
		$('#ccuprpr').val(id);
		$('#txt_curso').val(d[0]);
		$('#txt_docente').val(d[1]);
		$('#cprofes').val(d[2]);
		$('#txt_fecha_ini_pre').val(d[3]);
		$('#txt_fecha_fin_pre').val(d[4]);
		$('#txt_fecha_ini_vir').val(d[5]);
		$('#txt_fecha_fin_vir').val(d[6]);
		$('#cinstit').val(d[7]);
		$('#cfilial').val(d[8]);		
		grupoAcademicoDAO.cargarHorarioProgramado(VisualizarHorarioProgramadoHtml,id);		
		$("#actualizacion").css("display","");	
	}
	else{
		sistema.msjAdvertencia('Seleccione Seccion',200);
		$("#slct_detalle_grupo").focus();
	}

}

VisualizarHorarioProgramadoHtml=function(obj){
	var pos=0;
	$.each(obj,function(index,value){
		AgregarHorario('X');
		pos=$("#txt_cant_hor").val()*1;
		$("#slct_tipo_"+pos).val(value.ctipcla);
		$("#slct_tipo_ambiente_"+pos).val(value.ctipamb);
		$("#slct_horario_"+pos+" option").html(value.horario);
		$("#slct_horario_"+pos).multiselect("refresh");
		$("#txt_dprofes_"+pos).val(value.dprofes);
		$("#txt_cprofes_"+pos).val(value.cprofes);
		ActualizaAmbiente(value.ctipamb,'slct_tipo_ambiente_'+pos,value.cambien);
		$("#slct_tiempo_tolerancia_"+pos).val(value.ctietol);
		$("#slct_estado_"+pos).val(value.cestado);
		if(value.cestado!='1'){
			$("#slct_estado_"+pos).attr('disabled','true');
			$("#chk_"+pos).remove();
		}
		$("#chk_"+pos).attr("value",value.chorpro);
	});	
}

AgregarHorario=function(ide){
	var agregado='fijo';
	var disabled='';
	var disabled2='disabled'
	if(ide==''){
		agregado='agregado';
		disabled='disabled';
		disabled2='';
	}	
	var tot=0;
	var htm="";	
	tot = $("#txt_cant_hor").val()*1 + 1;
	$("#txt_cant_hor").val(tot);
	htm=''+
	'<tr id="trel_'+tot+'" class="FormData '+agregado+'"> '+                                      
		'<td class="t-left">'+ 
	      '<select id="slct_tipo_ambiente_'+tot+'" class="input-large" onChange="ActualizaAmbiente(this.value,this.id);validaHorarios('+tot+');" '+disabled2+'>'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                              
	    '<td class="t-left">'+ 
	      '<select id="slct_ambiente_'+tot+'" onChange="validaHorarios('+tot+');" class="input-mediun" '+disabled2+'>'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+ 	                                
	    '<td class="t-left">'+ 
	      '<input type="text" id="txt_dprofes_'+tot+'" class="input-large" disabled>'+
	      '<input type="hidden" id="txt_cprofes_'+tot+'">';
	      if(ide==''){
	htm+=' 	<span class="formBotones">'+
                '<a href="javascript:void(0)" onClick="BuscarDocenteD('+tot+');" class="btn btn-azul sombra-3d t-blanco">'+
                    '<i class="icon-white icon-search"></i>'+
                    '<span id="spanBtnMantDocente"></span>'+
                '</a>'+
            '</span>';
	      }
	htm+='</td>         '+                              
	    '<td class="t-left">'+ 
	      '<select id="slct_horario_'+tot+'" style="width:120px" >'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+  
	    '<td class="t-left">'+ 
	      '<select id="slct_tipo_'+tot+'" class="input-mediun" >'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '<option value="T">Teórico</option>'+ 
	      '<option value="P">Práctico</option>'+ 
	      '</select>'+ 
	    '</td>'+ 	                                                                          
	    '<td class="t-left">'+ 
	      '<select id="slct_tiempo_tolerancia_'+tot+'" class="input-mediun" >'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                              
	    '<td class="t-left">&nbsp;'+ 
	      '<select id="slct_estado_'+tot+'" '+disabled+'>'+ 
	      '<option value="1" selected=selected>Activo</option>'+ 
	      '<option value="0">Inactivo</option>'+ 
	      '</select>'+ 
	    '</td>';
	    if(ide==''){
	    htm+='<td class="t-left"><span class="formBotones" style="">'+ 
			'<a class="btn btn-azul sombra-3d t-blanco" onclick="$('+"'"+'#trel_'+tot+"'"+').remove();" href="javascript:void(0)">'+ 
			'<i class="icon-white icon-remove"></i>			'+ 
			'</a>'+ 
			'</span></td>'+ 
	'</tr>';
	    }
	    else{
	    htm+='<td><input type="checkbox" id="chk_'+tot+'"></td></tr>';
	    }
	    
	$("#detalle_actualizacion").append(htm);	
	$("#slct_horario_"+tot).multiselect({
	position: {
      my: 'left bottom',
      at: 'left top'
   	},
   	multiple: false,
    header: "Seleccione Horario",
    noneSelectedText: "Seleccione Horario",    
   	selectedList: 1 // 0-based index
	}).multiselectfilter();
	$("#slct_tipo_ambiente_"+tot).html($("#slct_tipo_ambiente").html());
	$("#slct_tipo_ambiente_"+tot).val('');
	$("#slct_tiempo_tolerancia_"+tot).html($("#slct_tiempo_tolerancia").html());
	$("#slct_tiempo_tolerancia_"+tot).val('');
}

guardarHorario=function(){	

		var error="";		
		var id="";
		var datos="";
		var datos2="";
		var datosf="";
		var general_datos="";

		datos=$("#detalle_actualizacion .fijo").map(function(index, element) {
			id=this.id.split("_")[1];
			if($("#chk_"+id).attr("checked")){			
				if($("#slct_tipo_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Tipo Horario",1000);
				$("#slct_tipo_"+id).focus();
				}
				else if($("#slct_tiempo_tolerancia_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Tiempo Tolerancia",1000);
				$("#slct_tiempo_tolerancia_"+id).focus();
				}
				else if($("#slct_estado_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Estado",1000);
				$("#slct_estado_"+id).focus();
				}
				else{
				return $("#slct_tipo_"+id).val()+'_'+$("#slct_tiempo_tolerancia_"+id).val()+'_'+$("#slct_estado_"+id).val()+'_'+$("#chk_"+id).val();
				}
			}
        }).get().join('|');

		datos2=$("#detalle_actualizacion .agregado").map(function(index, element) {
			id=this.id.split("_")[1];			

            if($("#slct_tipo_ambiente_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tipo Ambiente",1000);
			$("#slct_tipo_ambiente_"+id).focus();
			}
			else if($("#slct_ambiente_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Ambiente",1000);
			$("#slct_ambiente_"+id).focus();
			}
			else if($("#txt_cprofes_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Busque y seleccione un Docente",1000);
			$("#txt_cprofes_"+id).focus();
			}
			else if($("#slct_horario_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Horario",1000);
			$("#slct_hora_"+id).focus();
			}			
			else if($("#slct_tipo_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tipo Horario",1000);
			$("#slct_tipo_"+id).focus();
			}			
			else if($("#slct_tiempo_tolerancia_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tiempo Tolerancia",1000);
			$("#slct_tiempo_tolerancia_"+id).focus();
			}			
			else if(general_datos!='' && general_datos.split('A'+$("#slct_horario_"+id).val()+'-'+$("#slct_ambiente_"+id).val()).length>1){					
			error="ok";
			sistema.msjAdvertencia("Existe duplicidad en sus registros del horario para el ambiente",4000);
			$("#slct_horario_"+id).focus();	
			}
			else if(general_datos!='' && general_datos.split('D'+$("#slct_horario_"+id).val()+'-'+$("#txt_cprofes_"+id).val()).length>1){					
			error="ok";
			sistema.msjAdvertencia("Existe duplicidad en sus registros del horario para el docente",4000);
			$("#slct_horario_"+id).focus();
			}			
				general_datos+='|A'+$("#slct_horario_"+id).val()+'-'+$("#slct_ambiente_"+id).val()+'|D'+$("#slct_horario_"+id).val()+'-'+$("#txt_cprofes_"+id).val();
				return $("#slct_horario_"+id).val().split("-")[0]+'_'+$("#slct_horario_"+id).val().split("-")[1]+'_'+$("#slct_tipo_"+id).val()+'_'+$("#slct_tipo_ambiente_"+id).val()+'_'+$("#slct_ambiente_"+id).val()+'_'+$("#slct_tiempo_tolerancia_"+id).val()+'_'+$("#txt_cprofes_"+id).val();					
				
        }).get().join('|');
		
		datosf=datos+'^^'+datos2;

		if(error==""){
		$("#actualizacion").css("display","none");
		horarioDAO.guardarHorarios(datosf);
		}
}


ListarDocente=function(){
	var dis=$("#mantenimiento_docente").css("display");
	if(dis=='none'){
	$("#mantenimiento_docente").css("display",'');
	}
	else{
	$("#mantenimiento_docente").css("display",'none');
	}
}

BuscarDocenteD=function(pos){
	pos_global=pos;
	$('#frmDocente').dialog('open');	
}

cargar_docente=function(){
	var id=$("#table_docente").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_docente").jqGrid('getRowData',id);
        $('#cprofes').val(id);
        $('#txt_docente').val(data.dappape+' '+data.dapmape+', '+data.dnomper);
		        
		$("#mantenimiento_docente").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione un registro a cargar');
	}
}

cargar_docente2=function(){
	var id=$("#table_docente2").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_docente2").jqGrid('getRowData',id);
        $('#txt_cprofes_'+pos_global).val(id);
        $('#txt_dprofes_'+pos_global).val(data.dappape+' '+data.dapmape+', '+data.dnomper);
		        
		$('#frmDocente').dialog('close');
		validaHorarios(pos_global);
    }else {
	    sistema.msjAdvertencia('Seleccione un registro a cargar');
	}
}

validaHorarios=function(pos){
	var cprofes=$('#txt_cprofes_'+pos).val();
	var cambien=$('#slct_ambiente_'+pos).val();
	if(cprofes!='' && cambien!=''){		
		horarioDAO.cargarHorarioValidado(sistema.llenaSelectGrupo,'slct_horario_'+pos,'',cprofes,cambien);
	}
	else{
		$("#slct_horario_"+pos).html("<option value=''>--Seleccione--</option>");
		$("#slct_horario_"+pos).multiselect('refresh');
	}
}

ActualizaAmbiente=function(valor,id,selector){	
	horarioDAO.cargarAmbiente(sistema.llenaSelect,'slct_ambiente_'+id.split("_")[3],selector,valor);
}


ExportarGrupos = function (){
	var grupos = _.map($("#lista_grupos tr input:checked") , function(i){ return $(i).val() });
	if(grupos.length < 1){
		 sistema.msjAdvertencia('Seleccione un grupo a exportar',2500);
		 return false;
	}

	var lista_grupos = grupos.join(',');
	window.open('../reporte/pdf/PDFreporteHorarios.php?'+ "grupos="+lista_grupos , "_blank");
}

VerificaCambio=function() {
	$("#actualizacion").css("display","none");
}
