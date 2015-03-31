<div id="frmHora" title="MANTENIMIENTO OPCIONES DE SISTEMA" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
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
            <td class="t-left label" >
              <b>Turno: </b>
            </td>
            <td class="t-left">
              <select id="slct_turno" style="width:100px">
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>
            <tr class="FormData">
            <td class="t-left label"  >
              <b>Hora de Inicio: </b>
            </td>
            <td class="t-left">
              <input type="hidden" id="id_hora" value="" />
              <input type="text" id="txt_hini" value=""  style="width:30px" maxlength="2" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',2)"/>
              &nbsp; : &nbsp;
              <input type="text" id="txt_mini" value=""  style="width:30px" maxlength="2" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',2)"/>
            </td>
            </tr>
            <tr class="FormData">
            <td class="t-left label"  >
              <b>Hora de Fin: </b>
            </td>
            <td class="t-left">
              <input type="text" id="txt_hfin" value=""  style="width:30px" maxlength="2" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',2)"/>
              &nbsp; : &nbsp;
              <input type="text" id="txt_mfin" value=""  style="width:30px" maxlength="2" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',2)"/>
            </td>
            </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Tipo de Horario: </b>
            </td>
            <td class="t-left">&nbsp;
              <select id="slct_thorari" style="width:80px">
              <option value="R">Regular</option>
              <option value="M">Muerto</option>
              </select>
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Clase Horario: </b>
            </td>
            <td class="t-left">
              <select id="slct_chora" style="width:70px">
              <option value="1">Curso</option>
              <option value="2" selected="selected">Grupo</option>
              </select>
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
              <a id="btnFormHora" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
              <span id="spanBtnFormHora"></span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
        </table>
    </div>