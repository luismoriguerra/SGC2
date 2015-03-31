$().ready(function(){


	cencapDAO.cargarFiliales(sistema.llenaSelect,"slct_filial","");
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,"slct_instituto","");
		/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});


$('#frmProfes').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});

//validacion para saber si estamos en la pagina profesPeso
if(typeof systemPage !== "undefined" ){
    if( systemPage.page === "profesPeso" ){
        
        //si estoy en el ambiente de profesPeso
        //Cargo grid peso
        jqGridDocente.DocenteMantePeso();
        //Mostrar campos solo para profesPeso
        $(".profesPeso").show();
    }
    else{
        jqGridDocente.DocenteMante();
    }

}else{

    jqGridDocente.DocenteMante();

}



jqGridPersona.persona();

});


ListarPersona=function(){
	var dis=$("#mantenimiento_persona").css("display");
	if(dis=='none'){
	$("#mantenimiento_persona").css("display",'');
	}
	else{
	$("#mantenimiento_persona").css("display",'none');
	}
    $('#frmProfes').dialog("option", "position", "center");

}

cargar_persona_jqgrid=function(){
	var id="";	
	id=$("#table_persona").jqGrid("getGridParam",'selrow');
	
    if (id) {
        var data = $("#table_persona").jqGrid('getRowData',id);
        $('#cperson').val(id);
        $('#txt_persona').val(data.dappape + ' '+ data.dapmape + ', ' +  data.dnomper  );
  //       $('#txt_materno_c').val(data.dapmape);
		// $('#txt_nombre_c').val(data.dnomper);
		// $('#txt_email_c').val(data.email1);        
  //       $('#txt_celular_c').val(data.ntelpe2);
		// $('#txt_telefono_casa_c').val(data.ntelper);
		// $('#txt_telefono_oficina_c').val(data.ntellab);
		// $('#slct_estado_civil_c').val(data.cestciv);
		// $('#txt_dni_c').val(data.ndniper);
		// $('#slct_sexo_c').val(data.tsexo);
		// $('#txt_fecha_nacimiento_c').val(data.fnacper);
		// $('#slct_departamento_c').val(data.coddpto);
		// if(data.coddpto!=''){
		// ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c',data.codprov);	
		// ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c','slct_distrito_c',data.coddist);		
		// }
		// $('#txt_colegio_c').val(data.dcolpro);
		// $('#slct_Tipo_c').val(data.tcolegi);

		$("#mantenimiento_persona").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Cargar')
	}
}

function docente_agregar(){

//LIMPIAR CAMPOS
$('#slct_filial').val("");
$('#slct_instituto').val("");
$("#txt_fecha_ingreso").val("") ;
$("#cperson").val("") ;
$("#txt_persona").val("") ;
$("#slct_estado").val("1") ;
$("#txt_peso").val("0") ;
$("#btnMantPersona").show();
$("#txt_fecha_ingreso").removeAttr('disabled');

$('#btnFormCencap').attr('onclick', 'GuardarDocente()');
$('#spanBtnFormCencap').html('Guardar');
$('#frmProfes').dialog('open');	
}

function GuardarDocente(){
	
	var a = new Array();
    a[0] = sistema.requeridoSlct('slct_filial');
    a[1] = sistema.requeridoSlct('slct_instituto');
    a[2] = sistema.requeridoTxt('txt_fecha_ingreso');
    a[3] = sistema.requeridoTxt('txt_persona');
    

    for (var i = 0; i < 4; i++) {
        if (!a[i]) {
            return false;
            break;
        }
    }

    
    profesDAO.InsertarDocente();
    

}



function docente_editar(){

	var id = $("#table_docente").jqGrid("getGridParam", 'selrow');
    $("#frmProfes i").filter(".icon-red").remove();
    $('#frmProfes').dialog("option", "position", "center");

    if (id) {
        var data = $("#table_docente").jqGrid('getRowData', id);
        // console.log(data);
        // console.log(id);
        
        $('#cprofes').val(id);
       //CARGANDO DATOS 1 SECCION DE SELECTS 
        $("#slct_filial").val(data.cfilial);
        $("#slct_instituto").val(data.cinstit);
        $("#txt_fecha_ingreso").val(data.fingreso);
        $("#cperson").val(data.cperson);
        $("#txt_persona").val(data.dappape + ' ,'+ data.dapmape + ' ,'+ data.dnomper);
        $("#slct_estado").val(data.cestado);
        $("#txt_peso").val(data.peso);

        $("#btnMantPersona").hide();
        $("#txt_fecha_ingreso").attr("disabled","");

        $('#btnFormCencap').attr('onclick', 'docente_editar_guardar()');
        $('#spanBtnFormCencap').html('Modificar');
        $('#frmProfes').dialog('open');
    } else {
        sistema.msjAdvertencia('Seleccione <b>Profesor</b> a Editar')
    }
}

function docente_editar_guardar(){

var a = new Array();
    a[0] = sistema.requeridoSlct('slct_filial');
    a[1] = sistema.requeridoSlct('slct_instituto');
    a[2] = sistema.requeridoTxt('txt_fecha_ingreso');
    a[3] = sistema.requeridoTxt('txt_persona');
    a[4] = sistema.requeridoTxt('txt_peso');

    for (var i = 0; i < 5; i++) {
        if (!a[i]) {
            return false;
            break;
        }
    }

    profesDAO.ActualizarDocente();
    

}






