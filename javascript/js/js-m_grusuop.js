$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	grupusuDAO.cargarGrupos(sistema.llenaSelect,"slct_grupo","");
	grupusuDAO.cargarModulos(sistema.llenaSelect,"slct_cagrop","");
	grupusuDAO.cargarOpciones(sistema.llenaSelect,"slct_opcion","");
	jQGridGrUsuOp.GrUsuOp();  
        
        $('#frmGrUsuOp').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_grusuop_jqgrid=function(){
	$('#frmGrUsuOp input[type="text"],#frmGrUsuOp select').val('');
	
    $('#slct_grupo').val("");
    $('#slct_cagrop').val("");
    $('#slct_opcion').val("");
	
	$('#slct_grupo').removeAttr('disabled');
	$('#slct_cagrop').removeAttr('disabled');
	$('#slct_opcion').removeAttr('disabled');
	
	$('#btnFormGrUsuOp').attr('onclick', 'nuevoGrUsuOp()');
	$('#spanBtnFormGrUsuOp').html('Guardar');
	$('#frmGrUsuOp').dialog('open');
}

// campos a enviar al ajax para insertar
nuevoGrUsuOp=function(){
	var a=new Array();
	a[0] = sistema.requeridoSlct('slct_grupo');
	a[1] = sistema.requeridoSlct('slct_cagrop');
	a[2] = sistema.requeridoSlct('slct_opcion');
	a[3] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<4;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        grupusuDAO.addGrUsuOp();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_grusuop_jqgrid=function(){
	var id=$("#table_grusuop").jqGrid("getGridParam",'selrow');
	$("#frmGrUsuOp .form i").remove();
    if (id) {
        var data = $("#table_grusuop").jqGrid('getRowData',id);
        $('#slct_grupo').val(data.cgrupo);
        $('#slct_cagrop').val(data.ccagrop);
        $('#slct_opcion').val(data.copcion);
        $('#slct_estado').val(data.cestado);
		
		$('#slct_grupo').attr('disabled','true');
		$('#slct_cagrop').attr('disabled','true');
		$('#slct_opcion').attr('disabled','true');
		
        $('#btnFormGrUsuOp').attr('onclick', 'modificarGrUsuOp()');
        $('#spanBtnFormGrUsuOp').html('Modificar');
        $('#frmGrUsuOp').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Registro</b> a Editar')
	}
}

modificarGrUsuOp=function(){    
	var a=new Array();
	a[0] = sistema.requeridoSlct('slct_grupo');
	a[1] = sistema.requeridoSlct('slct_cagrop');
	a[2] = sistema.requeridoSlct('slct_opcion');
	a[3] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<4;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        grupusuDAO.editGrUsuOp();
}

