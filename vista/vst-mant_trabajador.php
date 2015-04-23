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
 
         <script type="text/javascript" src="../javascript/jqGrid/JqGridMantTrabajador.js"></script>
         <script type="text/javascript" src="../javascript/dao/DAOTrabajador.js"></script>
         <script type="text/javascript" src="../javascript/dao/DAOubigeo.js"></script>
        <script type="text/javascript" src="../javascript/js/js-trabajador.js"></script>
        <script type="text/javascript" src="../javascript/js/js-Trabajador2.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Trabajador <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Mantenimiento Trabajador(es) <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der" style="text-align: center">
							<? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */
							?>
                           
                              <div style="margin-right:3px">
                                <table id="table_Trabajador"></table>
                                <div id="pager_table_Trabajador"></div>
                              </div >                             
                            
                            <!--mantenimieto Trabajador-->
                            
                            <div id="frmTrabajador" title="MANTENIMIENTO TRABAJADOR">
						<div class="form">
						<table style="width:1000px;" align="center"><tr><td>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL TRABAJADOR</div>
                        <br>                        	
                        <table class="t-left">                        
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Paterno:
                            <input type="hidden" id="cperson">
                            </td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_paterno" class="input-large"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Materno:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_materno" class="input-large"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Nombre(s):</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre" class="input-large"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Estado Civil:</td>
                            <td>
                                <select id="slct_estado_civil" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="S">Soltero(a)</option>
                                <option value="C">Casado(a)</option>
                                <option value="D">Divorsiado(a)</option>
                                <option value="V">Viudo(a)</option>
                                <option value="C2">Comprometido(a)</option>
                                </select>
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>DNI</td>
                            <td>
                                <input type="text" onKeyPress="return sistema.validaDni(event,'txt_dni')" id="txt_dni" class="input-medium">
                            </td>
                            <td class="ui-state-default">Fecha Nacimiento:</td>
                            <td><input type="text" id="txt_fecha_nacimiento" class="input-medium" ></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Genero:</td>
                            <td>
                                <select id="slct_sexo" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                </select>
                            </td>                            
                        </tr>
                      	</table>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> UBICACION DE LA PERSONA</div>
                        <br>
                        <table class="t-left">
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Email:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_email" class="input-large" ></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Celular:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_celular" class="input-medium" ></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Tel Casa:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_casa" class="input-medium" ></td>
                            <td class="ui-state-default">Tel Ofic:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_oficina" class="input-medium"></td>
                        </tr>                        
                        <tr>
                            <td class="ui-state-default">Dirección:</td>
                            <td colspan="5">
                            <input type="text" id="txt_direccion" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>
                        </tr>
                        <tr>                        	
                            <td class="ui-state-default">Referencia:</td>
                            <td colspan="5">
                            <input type="text" id="txt_referencia" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento" class="input-medium" onChange="cargarProvincia();">
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia" class="input-medium" onChange="cargarDistrito();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>                        
                        <tr>
                        	<td class="ui-state-default">Nombre Empresa:</td>
                            <td>
                            <input type="text" id="txt_nombre_trabajo" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" >
                            </td>                        	
                            <td class="ui-state-default">Dirección Empresa:</td>
                            <td colspan="3">
                            <input type="text" id="txt_direccion2" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>                            
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento2" class="input-medium" onChange="cargarProvincia2();" >
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia2" class="input-medium" onChange="cargarDistrito2();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito2" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </table>
                        <div style="display:none" class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL COLEGIO</div>
                        <br>
                        <TABLE class="t-left">
                        <tr>
                        	<td class="ui-state-default">Colegio:</td>
                            <td colspan="2">
                            	<input type="text" id="txt_colegio" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" >                            
                            </td>
                            <td class="ui-state-default">Tipo:</td>
                            <td>
                                <select id="slct_Tipo" class="input-medium" >
                                <option value="">--Selecione--</option>
                                <option value="1">Nacional</option>
                                <option value="2">Particular</option>
                                <option value="3">Parroquia</option>
                                <option value="4">FFAA</option>
                                <option value="5">FFPP</option>
                                </select>
                            </td>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        </TABLE>
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
                            
                            <!--fin mantenimiento Trabajador-->
                            
                            
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
