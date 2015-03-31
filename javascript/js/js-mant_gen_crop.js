$(document).ready(function(){
	/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
	
	$('#frmDetGru').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
	
//	$("#mreportes").addClass("ui-corner-all active");	

	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
	//carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
	//carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	$("#slct_filial").change(function(){cargarCarrera("");cargarSemestre("");cargarInicio("");cargarCurricula("");validaFechasPago();cargarPension();});
	$("#slct_filial").on("multiselectclick", function(event, ui) { 
	cargarCarrera("");cargarSemestre("");cargarInicio("");cargarCurricula("");validaFechasPago();cargarPension();
	});
	$("#slct_instituto").change(function(){cargarCarrera("");cargarSemestre("");cargarInicio("");cargarCurricula("");validaFechasPago();cargarPension();});
	//$("#slct_modalidad").change(function(){cargarCarrera("");cargarCurricula("");validaFechasPago();});
	$("#slct_semestre").change(function(){cargarInicio("");validaFechasPago();});
	$("#slct_ciclo").change(function(){validaFechasPago();});
	$("#slct_inicio").change(function(){validaFechasPago();});
	$("#slct_carrera").change(function(){validaFechasPago();cargarPension();});
	$("#slct_carrera").on("multiselectclick", function(event, ui) { 
	validaFechasPago();cargarPension();
	});
	$("#slct_curricula").change(function(){validaFechasPago();});
	$("#slct_filial,#slct_concepto,#slct_carrera").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
        $("#slct_carrera").change(function(){ListarCiclos();});
});

ListarCiclos = function(){
     carreraDAO.cargarCiclosdeModuloaG(sistema.llenaSelect,'slct_ciclo','');
}

cargarPension=function(){
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!="" && $.trim($("#slct_carrera").val())!=""){
	institucionDAO.cargarPensionG2(sistema.llenaSelectGrupo2,'slct_concepto','','todo');
	}
}

LimpiaFechas=function(){
$("#detalle_fechas").html("");
}

ListarFechas=function(){
	var datos=$("#slct_concepto").val();
	var cuota=1;
	var htm="";
	if($.trim($("#slct_concepto").val().join(','))!=''){		
		for(i=0;i<datos.length;i++){			
			if(datos[i].split("-")[1]*1>cuota*1){
			cuota=datos[i].split("-")[1];
			}
		}
		valida="";
		for(i=1;i<=cuota*1;i++){			
		htm+="<tr><td class='t-left label'> Fecha "+i+" :</td>"+
			"<td class='t-left'><input class='fechas' type='text'  id='txt_fecha_pago"+i+"' style='width:95px'></tr>";
		}
	}
	$("#detalle_fechas").html(htm);
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
}

cargarSemestre=function(marcado){ //tendra "marcado" en select luego cargar
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!=""){
	carreraDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre',marcado);
	}
}

cargarInicio=function(marcado){ //tendra "marcado" en select luego cargar
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!="" && 
		$.trim($("#slct_semestre").val())!=""){
	carreraDAO.cargarInicioG(sistema.llenaSelect,'slct_inicio',marcado);
	}
}

cargarCarrera=function(marcado){ //tendra "marcado" en select luego cargar
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!="" && 
		$.trim($("#slct_tipo_carrera").val())!=""){
		//$.trim($("#slct_modalidad").val())!="" &&
	//carreraDAO.cargarCarreraG(sistema.llenaSelect,'slct_carrera',marcado);
	carreraDAO.cargarCarreraG(sistema.llenaSelectGrupo,'slct_carrera',marcado,'Carrera');
	}
}  

cargarCurricula=function(marcado){ //tendra "marcado" en select luego cargar
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!="" && 
		$.trim($("#slct_carrera").val())!="" && $.trim($("#slct_tipo_carrera").val())!=""){
		//$.trim($("#slct_modalidad").val())!="" &&
	carreraDAO.cargarCurricula(sistema.llenaSelect,'slct_curricula',marcado);
	}
}

validaFechasPago=function(){
	if(	$.trim($("#slct_filial").val())!="" && $.trim($("#slct_instituto").val())!="" && 
	$.trim($("#slct_semestre").val())!="" && 
	$.trim($("#slct_ciclo").val())!="" && $.trim($("#slct_inicio").val())!="" &&
	$.trim($("#slct_tipo_carrera").val())!="" && $.trim($("#slct_carrera").val())!="" ){
	//$.trim($("#slct_modalidad").val())!="" && 
		$("#valFechasCronograma").css("display",'');
		ListarGrupos();
	}else{
		$("#lista_grupos").html("");
		$(".fechas").val("");
		$("#valFechasCronograma").css("display",'none');
	}
}

