<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SGC2</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />
        <link type="text/css" rel="stylesheet" href="../javascript/includes/fileupload/jquery.fileupload-ui.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>
        <script type="text/javascript" src="../javascript/includes/fileupload/jquery.fileupload-ui.js" ></script>
        <script type="text/javascript" src="../javascript/includes/fileupload/jquery.fileupload.js" ></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>

		<script type="text/javascript" src="../javascript/js/js-digitadores_cant.js"></script>
        
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
                        <li id="list_exportar" onclick="sistema.activaPanel('list_exportar','panel_exportar')" class="active"><span><i class="icon-gray icon-download"></i> Exportar </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_exportar" style="display:block">
                        <form>
    					<div class="barra1 t-left"><i class="icon-gray icon-download"></i> <b>EXPORTAR CONTEO DE DIGITACIÓN</b></div>         
                        <div class="cont-der">
                        	
                            <div id="fechas" style="display:block">
                                <span class="ui-widget-content t-12" style="padding:2px">Rango de Fechas de digitación</span>
                                <input type="text" id="txt_fechaInicio" placeholder="inicio"/>
                                <input type="text" id="txt_fechaFin" placeholder="fin"/>
                            </div>
                            <div style="margin:10px 5px;">
                            	<span class="formBotones">
	                                <a href="javascript:void(0)" id="btnExportar" class="btn btn-azul sombra-3d t-blanco">
	                                    <i class="icon-white icon-download"></i>
	                                    <span>EXPORTAR</span>
	                                </a>
	                            </span>
                        	</div>
                        </div>
                        </form>
                    </div>			
            	</div>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
