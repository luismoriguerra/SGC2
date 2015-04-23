$(document).ready(function(){

	$('#nav-reportes').addClass('active');//aplica estilo al menu activo				
	institucionDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	    


	$('#btn_listar').click(function(){VisualizarGrupos()});
	
	$("#slct_filial,#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
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
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_grupo").css("display","");
	}
	$("#lista_grupos").html(htm);	
}

VisualizarHorarioProgramadoHtml=function(obj){
	var pos=0;
	$.each(obj,function(index,value){
		AgregarHorario('X');
		pos=$("#txt_cant_hor").val()*1;
		$("#slct_dia_"+pos).val(value.cdia);
		$("#slct_hora_"+pos).val(value.chora);
		$("#slct_tipo_"+pos).val(value.ctipcla);
		$("#slct_tipo_ambiente_"+pos).val(value.ctipamb);
		ActualizaAmbiente(value.ctipamb,'slct_tipo_ambiente_'+pos,value.cambien);
		$("#slct_tiempo_tolerancia_"+pos).val(value.ctietol);
		$("#chk_"+pos).attr("value",value.chorpro);
	});	
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












