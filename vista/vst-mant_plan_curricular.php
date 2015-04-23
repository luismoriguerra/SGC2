<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SGC2</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
                <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
                <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>
                
<!--                <script src="../javascript/jqGrid/JQGridPlancurricular.js"></script>-->
                
		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
                
                <script type="text/javascript" src="../javascript/dao/DAOcurso.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
                <script type="text/javascript" src="../javascript/dao/DAOplancurricular.js"></script>
                <script type="text/javascript" src="../javascript/js/js-plan_curricular.js"></script>
    </head>

	<body> 
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?require_once('ifrm-header.php')?>	
		<?require_once('ifrm-nav.php')?>	
        <div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:0px;">
					<ul class="lca" style="display:none">
						<li id="mant_concept" onClick="sistema.activaPanel('mant_modulos','panel_mant_modulo')" class="active"><span><i class="icon-gray icon-list-alt"></i> Plan curricular </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-der"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    <div id="panel_mant_modulo" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>CREAR PLAN CURRICULAR</b></div>         
                        <div class="cont-der">
                          <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                      <tr>                    
                                          <td class="t-left label">Institución:</td>
                                          <td class="t-left">
                                              <select id="slct_instituto" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>                                          
                                      </tr>
                                      <tr>
                                      	  <td class="t-left label">Carrera:</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_carrera" class="input-xlarge"><option value="">--Selecione--</option></select>
                                          </td>          
                                      </tr>
                                      
                                      <tr>
                                          <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr id="valCurriculasTot">
                                          <td colspan="6">
                                          <table width="100%" id="valcurriculas">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th colspan="6"><i class="icon-white icon-th"></i> CURRICULA</th>
                                            </tr>
                                            </table>
                                          </td>
                                      </tr>
                                      <tr>                                  
                                          <td class="t-left label">Curricula:</td>
                                          <td class="t-left">
                                              <select id="slct_curricula" class="input-xlarge"><option value="">--Selecione--</option></select>
                                          </td>      
                                          
                                          <td class="t-left">
                                               <span class="formBotones" id="btn_nuevaCurricula">
                                		<a href="javascript:void(0)" onClick="AgregarCurricula();" class="btn btn-azul sombra-3d t-blanco">
                                                    <i class="icon-white icon-plus"></i>
                                                    <span>Agregar</span>
                                                </a>
                                           	 </span>
                                                 
                                          </td>
                                      </tr>
                                      
                                      <tr class='nuevaCurricula campos' style='display:none;'>
                                         <td colspan='6'>
                                             <table>
                                                  <tr class="barra4 contentBarra t-blanco t-left">
                                                      <th colspan="6"><i class="icon-white icon-th"></i>NUEVA CURRICULA</th>
                                                  </tr>
                                                  <tr>
                                                    <td class="t-left label">Titulo:</td>
                                                    <td colspan="5" class="t-left"><input type='text' id='txt_nc_titulo' value='' class='input-' /> </td> 
                                                    <td class="t-left label">Nro Resulucion:</td>
                                                    <td colspan="5" class="t-left"> <input type='text' id='txt_nro_resolu' value='' class='input' /> </td> 
                                                    
                                                    <td class="t-left">
                                                        <span class="formBotones" id="btn_guardarCurricula">
                                                         <a href="javascript:void(0)" onClick="GuardarCurricula();" class="btn btn-azul sombra-3d t-blanco">
                                                             <i class="icon-white icon-plus"></i>
                                                             <span>Guardar</span>
                                                         </a>
                                                        </span>
                                                        <span class="formBotones" id="btn_descartarCurricula">
                                                         <a href="javascript:void(0)" onClick="DescartarCurricula();" class="btn btn-azul sombra-3d t-blanco">
                                                             <i class="icon-white icon-retweet"></i>
                                                             <span>Descartar</span>
                                                         </a>
                                                        </span>
                                                    </td>
                                                  
                                                  </tr>    
                                                 <tr> <td colspan="6">&nbsp;</td>  </tr> 
                                             </table>
                                             
                                         </td> 
                                      </tr>
                                      <tr>                                  
                                          <td class="t-left label">Modulos:</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_modulo" class="input-xlarge"><option value="">--Selecione--</option></select>
                                          </td>          
                                      </tr>
                                      
                                      <tr>
                                          <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr id="valPlancurricularTotTitle">
                                          <td colspan="6">
                                          <table width="100%" id="valcurriculas">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th colspan="6"><i class="icon-white icon-th"></i> Plan Curricular</th>
                                            </tr>
                                            </table>
                                          </td>
                                      </tr>
                                    <tr id="valPlancurricularTot" style="display:none">
                                          <td colspan="6">
                                          <table width="100%" id="valPlancurricular">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th><i class="icon-white icon-th"></i></th>
                                              <th>Codigo</th>
                                              <th>Curso</th>
                                              <th>Nro Creditos</th>
                                              <th>Hrs. Teoricas</th>
                                              <th>Hrs. Practicas</th>
                                              <th>Cursos Req</th>
                                              <th>Estado</th>
                                              <th>Actualiza</th>
                                            </tr>
                                            </table>
                                          </td>
                                      </tr>
                                      
                                      <tr>
                                          <td colspan="6">&nbsp;</td>
                                      </tr>
                                      <tr id="PlanCurCampos" class='PlanCurCampos title' style="display:none">
                                          <td colspan="6">
                                          <table width="100%" id="">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th colspan="6"><i class="icon-white icon-th"></i> Campos del Curso</th>
                                            </tr>
                                            </table>
                                          </td>
                                      </tr>
                                      <tr id="PlanCurCampos" class='PlanCurCampos fields' style="display:none">
                                          <td colspan="6">
                                          <table width="100%" id="ValCampos">
                                            <tr class="">
                                                <td class="t-left label">Curso:</td>
                                                <td colspan="5" class="t-left">
                                                  <select id="slct_curso" class="input-xlarge" ><option value="">--Selecione--</option></select>
                                                </td>
                                                <!--estado-->
                                                <td class="t-left label">Estado:</td>
                                                <td colspan="5" class="t-left">
                                                  <select id="slct_estado" class="input-medium">
                                                      <option value="1">Activo</option>
                                                      <option value="0">Inactivos</option>
                                                  </select>
                                                </td>
                                                  
                                            </tr>
                                            <tr class="">
                                                     
                                                <td class="t-left label">Nro Creditos:</td>
                                                <td colspan="2" class="t-left">
                                                  <input type='text' id='txt_nro_creditos' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
                                                </td>
                                                <td class="t-left label">Horas Teoricas:</td>
                                                <td colspan="2" class="t-left">
                                                  <input type='text' id='txt_nro_teo' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
                                                </td>
                                                <td class="t-left label">Horas Practicas:</td>
                                                <td colspan="2" class="t-left">
                                                  <input type='text' id='txt_nro_pra' value='' class='input-mini' onKeyPress="return sistema.validaNumeros(event)" />
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                               <table class="PlanCurRequerimientos">
                                                   
                                               </table> 
                                            </tr>
                                            </table>
                                          </td>
                                      </tr>
                                      
                                      <tr id="OperacionModulos"  style="display:none">
                                          <td colspan="7">
                                              
                                              <span class="formBotones" id="btn_AgregarReq" style="display:none;">
                                		<a href="javascript:void(0)" onClick="AgregarReq();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-th-list"></i>
                                                <span>Agregar un curso requerido</span>
                                                </a>
                                              </span>
                                              
                                              <span class="formBotones" id="btn_NuevoModulo" style="display:none;">
                                		<a href="javascript:void(0)" onClick="AgregarCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Curso</span>
                                                </a>
                                              </span>
                                              
                                              <span class="formBotones" id="btn_GuardaNuevo" style="display:none">
                                				<a href="javascript:void(0)" onClick="GuardarNuevoCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-check"></i>
                                                <span>Guardar Curso</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones" id="btn_Actualizar" style="display:none">
                                				<a href="javascript:void(0)" onClick="ActualizarCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-check"></i>
                                                <span>Actualizar Curso</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones" id="btn_cancelar" style="display:none">
                                				<a href="javascript:void(0)" onClick="DescartaCambiosCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-refresh"></i>
                                                <span>Cancelar</span>
                                                </a>
                                           	  </span>
                                            </td>
                                          </tr>
                                  </table>
                                  
<!--                            <section>
                              <article style="margin-right:3px">
                                <table id="table_plancurricular"></table>
                                <div id="pager_table_plancurricular"></div>
                              </article>
                            </section>-->
                            
                           	  </div>
                            </div>
                        </div>
    				</div>
					
            	</div>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
