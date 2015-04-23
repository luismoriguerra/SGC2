$(document).ready(function(){
	//curricula == plan_curricular + curricula
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo

  $(':text[id^="txt_fecha"]').datepicker({
    dateFormat:'yy-mm-dd',
    dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
    monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    nextText:'Siguiente',
    prevText:'Anterior'
  });
  personaDAO.ListarCiclos(sistema.llenaSelect,'slct_ciclos','');
  jqGridPersona.personaIngAlum4();
  $('#table_persona_ingalum').jqGrid('hideCol','sermatr');
  $('#table_persona_ingalum').jqGrid('hideCol','dcodlib');
  $('#table_persona_ingalum').jqGrid('hideCol','dhorari');
  $('#table_persona_ingalum').jqGrid('hideCol','finicio');   

  $('#btnResCancelar').click(cancelar);
  $('#btnResGuardar').click(guardar);
  $('#btnResNuevo').click(nuevo);
  $('#btnResEditar').click(editar);

  $('#btnGuardarAsiCon').click(guardarAsiCon);
  
  
});
var totalgeneral=0;
guardarAsiCon=function(){
   var idg='';
   var error='';
   var datos=new Array();
   var pos=0;
   if($("#slct_resolucion").val()!=''){

    $("#tabla_destino input[type=checkbox]:checked").each(function(){
      idg=this.id.split("_")[1];
      datos[pos]=this.value+'_'+$("#slct_resolucion").val().split("_")[0]+"_"+$("#slct_curso_destino_"+idg).val().split("-").join("_")+"_"+$("#slct_estado_destino_"+idg).val();
      pos++;
      
      if(error==''){
          if($.trim($("#slct_ciclo_destino_"+idg).val())==''){
            sistema.msjAdvertencia('Seleccione Ciclo Destino');
            $("#slct_ciclo_destino_"+idg).focus();
            error='ok';
          }
          else if($.trim($("#slct_curso_destino_"+idg).val())==''){
            sistema.msjAdvertencia('Seleccione Curso Destino');
            $("#slct_curso_destino_"+idg).focus();
            error='ok';
          }  
      }
      
    });

    if(error==''){
      personaDAO.RegistrarAsiCon(datos);
    }

  }
  else{
    sistema.msjAdvertencia('Seleccione Resolucion');
    $("#slct_resolucion").focus();
  }
}

MostrarCursosCiclo=function (id,val) {
  $('#slct_curso_destino_'+id).find('option').css('display','none');
  $('#slct_curso_destino_'+id+' option:contains("--Seleccione--")').css('display','');
  $('#slct_curso_destino_'+id+' option[value^="'+val+'-"]').css('display','');
}

ImprimeDetalle=function(id,val){
  if(val!=''){
    $("#div_nhorteo_destino_"+id).html(val.split("_")[2]);
    $("#div_nhorpra_destino_"+id).html(val.split("_")[3]);
    $("#div_ncredit_destino_"+id).html(val.split("_")[4]);
    $("#div_silabo_destino_"+id).html(val.split("_")[5]);
  }
  else{
    $("#div_nhorteo_destino_"+id).html("-");
    $("#div_nhorpra_destino_"+id).html("-");
    $("#div_ncredit_destino_"+id).html("-");
    $("#div_silabo_destino_"+id).html("-"); 
  }
}

ListarResolucion=function(selecciona){
$('#slct_resolucion').html('');
personaDAO.ListarResolucion(sistema.llenaSelect,'slct_resolucion',selecciona);  
var ht='';
  ht=' <tr><td colspan="7" class="label"><b>Procedencia</b></td></tr>'+
      '<tr">'+
      ' <td class="label">N°</td>'+
      ' <td class="label">Ciclo</td>'+
      ' <td class="label">Asignatura</td>'+
      ' <td class="label">H. Teorica</td>'+
      ' <td class="label">H. Practica</td>'+
      ' <td class="label">N. Credito</td>'+
      ' <td class="label">Tiene silabo?</td>'+
      '  </tr>';
  $("#tabla_procedencia").html(ht);
  ht=' <tr><td colspan="8" class="label"><b>Destino</b></td></tr>'+
      '<tr">'+
      ' <td class="label">N°</td>'+
      ' <td class="label">Ciclo</td>'+
      ' <td class="label">Asignatura</td>'+
      ' <td class="label">H. Teorica</td>'+
      ' <td class="label">H. Practica</td>'+
      ' <td class="label">N. Credito</td>'+
      ' <td class="label">Tiene silabo?</td>'+
      ' <td class="label">Elimina</td>'+
      '  </tr>';
  $("#tabla_destino").html(ht);
}

listacursos=function(){
  personaDAO.listarCursoProcedencia(htmlListarCursoProcedencia);
}

