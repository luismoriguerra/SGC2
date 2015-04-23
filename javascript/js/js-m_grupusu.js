$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.cargarInstitucion(sistema.llenaSelect,"slct_instituto","");
	jQGridGrupUsu.GrupUsu();  
        
        $('#frmGrupUsu').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_grupusu_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$('#frmGrupUsu input[type="text"],#frmGrupUsu select').val('');
    $('#id_grupom').val("");
	$('#btnFormGrupUsu').attr('onclick', 'nuevoGrupUsu()');
	$('#spanBtnFormGrupUsu').html('Guardar');
	$('#frmGrupUsu').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoGrupUsu=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	/*a[1] = sistema.requeridoSlct('slct_instituto');*/
	a[1] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<2;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        grupusuDAO.addGrupUsu();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_grupusu_jqgrid=function(){
	var id=$("#table_grupusu").jqGrid("getGridParam",'selrow');
	$("#frmGrupUsu .form i").remove();
    if (id) {
        var data = $("#table_grupusu").jqGrid('getRowData',id);
        $('#id_grupom').val(data.cgrupo);
        $('#txt_descrip').val(data.dgrupo);
        $('#slct_instituto').val(data.cinstit);
        $('#slct_estado').val(data.cestado);
        $('#btnFormGrupUsu').attr('onclick', 'modificarGrupo()');
        $('#spanBtnFormGrupUsu').html('Modificar');
        $('#frmGrupUsu').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Grupo de Usuarios</b> a Editar')
	}
}

modificarGrupo=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	/*a[1] = sistema.requeridoSlct('slct_instituto');*/
	a[1] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<2;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        grupusuDAO.editGrupUsu();
}