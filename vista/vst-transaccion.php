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

		<script type="text/javascript" src="../javascript/js/js-transaccion.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOtransaccion.js"></script>
    </head>

	<body>
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?require_once('ifrm-header.php')?>	
		<?require_once('ifrm-nav.php')?>	
        <div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:140px;">
					<ul class="lca" style="display:block">
						<li id="list_exportar" onclick="sistema.activaPanel('list_exportar','panel_exportar')" class="active"><span><i class="icon-gray icon-download"></i> Exportar </span></li>
						<li id="list_importar" onclick="sistema.activaPanel('list_importar','panel_importar')" class=""><span><i class="icon-gray icon-upload"></i> Importar </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_exportar" style="display:block">
    					<div class="barra1 t-left"><i class="icon-gray icon-download"></i> <b>EXPORTAR TRANSACCIONES</b></div>         
                        <div class="cont-der">
                        	Su filial es:<b> <?=$_SESSION['SECON']['dfilial']?></b>
                            <div id="fechas" style="display:block">
                                <span class="ui-widget-content t-12" style="padding:2px">Rango de Fechas</span>
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
    				</div>

    				<div id="panel_importar" style="display:none">
    					<div class="barra1 t-left"><i class="icon-gray icon-upload"></i> <b>IMPORTAR TRANSACCIONES</b></div>         
                        <div class="cont-der t-center">

                        	<div style="margin:10px;">
                                <div id="file_uploadImportar" class="file_upload btn btn-azul sombra-i" style="display:inline-block;">
                                    <form action="" method="POST" enctype="multipart/form-data" class="file_upload" style="text-align:left">
                                        <input type="hidden" name="error" value="0" id="loadHeaderError" />
                                        <input type="hidden" name="error" value="" id="loadHeaderErrorMsg" />
                                        <input type="file" name="file[]" id="dirImportar" style="display:block">
                                            <button type="submit">Upload</button>
                                            <i class="icon-white icon-upload"></i> <span>Seleccionar archivo a Importar</span>
                                    </form>
                                </div>
                            </div>
                            <div style="display:inline-block;margin:10px;">
                                <table id="filesImportar">
                                    <tbody>
                                        <tr class="file_upload_template" style="display:none;">
                                            <td class="file_upload_preview"></td>
                                            <td class="file_name"></td>
                                            <td class="file_size"></td>
                                            <td class="file_upload_progress"><div></div></td>

                                            <td class="file_upload_start"><button>Start</button></td>
                                            <td class="file_upload_cancel"><button>Cancel</button></td>
                                        </tr>
                                        <tr class="file_download_template" style="display:none;">
                                            <td class="file_download_preview"></td>
                                            <td class="file_name"><a></a></td>
                                            <td class="file_size"></td>
                                            <td class="file_download_delete" colspan="3"><button>Delete</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="file_upload_overall_progress"><div style="display: none; " class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%; "></div></div></div>
                                <div class="file_upload_buttons"></div>
                            </div>
                            <div class="t-center">
                                <div id="msg_resultado_importar" style="display:none;vertical-align: middle;">
                                    <b>Archivo cargado:</b>
                                    <span id="spanImportar" style="border: 1px solid #888;padding: 2px 10px;"></span>
                                    <input type="hidden" id="hddFileImportar" value=""/>
                                    <a id="ProcImportar" class="btn btn-gris sombra-i" href="javascript:void(0)">PROCESAR</a>
                                    <a id="cancelaProcImportar" class="btn btn-gris sombra-i" href="javascript:void(0)">CANCELAR</a>
                                </div>
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
