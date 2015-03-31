<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SGC2</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />
        <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.css" />
        <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.filter.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
		
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.filter.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.min.js"></script>
        
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOconcepto.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_concep.js"></script>
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
						<li id="mant_concept" onClick="sistema.activaPanel('mant_concept','panel_mant_conc')" class="active"><span><i class="icon-gray icon-list-alt"></i> Conceptos </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    <div id="panel_mant_conc" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>MANTENIMIENTO DE CONCEPTOS</b></div>         
                        <div class="cont-der">
                          <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                      <tr>
                                          <td class="t-left label">Filial:</td>
                                          <td class="t-left">
                                                <select id="slct_filial" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Filial">
                                                		<option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                                <input type='hidden' id='validacuentas' value='ok'>
                                          </td>                                        
                                          <td class="t-left label">Institución:</td>
                                          <td class="t-left">
                                              <select id="slct_instituto" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>                            
                                      </tr> 
                                      <tr>
                                          <td style="display:none" class="t-left label">Tipo de Carrera:</td>
                                          <td style="display:none">
                                            <select id="slct_tipo_carrera" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>
                                          <td class="t-left label">Tipo de Pago:</td>
                                          <td class="t-left">
                                            <select id="slct_tipo_pago" class="input-large">
                                            	<option value="">--Selecione--</option>
                                                <option value="O">OFICINA</option>
                                                <option value="C">CAMPO</option>
                                            </select>
                                          </td>
                                       	  <td class="t-left label" style="display:none">Modalidad:</td>
                                          <td style="display:none">
                                              <select id="slct_modalidad" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td class="t-left label">Cuenta de Ingreso:</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_cuenta_ing" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span style="display:none" class="formBotones" id="btn_NuevaCtaIng">
                                				<a href="javascript:void(0)" onClick="NuevaCtaIng();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Cuenta de Ingreso</span>
                                                </a>
                                           	  </span>
                                          </td>
                                      </tr>
                                      <tr id="valNuevaCtaIng" style="display:none">
                                          <td class="t-left label">Nueva Cuenta de Ingreso:</td>
                                          <td colspan="5" class="t-left">
                                              <input type="text" id="txt_NuevaCtaIng" value="" class="input-xlarge"/>
                                              &nbsp;
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarNuevaCtaIng();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Guardar</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="CancelarNuevaCtaIng();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove"></i>
                                                <span>Cancelar</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="t-left label">Sub Cuenta 1</td>
                                          <td colspan="3" class="t-left">
                                              <select id="slct_subcta_1" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span style="display:none" class="formBotones" id="btn_NuevaSubCta1">
                                				<a href="javascript:void(0)" onClick="NuevaSubCta1();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Sub-Cuenta 1</span>
                                                </a>
                                           	  </span>
                                          </td>
                                          <td class="t-left label">Para todas las Carreras?</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_todas_carreras" class="input-mediun" onChange="VisualizarCarreras();">
                                              <option value="">--Selecione--</option>
                                              <option value="SI" selected>SI</option>
                                              <option value="NO">NO</option>
                                              </select>
                                           </td>
                                        </tr>
                                        <tr id="valNuevaSubCta1" style="display:none">
                                          <td class="t-left label">Nueva Sub Cuenta 1:</td>
                                          <td colspan="5" class="t-left">
                                              <input type="text" id="txt_NuevaSubCta1" value="" class="input-xlarge"/>
                                              &nbsp;
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarNuevaSubCta1();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Guardar</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="CancelarNuevaSubCta1();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove"></i>
                                                <span>Cancelar</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="t-left label">Sub Cuenta 2</td>
                                          <td colspan="3" class="t-left">
                                              <select id="slct_subcta_2" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span class="formBotones" id="btn_NuevaSubCta2" style="display:none">
                                				<a href="javascript:void(0)" onClick="NuevaSubCta2();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Sub-Cuenta 2</span>
                                                </a>
                                           	  </span>
                                          </td>
                                          <td class="escondecar t-left label">Carreras:</td>
                                          <td class="escondecar t-left">
                                                <select id="slct_carrera" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Carrera">
                                                		<option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                          </td>
                                        </tr>
                                        <tr id="valNuevaSubCta2" style="display:none">
                                          <td class="t-left label">Nueva Sub Cuenta 2:</td>
                                          <td colspan="5" class="t-left">
                                              <input type="text" id="txt_NuevaSubCta2" value="" class="input-xlarge"/>
                                              &nbsp;
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarNuevaSubCta2();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Guardar</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="CancelarNuevaSubCta2();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove"></i>
                                                <span>Cancelar</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr height="30px">
                                          <td>&nbsp;</td>
                                          <td colspan="5">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td colspan="6">
                                          	<table width="100%" id="valConceptos" style="display:none">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th><i class="icon-white icon-th"></i></th>
                                              <th>Filial</th>
                                              <th>Carrera</th>
                                              <th>Descripcion</th>
                                              <th>Cuota(s)</th>
                                              <th>Monto</th>
                                              <th>Cuota(s) PROM</th>
                                              <th>Monto PROM</th>
                                              <th>Estado</th>
                                              <th>&nbsp;</th>
                                            </tr>
                                            </table>
                                            </tr>
                                          <tr id="OperacionConceptos" style="display:none">
                                            <td colspan="7">
                                              <span class="formBotones" id="btn_NuevoConcepto">
                                				<a href="javascript:void(0)" onClick="AgregarConcepto();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Concepto</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarCambiosConcep();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-check"></i>
                                                <span>Guardar Cambios</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="DescartaCambiosConcep();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-trash"></i>
                                                <span>Descartar Cambios</span>
                                                </a>
                                           	  </span>
                                            </td>
                                          </tr>
                                          </td>
                                        </tr>
                                  </table>
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
