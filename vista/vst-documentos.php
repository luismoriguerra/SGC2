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
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/js/js-documentos.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ranking <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
                        <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>DOCUMENTOS DEL ALUMNO <?   /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
							<div class="t-center">
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                       
                                <!--Inicio tabla-->
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
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Semestre:</td>
                                            <td class="t-left">
                                                <!--<select id="slct_semestre" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Semestre">
                                                        <option value="">-Selecione-</option>
                                                    </optgroup>
                                                </select>-->
                                                <select id="slct_semestre" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>
                                            <td class="t-left label">Ciclo:</td>
                                            <td class="t-left">
                                                <select id="slct_ciclo" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>
                                       </tr>   
                                       <tr>
                                            <td class="t-left label input-large">Fechas de Inicio de Grupos:</td>
                                            <td class="t-left">
                                            Del:
                                            <input type="text" id="txt_fecha_inicio" class="input-medium" value="">
                                            Al
                                            <input type="text" id="txt_fecha_fin" class="input-medium" value="">
                                            </td>
                                       </tr>                                      
                                    </table>
                                <!--fin talba-->                                
                                <br>
                                <div>
                                    <span style="margin:15px 0px 10px 0px;">
                                        <a id="btn_listar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                                            <i class="icon-white icon-th"></i>
                                            <span>Listar</span>
                                        </a>
                                    </span>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span style="margin:15px 0px 10px 0px;">
                                        <a id="btn_listar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)" onClick="ExportarGrupoG();">
                                            <i class="icon-white icon-th"></i>
                                            <span>Exportar Todo</span>
                                        </a>
                                    </span>
                                </div>
                                <br>
                                <div id="v_lista_grupo" style="display:none;">
                                	<div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table>
                                        <tr class="" align="center">                                        
                                            <td class="t-center label" width="70">FILIAL</td>
                                            <td class="t-center label" width="70">INSTITUCION</td>
                                            <td class="t-center label" width="150">CURRICULA</td>
                                            <td class="t-center label" width="150">CARRERA</td>
                                            <td class="t-center label" width="90">TURNO</td>
                                            <td class="t-center label" width="90">INICIO</td>
                                            <td class="t-center label" width="150">F.INICIO/F FINAL</td>
                                            <td class="t-center label" width="150">HORARIO</td>
                                            <td class="t-center label" >T.A</td>
                                            <td class="t-center label" >[/]</td>
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
                            	</div><!--fin listado de grupos-->
                                <br>
                                <div id="v_lista_alumnos" style="display:none; width:700px">
                                	<div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table>
                                        <tr class="" align="center">                                        
                                            <td class="t-center label" width="200">PATERNO</td>
                                            <td class="t-center label" width="200">MATERNO</td>
                                            <td class="t-center label" width="200">NOMBRE(S)</td>
                                            <td class="t-center label" width="200">ESTADO</td>
                                            <td class="t-center label" >[/]</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 200px">
                                    <table id="lista_alumnos" cellspacing="1" cellpadding="1" border="1"> </table>
                                    </div>
                                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onclick="sistema.mostrar_cerrar_buscar('txtAlumnos','buscarAlumnos')">
                                        <i id="buscarAlumnos" class="icon-gray icon-search"></i>
                                        </span>
                                        
                                        <span style="display:inline-block;vertical-align:top">
                                        <input id="txtAlumnos" class="input_buscar" type="text" style="width: 150px;display: none;" onkeyup="sistema.buscarEnTable(this.value,'lista_alumnos')">
                                        </span>
                                    </div>
                            	</div><!--fin listado de alumnos-->                                
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
