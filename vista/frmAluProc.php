<div id="frmProcedencia" title="MANTENIMIENTO" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table>
          <tr><td>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
           <tr class="FormData">
            <td class="t-left label" >
              <b>Asig. Procedencia: </b>
            </td>
            <td class="t-left">
              <input type='hidden' id='txt_caspral' value=''>
              <input type='text' id='txt_daspral' value='' class='input-large' onKeyPress="return sistema.validaLetras(event)" />
            </td>
          </tr>
           <tr class="FormData">
            <td class="t-left label" >
              <b>Ciclo: </b>
            </td>
            <td class="t-left">
              <select id="slct_ciclo" class='input-mediun'>
              <option value="">--Seleccione--</option>
              </select>
            </td>
          </tr>           
          <tr class="FormData">
            <td class="t-left label" >
              <b>Nro. Crédito: </b>
            </td>
            <td class="t-left">
              <input type='text' id='txt_ncredit' maxlength='2' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Nro. Hora Teórica: </b>
            </td>
            <td class="t-left">
              <input type='text' id='txt_nhorteo' maxlength='2' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
            </td>
          </tr>
          <tr class="FormData">
            <td class="t-left label" >
              <b>Nro. Hora Práctica: </b>
            </td>
            <td class="t-left">
              <input type='text' id='txt_nhorpra' maxlength='2' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
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
              <a id="btnFormProcedencia" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
              <span id="spanBtnFormProcedencia"></span><span class="icon-hdd"></span>
              </a>
            </td>
          </tr>
        </table>
          </td><td>
        <table id="tabla_archivos" style='display:none'>
          <th class="t-left label">Archivos</th>
          <tr class="FormData">
            <td id='listado_archivos'>              
            </td>
          </tr>
          <tr>
            <td >
                <div style="margin:10px;">
                    <div id="file_uploadImportar" class="file_upload btn btn-azul sombra-i" style="display:inline-block;">
                        <form action="" method="POST" enctype="multipart/form-data" class="file_upload" style="text-align:left">
                            <input type="hidden" name="error" value="0" id="loadHeaderError" />
                            <input type="hidden" name="error" value="" id="loadHeaderErrorMsg" />
                            <input type="file" name="file[]" id="dirImportar" style="display:block">
                                <button type="submit">Upload</button>
                                <i class="icon-white icon-upload"></i> <span>Seleccionar archivo a Importar</span>
                        </form>
                    </div>
                </div>
                <div style="display:inline-block;margin:10px;">
                    <table id="filesImportar">
                        <tbody>
                            <tr class="file_upload_template" style="display:none;">
                                <td class="file_upload_preview"></td>
                                <td class="file_name"></td>
                                <td class="file_size"></td>
                                <td class="file_upload_progress"><div></div></td>

                                <td class="file_upload_start"><button>Start</button></td>
                                <td class="file_upload_cancel"><button>Cancel</button></td>
                            </tr>
                            <tr class="file_download_template" style="display:none;">
                                <td class="file_download_preview"></td>
                                <td class="file_name"><a></a></td>
                                <td class="file_size"></td>
                                <td class="file_download_delete" colspan="3"><button>Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="file_upload_overall_progress"><div style="display: none; " class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%; "></div></div></div>
                    <div class="file_upload_buttons"></div>
                </div>
                <div class="t-center">
                    <div id="msg_resultado_importar" style="display:none;vertical-align: middle;">
                        <b>Archivo cargado:</b>
                        <span id="spanImportar" style="border: 1px solid #888;padding: 2px 10px;"></span>
                        <input type="hidden" id="hddFileImportar" value=""/>
                        <a id="ProcImportar" class="btn btn-gris sombra-i" href="javascript:void(0)">GUARDAR</a>
                        <a id="cancelaProcImportar" class="btn btn-gris sombra-i" href="javascript:void(0)">CANCELAR</a>
                    </div>
                </div>
            </td>
          </tr>
        </table>
          </td></tr>
        </table>
    </div>