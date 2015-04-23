$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarFilialValida(sistema.llenaSelect,'slct_filial_edit','');
	ambienteDAO.cargarTipoAmbiente(sistema.llenaSelect,'slct_tipo_ambiente','');
	jQGridAmbiente.Ambiente();
        
    $('#frmAmbiente').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});

	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
});

add_ambiente_jqgrid=function(){
//	$("#frmPersonal .form i").remove();
//	$('#cperson').val('');
	$("#id_filial_edit").css("display","none");
	$("#id_filial").css("display","");
	$('#frmAmbiente input[type="text"],#frmAmbiente select').val('');
	$('#frmAmbiente input[type="text"],#frmAmbiente select').removeAttr('disabled');	
    $('#id_ambiente').val("");
	
	$('#btnFormAmbiente').attr('onclick', 'nuevoAmbiente()');
	$('#spanBtnFormAmbiente').html('Guardar');
	$('#frmAmbiente').dialog('open');	
}

// campos a enviar al ajax para insertar
nuevoAmbiente=function(){	
	var a=new Array();
	var pos=0;
	a[pos] = sistema.requeridoSlct('slct_filial');pos++;
	a[pos] = sistema.requeridoSlct('slct_tipo_ambiente');pos++;
	a[pos] = sistema.requeridoTxt('txt_nro_ambiente');pos++;
	a[pos] = sistema.requeridoTxt('txt_capacidad');pos++;
	a[pos] = sistema.requeridoTxt('txt_metroscuadrados');pos++;
	a[pos] = sistema.requeridoTxt('txt_maquinas');pos++;
	a[pos] = sistema.requeridoSlct('slct_estado');pos++;
	for(var i=0;i<pos;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        ambienteDAO.addAmbiente();
	//si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_ambiente_jqgrid=function(){
	$("#id_filial_edit").css("display","");
	$("#id_filial").css("display","none");

	var id=$("#table_ambiente").jqGrid("getGridParam",'selrow');
	$("#frmAmbiente .form i").remove();
    if (id) {
        var data = $("#table_ambiente").jqGrid('getRowData',id);
        $('#id_ambiente').val(id);
        $('#slct_filial_edit').val(data.cfilial);
        $('#slct_tipo_ambiente').val(data.ctipamb);        
        $('#txt_nro_ambiente').val(data.numamb);
        $('#txt_capacidad').val(data.ncapaci);
        $('#txt_metroscuadrados').val(data.nmetcua);
        $('#txt_maquinas').val(data.ntotmaq);

		$('#frmAmbiente input[type="text"],#frmAmbiente select').attr('disabled','true');
		$('#txt_nro_ambiente').attr('disabled','true');
		$('#slct_estado').removeAttr('disabled');
		$('#txt_capacidad').removeAttr('disabled');
		$('#txt_metroscuadrados').removeAttr('disabled');
		$('#txt_maquinas').removeAttr('disabled');
        $('#btnFormAmbiente').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormAmbiente').html('Modificar');
        $('#frmAmbiente').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Ambiente</b> a Editar')
	}
}

modificarOpcion=function(){    
	var a=new Array();
	var pos=0;
	a[pos] = sistema.requeridoSlct('slct_filial_edit');pos++;
	a[pos] = sistema.requeridoSlct('slct_tipo_ambiente');pos++;
	a[pos] = sistema.requeridoTxt('txt_nro_ambiente');pos++;
	a[pos] = sistema.requeridoTxt('txt_capacidad');pos++;
	a[pos] = sistema.requeridoTxt('txt_metroscuadrados');pos++;
	a[pos] = sistema.requeridoTxt('txt_maquinas');pos++;
	a[pos] = sistema.requeridoSlct('slct_estado');pos++;
	for(var i=0;i<pos;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        ambienteDAO.editAmbiente();
}

