<?
set_time_limit(300);
require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>Mantenimiento de Asistencia</title>
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
        <script type="text/javascript" src="../javascript/dao/DAOasistencia.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
                <script type="text/javascript" src="../javascript/js/js-mant_asist.js"></script>
			
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
                                              <select id="slct_carrera" class="input-large"><option value="">--Selecione--</option></select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Curricula:</td>
                                            <td class="t-left">
                                              <select id="slct_curricula" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                            </td>
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
                                    </table>
                             	</div>
                            <!--listado de grupos--><p><p>
                            <div class="corner_top ui-state-default" style="font-weight:bold">
                                <table>
                                    <tr class="" align="center">
                                        <td class="t-center label" width="14%">ODE</td>
                                        <td class="t-center label" width="7%">INSITUTCION</td>
                                        <td class="t-center label" width="7%">CURRICULA</td>
                                        <td class="t-center label" width="10%">CARRERA</td>
                                        <td class="t-center label" width="7%">CICLO DE ESTUDIOS</td>
                                        <td class="t-center label" width="7%">TURNO</td>
                                        <td class="t-center label" width="7%">CICLO ACADEMICO</td>
                                        <td class="t-center label" width="7%">INICIO</td>
                                        <td class="t-center label" width="7%">F INICIO</td>
                                        <td class="t-center label" width="7%">F FIN</td>
                                        <td class="t-center label" width="7%">HORARIO</td>
                                        <td class="t-center label" width="7%">DIAS </td>
                                        <td class="t-center label" width="7%">ESTADO</td>
                                        <td class="t-center label" width="7%">ACCIONES</td>
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
                 
               <!--listado de alumnos-->
               <div id="alu_listado" style="display:none">
                   <h2>Asignación de secciones</h2>
                   <br>
                   <table class="listado_alumnos">
                       <tr><td colspan='3'>*Por favor, haga click en las letras para cambiar de seccion.<br></td></tr>
                       <tr>
                           <th class="t-center label">NRO</th>
                           <th class="t-center label">APELLIDOS Y NOMBRES</th>
                           <th class="t-center label">SECCION</th>
                       </tr>
                   </table>
                   <div>
                       <a id="btnCerrarListado" class='btn btn-azul sombra-3d t-blanco'onclick="$('#alu_listado').hide()" ><i class='icon-white  icon-list'></i> Guardar</a>
                   </div>  
               </div>
               <!--fin listado alumnos-->             
                      
               <!--INICIO interfaz de asistencia-->
               <div id="wrap_iu_asist" style="display:none">
                   <h2>Registro de Asistencia</h2>
                   <br>
                   <div id="iu_asist_sec">
                       <table>
                           <tr>
                               <th class="t-center label">Sección</th>
                               <th><select id="iu_select_sec">
                           <option value="A">A</option>
                           <option value="B">B</option>
                           <option value="C">C</option>
                           <option value="D">D</option>
                       </select>
                               <input type="hidden" id="chgrupo" value="">
                               </th>
                           </tr>
                           <tr><th class="t-center label">Fecha de hoy:</th><td><?php print date("Y-m-d");?></td></tr>
                            <tr>
                                <td class="">
                    <div>
                       <a id="btnExportarFormato" class='btn btn-azul sombra-3d t-blanco' >
                           <i class='icon-white  icon-list'></i> Formato de Impresion</a>
                   </div>    
                                </td>
                                <td>
                                     <div>
                       <a id="btnExportarReporte" class='btn btn-azul sombra-3d t-blanco' >
                           <i class='icon-white  icon-list'></i>Reporte de Asistencia</a>
                   </div> 
                                </td>
                            </tr>
                       </table>
                       
                   </div> 
                   <br>
                   <table class="iu_asist" border="1">
                       <tr class='iu_asis_cab'>
                           <th class="t-center label">NRO</th>
                           <th class="t-center label">APELLIDOS Y NOMBRES</th>
                           <th class="t-center label">TEL FIJO/CELULAR</th>
                       </tr>
                   </table>
                   <div>
                       <a id="btnCerrarListado" class='btn btn-azul sombra-3d t-blanco'onclick="$('#wrap_iu_asist').hide()" >
                           <i class='icon-white  icon-list'></i> Guardar</a>
                   </div>
               </div>
               <!--fin interfaz de asistencia-->
               
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
