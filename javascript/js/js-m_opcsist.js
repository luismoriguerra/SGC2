$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	/*grupusuDAO.cargarInstitutos(sistema.llenaSelect,"slct_instituto","");*/
	jQGridOpcSist.OpcSist();  
        
        $('#frmOpcSist').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_opcsist_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$('#frmOpcSist input[type="text"],#frmOpcSist select').val('');
    $('#id_grupom').val("");
	$('#btnFormOpcSist').attr('onclick', 'nuevoOpcSist()');
	$('#spanBtnFormOpcSist').html('Guardar');
	$('#frmOpcSist').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoOpcSist=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoTxt('txt_url');
	/*a[1] = sistema.requeridoSlct('slct_instituto');*/
	a[2] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        opcsistDAO.addOpcSist();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_opcsist_jqgrid=function(){
	var id=$("#table_opcsist").jqGrid("getGridParam",'selrow');
	$("#frmOpcSist .form i").remove();
    if (id) {
        var data = $("#table_opcsist").jqGrid('getRowData',id);
        $('#id_opcion').val(id);
        $('#txt_descrip').val(data.dopcion);
        $('#txt_url').val(data.durlopc);
        $('#txt_coment').val(data.dcoment);
        $('#slct_estado').val(data.cestado);
        $('#btnFormOpcSist').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormOpcSist').html('Modificar');
        $('#frmOpcSist').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Opción</b> a Editar')
	}
}

modificarOpcion=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoTxt('txt_url');
	/*a[1] = sistema.requeridoSlct('slct_instituto');*/
	a[2] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        opcsistDAO.editOpcSist();
}

