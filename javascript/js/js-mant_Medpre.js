$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
        institucionDAO.cargarFilialG(sistema.llenaSelectGrupo,'slct_filiales','','Filial');
	institucionDAO.cargarFilial(sistema.llenaSelect,"slct_filial","");
	jQGridMedpre.Medpre();  
	medpreDAO.listarFiltro(sistema.llenaSelect,"slct_tipo","");
        
        $('#frmMedpre').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
        
        $("#slct_filiales").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
});

add_medpre_jqgrid=function(){

	$('#frmMedpre input[type="text"],#frmMedpre select').val('');
        
        $("tr.filiales").show();
        $("tr.filial").hide();
        $(".ui-multiselect-none").trigger("click");
	$('#btnFormMedpre').attr('onclick', 'nuevoMedpre()');
	$('#spanBtnFormMedpre').html('Guardar');
	$('#frmMedpre').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoMedpre=function(){
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoTxt('slct_filiales');
	a[2] = sistema.requeridoSlct('slct_tipo');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        medpreDAO.addMedpre();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_medpre_jqgrid=function(){
	var id=$("#table_medpre").jqGrid("getGridParam",'selrow');
	$("#frmMedpre .form i").remove();
    if (id) {
        var data = $("#table_medpre").jqGrid('getRowData',id);
        $('#id_opcion').val(id);
        $('#txt_descrip').val(data.dmedpre);
        $('#slct_filial').val(data.cfilial);
        $('#slct_tipo').val(data.tmedpre);	
	
        
         $("tr.filiales").hide();
        $("tr.filial").show();
        
        $('#btnFormMedpre').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormMedpre').html('Modificar');
        $('#frmMedpre').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Medio de Prensa</b> a Editar')
	}
}

modificarOpcion=function(){    
	var a=new Array();
	a[0] = sistema.requeridoTxt('txt_descrip');
	a[1] = sistema.requeridoSlct('slct_filial');
	a[2] = sistema.requeridoSlct('slct_tipo');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        medpreDAO.editMedpre();
}

