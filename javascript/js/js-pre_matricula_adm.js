$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo		
	carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','01');
	//institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
	$("#slct_filial,#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	
    //institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	//institucionDAO.cargarFilial(sistema.llenaSelect,'slct_filial','');	    
	$('#btn_listar').click(function(){VisualizarGrupos()});
	$("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});

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
	//carreraDAO.cargarSemestreG(sistema.llenaSelect,'slct_semestre','');	
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
		'		<a onClick="VisualizarDetalle('+"'"+obj[i].id+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="#v_lista_alumnos">'+
        '        	<i class="icon-white icon-search"></i>'+
        '       </a>'+
        ' 	</div>'+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo('+"'"+obj[i].id+"','','"+obj[i].total+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-folder-open"></i>'+
        '       </a>'+
        ' 	</div>'+
        '	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupoPDF('+"'"+obj[i].id+"','','"+obj[i].total+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	 PDF'+
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
	var idgrupo='';
	for(i=0;i<obj.length;i++){
	htm+="<tr id='trg-"+obj[i].cingalu+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_alumnos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	if(obj[i].cestado=='Activo'){
	htm+="<td width='20' class='t-center'>"+
			'<input class="check" id="chk-'+obj[i].cingalu+'" type="checkbox" value='+"'"+obj[i].cingalu+"'"+'>'+(i+1)+'</td>';
	}
	else{
	htm+="<td width='20' class='t-center'>"+
			'</td>';
	}
	
	htm+="<td width='200' class='t-center'>"+obj[i].dappape+"</td>";
	htm+="<td width='200' class='t-center'>"+obj[i].dapmape+"</td>";
	htm+="<td width='200' class='t-center'>"+obj[i].dnomper+"</td>";
	htm+="<td width='200' class='t-center'>"+obj[i].cestado+"</td>";
	if(obj[i].cestado=='Activo'){
	htm+="<td width='50' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo('+"'"+obj[i].id+"','"+obj[i].cingalu+"','1'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-folder-open"></i>'+
        '       </a>'+
        ' 	</div>'+

        '	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupoPDF('+"'"+obj[i].id+"','"+obj[i].cingalu+"','1'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	PDF'+
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
	idgrupo=obj[i].id;
	}
	var htm2="";
	htm2+="<tr>";
	htm2+="<td width='800' class='t-center'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo2('+"'"+idgrupo+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	Exportar Seleccionados<i class="icon-white icon-folder-open"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm2+="</tr>";
	htm2+="<tr>";
	htm2+="<td width='800' class='t-center'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ExportarGrupo2PDF('+"'"+idgrupo+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	Exportar Seleccionados PDF<i class="icon-white icon-folder-open"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm2+="</tr>";
	if(obj.length>0){
	$("#v_lista_alumnos").css("display","");
	}
	$("#lista_alumnos").html(htm);
	$("#btn_alumnos").html(htm2);
}

ExportarGrupo2=function(grupo){
	var act=false;
	var contador=0;
	var alumnos=$(".check").map(function(index, element) {
        if($(this).attr("checked")){
			contador++;
			act=true;
		return this.value;		
		}
    }).get().join(",");
	//alert(alumnos);
	
	if(act==true && contador<=30){
	window.location='../reporte/excel/EXCELpreMatriculaAdm.php?cgracpr='
                	+grupo+'&cingalu='+alumnos+
					'&csemaca='+$("#slct_semestre").val()+
					'&cfilial='+$("#slct_filial").val()+
					'&cinstit='+$("#slct_instituto").val();
	}
	else if(act==true && contador>30){
	sistema.msjAdvertencia("El max para enviar es de 30 ud selecciono "+contador,3000);
	}
	else{
	sistema.msjAdvertencia("Seleccione almenos un registro",3000);
	}
}

ExportarGrupo2PDF=function(grupo){
	var act=false;
	var contador=0;
	var alumnos=$(".check").map(function(index, element) {
        if($(this).attr("checked")){
			contador++;
			act=true;
		return this.value;		
		}
    }).get().join(",");
	//alert(alumnos);
	
	if(act==true && contador<=30){
	// window.location='../reporte/pdf/PDFpreMatriculaAdm.php?cgracpr='
 //                	+grupo+'&cingalu='+alumnos+
	// 				'&csemaca='+$("#slct_semestre").val()+
	// 				'&cfilial='+$("#slct_filial").val()+
	// 				'&cinstit='+$("#slct_instituto").val();
	window.open('../reporte/pdf/PDFpreMatriculaAdm.php?cgracpr='
                	+grupo+'&cingalu='+alumnos+
					'&csemaca='+$("#slct_semestre").val()+
					'&cfilial='+$("#slct_filial").val()+
					'&cinstit='+$("#slct_instituto").val(), "_blank");
	}
	// else if(act==true && contador>30){
	// sistema.msjAdvertencia("El max para enviar es de 30 ud selecciono "+contador,3000);
	// }
	else{
	sistema.msjAdvertencia("Seleccione almenos un registro",3000);
	}
}

ExportarGrupo=function(grupo,alumno,t){
	if(t<=30){
	window.location='../reporte/excel/EXCELpreMatriculaAdm.php?cgracpr='
                	+grupo+'&cingalu='+alumno+
					'&csemaca='+$("#slct_semestre").val()+
					'&cfilial='+$("#slct_filial").val()+
					'&cinstit='+$("#slct_instituto").val();
	}
	else{
	sistema.msjAdvertencia("El max para enviar es de 30 ud tiene "+t,3000);
	}
}

ExportarGrupoPDF=function(grupo,alumno,t){
	// if(t<=30){
	// window.location='../reporte/pdf/PDFpreMatriculaAdm.php?cgracpr='
 //                	+grupo+'&cingalu='+alumno+
	// 				'&csemaca='+$("#slct_semestre").val()+
	// 				'&cfilial='+$("#slct_filial").val()+
	// 				'&cinstit='+$("#slct_instituto").val();

	window.open('../reporte/pdf/PDFpreMatriculaAdm.php?cgracpr='
                	+grupo+'&cingalu='+alumno+
					'&csemaca='+$("#slct_semestre").val()+
					'&cfilial='+$("#slct_filial").val()+
					'&cinstit='+$("#slct_instituto").val() , "_blank");				
	// }
	// else{
	// sistema.msjAdvertencia("El max para enviar es de 30 ud tiene "+t,3000);
	// }
}