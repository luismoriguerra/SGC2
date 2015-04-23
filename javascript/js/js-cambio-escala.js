$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);
		
		pagoDAO.cargarMontoEscala();
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Alumno</b>')
	}
}


CambiarEscala=function(){
	var valores=new Array();
	var montoescala=0;
	var montototalnuevo=0;
	if($.trim($("#slct_escala").val().split("-"))==""){
		sistema.msjAdvertencia('Seleccione <b>Escala</b> a Cambiar');
		$("#slct_escala").focus();
	}
	else{
	valores=$("#slct_escala").val().split("-");	
	montoescala=$("#txt_monto_escala").val();
	montototalnuevo=valores[1]*valores[4];
		if(montototalnuevo<montoescala){
			sistema.msjAdvertencia('Monto de la escala anterior:<b>'+montoescala+'</b> es mayor al total de la escala seleccionada:<b>'+montototalnuevo+'</b>');
		}
		else{
			pagoDAO.cambiarEscala();
		}
	}

}
