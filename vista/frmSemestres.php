<div id="frmSemestre" title="MANTENIMIENTO PERIODO" class="corner_all" style="background: #ffffff;margin:7px;height: auto;">
      <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
         	<tr>
                <td class="t-left label">Filial:</td>
                <td class="t-left">
                    <input type="hidden" value="" id="csemaca" name="csemaca" >
                  <select id="slct_filial_edit" class="input-large"><option value="">--Selecione--</option></select>
                </td>
                <td class="t-left label">Instituto:</td>
                <td class="t-left">
                  <select id="slct_instituto_edit" class="input-large" disabled="disabled"><option value="">--Selecione--</option></select>                                              
                </td>
            </tr>
            <tr>
                <td class="t-left label">Periodo</td>
                <td class="t-left">
                <input type="text" id="txt_semestre1_edit" onkeypress="return sistema.validaNumeros(event)" maxlength="4" style="width:70px">
                <input type="text" id="txt_semestre2_edit" onkeypress="return sistema.validaNumeros(event)" maxlength="1" style="width:10px">  
                </td>
                <td class="t-left label">Inicio</td>
                <td class="t-left">
                <input type="text" id="txt_inicio_edit" onkeypress="return sistema.validaLetras(event)" maxlength="1" style="width:10px">  
                </td>                                            
            </tr>
            <tr>
                <td class="t-left label">Fecha Inicio Sem.:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_inicio_sem_edit" onChange="sistema.validaFecha('txt_fecha_inicio_sem_edit','txt_fecha_final_sem_edit');" style="width:65px">  
                </td>
                <td class="t-left label">Fecha Final Sem.:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_final_sem_edit" onChange="sistema.validaFecha('txt_fecha_inicio_sem_edit','txt_fecha_final_sem_edit');" style="width:65px"> 
                </td>
            </tr>
            <tr>
                <td class="t-left label">Fecha Inicio Mat.:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_inicio_mat_edit" onChange="sistema.validaFecha('txt_fecha_inicio_mat_edit','txt_fecha_final_mat_edit');" style="width:65px">  
                </td>
                <td class="t-left label">Fecha Final Mat.:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_final_mat_edit" onChange="sistema.validaFecha('txt_fecha_inicio_mat_edit','txt_fecha_final_mat_edit');" style="width:65px"> 
                </td>
            </tr>
            <tr>
                <td class="t-left label">Fecha de Gracia:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_gra_edit" onChange="sistema.validaFecha('txt_fecha_final_mat_edit','txt_fecha_gra_edit');" style="width:65px">  
                </td>
                <td class="t-left label">Fecha Extemporanea:</td>
                <td class="t-left">
                <input type="text" id="txt_fecha_ext_edit" onChange="sistema.validaFecha('txt_fecha_gra_edit','txt_fecha_ext_edit');" style="width:65px"> 
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                  <a class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px;width: 70px;" onclick="Actualizar();">
                  <span id="spanBtnFormGruposAca">Actualizar</span><span class="icon-hdd"></span>
                  </a>
                </td>
             </tr>                
        </table>
    </div>