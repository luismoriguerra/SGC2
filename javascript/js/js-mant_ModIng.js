$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,"slct_instituto","");
	jQGridModIng.ModIng();  
        
        $('#frmModIng').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_moding_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$('#frmModIng input[type="text"],#frmModIng select').val('');
	$('#slct_tipo').val("S");
    $('#id_grupom').val("");
	$('#btnFormModIng').attr('onclick', 'nuevoModIng()');
	
	$('#slct_instituto').removeAttr('disabled');
	
	$('#spanBtnFormModIng').html('Guardar');
	$('#frmModIng').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoModIng=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoTxt('slct_instituto');
	a[2] = sistema.requeridoSlct('slct_tipo');
	a[3] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<a.length;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        modingDAO.addModIng();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_moding_jqgrid=function(){
	var id=$("#table_moding").jqGrid("getGridParam",'selrow');
	$("#frmModIng .form i").remove();
    if (id) {
        var data = $("#table_moding").jqGrid('getRowData',id);
        $('#id_opcion').val(id);
        $('#txt_descrip').val(data.dmoding);
        $('#slct_instituto').val(data.cinstit);
		$('#slct_tipo').val(data.treqcon);
        $('#slct_estado').val(data.cestado);
        
		$('#slct_instituto').attr('disabled','true');
		
        $('#btnFormModIng').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormModIng').html('Modificar');
        $('#frmModIng').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Modalidad de Ingreso</b> a Editar')
	}
}

modificarOpcion=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoSlct('slct_instituto');
	a[2] = sistema.requeridoSlct('slct_tipo');
	a[3] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<a.length;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        modingDAO.editModIng();
}

