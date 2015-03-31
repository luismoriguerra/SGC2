<div id="frmEquivalencia" title="MANTENIMIENTO OPCIONES DE SISTEMA" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
    <form>
        <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all ">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">

            <tr class="FormData">
                <td>1. Seccione un curso Refencia
                    <table id="cursoReferencia">
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Instituto: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_instituto" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                            <td class="t-left label" >
                                <b>Carrera: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_carrera" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curricula: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curricula" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                            <td class="t-left label" >
                                <b>Modulo: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_modulo" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>

                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curso: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curso" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                            <td class="t-left label" >
                                <b>Tipo de Equivalencia: </b>
                            </td>
                            <td class="t-left">&nbsp;
                                <select id="slct_tequi" style="width:80px">
                                    <option value="r">Regular</option>
                                    <option value="i">Irregular</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>2. Agrege cursos de equivalencia
                <table id="cursosActa">

                </table>
                </td>
            </tr>


            <tr>
                <td  align="center">
                <!-- <a id="aBtnAddEquivalencia" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                    <span id="spanBtnAddquivalencia"></span><span class="icon-hdd"></span>
                </a>
                <a id="btnFormEquivalencia" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                    <span id="spanBtnFormEquivalencia"></span><span class="icon-hdd"></span>
                </a> -->

                <input type="hidden" value="" id="gruequi">
                <span class="formBotones" id="btn_NuevoConcepto">
                    <input type="hidden" value="1" id="txt_cant_cur" >
                    <a href="javascript:void(0)" onClick="AgregarCurso();" class="btn btn-azul sombra-3d t-blanco">
                        <i class="icon-white icon-plus"></i>
                        <span>Agregar curso</span>
                    </a>
                </span>
                <span class="formBotones">
                    <a href="javascript:void(0)" onClick="GuardarCambiosEquivalencia();" class="btn btn-azul sombra-3d t-blanco" id="sendData">
                        <i class="icon-white icon-check"></i>
                        <span>Guardar Cambios</span>
                    </a>
                </span>
            </td>
        </tr>
    </table>
</form>
</div>


<script type="text/template" id="TemplateCurso">
    <tr class="FormData curso-acta">
        <td class="t-left label" >
            <b>Instituto: </b>
        </td>
        <td class="t-left">
            <select id="slct_instituto_asig_<%= id %>" style="width:120px">
                <option value="">--Seleccione--</option>
            </select>
        </td>

        <td class="t-left label" >
            <b>Carrera: </b>
        </td>
        <td class="t-left">
            <select id="slct_carrera_asig_<%= id %>" style="width:120px">
                <option value="">--Seleccione--</option>
            </select>
        </td>

        <td class="t-left label" >
            <b>Curricula: </b>
        </td>
        <td class="t-left">
            <select id="slct_curricula_asig_<%= id %>" style="width:120px">
                <option value="">--Seleccione--</option>
            </select>
        </td>

        <td class="t-left label" >
            <b>Modulo: </b>
        </td>
        <td class="t-left">
            <select id="slct_modulo_asig_<%= id %>" style="width:120px">
                <option value="">--Seleccione--</option>
            </select>
        </td>

        <td class="t-left label" >
            <b>Curso: </b>
        </td>
        <td class="t-left">
            <select id="slct_curso_asig_<%= id %>" style="width:120px">
                <option value="">--Seleccione--</option>
            </select>
        </td>




        <td class="t-left label" >
            <b>Curso Acta: </b>
        </td>
        <td class="t-left">
            
            <select id="slct_acta_<%= id %>" style="display:none"> </select>
            <span id='txt_acta_span_<%= id %>'></span>
            
        </td>
        <td>
            <span class='formBotones' style=''>
                <a class='btn btn-azul sombra-3d t-blanco' onclick="searchCurso('<%= id %>')" href='javascript:void(0)'>
                    <i class='icon-white icon-search'></i>      
                </a>
            </span>
        </td>





        <td class="t-left" >
           <span class='formBotones' style=''>
                <a class='btn btn-azul sombra-3d t-blanco' onclick="RemoverCurso(this)" href='javascript:void(0)'>
                    <i class='icon-white icon-remove'></i>      
                </a>
            </span>
    </td>
</tr>

</script>
<div id="tablecurso" style="display: none;">
     <section>
                              <article style="margin-right:3px">
                                <table id="table_curso"></table>
                                <div id="pager_table_curso"></div>
                              </article>
                            </section>

</div>
