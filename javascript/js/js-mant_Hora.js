$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,"slct_instituto","");
	carreraDAO.cargarTurno(sistema.llenaSelect,"slct_turno","");
	jQGridHora.Hora();  
        
        $('#frmHora').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
});

add_hora_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$('#frmHora input[type="text"],#frmHora select').val('');
	$('#frmHora input[type="text"],#frmHora select').removeAttr('disabled');	
    $('#id_hora').val("");
	// $("#slct_chora").attr("disabled","false");
	$("#slct_chora").val('2');
	$('#btnFormHora').attr('onclick', 'nuevoHora()');
	$('#spanBtnFormHora').html('Guardar');
	$('#frmHora').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoHora=function(){
	var a=new Array();
	a[0] = sistema.requeridoSlct('slct_instituto');
	a[1] = sistema.requeridoSlct('slct_turno');
	a[2] = sistema.requeridoTxt('txt_hini');
	a[3] = sistema.requeridoTxt('txt_mini');
	a[4] = sistema.requeridoTxt('txt_hfin');
	a[5] = sistema.requeridoTxt('txt_mfin');
	a[6] = sistema.requeridoSlct('slct_thorari');
	a[7] = sistema.requeridoSlct('slct_chora');
	a[8] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<9;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        horaDAO.addHora();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_hora_jqgrid=function(){
	var id=$("#table_hora").jqGrid("getGridParam",'selrow');
	$("#frmHora .form i").remove();
    if (id) {
        var data = $("#table_hora").jqGrid('getRowData',id);
        $('#id_hora').val(id);
        $('#slct_instituto').val(data.cinstit);
        $('#slct_turno').val(data.cturno);
        $('#txt_hini').val(data.hinici.substring(0,2));
        $('#txt_mini').val(data.hinici.substring(5,3));
        $('#txt_hfin').val(data.hfin.substring(0,2));
        $('#txt_mfin').val(data.hfin.substring(5,3));
        $('#slct_thorari').val(data.thorari);
        $('#slct_chora').val(data.thora);
        $('#slct_estado').val(data.cestado);
		$('#frmHora input[type="text"],#frmHora select').attr('disabled','true');
		$('#slct_estado').removeAttr('disabled');
        $('#btnFormHora').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormHora').html('Modificar');
        $('#frmHora').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Hora</b> a Editar')
	}
}

modificarOpcion=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('slct_instituto');
	a[1] = sistema.requeridoTxt('slct_turno');
	a[2] = sistema.requeridoTxt('txt_hini');
	a[3] = sistema.requeridoTxt('txt_mini');
	a[4] = sistema.requeridoTxt('txt_hfin');
	a[5] = sistema.requeridoTxt('txt_mfin');
	a[6] = sistema.requeridoSlct('slct_thorari');
	a[7] = sistema.requeridoSlct('slct_chora');
	a[8] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<9;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        horaDAO.editHora();
}

