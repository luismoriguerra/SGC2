$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
	jqGridPago.pagolista();
})


eventoClick=function(){
var ids=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (ids) {	
    	var data = $("#table_persona_ingalum").jqGrid('getRowData',ids);			
		$("#table_pago").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val()+'&cingalu='+ids.split("-")[0]+'&cgracpr='+ids.split("-")[1]+'&cperson='+data.cperson}); 
       	$("#table_pago").trigger('reloadGrid'); 
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Editar')
	}
}

