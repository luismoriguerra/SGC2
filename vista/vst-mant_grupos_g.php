<?
set_time_limit(300);
require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>Telesup | Gestión de Grupos</title>
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
        
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_grupos_g.js"></script>
			
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
						<li id="cron_pag" onClick="sistema.activaPanel('cron_pag','panel_crono_pago')" class="active"><span><i class="icon-gray icon-list-alt"></i> Gestión de Grupos</span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-der"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_crono_pago" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>GESTIÓN DE GRUPOS</b></div>         
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
                                            <td class="t-left label">Carrera:</td>
                                            <td class="t-left">
                                                <select id="slct_carrera" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Carrera">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>                                              
                                            </td>
                                        </tr>
                                        <tr>                                        	
                                            <td class="t-left label">Ciclo Académico:</td>
                                            <td class="t-left">
                                              <select id="slct_semestre" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Ciclo de estudios:</td>
                                            <td class="t-left">
                                              <select id="slct_ciclo" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                            <td class="t-left label">Inicio:</td>
                                            <td class="t-left">
                                              <select id="slct_inicio" class="input-large"><option value="">--Selecione--</option></select>
                                              <div id="fechas_semestre"></div>
                                            </td>
                                        </tr>    
                                        <tr>
                                        	<td class="t-left label">Turno:</td>
                                            <td class="t-left">
                                              <select id="slct_turno" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                            <td class="t-left label">Horario:</td>
                                            <td class="t-left">
                                              <select id="slct_horario" class="input-large"><option value="">--Selecione--</option></select>
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Agregar Día:</td>
                                            <td class="t-left">
                                            <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="AgregarDia();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Día</span>
                                                </a>
                                            </span>
                                            </td>
                                            <td class="t-left label">Días:</td>
                                            <td class="t-left">
                                              <select style="display:none" id="slct_dia" class="input-mediun">
                                              </select>
                                              <table id="td-dias">
                                              <tr id="quita_1"><td>
                                              <select id="slct_dia_1" class="input-mediun">
                                              <option value="">--Selecione--</option>
                                              </select>
                                              </td><td>
                                              <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="QuitarDia('quita_1');" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove-sign"></i>                            
                                                </a>
                                              </span>
                                              </td>
                                              </tr>
                                              </table>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Fecha Inicio:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_fecha_inicio" onChange="sistema.validaFecha('txt_fecha_inicio','txt_fecha_final');" style="width:65px">  
                                            </td>
                                            <td class="t-left label">Fecha Final:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_fecha_final" onChange="sistema.validaFecha('txt_fecha_inicio','txt_fecha_final');" style="width:65px"> 
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Meta a Matricular:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_meta_mat" size="5" maxlength="3" onKeyPress="sistema.validaNumeros(return event);" style="width:65px">  
                                            </td>
                                            <td class="t-left label">Meta Mínima:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_meta_min" size="5" maxlength="3" onKeyPress="sistema.validaNumeros(return event);" style="width:65px">  
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="4" style="text-align:center">
                                            <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="CrearGrupos();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Crear Grupo(s)</span>
                                                </a>
                                            </span>
                                            </td>
                                        </tr>
                                    </table>
                             	</div>
                            <!--listado de grupos--><p><p>
                            <div class="corner_top ui-state-default" style="font-weight:bold">
                                <table>
                                    <tr class="" align="center">
                                        <td class="t-center label" width="120">ODE</td>
                                        <td class="t-center label" width="120">INSITUTCION</td>
                                        <td class="t-center label" width="120">CURRICULA</td>
                                        <td class="t-center label" width="120">CARRERA</td>
                                        <td class="t-center label" width="120">CICLO DE ESTUDIOS</td>
                                        <td class="t-center label" width="120">TURNO</td>
                                        <td class="t-center label" width="120">CICLO ACADEMICO</td>
                                        <td class="t-center label" width="120">INICIO</td>
                                        <td class="t-center label" width="120">F INICIO</td>
                                        <td class="t-center label" width="120">F FIN</td>
                                        <td class="t-center label" width="120">HORARIO</td>
                                        <td class="t-center label" width="120">DIAS </td>
                                        <td class="t-center label" width="120">ESTADO</td>
                                        <td class="t-center label" width="120">ACCIONES</td>
                                    </tr>
                                </table>
                                </div>
                                <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 200px">
                                <table id="lista_grupos" cellspacing="1" cellpadding="1" border="1"> </table>
                                </div>
                                <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                    <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onclick="sistema.mostrar_cerrar_buscar('txtGruposAcademicos','buscarGruposAcademicos')">
                                    <i id="buscarGruposAcademicos" class="icon-gray icon-search"></i>
                                    </span>
                                    
                                    <span style="display:inline-block;vertical-align:top">
                                    <input id="txtGruposAcademicos" class="input_buscar" type="text" style="width: 150px;display: none;" onkeyup="sistema.buscarEnTable(this.value,'lista_grupos')">
                                    </span>
                                </div>
                            
                            
                            <!--fin listado de grupos-->
                            
                            </div>
                            
                        </div>
    				</div>

            	</div>
			</div>
        <?require_once('frmGruposAca.php')?>
		
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
