<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>Telesup</title>
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
        
		<script type="text/javascript" src="../javascript/dao/DAOcronograma.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_gen_crop.js"></script>
			
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
						<li id="cron_pag" onClick="sistema.activaPanel('cron_pag','panel_crono_pago')" class="active"><span><i class="icon-gray icon-list-alt"></i> Cronog. Pago</span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_crono_pago" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>GENERACION DE CRONOGRAMAS DE PAGO</b></div>         
                        <div class="cont-der">
							<div class="t-center">
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                        <tr>
                                            <td class="t-left label">ODE:</td>
                                            <td class="t-left">
                                                <select id="slct_filial" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Filial">
                                                		<option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>                                   
                                            <td class="t-left label">Institución:</td>
                                            <td class="t-left">
                                              <select id="slct_instituto" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>                                            
                                        </tr>    
                                        <tr>
                                        	<!--td class="t-left label">Modalidad:</td>
                                            <td class="t-left">
                                              <select id="slct_modalidad" class="input-large"><option value="">--Selecione--</option></select>
                                            </td-->                                        	
                                            <td class="t-left label" style="display:none">Tipo de Carrera:</td>
                                            <td class="t-left" style="display:none">
                                              <select id="slct_tipo_carrera" class="input-large"><option value="2" selected>Profesional</option></select>
                                            </td>
                                            <td class="t-left label">Ciclo Académico:</td>
                                            <td class="t-left">
                                              <select id="slct_semestre" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                             <td class="t-left label">Inicio:</td>
                                            <td class="t-left">
                                              <select id="slct_inicio" class="input-large"><option value="">--Selecione--</option></select>
                                              <div id="fechas_semestre"></div>
                                            </td> 
                                        </tr>    
                                        <tr>
                                        	<td class="t-left label">Carrera:</td>
                                            <td class="t-left">
                                              <select id="slct_carrera" class="input-xlarge" style="width: 370px;" multiple>
                                                    <optgroup label="Carrera">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td> 
                                        	<!-- <td class="t-left label">Curricula:</td>
                                            <td colspan="3" class="t-left">
                                              <select id="slct_curricula" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                            </td> -->
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Ciclo de Estudios:</td>
                                            <td class="t-left">
                                              <select id="slct_ciclo" class="input-large"><option value="">--Selecione--</option></select>
                                            </td> 
                                        	<td colspan="2" class="">&nbsp;</td>                                         
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Conceptos Pension:</td>
                                            <td class="t-left">
                                              <select id="slct_concepto" onChange="LimpiaFechas()" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Concepto">
                                                		<option value="">--Selecione--</option>
                                                    </optgroup>
                                              </select>
                                            </td> 
                                        	<td colspan="2" class="">&nbsp;</td>
                                            
                                        </tr>
                                        <tr><td colspan="6">&nbsp;</td></tr>
                                        <tr><td colspan="6"><span class="formBotones">
                                                                <a href="javascript:void(0)" onClick="ListarFechas();" class="btn btn-azul sombra-3d t-blanco">
                                                                <i class="icon-white icon-th-list"></i>
                                                                <span>Listar Fechas</span>
                                                                </a>
                                                            </span></td></tr>
                                        <tr><td colspan="6">&nbsp;</td></tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="4">
                                                <table id="valFechasCronograma" style="display:none" width="60%" align="center">
                                                    <tr>
                                                        <td class="t-left label"><div align="center"> Fechas de Pagos : </div></td>
                                                    </tr>
                                                    <tr>
                                                    	<td>
                                                    	<table align="center" id="detalle_fechas">                                                        </table>
                                                        </td>
                                                    </tr>                                                    
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr>
                                                        <td class="t-left"><div align="center">
                                                            <span class="formBotones">
                                                                <a href="javascript:void(0)" onClick="guardarCronograma();" class="btn btn-azul sombra-3d t-blanco">
                                                                <i class="icon-white icon-download-alt"></i>
                                                                <span>Guardar</span>
                                                                </a>
                                                            </span></div>
                                                        </td>
                                                    </tr> 
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                            </tr>
                                    </table>
                             	</div>
                                <br><br>
                                <div>
                                	<div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table>
                                        <tr class="" align="center">
                                        	<td class="t-center label"><input type="checkbox" onChange="sistema.checkall('lista_grupos','chk-todo')" id="chk-todo"></td>
                                            <td class="t-center label">DETALLE</td>
                                            <td class="t-center label" width="120">FILIAL</td>
                                            <td class="t-center label" width="120">INSTITUCION</td>
                                            <td class="t-center label" width="120">CURRICULA</td>
                                            <td class="t-center label" width="120">CARRERA</td>
                                            <td class="t-center label" width="120">CICLO</td>
                                            <td class="t-center label" width="120">TURNO</td>
                                            <td class="t-center label" width="120">SEMESTRE</td>
                                            <td class="t-center label" width="120">INICIO</td>
                                            <td class="t-center label" width="120">F INICIO</td>
                                            <td class="t-center label" width="120">F FIN</td>
                                            <td class="t-center label" width="120">HORARIO</td>
                                            <td class="t-center label" width="120">DIAS </td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 200px">
                                    <table id="lista_grupos" cellspacing="1" cellpadding="1" border="1"> </table>
                                    </div>
                                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onClick="sistema.mostrar_cerrar_buscar('txtGruposAcademicos','buscarGruposAcademicos')">
                                        <i id="buscarGruposAcademicos" class="icon-gray icon-search"></i>
                                        </span>
                                        
                                        <span style="display:inline-block;vertical-align:top">
                                        <input id="txtGruposAcademicos" class="input_buscar" type="text" style="width: 150px;display: none;" onKeyUp="sistema.buscarEnTable(this.value,'lista_grupos')">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
    				</div>

            	</div>
			</div>
			<div id="frmDetGru" title="CRONOGRAMA DE PAGOS" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
                <div>
                    <div class="corner_top ui-state-default" style="font-weight:bold">
                    <table>
                        <tr class="" align="center">                            
                            <td class="t-center label" width="315">CONCEPTO</td>
                            <td class="t-center label" width="375">FECHAS</td>
                        </tr>
                    </table>
                    </div>
                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 200px">
                    <table id="lista_grupos_detalle" cellspacing="1" cellpadding="1" border="1"> </table>
                    </div>
                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onClick="sistema.mostrar_cerrar_buscar('txtGruposAcademicosDetalle','buscarGruposAcademicosDetalle')">
                        <i id="buscarGruposAcademicosDetalle" class="icon-gray icon-search"></i>
                        </span>
                        
                        <span style="display:inline-block;vertical-align:top">
                        <input id="txtGruposAcademicosDetalle" class="input_buscar" type="text" style="width: 150px;display: none;" onKeyUp="sistema.buscarEnTable(this.value,'lista_grupos_detalle')">
                        </span>
                    </div>
                </div>
			    
        	</div>
		
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
