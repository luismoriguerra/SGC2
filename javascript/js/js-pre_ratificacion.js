$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
	jQGridGrupoAcademico.GrupoAcademico();
	jQGridPlanCurricular.PlanCurricular();
	//$('#table_persona_ingalum').jqGrid('hideCol','finicio');
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);
		$("#table_plan_curricular").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=curricula&action=jqgrid_listar_plancurricular&cingalu='+$('#txt_cingalu').val()}); 
		$("#table_plan_curricular").trigger('reloadGrid');
		grupoAcademicoDAO.crearPonderado();
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Alumno</b>')
	}
}

ListadoCursos=function(){
var id=$("#table_grupo_academico").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_grupo_academico").jqGrid('getRowData',id);
        $("#txt_cgracpr_destino").val(id);
        $("#txt_dciclo_destino").val(data.dciclo);
        grupoAcademicoDAO.cargarCursosAcademicosAlumno(HTMLcargarCursosAcademicosAlumno);
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Grupo Academico</b>')
	}
}

HTMLcargarCursosAcademicosAlumno=function(obj){
	var htm="";
	var codigo="";

	$.each(obj,function(index,value){
		codigo='"'+value.ccuprpr+'","'+value.gruequi+'","'+value.dcurso+'","'+value.dcursof+'","'+value.ncredit+'","'+$("#txt_dciclo_destino").val()+'"';
		htm+="<tr class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
        htm+="<td width='140px' class='t-center'>"+value.dcurso+"</td>";
		htm+="<td width='140px class='t-center'>"+value.dcursof+"</td>";
		htm+="<td width='60px' class='t-center'>"+value.ncredit+"</td>";
		htm+="<td width='50px' class='t-center'><a class='alu_listar btn btn-azul sombra-3d t-blanco' onClick='verHorario("+'"'+value.ccuprpr+'"'+")'><i class='icon-white  icon-search'></i></a></td>";
		htm+="<td width='50px' class='t-center'><a class='alu_asist btn btn-azul sombra-3d t-blanco' onClick='pasarRegistro("+codigo+")'><i class='icon-white  icon-list'></i></a></td>";
		htm+="</tr>";
	});

	$("#lista_curso_grupos").html(htm);
}

verHorario=function(cod){

}

pasarRegistro=function(ccuprpr,gruequi,dcurso,dcursof,ncredit,dciclo){
	var htm="";
	var codigo='"'+ccuprpr+'","'+gruequi+'","'+ncredit+'","no_"';
	htm+="<tr id='curso_alumno_"+ccuprpr+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
    htm+="<td width='140px' class='t-center'>"+dcurso+"</td>";
	htm+="<td width='140px class='t-center'>"+dcursof+"</td>";
	htm+="<td width='60px' class='t-center'>"+ncredit+"</td>";
	htm+="<td width='60px' class='t-center'>"+dciclo+"</td>";
	htm+="<td width='50px' class='t-center'><a class='alu_listar btn btn-azul sombra-3d t-blanco' onClick='eliminarRegistro("+codigo+")'><i class='icon-white  icon-trash'></i></a></td>";
	htm+="</tr>";
		
	grupoAcademicoDAO.validarPasarRegistro(ccuprpr,gruequi,htm,ncredit);	
}

eliminarRegistro=function(ccuprpr,gruequi,ncredit,adic){
	var total=$("#total_credito").val()*1-ncredit*1;
	var cantidad=0;

	cantidad=$("#ccreditosaux").val()*1-1;

	if(adic!='no_'){
	$("#ccreditosaux").val(cantidad);
		if(cantidad==0){
			$("#tcreditosaux").val("");
		}
	}
	
	$("#total_credito").val(total);
	$("#curso_alumno_"+ccuprpr).remove();

	sistema.msjAdvertencia('Registro eliminado',4000);
}

adicionarRegistro=function(htm,ncredit,ccuprp,adic){
	var total=$("#total_credito").val()*1+ncredit*1;

	if($("#lista_curso_alumno").html().split(ccuprp).length>1){
		sistema.msjAdvertencia('Ud ya adiciono el curso seleccionado',4000);
	}
	else if($("#tcreditos").val()*1>=total && $("#tcreditosaux").val()==''){

		$("#total_credito").val(total);

		var htmlfinal=htm;
		if($.trim(adic)!=''){
		htmlfinal=htm.split("no_").join(adic);	
		}
		
		$("#lista_curso_alumno").append(htmlfinal);
	}
	else if($.trim($("#tcreditosaux").val())!='' && $("#tcreditosaux").val()*1>=total){
		$("#total_credito").val(total);

		var htmlfinal=htm;
		if($.trim(adic)!=''){
		htmlfinal=htm.split("no_").join(adic);	
		}
		
		$("#lista_curso_alumno").append(htmlfinal);
	}	
	else{
		sistema.msjAdvertencia('Ud sobrepasa el limite de creditos asignar',4000);
	}
	
}

VerHorarioGeneral=function(){

}

GuardarGeneral=function(){
	
}