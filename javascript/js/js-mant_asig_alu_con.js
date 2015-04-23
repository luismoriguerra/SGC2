$(document).ready(function(){
	//curricula == plan_curricular + curricula
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
  $('#btnActProc').click(actualizaActProc);
  jqGridPersona.personaIngAlum4();
  jqGridPersona.AlumProc();
  $('#table_persona_ingalum').jqGrid('hideCol','sermatr');
  $('#table_persona_ingalum').jqGrid('hideCol','dcodlib');
  $('#table_persona_ingalum').jqGrid('hideCol','dhorari');
  $('#table_persona_ingalum').jqGrid('hideCol','finicio');

  subirDAO.uploadImportarsilabo();
  $('#cancelaProcImportar').click(cancelaProcesarImportar);
  $('#ProcImportar').click(procesarImportar);


  $('#frmProcedencia').dialog({
    beforeClose: function (event, ui) { return CloseDialog(); },
    closeOnEscape: true, 
    autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
  });
  
  personaDAO.ListarCiclos(sistema.llenaSelect,"slct_ciclo","");
        
});

CloseDialog=function() {
    if($("#msg_resultado_importar").css("display")!='none'){
      sistema.msjAdvertencia("Falta confirmar o cancelar el archivo que subio, favor de verificar",4000);
      return false;
    }
}

procesarImportar=function(){
    var arch=$('#hddFileImportar').val();//valida si se subio archivo
    if(arch==''){
        sistema.msjAdvertencia('No ha subido Archivo');return false;
    }
    subirDAO.procesaArchivoImportarSilabo();
}

cancelaProcesarImportar=function(){
  $('#hddFileImportar').val('');
  $('#spanImportar').html('');
  $('#msg_resultado_importar').css('display', 'none');
}

actualizaActProc=function(){
  if($.trim($('#txt_cingalu').val())==''){
    sistema.msjAdvertencia('Selecione <b>Alumno</b>');
  }
  else if($.trim($('#txt_dinstpro').val())==''){
    sistema.msjAdvertencia('Ingrese el <b>Instituto</b> de procedencia');
  }
  else if($.trim($('#txt_dcarpro').val())==''){
    sistema.msjAdvertencia('Ingrese la <b>Carrera</b> de procedencia');
  }
  else{
    personaDAO.ActProc()
  }
}

eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow'); 
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
    $('#txt_cgracpr').val(id.split("-")[1]);
    $('#span_nombre').html(data.dnomper+" "+data.dappape+" "+data.dapmape);
    $('#span_dinstit').html(data.dinstit);
    $('#span_dcarrer').html(data.dcarrer);
    $('#span_dinstip').html(data.dinstip);
    $('#span_dcarrep').html(data.dcarrep);
    $('#txt_dinstpro').val(data.dinstip);
    $('#txt_dcarpro').val(data.dcarrep);
    LimpiarTextos();
      $("#table_curso_proc").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_AlumProc&cingalu='+$('#txt_cingalu').val()}); 
      $("#table_curso_proc").trigger('reloadGrid'); 
      //personaDAO.ListarProc(); 
    }else {
      sistema.msjAdvertencia('Seleccione <b>Alumno</b> para listar sus cursos')
  }
}

LimpiarTextos=function(){
//$('#txt_dinstpro,#txt_dcarpro').val('');
}

add_jqgrid=function(){
  $("#frmProcedencia .form i").remove();
  $('#frmProcedencia input[type="text"],#frmProcedencia select').val(''); 
  $("#slct_estado").attr("disabled","true");
  $("#slct_estado").val('1');
  $("#tabla_archivos").css('display','none');
  $('#btnFormProcedencia').attr('onclick', 'nuevo()');
  $('#spanBtnFormProcedencia').html('Guardar');
  $('#frmProcedencia').dialog('open'); 
}

// campos a enviar al ajax para insertar
nuevo=function(){
  var a=new Array();
  a[0] = sistema.requeridoTxt('txt_daspral');
  a[1] = sistema.requeridoSlct('slct_ciclo');
  a[2] = sistema.requeridoTxt('txt_ncredit');
  a[3] = sistema.requeridoTxt('txt_nhorteo');
  a[4] = sistema.requeridoTxt('txt_nhorpra');
  a[5] = sistema.requeridoSlct('slct_estado');
  for(var i=0;i<6;i++){
    if(!a[i]){
    return false;
    break;        
    }
  }
        personaDAO.addProcedencia();
  //si valida todo envia a insertar persona
//  personalDAO.InsertarPersonal();
}

edit_jqgrid=function(){
  var id=$("#table_curso_proc").jqGrid("getGridParam",'selrow');
  $("#frmProcedencia .form i").remove();
    if (id) {
        var data = $("#table_curso_proc").jqGrid('getRowData',id);
        $('#txt_caspral').val(id);
        $('#slct_ciclo').val(data.cciclo);        
        $('#txt_daspral').val(data.daspral);
        $('#txt_nhorpra').val(data.nhorpra);
        $('#txt_nhorteo').val(data.nhorteo);
        $('#txt_ncredit').val(data.ncredit);
        $('#slct_estado').val(data.cestado);
        $("#tabla_archivos").css('display','');
        $('#slct_estado').removeAttr('disabled');
        $('#listado_archivos').html(data.csilabo.split(",").join("<br>"));
        $('#btnFormProcedencia').attr('onclick', 'modificar()');
        $('#spanBtnFormProcedencia').html('Modificar');
        $('#frmProcedencia').dialog('open'); 
    }else {
      sistema.msjAdvertencia('Seleccione <b>Curso de Procedencia</b> a Editar')
  }
}

modificar=function(){    
  var a=new Array();   
  a[0] = sistema.requeridoTxt('txt_daspral');
  a[1] = sistema.requeridoSlct('slct_ciclo');
  a[2] = sistema.requeridoTxt('txt_ncredit');
  a[3] = sistema.requeridoTxt('txt_nhorteo');
  a[4] = sistema.requeridoTxt('txt_nhorpra');
  a[5] = sistema.requeridoSlct('slct_estado');
  for(var i=0;i<6;i++){
    if(!a[i]){
    return false;
    break;        
    }
  }

    if($("#msg_resultado_importar").css("display")!='none'){
      sistema.msjAdvertencia("Falta confirmar o cancelar el archivo que subio, favor de verificar",4000);
      return false;
    }
        personaDAO.editProcedencia();
}