$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo			
	institucionDAO.cargarCuentas(sistema.llenaSelect,'slct_cuenta','');
	institucionDAO.cargarDetalleEx(sistema.llenaSelect,'txt_detalle_ex','');
	$('#btn_exportar').click(function(){Exportar()});
	$("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});
	$("#slct_semestre,#slct_carrera").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();

})

verificaNombre=function(){
	institucionDAO.verificaNombre2();
}

VisualizaAsignacion=function(){
    $("#cfilial").val('');
    $("#cinstit").val('');
    institucionDAO.cargarFilIns();

    institucionDAO.cargarSemestreR(sistema.llenaSelectGrupo,'slct_semestre','','Semestre');
	institucionDAO.cargarCarreraR(sistema.llenaSelectGrupo,'slct_carrera','','Carrera');

}

muestrafilins=function(dfilial,dinstit){
	var fil=new Array();
	var ins=new Array();
	fil=dfilial.split("|");
	ins=dinstit.split("|");

	$("#lista_filial").html('');
	$("#lista_instit").html('');

	for(i=0;i<fil.length;i++){
		$("#lista_filial").append("<tr class='ui-widget-content jqgrow ui-row-ltr' "+ 
		"onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'><td>"+fil[i]+"</td></tr>");
	}

	for(i=0;i<ins.length;i++){
		$("#lista_instit").append("<tr class='ui-widget-content jqgrow ui-row-ltr' "+ 
		"onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'><td>"+ins[i]+"</td></tr>");
	}
}

Exportar=function(){
	var filial,instituto,semestre,carrera;
	if($.trim($("#cfilial").val())==''){		
		sistema.msjAdvertencia("Cuenta Asignada no tiene Filial",3000);
	}
	else if($.trim($("#cinstit").val())==''){
		sistema.msjAdvertencia("Cuenta Asignada no tiene Institucion",3000);
	}
	else if($.trim($("#slct_semestre").val())==''){
		sistema.msjAdvertencia("Seleccione Semestre",3000);
	}
	else if($.trim($("#slct_carrera").val())==''){
		sistema.msjAdvertencia("Seleccione Carrera",3000);
	}
	else{
		filial=$("#cfilial").val().split("|").join(",");
		instituto=$("#cinstit").val().split("|").join(",");
		cuenta=$("#cuenta").val();
		carrera=$("#slct_carrera").val().join(",");
		semestre=$("#slct_semestre").val().join(",");
		if(cuenta.split("|")[4]=='BCP'){
			window.location='../reporte/txt/TXTbancos.php?cuenta='+cuenta+'&cfilial='+filial+'&cinstit='+instituto+'&csemaca='+semestre+'&ccarrer='+carrera;
		}
		else if(cuenta.split("|")[4]=='SCOTIABANK'){
			window.location='../reporte/txt/TXTbancos2.php?cuenta='+cuenta+'&cfilial='+filial+'&cinstit='+instituto+'&csemaca='+semestre+'&ccarrer='+carrera;
		}		
	}
	
}