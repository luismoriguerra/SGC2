<?//require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>[]</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
        <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />
       
		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>

		<script type="text/javascript" src="../javascript/dao/DAOregistro.js"></script>
        <script type="text/javascript" src="../javascript/js/js-registro.js"></script>

	</head>

	<body>
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?require_once('ifrm-header.php')?>	
		
		<div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:0px;">
					<ul class="lca" style="display:none">
						<li id="list_inscripcion" onClick="sistema.activaPanel('list_inscripcion','panel_inscripcion')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ficha Inscripción </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
					<div id="panel_inscripcion" style="display:block">
						<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>REGISTROS</b></div>         
					  <div class="cont-der">
                       <table style="width:450px;" align="center"><tr><td>
                       <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL ALUMNO </div>
                        <br>                        	
                        <table class="t-left">                        
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Paterno</td>
                            <td><input type="text" id="txt_paterno" maxlength="50" onKeyPress="return sistema.validaLetras(event)" class="input-large" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Materno</td>
                            <td><input type="text" id="txt_materno" maxlength="50" onKeyPress="return sistema.validaLetras(event)" class="input-large" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Nombre</td>
                            <td><input type="text" id="txt_nombre" maxlength="50" onKeyPress="return sistema.validaLetras(event)" class="input-large" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            DNI</td>
                            <td><input type="text" id="txt_dni" maxlength="8" onKeyPress="return sistema.validaNumeros(event);" class="input-mediun" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Email</td>
                            <td><input type="text" id="txt_email" maxlength="50" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Telefono</td>
                            <td><input type="text" id="txt_tel" maxlength="15" onKeyPress="return sistema.validaNumeros(event);" class="input-mediun" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>                            Celular</td>
                            <td><input type="text" id="txt_cel" maxlength="15" onKeyPress="return sistema.validaNumeros(event);" class="input-mediun" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Carrera</td>
                            <td><select id="slct_carrera">
                            	<option value="">--Seleccione--</option>
                                <option value="ADMINISTRACION DE NEGOCIOS TURISTICOS Y HOTELEROS">ADMINISTRACION DE NEGOCIOS TURISTICOS Y HOTELEROS</option>
                                <option value="ADMINISTRACION, FINANZAS Y NEGOCIOS GLOBALES">ADMINISTRACION, FINANZAS Y NEGOCIOS GLOBALES</option>
                                <option value="CIENCIAS DE LA COMUNICACION">CIENCIAS DE LA COMUNICACION</option>
                                <option value="CONTABILIDAD Y FINANZAS">CONTABILIDAD Y FINANZAS</option>
                                <option value="DERECHO CORPORATIVO">DERECHO CORPORATIVO</option>
                                <option value="INGENIERIA DE SISTEMAS E INFORMATICA">INGENIERIA DE SISTEMAS E INFORMATICA</option>
                                <option value="MARKETING Y NEGOCIOS GLOBALES">MARKETING Y NEGOCIOS GLOBALES</option>
                                <option value="PSICOLOGIA">PSICOLOGIA</option>
                                </select>
                            </td>
                        </tr>
                        </table>
						</div><!--Form-->
                        <table align="center">
                        <tr><td>
                            <div class="formBotones">
                                <a href="javascript:void(0)" onClick="Registrar();" id="btnFormTrabajador" class="btn btn-azul sombra-3d t-blanco">
                                <i class="icon-white icon-download-alt"></i>
                                <span id="spanBtnFormTrabajador">Registrar</span>
                                </a>
                            </div>
                        </td><td>
                            <div class="formBotones">
                                <a href="javascript:void(0)" onClick="Omitir();" id="btnFormTrabajador" class="btn btn-azul sombra-3d t-blanco">
                                <i class="icon-white icon-download-alt"></i>
                                <span id="spanBtnFormTrabajador">Omitir>></span>
                                </a>
                            </div>
                        </td></tr>
                        </table>
                        </div>
					  </div><!-- Mant Promotor y Recepcionista-->
                        
					  </div><!-- Panel de Inscripcion-->
            	</div><!-- Secc Derecha-->
			</div><!-- Cuerpo-->
		</div><!-- Contenido-->
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
