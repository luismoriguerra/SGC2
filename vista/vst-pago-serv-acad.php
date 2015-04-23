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

		<script type="text/javascript" src="../javascript/js/js-pago-serv-acad.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOpago.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPago.js"></script>
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
						<li id="list_buscar_alu" onclick="sistema.activaPanel('list_buscar_alu','panel_buscar_alu')" class="active"><span><i class="icon-gray icon-list-alt"></i> Buscar </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_buscar_alu" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>BUSCAR ALUMNO-PAGO</b></div>         
                        <div class="cont-der">

                            <!-- inicio buscar -->
                            <div style="overflow:auto;">
                                <table id="table_persona_ingalum"></table>
                                <div id="pager_table_persona_ingalum"></div>
                            </div>
                            <!-- fin buscar -->

                            <div style="overflow:auto;">
                                <table id="table_pago"></table>
                                <div id="pager_table_pago"></div>
                            </div>

                        </div>
    				</div>
					
            	</div>
			</div>
		</div>
		<!-- dialogs -->
		<div id="form_pagos" title="Registro de Pagos">
			<table>
				<tr>
                    <td class="t-left label">Monto señalado por pagar:</td>
                    <td><input type="text" id="txt_monto_por_pagar" readonly class="input-small t-center t-negrita t-rojo t-13"><span class="t-rojo t-negrita"> *</span></td>
                    <td width="100"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="t-left label">Fecha de Pago:</td>
                    <td><input type="text" id="txt_fecha_pago" class="input-small t-center"><span class="t-rojo t-negrita"> *</span></td>
                    <td></td>
                    <td rowspan="2">
                    	<table width="100%" id="valConceptos" style="display:none">
                        	<tr><td class="t-left label" colspan="2">Pagos :</td></tr>
                            <tr><td class="t-left label"> Número </td><td> Monto : </td></tr>
                        </table>
                    </td></td>
                </tr>
                <tr>
                    <td class="t-left label">Monto pagado:</td>
                    <td><input type="text" id="txt_monto_pagado" onKeyPress="return sistema.validaNumeros(event)" onKeyUp="CalculaDeuda();" class="input-small t-center" value="0"><span class="t-rojo t-negrita"> *</span></td>
                    <td><input type="hidden" id="txt_monto_minimo" class="input-small t-center"></td></td>
                    <td>
                    	<!--<a class="btn btn-azul sombra-3d t-blanco" onclick="cargarMontoPago();" href="javascript:void(0)">
	                        <i class="icon-white ui-icon-refresh"></i><span>Actualizar Pagos</span>
                        </a>-->
                    </td>
                </tr>
                 <tr>
                    <td class="t-left label">Monto deuda:</td>
                    <td><input type="text" id="txt_monto_deuda" class="input-small t-center" value="0" disabled><span class="t-rojo t-negrita"> *</span></td>
                </tr>
               <tr>
                    <td class="t-left label">Tipo Documento:</td>
                    <td>
                        <select id="slct_tipo_documento_pension" class="input-small" onChange="ValidaTipoPagoPension();">
	                        <option value="">--Seleccione--</option>
	                        <option value="B">Boleta</option>
	                        <option value="V">Voucher</option>
                        </select>
                        <span class="t-rojo t-negrita"> *</span>
                    </td>
                    <td><!--a class="btn btn-azul sombra-3d t-blanco" onClick="cargarMontoPago();" href="javascript:void(0)"> <i class="icon-white ui-icon-refresh"></i><span>Actualizar Pagos</span> </a--></td>
                    <td></td>
                </tr>
                <tr id="val_boleta_pension" style="display:none">
                    <td class="t-left label">Serie Boleta:</td>
                    <td>
                    	<input type="text" id="txt_serie_boleta_pension" class="input-small" onKeyPress="return sistema.validaNumeros(event)"  onBlur="sistema.lpad(this.id,'0',3)"><span class="t-rojo t-negrita"> *</span>
                    </td>
                    <td class="t-left label">Nro Boleta:</td>
                    <td>
                    	<input type="text" id="txt_nro_boleta_pension" class="input-small" onKeyPress="return sistema.validaNumeros(event)"  onBlur="sistema.lpad(this.id,'0',7)"><span class="t-rojo t-negrita"> *</span>

                    </td>
                </tr>
                <tr id="val_voucher_pension" style="display:none">
                    <td class="t-left label">Nro Voucher:</td>
                    <td class="t-left">
                    	<input type="text" id="txt_nro_voucher_pension" class="input-small" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',11);"><span class="t-rojo t-negrita"> *</span>
                    </td>
                    <td class="t-left label">Banco:</td>
                    <td>
                    	<select id="slct_banco_pension" class="input-small">
                        	<option value="">--Seleccione--</option>
                        </select>
                        <span class="t-rojo t-negrita"> *</span>
                    </td>
                </tr>
			</table>
            <div style="margin:15px 0px 10px 0px;">
                <a id="btn_registrar_pago" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                    <i class="icon-white icon-ok-sign"></i>
                    <span>REGISTRAR PAGO</span>
                </a>
            </div>
		</div>

        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
