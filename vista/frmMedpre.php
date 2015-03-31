<div id="frmMedpre" title="MANTENIMIENTO DE MEDIOS DE COMUNICACIÓN MASIVA" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
           
            <tr class="FormData filiales" style="display:none">
            <td class="t-left label">Filial:</td>
            <td class="t-left">
                <select id="slct_filiales" class="input-xlarge" style="width: 370px; display: none;" multiple>
                        <optgroup label="Filial">
                                <option value="">--Selecione--</option>
                    </optgroup>
                </select>
            </td>
          </tr>
            
            <tr class="FormData filial">
            <td class="t-left label" >
              <b>Filial</b>
            </td>
            <td class="t-left">
              <select id="slct_filial">
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>
            <tr class="FormData">
            <td class="t-left label"  >
              <b>Nombre</b>
            </td>
            <td class="t-left">
              <input type="hidden" id="id_opcion" value="" />
              <input type="text" id="txt_descrip" value=""  style="width:200px"/>
            </td>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Tipo</b>
            </td>
            <td class="t-left">&nbsp;
              <select id="slct_tipo">             
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <a id="btnFormMedpre" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
              <span id="spanBtnFormMedpre"></span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
        </table>
    </div>