$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	cencapDAO.cargarFiliales(sistema.llenaSelect,"slct_filial","");
	jQGridCencap.Cencap();  
        
        $('#frmCencap').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_cencap_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$('#frmCencap input[type="text"],#frmCencap select').val('');
        $('#id_cencap').val("");
		$('#slct_filial').removeAttr("disabled");
	$('#btnFormCencap').attr('onclick', 'nuevoCencap()');
	$('#spanBtnFormCencap').html('Guardar');
	$('#frmCencap').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoCencap=function(){
 
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoSlct('slct_filial');
	a[2] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        cencapDAO.addCencap();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_cencap_jqgrid=function(){
	var id=$("#table_cencap").jqGrid("getGridParam",'selrow');
	$("#frmCencap .form i").remove();
    if (id) {
        var data = $("#table_cencap").jqGrid('getRowData',id);
        $('#id_cencap').val(data.ccencap);
        $('#txt_descrip').val(data.description);
        $('#slct_filial').val(data.cfilial);
		$('#slct_filial').attr("disabled","true");		
        $('#slct_estado').val(data.cestado);
	
        $('#btnFormCencap').attr('onclick', 'modificarPersonal()');
        $('#spanBtnFormCencap').html('Modificar');
        $('#frmCencap').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Centro de captacion</b> a Editar')
	}
}
modificarPersonal=function(){
    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoSlct('slct_filial');
	a[2] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        cencapDAO.editCencap();
}

