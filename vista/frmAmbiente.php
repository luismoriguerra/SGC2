<div id="frmAmbiente" title="MANTENIMIENTO DE AMBIENTES" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
           <tr class="FormData">
            <td class="t-left label" >
              <b>Ode: </b>
            </td>
            <td id="id_filial" style="display:none" class="t-left">
              <select id="slct_filial" class="input-xlarge" style="width: 370px;display:none" multiple>
                <optgroup label="Filial">
                  <option value="">--Selecione--</option>
                  </optgroup>
              </select>              
            </td>
            <td id="id_filial_edit" style="display:none">
              <select id="slct_filial_edit" style="width:120px;">
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr> 
          <tr class="FormData">
            <td class="t-left label" >
              <b>Tipo Ambiente: </b>
            </td>
            <td class="t-left">
              <select id="slct_tipo_ambiente" style="width:120px">
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>    
          <tr>
            <td class="t-left label">Nro Ambiente</td>
              <td class="t-left">
              <input type="text" id="txt_nro_ambiente" maxlength="20" class="input-mini" onkeypress="return sistema.validaAlfanumerico(event)" style="width:65px">  
              </td>                                            
          </tr>
          <tr>
            <td class="t-left label">Capacidad a foro</td>
              <td class="t-left">
              <input type="text" id="txt_capacidad" maxlength="3" class="input-mini" onkeypress="return sistema.validaNumeros(event)" style="width:65px">  
              </td>                                            
          </tr>
          <tr>
            <td class="t-left label">Metros cuadrados</td>
              <td class="t-left">
              <input type="text" id="txt_metroscuadrados" maxlength="3" class="input-mini" onkeypress="return sistema.validaNumeros(event)" style="width:65px">  
              </td>                                            
          </tr>
          <tr>
            <td class="t-left label">Total Máquinas</td>
              <td class="t-left">
              <input type="text" id="txt_maquinas" maxlength="3" class="input-mini" onkeypress="return sistema.validaNumeros(event)" style="width:65px">  
              </td>                                            
          </tr>        
          <tr class="FormData">
            <td class="t-left label" >
              <b>Estado: </b>
            </td>
            <td class="t-left">&nbsp;
              <select id="slct_estado">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <a id="btnFormAmbiente" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
              <span id="spanBtnFormAmbiente"></span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
        </table>
    </div>