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
        
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_semestres.js"></script>
			
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
						<li id="cron_pag" onClick="sistema.activaPanel('mant_semestre','panel_mant_semestre')" class="active"><span><i class="icon-gray icon-list-alt"></i> Periodos </span></li>						
					</ul>
				</div>  
				<div id="secc-divi" class="secc-divi secc-divi-der"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_mant_semestre" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>GENERACION DE PERIODOS ACADEMICOS</b></div>         
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
                                            </td>                                   
                                            <td class="t-left label">Institución:</td>
                                            <td class="t-left">
                                                <select id="slct_instituto" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Instituto">
                                                		<!--option value="">--Selecione--</option-->
                                                    </optgroup>
                                                </select>
                                            </td>                                            
                                        </tr>    
                                        
                                        
                                        
                                        <tr><td colspan="6">&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="6">
                                                <table width="100%" id="valSemestres" style="display:none">
                                                <tr class="barra4 contentBarra t-blanco t-left">
                                                  <th><i class="icon-white icon-th"></i>
                                                  	  Periodo<input type="hidden" value="1" id="txt_cant_sem" ></th>
                                                  <th>Inicio</th>
                                                  <th>Fecha Inicio Periodo</th>
                                                  <th>Fecha Fin Periodo</th>
                                                  <th>Fecha Inicio Matricula</th>
                                                  <th>Fecha Fin Matricula</th>
                                                  <th>Fecha de Gracia</th>
                                                  <th>Fecha Extemporanea</th>
                                                  <th>&nbsp;</th>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>
                                          <tr id="OperacionSemestres" style="display:none">
                                            <td colspan="7">
                                              <span class="formBotones" id="btn_NuevoConcepto">
                                				<a href="javascript:void(0)" onClick="AgregarSemestre();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar Periodos</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarCambiosSem();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-check"></i>
                                                <span>Guardar Cambios</span>
                                                </a>
                                           	  </span>
                                            </td>
                                          </tr>
                                          <tr><p></tr>
                                          <!--inicio listado-->
                                        <tr>
                        	<td colspan="4">
                               	<div class="corner_top ui-state-default" style="font-weight:bold">
                                <table>
                                    <tr class="" align="center">
                                        <td class="t-center label" width="120">FILIAL</td>
                                        <td class="t-center label" width="120">INSITUTCION</td>
                                        <td class="t-center label" width="120">PERIODO</td>
                                        <td class="t-center label" width="120">INICIO</td>
                                        <td class="t-center label" width="120">FECHA INICIO SEM</td>
                                        <td class="t-center label" width="120">FECHA FIN SEM</td>
                                        <td class="t-center label" width="120">FECHA INICIO MATR</td>
                                        <td class="t-center label" width="120">FECHA FIN MATR</td>
                                        <td class="t-center label" width="120">FECHA GRACIA</td>
                                        <td class="t-center label" width="120">FECHA EXTEMPORANEA</td>
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
                            </td>
                        </tr>
                                        <!--fin listado-->
                                          
                                    </table>
                             	</div>
                            </div>
                            
                        </div>
    				</div>

            	</div>
			</div>
		<?require_once('frmSemestres.php')?>
        
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
