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
		<script type="text/javascript" src="../javascript/js/js-banco2.js"></script>
			
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
                        <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>EXPORTAR TXT A BANCO <?   /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
							<div class="t-center">
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                       
                                <!--Inicio tabla-->
                                <table style="width:90%">
                                        <tr>
                                            <td class="t-left label input-large">Cuenta de Export. a Bancos:</td>
                                            <td class="t-left">
                                                <select id="txt_detalle_ex" class="input-xxlarge" onChange="verificaNombre();">
                                                    <option value="">--Selecione--</option>
                                                </select>
                                            </td>
                                       </tr>
                                        <tr>
                                            <input type='hidden' id='cfilial' value=''>
                                            <input type='hidden' id='cinstit' value=''>
                                            <input type='hidden' id='cuenta' value=''>
                                            <td class="t-left label input-large">Seleccionar Cuenta:</td>
                                            <td class="t-left">
                                                <select id="slct_cuenta" class="input-xxlarge" onChange="VisualizaAsignacion();" disabled>
                                                    <option value="">--Selecione--</option>
                                                </select>
                                            </td>
                                       </tr>
                                       <tr><td>_</td>
                                           <td>
                                            <div class="corner_top ui-state-default" style="font-weight:bold">
                                                <table>
                                                    <tr class="" align="center">                                                        
                                                        <td class="t-center label" width="150">INSTITUCION</td>                                                        
                                                    </tr>
                                                </table>
                                                </div>
                                                <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 155px">
                                                <table id="lista_instit" cellspacing="1" cellpadding="1" border="1"> </table>
                                                </div>
                                                <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                                    <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onclick="sistema.mostrar_cerrar_buscar('txtinstit','buscarInstit')">
                                                    <i id="buscarInstit" class="icon-gray icon-search"></i>
                                                    </span>
                                                    
                                                    <span style="display:inline-block;vertical-align:top">
                                                    <input id="txtinstit" class="input_buscar" type="text" style="width: 150px;display: none;" 
                                                    onkeyup="sistema.buscarEnTable(this.value,'lista_instit')">
                                                    </span>
                                                </div>
                                            </div>
                                           </td>
                                           <td>_</td>
                                           <td>
                                            <div class="corner_top ui-state-default" style="font-weight:bold">
                                                <table>
                                                    <tr class="" align="center">                                                        
                                                        <td class="t-center label" width="150">FILIAL</td>                                                        
                                                    </tr>
                                                </table>
                                                </div>
                                                <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 155px">
                                                <table id="lista_filial" cellspacing="1" cellpadding="1" border="1"> </table>
                                                </div>
                                                <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                                    <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onclick="sistema.mostrar_cerrar_buscar('txtfilial','buscarFilial')">
                                                    <i id="buscarFilial" class="icon-gray icon-search"></i>
                                                    </span>
                                                    
                                                    <span style="display:inline-block;vertical-align:top">
                                                    <input id="txtfilial" class="input_buscar" type="text" style="width: 150px;display: none;" 
                                                    onkeyup="sistema.buscarEnTable(this.value,'lista_filial')">
                                                    </span>
                                                </div>
                                            </div>
                                           </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Semestre:</td>
                                            <td class="t-left">
                                                <select id="slct_semestre" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Semestre">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                            <td class="t-left label">Carrera:</td>
                                            <td class="t-left">
                                                <select id="slct_carrera" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Carrera">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                       </tr>                                     
                                    </table>
                                <!--fin talba-->                                
                                <br>
                                <div style="margin:15px 0px 10px 0px;">
                                    <a id="btn_exportar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                                        <i class="icon-white icon-th"></i>
                                        <span>Exportar</span>
                                    </a>
                                </div>
                                <br>                                   
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
