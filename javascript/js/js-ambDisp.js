$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelect,'slct_filial','');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	$("#slct_filial").change(function(){cargaAmbiente();});

	$("#slct_ambiente").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();

});
	
	


cargaAmbiente=function(){
	if($.trim($("#slct_filial").val())=="")	{		
	sistema.limpiaSelect('slct_ambiente');	
	}else{	


	// carreraDAO.cargaAmbiente(sistema.llenaSelect,'slct_ambiente','');	
	carreraDAO.cargaAmbiente(sistema.llenaSelectGrupo,'slct_ambiente','','Ambiente');


	}
}


ExportarAmbientes = function(){

		if($.trim($("#slct_filial").val())=="")	{		
		// sistema.limpiaSelect('slct_ambiente');	
		sistema.msjAdvertencia("Seleccionar Filial",200);
		$("#slct_filial").focus();
		}else{
			var ambientes = ''
			if($.trim($("#slct_ambiente").val())!="")
				ambientes = $('#slct_ambiente').val().join(",");
			
		  	var filial=$('#slct_filial').val();
	        
	        var institucion = $("#slct_instituto").val();
	  
			window.location='../reporte/excel/EXCELambientesDisponibles.php?filial='+filial+'&ambientes='+ambientes+"&institucion="+institucion;	
    }
}

