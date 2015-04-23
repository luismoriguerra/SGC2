$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum4();
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dappape+" "+data.dapmape+" "+data.dnomper);
		
		personaDAO.ListarResolucion(sistema.llenaSelect,'slct_resolucion','');  
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Alumno</b>')
	}
}


Exportar=function(){
	if($.trim($("#slct_resolucion").val())!=''){
		window.location='../reporte/word/WORDresolucion_externo.php?nombre='
                	+$("#txt_nombre").val()+'&resolucion='+$("#slct_resolucion").val()
                	+'&cingalu='+$('#txt_cingalu').val()+'&cusuari='+$('#hd_idUsuario').val();	
	}
	else{
		sistema.msjAdvertencia('Seleccione <b>Resolucion</b>')
	}	
}
