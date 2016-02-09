<div id="frmGruposAcaFecha" title="MANTENIMIENTO GRUPOS ACADEMICOS" class="corner_all" style="background: #ffffff;margin:7px;height: auto;">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
         
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
                                          <td colspan='2' class="t-center" id='secciones'>

                                          </td>
                                            <td class="t-left label">Observacion:</td>
                                            <td>
                                                <textarea name="observacion" id="observacion" cols="30" rows="3"></textarea>
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
