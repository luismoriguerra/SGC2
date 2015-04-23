$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');//aplica estilo al menu activo		
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
	$('#btn_exportar').click(function(){Exportar()});
	$("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});
	$("#slct_filial,#slct_instituto,#slct_semestre,#slct_carrera").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
})

CargaSemestre=function(){	
	if($.trim($("#slct_filial").val())==''){		
		sistema.msjAdvertencia("Seleccione Filial",3000);
	}
	else if($.trim($("#slct_instituto").val())==''){
		sistema.msjAdvertencia("Seleccione Instituto",3000);
	}
	else{
	institucionDAO.cargarSemestreG(sistema.llenaSelectGrupo,'slct_semestre','','Semestre');
	institucionDAO.cargarCarreraG(sistema.llenaSelectGrupo,'slct_carrera','','Carrera');	
	}	
}

Exportar=function(){
	var filial,instituto,semestre,carrera;
	if($.trim($("#slct_filial").val())==''){		
		sistema.msjAdvertencia("Seleccione Filial",3000);
	}
	else if($.trim($("#slct_instituto").val())==''){
		sistema.msjAdvertencia("Seleccione Instituto",3000);
	}
	else if($.trim($("#slct_semestre").val())==''){
		sistema.msjAdvertencia("Seleccione Semestre",3000);
	}
	else if($.trim($("#slct_carrera").val())==''){
		sistema.msjAdvertencia("Seleccione Carrera",3000);
	}
	else{
		filial=$("#slct_filial").val().join(",");
		instituto=$("#slct_instituto").val().join(",");
		carrera=$("#slct_carrera").val().join(",");
		semestre=$("#slct_semestre").val().join(",");
		if($("#slct_banco").val()=='1'){
			window.location='../reporte/txt/TXTbancos.php?cfilial='+filial+'&cinstit='+instituto+'&csemaca='+semestre+'&ccarrer='+carrera;
		}
		else if($("#slct_banco").val()=='2'){
			window.location='../reporte/txt/TXTbancos2.php?cfilial='+filial+'&cinstit='+instituto+'&csemaca='+semestre+'&ccarrer='+carrera;
		}		
	}
	
}