htmlListarCursoProcedencia=function(obj){

  var ht='';
  ht=' <tr><td colspan="7" class="label"><b>Procedencia</b></td></tr>'+
      '<tr">'+
      ' <td class="label">N°</td>'+
      ' <td class="label">Ciclo</td>'+
      ' <td class="label">Asignatura</td>'+
      ' <td class="label">H. Teorica</td>'+
      ' <td class="label">H. Practica</td>'+
      ' <td class="label">N. Credito</td>'+
      ' <td class="label">Tiene silabo?</td>'+
      '  </tr>';
  $("#tabla_procedencia").html(ht);
  ht=' <tr><td colspan="8" class="label"><b>Destino</b></td></tr>'+
      '<tr">'+
      ' <td class="label">N°</td>'+
      ' <td class="label">Ciclo</td>'+
      ' <td class="label">Asignatura</td>'+
      ' <td class="label">H. Teorica</td>'+
      ' <td class="label">H. Practica</td>'+
      ' <td class="label">N. Credito</td>'+
      ' <td class="label">Tiene silabo?</td>'+
      ' <td class="label">Elimina</td>'+
      '  </tr>';
  $("#tabla_destino").html(ht);

  var htm='';
  var htm2='';
  var total=0;
  var chk='';
  var disabled="";
  var valuearray=new Array();
  $.each(obj,function(index,value){
    total = total + 1 ;
    valuearray[0]=value.dciclo;
    valuearray[1]=value.daspral;
    valuearray[2]=value.nhorteo;
    valuearray[3]=value.nhorpra;
    valuearray[4]=value.ncredit;
    valuearray[5]=value.silabo;
    valuearray[6]=value.caspral;

    htm="<tr style='height:30px' class='ui-widget-content jqgrow ui-row-ltr'>";
    htm+="<td class='t-left'><span>";
    htm+="  <a onClick='AdiccionarRegistro("+'"'+valuearray.join("^^")+'"'+");' class='button fm-button ui-corner-all fm-button-icon-left'>";
    htm+="  <span>"+total+"</span>";
    htm+="  <span class='ui-icon ui-icon-plus'></span>";
    htm+="  </a>";
    htm+="</span></td>";
    htm+="<td class='t-left input-small'>"+value.dciclo+"</td>";
    htm+="<td class='t-left input-large'>"+value.daspral+"</td>";
    htm+="<td class='t-center'>"+value.nhorteo+"</td>";
    htm+="<td class='t-center'>"+value.nhorpra+"</td>";
    htm+="<td class='t-center'>"+value.ncredit+"</td>";
    htm+="<td class='t-left'>"+value.silabo+"</td>";
    htm+="</tr>";
      if($.trim(value.casicon)!=''){
        chk="<input type='checkbox' id='chk_"+total+"' value='"+value.casicon+"_"+value.caspral+"' checked='checked' disabled>";
        disabled="";
      }
      else{
        chk="<input type='checkbox' id='chk_"+total+"' value='nuevo_"+value.caspral+"'>"; 
        disabled="disabled";
      }
    htm2="<tr style='height:30px' class='ui-widget-content jqgrow ui-row-ltr'>";
    htm2+="<td class='t-left'>"+total+chk+"</td>";
    htm2+="<td class='t-left'><select id='slct_ciclo_destino_"+total+"' class='input-small' onChange='MostrarCursosCiclo("+total+",this.value);'></select></td>";
    htm2+="<td class='t-left'><select id='slct_curso_destino_"+total+"' class='input-large' onChange='ImprimeDetalle("+total+",this.value)'></select></td>";
    htm2+="<td class='t-center'><div id='div_nhorteo_destino_"+total+"'>-</div></td>";
    htm2+="<td class='t-center'><div id='div_nhorpra_destino_"+total+"'>-</div></td>";
    htm2+="<td class='t-center'><div id='div_ncredit_destino_"+total+"'>-</div></td>";
    htm2+="<td class='t-left'><div id='div_silabo_destino_"+total+"'>-</div></td>";
    htm2+="<td class='t-left'><select id='slct_estado_destino_"+total+"' class='input-mini' onChange='verificaEstado(this.id,this.value);' "+disabled+"><option value='1' selected=selected>NO</option><option value='0'>SI</option></select></td>";
    htm2+="</tr>";

    $("#tabla_procedencia").append(htm);
    $("#tabla_destino").append(htm2);

    $('#slct_ciclo_destino_'+total).html($('#slct_ciclos').html());
    $('#slct_ciclo_destino_'+total).val(value.cciclo);

    $('#slct_curso_destino_'+total).html($('#slct_curso_destino').html());
    $('#slct_curso_destino_'+total).find('option').css('display','none');
    $('#slct_curso_destino_'+total+' option:contains("--Seleccione--")').css('display','');
    if($.trim(value.casicon)!=''){
      MostrarCursosCiclo(total,value.cciclo);
      $('#slct_curso_destino_'+total+' option[value^="'+value.idg+'"]').attr('selected','true');
      ImprimeDetalle(total,$('#slct_curso_destino_'+total).val());
    }    
    
  });

  totalgeneral=total;
}

