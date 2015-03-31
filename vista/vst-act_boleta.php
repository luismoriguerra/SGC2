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

		<script type="text/javascript" src="../javascript/dao/DAOreporte.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOpago.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridReporte.js"></script>
		<script type="text/javascript" src="../javascript/js/js-act_boleta.js"></script>
        
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
                                            <li id="list_Arqueo Caja" onclick="sistema.activaPanel('list_Arqueo Caja','panel_Arqueo Caja')" class="active"><span><i class="icon-gray icon-download"></i> Editar Boleta </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-der"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_Arqueo Caja" style="display:block">
                        <form>
    					<div class="barra1 t-left"><i class="icon-gray icon-download"></i> <b>ARQUEO CAJA => Editar Boleta</b></div>         
                        <div class="cont-der">
                        	<? /*
                                Su filial es:<b> <?=$_SESSION['SECON']['dfilial']?></b>
                            */?>
                            <div style="display:block">
                                <span class="ui-widget-content t-12" style="padding:2px">Consultar con Rango de Fechas</span>
                                <select id='slct_valida_fecha' onChange='validavisiblefecha(this.value);'><option value='SI' selected>SI</option><option value='NO'>NO</option></select>
                            </div>
                            <div id="fechas" style="display:block">                                
                                <span class="ui-widget-content t-12" style="padding:2px">Rango de Fechas</span>
                                <input type="text" id="txt_fechaInicio" onChange="sistema.validaFecha('txt_fechaInicio','txt_fechaFin');" />
                                <input type="text" id="txt_fechaFin" onChange="sistema.validaFecha('txt_fechaInicio','txt_fechaFin');" />
                            </div>
                            <div id="boletas" style="display:block">
                                <span class="ui-widget-content t-12" style="padding:2px">Serie</span>
                                <input type="text" id="txt_serie_boleta" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',3);">
                                <span class="ui-widget-content t-12" style="padding:2px">Nro</span>
                                <input type="text" id="txt_nro_boleta" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',7);">
                            </div>
                            <div style="margin:10px 5px;">
                            	<span class="formBotones">
	                                <a href="javascript:void(0)" id="btnListar" class="btn btn-azul sombra-3d t-blanco">
	                                    <i class="icon-white icon-th-list"></i>
	                                    <span>LISTAR</span>
	                                </a>
	                            </span>
                        	</div>
                            <div id="validalista" style="display:none; text-align:center">
                            
                            	<div style="overflow:auto;">
                                <table id="table_arqueo"></table>
                                <div id="pager_table_arqueo"></div>
                                </div>
                            	
                                <!--<span class="formBotones">
	                                <a href="javascript:void(0)" id="btnExportar" class="btn btn-azul sombra-3d t-blanco">
	                                    <i class="icon-white icon-th-list"></i>
	                                    <span>EXPORTAR</span>
	                                </a>
	                            </span> -->
                            </div><!--FIN -->
                        </div>
                        </form>
                    </div>			
            	</div>

        <div id="form_act_boleta" title="Actualizar Boleta">
            <table>
                <tr>
                    <td class="t-left label">Alumno(a):</td>
                    <td>
                        <div id="div_alumno"> </div>                    
                    </td>                    
                </tr>
                <tr>
                    <td class="t-left label">Serie Boleta:</td>
                    <td><input type='hidden' id='id_boleta' value=''>
                        <input type='hidden' id='txt_fecha_edit2' value=''>
                        <input type="text" id="txt_serie_boleta_edit" class="input-small" onKeyPress="return sistema.validaNumeros(event)"  onBlur="sistema.lpad(this.id,'0',3)"><span class="t-rojo t-negrita"> *</span>
                        <input type="hidden" id="txt_serie_boleta_edit2">
                    </td>
                    <td class="t-left label">Nro Boleta:</td>
                    <td>
                        <input type="text" id="txt_nro_boleta_edit" class="input-small" onKeyPress="return sistema.validaNumeros(event)"  onBlur="sistema.lpad(this.id,'0',7)"><span class="t-rojo t-negrita"> *</span>
                        <input type="hidden" id="txt_nro_boleta_edit2">

                    </td>
                </tr>
                <tr>
                    <td class="t-left label">Serie Boleta:</td>
                    <td>
                        <input type="text" id="txt_fecha_edit" />                    
                    </td>                    
                </tr>
                
            </table>
            <div style="margin:15px 0px 10px 0px;">
                <a id="btn_actualizar_boleta" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                    <i class="icon-white icon-ok-sign"></i>
                    <span>ACTUALIZAR BOLETA</span>
                </a>
            </div>
        </div>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