guardarCronograma=function(){
	var error="";
	if($.trim($("#slct_concepto").val())==""){
		sistema.msjAdvertencia("Debe Seleccionar almenos 1 concepto");
		error="ok";
	}
	
	if(error!='ok'){
		$(".fechas").map(function(index, element) {
            if($("#"+element.id).val()=='' && error!='ok'){
			sistema.msjAdvertencia("Debe Seleccionar la Fecha de Pago "+(index*1+1));
			$("#"+element.id).focus();
			error="ok";
			}
        });
		if(error!='ok'){
			for(i=1;i<=$(".fechas").length;i++){
				if(i<$(".fechas").length){
					if($("#txt_fecha_pago"+i).val()>$("#txt_fecha_pago"+(i*1+1)).val()){
					sistema.msjAdvertencia("Fecha "+i+" no puede ser mayor que Fecha "+(i*1+1));
					error='ok';
					break;
					}
				}
			}			
		}		
	}
	
	if(error=='ok'){
	}
	else{
		var cgrupos="";
		cgrupos=$("#lista_grupos tr").map(function(index, element) {
					if($('#chk-'+element.id.split("-")[1]).attr("checked")){
					return element.id.split("-")[1];
					}
				}).get().join("','");
		if($.trim(cgrupos)!=""){
		cronogramaDAO.guardarCronograma(cgrupos);
		}
		else{
	 	sistema.msjAdvertencia("Seleccione almenos 1 grupo para realizar la operación",3000);
		}
	}
}

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

limpiarSelects=function(){
	//institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	//institucionDAO.cargarInstitucion(sistema.llenaSelect,'slct_instituto','');
	$("#slct_instituto").val('');
	//carreraDAO.cargarModalidad(sistema.llenaSelect,'slct_modalidad','');
	carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	sistema.limpiaSelect('slct_semestre');
	sistema.limpiaSelect('slct_inicio');	
	//sistema.limpiaSelect('slct_tipo_carrera');
	sistema.limpiaSelect('slct_carrera');
	sistema.limpiaSelect('slct_curricula');
	$("#lista_grupos").html("");
	$("#chk-todo").removeAttr("checked");
	getFechasSemetre();
}

ListarGrupos = function(){
    $("#lista_grupos").html("");
    if( $('#slct_filial').val() && $('#slct_instituto').val() && $('#slct_carrera').val() && $('#slct_semestre').val() ){
        institucionDAO.ListarGruposG(ListarGruposHtml);
    }
	getFechasSemetre();
    
}

LDG=function(id){
institucionDAO.ListarDetalleGrupos(ListarDetalleGruposHtml,id);
}

ListarDetalleGruposHtml=function(obj){
var htm="";
$("#lista_grupos_detalle").html("");
	$.each(obj,function(index,value){
		htm+="<tr id='trgdet-"+value.cconcep+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos_detalle"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
		htm+="<td width='340' class='t-left'>"+value.concepto+"</td>";
		htm+="<td width='395' class='t-left'>"+value.fechas.split("|").sort().join(" | ")+"</td>";
		htm+="</tr>";
	});
$("#lista_grupos_detalle").html(htm);
$('#frmDetGru').dialog('open');
}

ListarGruposHtml = function(obj){
	$("#chk-todo").removeAttr("checked")
    $("#lista_grupos").html("");
    var htm="";
	$.each(obj,function(index,value){
		htm+="<tr id='trg-"+value.cgracpr+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
		htm+="<td class='t-center'><input type='checkbox' id='chk-"+value.cgracpr+"'></td>";
		htm+='<td><span class="formBotones">'+
				'<a class="btn btn-azul sombra-3d t-blanco" onclick="LDG('+"'"+value.cgracpr+"'"+')" href="javascript:void(0)">'+
					'<i class="icon-white icon-search"></i>'+
				'</a>'
			 '</span></td>';		
        htm+="<td width='120' class='t-center'>"+value.filial+"</td>";
		htm+="<td width='184' class='t-center'>"+value.institucion+"</td>";
		htm+="<td width='169' class='t-center'>"+value.curricula+"</td>";
		htm+="<td width='200' class='t-center'>"+value.carrera+"</td>";
		htm+="<td width='120' class='t-center'>"+value.ciclo+"</td>";
		htm+="<td width='118' class='t-center'>"+value.turno+"</td>";
		htm+="<td width='120' class='t-center'>"+value.csemaca+"</td>";
		htm+="<td width='120' class='t-center'>"+value.cinicio+"</td>";
        htm+="<td width='120' class='t-center'>"+value.finicio+"</td>";
		htm+="<td width='118' class='t-center'>"+value.ffin+"</td>";
		htm+="<td width='120' class='t-center'>"+value.hora+"</td>";
		htm+="<td width='120' class='t-center'>"+value.dias+"</td>";
               // htm+="<td width='120' class='t-center'>"+value.gestado+"</td>";
		htm+="</tr>";
	});
	
     $("#lista_grupos").html(htm);
}