AdiccionarRegistro=function(val){
  totalgeneral++;
  var htm='';
  var htm2='';
  var value=new Array(); 
  value=val.split("^^");
    htm="<tr style='height:30px' class='ui-widget-content jqgrow ui-row-ltr'>";
    htm+="<td class='t-left'>"+totalgeneral+"</td>";
    htm+="<td class='t-left input-small'>"+value[0]+"</td>";
    htm+="<td class='t-left input-large'>"+value[1]+"</td>";
    htm+="<td class='t-center'>"+value[2]+"</td>";
    htm+="<td class='t-center'>"+value[3]+"</td>";
    htm+="<td class='t-center'>"+value[4]+"</td>";
    htm+="<td class='t-left'>"+value[5]+"</td>";
    htm+="</tr>";

        chk="<input type='checkbox' id='chk_"+totalgeneral+"' value='nuevo_"+value[6]+"'>"; 
        disabled="disabled";
      
    htm2="<tr style='height:30px' class='ui-widget-content jqgrow ui-row-ltr'>";
    htm2+="<td class='t-left'>"+totalgeneral+chk+"</td>";
    htm2+="<td class='t-left'><select id='slct_ciclo_destino_"+totalgeneral+"' class='input-small' onChange='MostrarCursosCiclo("+totalgeneral+",this.value);'></select></td>";
    htm2+="<td class='t-left'><select id='slct_curso_destino_"+totalgeneral+"' class='input-large' onChange='ImprimeDetalle("+totalgeneral+",this.value)'></select></td>";
    htm2+="<td class='t-center'><div id='div_nhorteo_destino_"+totalgeneral+"'>-</div></td>";
    htm2+="<td class='t-center'><div id='div_nhorpra_destino_"+totalgeneral+"'>-</div></td>";
    htm2+="<td class='t-center'><div id='div_ncredit_destino_"+totalgeneral+"'>-</div></td>";
    htm2+="<td class='t-left'><div id='div_silabo_destino_"+totalgeneral+"'>-</div></td>";
    htm2+="<td class='t-left'><select id='slct_estado_destino_"+totalgeneral+"' class='input-mini' onChange='verificaEstado(this.id,this.value);' "+disabled+"><option value='1' selected=selected>NO</option><option value='0'>SI</option></select></td>";
    htm2+="</tr>";

    $("#tabla_procedencia").append(htm);
    $("#tabla_destino").append(htm2);

    $('#slct_ciclo_destino_'+totalgeneral).html($('#slct_ciclos').html());
    $('#slct_curso_destino_'+totalgeneral).html($('#slct_curso_destino').html());
}

verificaEstado=function(id,valor){
  if(valor=='0'){
    if(!confirm("Esta seleccionando para eliminar este registro al guardar los cambios, favor acepte si esta seguro")){
      $("#"+id).val('1');
    }
  }
}

cancelar=function(){
limpiarResolucion();
$('#tabla_resolucion').css('display','none');
}

limpiarResolucion=function(){
$('#tabla_resolucion input[type="text"],#tabla_resolucion input[type="hidden"],#tabla_resolucion select').val('');
}

guardar=function(){
  if($.trim($('#txt_nrescon').val())==''){
    sistema.msjAdvertencia('Ingrese Nro Resolucion');
  }
  else if($.trim($('#txt_dautres').val())==''){
    sistema.msjAdvertencia('Ingrese quien autoriza resolucion');
  }
  else if($.trim($('#txt_fecha').val())==''){
    sistema.msjAdvertencia('Ingrese fecha de resolucion');
  }
  else{
    if($.trim($('#txt_crescon').val())==''){
      personaDAO.guardarResolucion();
    }
    else{
      personaDAO.editarResolucion(); 
    }
  }
}

nuevo=function(){
  if($.trim($("#txt_cingalu").val())!=''){
    limpiarResolucion();
    $('#tabla_resolucion').css('display','');
    $('#txt_nrescon').focus();
  }
  else{
    sistema.msjAdvertencia('Seleccione a Alumno para generar su resolucion');
  }
}

editar=function(){
  if($.trim($("#slct_resolucion").val())!=''){
    $('#tabla_resolucion').css('display','');
    $('#txt_crescon').val($("#slct_resolucion").val().split("_")[0]);
    $('#txt_nrescon').val($("#slct_resolucion").val().split("_")[1]);
    $('#txt_dautres').val($("#slct_resolucion").val().split("_")[2]);
    $('#txt_fecha').val($("#slct_resolucion").val().split("_")[3]);
  }
  else{
    sistema.msjAdvertencia('Seleccione una referencia para editar');
    $('#slct_resolucion').focus();
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
    personaDAO.ListarProc2();
    ListarResolucion('');
    personaDAO.ListarCursoDestino(sistema.llenaSelect,'slct_curso_destino','');
    }
    else {
      sistema.msjAdvertencia('Seleccione <b>Alumno</b> para listar sus cursos')
  }
}

