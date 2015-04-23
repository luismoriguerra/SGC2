<div id="frmProfes" title="MANTENIMIENTO PROFESORES" class="corner_all" style="background: #ffffff;margin:7px;height: auto; display:none;">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
           <tr class="FormData">
            <td class="t-left label" >
              <b>Filial</b>
            </td>
            <td class="t-left">&nbsp;
              <select id="slct_filial">;
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Instituto: </b>
            </td>
            <td class="t-left">
              <select id="slct_instituto" style="width:120px">
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label"  >
              <b>Fecha Ingreso</b>
            </td>
            <td class="t-left">&nbsp;
              <!-- <input type="hidden" id="id_cencap" value="" /> -->
              <input type="text" id="txt_fecha_ingreso" value=""  style="width:200px"/>
            </td>
          </tr>
          <tr>
            <td class="t-left label input-xlarge"><b>Persona:</b></td>
            <td>
                <input type="text" id="txt_persona" class="input-xlarge" disabled>
                <input type="hidden" id="cperson">
                <span class="formBotones">
                    <a href="javascript:void(0)" onClick="ListarPersona();" id="btnMantPersona" class="btn btn-azul sombra-3d t-blanco">
                        <i class="icon-white icon-search"></i>
                        <span id="spanBtnMantpersona"></span>
                    </a>
                </span>
            </td>                            
        </tr>
        <tr id="mantenimiento_persona" style="display:none">
            <td colspan="2">
              <div style="margin-right:3px">
                <table id="table_persona"></table>
                <div id="pager_table_persona"></div>
              </div >                             
            </td>
        </tr>
        <tr class="FormData  profesPeso" style="display: none">
            <td class="t-left label" >
              <b>Peso</b>
            </td>
            <td class="t-left">&nbsp;
                <input type="text" id="txt_peso" class="input-xsmall" value="0">
              
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Estado</b>
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
              <input type="hidden" id="cprofes">
              <a href="javascript:void(0)" onClick="GuardarDocente();" id="btnFormCencap" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
              <span id="spanBtnFormCencap">Guardar</span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
        </table>
    </div>