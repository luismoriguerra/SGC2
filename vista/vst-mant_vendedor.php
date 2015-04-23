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

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOubigeo.js"></script>
         <script type="text/javascript" src="../javascript/jqGrid/JqGridMantVendedor.js"></script>
         <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
        <script type="text/javascript" src="../javascript/js/js-persona.js"></script>
        <script type="text/javascript" src="../javascript/js/js-persona2.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Vendedor <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Mantenimiento Vendedor(es) <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der" style="text-align: center">
							<? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */
							?>
                           <table align="center">
                           	<tr>
                            	<td class="ui-state-default">Seleccione:
                                </td>
                                <td><select id="slct_vendedor" onChange="ActVisualiza()">                                    </select></td>
                            </tr>
                           </table>
                           <br>
                           <br>
                           <div id="mantenimiento_jqgrid_vended">
                           	  <div style="margin-right:3px">
                                <table id="table_jqgrid_vended"></table>
                                <div id="pager_table_jqgrid_vended"></div>
                              </div >
                           </div>
                            
                           <div id="frmTrabajador" title="MANTENIMIENTO VENDEDOR">
						<div class="form">
						<table style="width:1000px;" align="center"><tr><td>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS PERSONALES</div>
                        <br>                        	
                        <table class="t-left">                        
                        <tr>
                            <td class="ui-state-default">Paterno:
                            <input type="hidden" id="cvended">
                            <input type="hidden" id="tvended">
                            </td>
                            <td colspan="2"><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_paterno_t" class="input-large"></td>
                            <td class="ui-state-default">Estado:</td>
                            <td>
                                <select id="slct_estado_t" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                                </select>
                            </td>
                            
                            <td class="ui-state-default">Centro Ope Ven:</td>
                            <td>
                                <select id="slct_opeven" class="input-medium">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="ui-state-default">Materno:</td>
                            <td colspan="2"><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_materno_t" class="input-large"></td>
                            <td class="ui-state-default">Fecha Retiro:</td>
                            <td><input type="text" id="txt_fecha_retiro_t" class="input-medium" value="" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Nombre(s):</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre_t" class="input-large"></td>
                        </tr>                        
                        </table>                        
                        <table class="t-left">
                        <tr>
                        	<td class="ui-state-default">Tipo Trabajador:</td>
                            <td>
                                <select id="slct_tipo_trabajador_t" class="input-medium" disabled>
                                <option value="">--Selecione--</option>                                
                                </select>
                            </td>
                            <td class="ui-state-default">Email:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_email_t" class="input-large" ></td>
                            <td class="ui-state-default">Tel/Cel:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_celular_t" class="input-medium" ></td>
                        </tr>
                        <tr>                            
                            <td class="ui-state-default">DNI</td>
                            <td>
                                <input type="text" onKeyPress="return sistema.validaDni(event,'txt_dni_t')" id="txt_dni_t" class="input-medium">
                            </td>
                            <td class="ui-state-default">Genero:</td>
                            <td>
                                <select id="slct_sexo_t" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                </select>
                            </td>
                            <td class="ui-state-default">Fecha Ingreso:</td>
                            <td><input type="text" id="txt_fecha_ingreso_t" class="input-medium" value="" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento_t" class="input-medium" onChange="cargarProvinciat();">
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia_t" class="input-medium" onChange="cargarDistritot();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito_t" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </table>                        
                        <table class="t-left">
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Código Interno:</td>
                            <td colspan="5">
                            <input type="text" id="txt_codigo_interno_t" maxlength="20" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-medium" >
                            <td class="ui-state-default">Dirección:</td>
                            <td colspan="5">
                            <input type="text" id="txt_direccion_t" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>
                        </tr>
                        </table>                        
                        </td></tr>
                        </table>
						</div><!--Form-->
                        <div class="formBotones">
							<a href="javascript:void(0)" id="btnFormTrabajador" class="btn btn-azul sombra-3d t-blanco">
							<i class="icon-white icon-download-alt"></i>
							<span id="spanBtnFormTrabajador"></span>
							</a>
						</div>
					  </div>
                            
                            <!--fin mantenimiento persona-->
                            
                            
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
