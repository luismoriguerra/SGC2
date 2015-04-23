<div id="frmGruposAca" title="MANTENIMIENTO GRUPOS ACADEMICOS" class="corner_all" style="background: #ffffff;margin:7px;height: auto;">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
         <tr>
                                        	<td class="t-left label">Turno:</td>
                                            <td class="t-left">
                                                <input type="hidden" value="" id="cgruaca" name="cgruaca" >
                                              <select id="slct_turno_edit" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                            <td class="t-left label">Horario:</td>
                                            <td class="t-left">
                                              <select id="slct_horario_edit" class="input-large"><option value="">--Selecione--</option></select>
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Agregar Día:</td>
                                            <td class="t-left">
                                            <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="AgregarDiaEdit();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Día</span>
                                                </a>
                                            </span>
                                            </td>
                                            <td class="t-left label">Días:</td>
                                            <td class="t-left">
                                              <select style="display:none" id="slct_dia_edit" class="input-mediun">
                                              </select>
                                              <table id="td-dias_edit">
                                              <tr id="quita_1"><td>
                                              
                                              </td><td>
                                              <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="QuitarDia('quita_1');" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove-sign"></i>                            
                                                </a>
                                              </span>
                                              </td>
                                              </tr>
                                              </table>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Fecha Inicio:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_fecha_inicio_edit" onChange="sistema.validaFecha('txt_fecha_inicio_edit','txt_fecha_final_edit');" style="width:65px">  
                                            </td>
                                            <td class="t-left label">Fecha Final:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_fecha_final_edit" onChange="sistema.validaFecha('txt_fecha_inicio_edit','txt_fecha_final_edit');" style="width:65px"> 
                                            </td>
                                        </tr> 
                                        <tr>
                                        	<td class="t-left label">Meta a Matric.</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_meta_mat_edit" onkeypress="return sistema.validaNumeros(event)" style="width:65px">  
                                            </td>
                                          <td class="t-left label">Meta Mínimo.</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_meta_min_edit" onkeypress="return sistema.validaNumeros(event)" style="width:65px">  
                                            </td>                                            
                                        </tr>
                                        <tr>
                                          <td class="t-left label">Cant. Secciones:</td>
                                            <td class="t-left">
                                              <a class="btn btn-azul sombra-3d t-blanco" onclick="AgregarSeccion();" href="javascript:void(0)">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Sección</span>
                                              </a>  
                                            </td>                                          
                                        </tr>
                                        <tr>
                                          <td colspan='2' class="t-center" id='secciones'>

                                          </td>                                           
                                        </tr>
                                        <tr>
            <td colspan="4" align="center">
              <a id="btnFormGruposAca" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px;width: 70px;">
              <span id="spanBtnFormGruposAca">Actualizar</span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
                
        </table>
    </div>