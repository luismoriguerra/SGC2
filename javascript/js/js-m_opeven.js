$(document).ready(function(){
	$("#nav-mantenimientos").addClass("ui-corner-all active");
	ubigeoDAO.cargarDepartamento(sistema.llenaSelect,'slct_depa','');
              personaDAO.ListarFiltrobyID(sistema.llenaSelect,"slct_tipo","");
	jQGridCencap.Cencap();  
        
        $('#frmCencap').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});
        
        $("#slct_depa").change(function(){
            cargarProvincia();  cargarDistrito();
        });
        
         $("#slct_prov").change(function(){
            cargarDistrito();
        });
        
        
});

cargarProvincia=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_depa','slct_prov','');	
}

cargarDistrito=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_depa','slct_prov','slct_dist','');
}

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
                var i = 0;
	a[i] = sistema.requeridoTxt('txt_dopeven');
        a[i++] = sistema.requeridoTxt('txt_direc');
	a[i++] = sistema.requeridoSlct('slct_depa');
        a[i++] = sistema.requeridoSlct('slct_prov');
        a[i++] = sistema.requeridoSlct('slct_dist');
        a[i++] = sistema.requeridoSlct('slct_tipo');
	a[i++] = sistema.requeridoSlct('slct_estado');
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
        $('#txt_dopeven').val(data.dopeven);
        $('#txt_direc').val(data.ddiopve);
        $('#id_copeven').val(id);
       
          $('#slct_depa').val(data.coddpto).trigger("change");
          $('#slct_prov').val(data.codprov).trigger("change");
          $('#slct_dist').val(data.coddistr);
          $('#slct_tipo').val(data.ctipcap);
        
        $('#slct_estado').val(data.cestado);
	
        $('#btnFormCencap').attr('onclick', 'modificarPersonal()');
        $('#spanBtnFormCencap').html('Modificar');
        $('#frmCencap').dialog('open');	
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Centro de operación</b> a Editar')
	}
}
modificarPersonal=function(){
    
	var a=new Array();
	 var i = 0;
	a[i] = sistema.requeridoTxt('txt_dopeven');
        a[i++] = sistema.requeridoTxt('txt_direc');
	a[i++] = sistema.requeridoSlct('slct_depa');
        a[i++] = sistema.requeridoSlct('slct_prov');
        a[i++] = sistema.requeridoSlct('slct_dist');
        a[i++] = sistema.requeridoSlct('slct_tipo');
	a[i++] = sistema.requeridoSlct('slct_estado');
	for(var i=0;i<3;i++){
		if(!a[i]){
		return false;
		break;				
		}
	}
        cencapDAO.editCencap();
}

