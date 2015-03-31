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
        
		<script type="text/javascript" src="../javascript/dao/DAOconcepto.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_cuenta.js"></script>
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
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>MANTENIMIENTO DE CUENTAS DE INGRESO</b></div>         
                        <div class="cont-der">
                          <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                      <tr>
                                          <td class="t-left label">Cuenta de Ingreso:</td>
                                          <td class="t-left">
                                              <select id="slct_cuenta_ing" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span style="display:" class="formBotones" id="btn_NuevaCtaIng">
                                				<a href="javascript:void(0)" onClick="NuevaCtaIng();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Cuenta de Ingreso</span>
                                                </a>
                                           	  </span>
                                              <span style="display:none" class="formBotones" id="btn_EstCtaIng">
                                				<a href="javascript:void(0)" onClick="CambiarEstCtaIng();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Cambiar Estado</span>
                                                </a>
                                           	  </span>
                                          </td>
                                      </tr>
                                      <tr id="valNuevaCtaIng" style="display:none">
                                          <td class="t-left label">Nueva Cuenta de Ingreso:</td>
                                          <td class="t-left">
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
                                          <td class="t-left">
                                              <select id="slct_subcta_1" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span style="display:none" class="formBotones" id="btn_NuevaSubCta1">
                                				<a href="javascript:void(0)" onClick="NuevaSubCta1();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Sub-Cuenta 1</span>
                                                </a>
                                           	  </span>
                                              <span style="display:none" class="formBotones" id="btn_EstSubCta1">
                                				<a href="javascript:void(0)" onClick="CambiarEstSubCta1();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Cambiar Estado</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr id="valNuevaSubCta1" style="display:none">
                                          <td class="t-left label">Nueva Sub Cuenta 1:</td>
                                          <td class="t-left">
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
                                          <td class="t-left">
                                              <select id="slct_subcta_2" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span class="formBotones" id="btn_NuevaSubCta2" style="display:none">
                                				<a href="javascript:void(0)" onClick="NuevaSubCta2();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Sub-Cuenta 2</span>
                                                </a>
                                           	  </span>
                                              <span style="display:none" class="formBotones" id="btn_EstSubCta2">
                                				<a href="javascript:void(0)" onClick="CambiarEstSubCta2();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Cambiar Estado</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr id="valNuevaSubCta2" style="display:none">
                                          <td class="t-left label">Nueva Sub Cuenta 2:</td>
                                          <td class="t-left">
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
                                          <td>&nbsp;</td>
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
