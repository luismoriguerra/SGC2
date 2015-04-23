$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo		
	carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	//institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    //institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	    
	$('#btn_listar').click(function(){VisualizarGrupos()});
	$("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});
	$("#slct_instituto,#slct_filial").multiselect({
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

CargaSemestre=function(){	
	if($("#slct_instituto").val() && $("#slct_filial").val()){
	institucionDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre','');
	}	
	//institucionDAO.cargarSemestreG(sistema.llenaSelectGrupo,'slct_semestre','','Semestre');	
}

VisualizarGruposHTML=function(obj){
	var htm="";	
	for(i=0;i<obj.length;i++){
	htm+="<tr id='trg-"+obj[i].id.split(",").join("-")+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='90' class='t-center'>"+obj[i].dfilial+"</td>";
	htm+="<td width='100' class='t-center'>"+obj[i].dinstit+"</td>";
	htm+="<td width='210' class='t-center'>"+obj[i].dcurric+"</td>";
	htm+="<td width='170' class='t-left'>"+obj[i].dcarrer+"</td>";
	htm+="<td width='120' class='t-center'>"+obj[i].dturno+"</td>";
	htm+="<td width='120' class='t-center'>"+obj[i].cinicio+"</td>";
	htm+="<td width='160' class='t-center'>"+obj[i].finicio+" / "+obj[i].ffin+"</td>";
	htm+="<td width='160' class='t-left'>"+obj[i].horario+"</td>";
	htm+="<td width='30' class='t-left'>"+obj[i].total+"</td>";
	htm+="<td width='30' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="VisualizarDetalle('+"'"+obj[i].id+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-search"></i>'+
        '       </a>'+
        ' 	</div>'+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo('+"'"+obj[i].id+"',''"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-folder-open"></i>'+
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

VisualizarDetalle=function(ids){
	$("#v_lista_alumnos").css("display","none");
	grupoAcademicoDAO.cargarAlumnos(VisualizarDetalleHTML,ids);
}

VisualizarDetalleHTML=function(obj){
	var htm="";	
	for(i=0;i<obj.length;i++){
	htm+="<tr id='trg-"+obj[i].cingalu+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_alumnos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";	
	htm+="<td width='250' class='t-center'>"+obj[i].dappape+"</td>";
	htm+="<td width='250' class='t-center'>"+obj[i].dapmape+"</td>";
	htm+="<td width='250' class='t-center'>"+obj[i].dnomper+"</td>";
	htm+="<td width='200' class='t-center'>"+obj[i].cestado+"</td>";
	if(obj[i].cestado=='Activo'){
	htm+="<td width='50' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo('+"'"+obj[i].id+"','"+obj[i].cingalu+"','1'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-folder-open"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	}
	else{
	htm+="<td width='50' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
        ' 	</div>'+
		'</td>';
	}
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_alumnos").css("display","");
	}
	$("#lista_alumnos").html(htm);	
}

ExportarGrupo=function(grupo,alumno){
	window.location='../reporte/excel/EXCELdocumentos.php?cgracpr='
                	+grupo+'&cingalu='+alumno+'&usuario='+$("#hd_idUsuario").val();
}

ExportarGrupoG=function(){
	var cfilial=$("#slct_filial").val().join(",");
	var cinstit=$("#slct_instituto").val().join(",");
	var fechini=$("#txt_fecha_inicio").val();
    var fechfin=$("#txt_fecha_fin").val();
	var csemaca=$("#slct_semestre").val();
	var cciclo=$("#slct_ciclo").val();
	window.location='../reporte/excel/EXCELdocumentos.php?cfilial='
                	+cfilial+'&cinstit='+cinstit+'&csemaca='+csemaca+'&cciclo='+cciclo+'&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;
}