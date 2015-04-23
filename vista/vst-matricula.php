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

		<script type="text/javascript" src="../javascript/js/js-matricula.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridInscrito.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOconcepto.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOmatricula.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Matricula </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>FICHA DE MATRICULA A PROFESIONALES:</b></div>         
                        <div class="cont-der">

                            <!-- inicio buscar matriculado -->
                            <div style="overflow:auto;">
                                <table id="table_inscrito"></table>
                                <div id="pager_table_inscrito"></div>
                            </div>
                            <!-- fin buscar matriculado -->

                            <!-- inicio formulario matricula -->
                            <div id="form_matricula" style="width:1000px;border:1px solid #ccc;margin:0px auto;padding:10px 0px;" class="t-center">
                                <input type="hidden" id="txtIdInscrito">
                                <input type="hidden" id="cciclo" value="01">
                                <div style="display:inline-block;"><img src="../images/tel2.jpg"></div>
                                <div style="display:inline-block;width:800px;" class="t-center">
                                    <table>
                                        <tr>                                            
                                            <td class="t-left label t-negrita">FECHA:</td>
                                            <td class="t-left"><input type="text" id="txt_fecha_matri" style="width:65px"></td>
                                            <td style="display:none" class="t-left label t-negrita">Nro Ficha Matrícula:</td>
                                            <td style="display:none" class="t-left">SERIE<input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_cod_fic_mat1" maxlength="3" class="input-mini" value="000">&nbsp;NRO<input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_cod_fic_mat2" maxlength="8" class="input-mini" value="00000"></td>                                            
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <div style="width:800px;display:inline-block;" class="t-center">
                                        <table>
                                            <tr>                                            	
                                                <td class="t-left label t-negrita">Ficha de Inscripción:</td>                                                
                                                <td class="t-left"><input type="text" id="txt_ficha_insc_post" style="width:96%" disabled></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div>
                                    <div style="width:49.8%;display:inline-block;">
                                        <div class="barra4 contentBarra t-blanco t-center"><i class="icon-white icon-th"></i>DATOS DE LA CARRERA</div>
                                        <div>
                                            <table style="width:90%">
                                                <tr style="display:none">
                                                    <td class="t-left label">Tipo Carrera:</td>
                                                    <td>
                                                        <select id="slct_tipo_carrera" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label">Modalidad:</td>
                                                    <td>
                                                        <select id="slct_modalidad" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label">Carrera:</td>
                                                    <td>
                                                        <select id="slct_carrera" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>                            
                                                </tr> 
                                                <tr>
                                                    <td class="t-left label" width="30%">Semestre:</td>
                                                    <td>
                                                        <select id="slct_semestre" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="30%">Inicio:</td>
                                                    <td>
                                                        <select id="slct_inicio" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td class="t-left label" width="30%">Modalidad Ingreso:</td>
                                                    <td>
                                                        <select id="slct_modalidad_ingreso" style="width:96%" disabled><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="30%">Horario:</td>
                                                    <td >
                                                        <select id="slct_horario" style="width:96%"><option value="">--Selecione--</option></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="45%">Código Universidad.:</td>
                                                    <td><input type="text" maxlength="12" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_cod_univers" style="width:96%" value=""></td>
                                                </tr>                                             
                                            </table>
                                        </div>
                                    </div>
                                    <div style="width:49.8%;display:inline-block;">
                                        <div class="barra4 contentBarra t-blanco t-center"><i class="icon-white icon-th"></i>DATOS DEL ALUMNO</div>
                                        <div>
                                            <table style="width:80%">                                                <tr>
                                            		<td class="t-left label t-negrita">ODE:</td>
                                            		<td class="t-left"><input type="text" id="txt_ode" style="width:65px" disabled></td>
                                            	</tr>                                            	
                                                <tr>
                                                    <td class="t-left label" width="45%">Paterno:</td>
                                                    <td><input type="text" id="txt_paterno" style="width:96%" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="45%">Materno:</td>
                                                    <td><input type="text" id="txt_materno" style="width:96%" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="45%">Nombre(s):</td>
                                                    <td><input type="text" id="txt_nombre" style="width:96%" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td class="t-left label" width="45%">Código de Libro:</td>
                                                    <td class="t-left"><input type="text" maxlength="12" id="txt_cod_libro" onKeyPress="return sistema.validaAlfanumerico(event)" style="width:96%"></td>
                                            	</tr>
                                                <tr>
                                                	<td class="t-left label">Condición del Alumno:</td>
                                                    <td>
                                                        <select id="slct_rdo_condic_alum" onChange="CargarCursos(this.value);" style="width:96%">
                                                        <option value="RE" selected=selected>Regular</option>
                                                        <option value="IR">Irregular</option>
                                                        <option value="TE">Traslado Externo</option>
                                                        </select>
                                                    </td>
                                                </tr>                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>UBICACIÓN DEL ALUMNO</div>
                                    <div>
                                        <table style="width:100%">
                                        	<tr>
                                                <td class="t-left label" width="45%">E-Mail:</td>
                                                <td><input type="text" id="txt_email" class="input-mediun" disabled></td>
                                            	<td class="t-left label" width="45%">Celular:</td>
                                                <td><input type="text" id="txt_celular" class="input-mediun" disabled></td>
                                            	<td class="t-left label" width="45%">Tel. Casa/Trab.:</td>
                                                <td><input type="text" id="txt_tel_casa_trab" class="input-mediun" disabled></td>
                                            </tr>
                                            <tr>
                                                <td class="t-left label">Dirección:</td>
                                                <td colspan="5" class="t-left">
                                                <input type="text" id="txt_direccion" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" disabled>
                                                </td>
                                            </tr>
                                            <tr>                        	
                                                <td class="t-left label">Referencia:</td>
                                                <td colspan="5" class="t-left">
                                                <input type="text" id="txt_referencia" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" disabled>
                                                </td>
                                            </tr>
                                            <tr>                                                
                                                <td class="t-left label">Departamento:</td>
                                                <td><input type="text" id="txt_departamento" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-medium" disabled></td>
                                                <td class="t-left label">Provincia:</td>
                                                <td><input type="text" id="txt_provincia" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-medium" disabled></td>
                                                <td class="t-left label">Distrito:</td>
                                                <td><input type="text" id="txt_distrito" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-medium" disabled></td>
                                            </tr>
                                            <tr>                        	
                                                <td class="t-left label">Dirección Trabajo:</td>
                                                <td colspan="3">
                                                <input type="text" id="txt_direccion2" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" disabled>
                                                </td>
                                                <td class="t-left label">Nombre Trabajo:</td>
                                                <td>
                                                <input type="text" id="txt_nombre_trabajo" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" disabled>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div style="display:none">
                                    <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>DOCUMENTOS ACADÉMICOS OBLIGATORIOS PARA LA MATRÍCULA</div>
                                    <div>
                                        <table style="width:100%">
                                            <tr>
                                                <td class="t-left label" width="23%">CÓD. Certificado de Estudios:</td>
                                                <td class="t-left" width="27%"><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_cod_cert_est" style="width:96%" value="0"></td>
                                                <td class="t-left label" width="23%">CÓD. Partida de Nacimiento:</td>
                                                <td class="t-left"><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_cod_part_nac" style="width:96%" value="0"></td>
                                            </tr>
                                            <tr>
                                                <td class="t-left label">Fotocopia de DNI:</td>
                                                <td>
                                                        <select id="slct_rdo_fotoc_dni" style="width:96%">
                                                        <option value="0" selected=selected>No</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">Otro</option>
                                                        </select>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="ui-state-default">Otro:</td>
                                                <td>
                                                    <input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_otro_doc" style="width:96%">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="t-center" style="display:none">
                                    <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>ASIGNATURAS MATRICULADAS</div>
                                    <div style="display:inline-block;">
                                        <table id="lista_cursos">
                                        	<tr>
                                                <td class="t-center label" width="50">N°</td>
                                                <td class="t-center label" width="200">COD. ASIGNATURA</td>
                                                <td class="t-center label" width="400">NOMBRE ASIGNATURA</td>
                                                <td class="t-center label" width="200">CICLO</td>
                                                <td class="t-center label" width="70">N° CRED.</td>
                                            </tr> 
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="t-center">
                                    <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>PAGO MATRÍCULA</div>
                                    <table>
                                    	<tr>
                                            <td class="t-left label">Recepcionista:</td>
                                            <td class="t-left">
                                                <input type="text" id="txt_recepcionista" class="input-large" disabled>
                                                <input type="hidden" id="id_cvended_r">
                                                <span class="formBotones">
                                                    <a href="javascript:void(0)" onClick="ListarRecepcionista();" id="btnMantRecepcionista" class="btn btn-azul sombra-3d t-blanco">
                                                        <i class="icon-white icon-search"></i>
                                                        <span id="spanBtnMantRecepcionista"></span>
                                                    </a>
                                                </span>
                                            </td>                            
                                        </tr>
                                        <tr id="mantenimiento_recepcionista" style="display:none">
                                            <td colspan="2">
                                              <div style="margin-right:3px">
                                                <table id="table_recepcionista"></table>
                                                <div id="pager_table_recepcionista"></div>
                                              </div >                             
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td class="t-left label">Condicion de Pago:</td>
                                            <td class="t-left">
                                            <select id="slct_condicion_pago">
                                            <option value="">--Seleccione--</option>
                                            <option value="0">Pagante</option>
	                                        <option value="1">Becado</option>
                                            </select>
                                            </td>                                            
                                        </tr>
                                        <tr id="valida_t_pagante" class="valida" style="display:none">
                                        	<td class="t-left label">Tipo Pagante:</td>
                                            <td class="t-left">
                                            <select id="slct_tipo_beca">
                                            <option value="">--Seleccione--</option>
                                           	</select>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Tipo de Pago:</td>
                                            <td class="t-left">
                                                <select id="slct_tipo_pago" class="input-medium">
                                                <option value="">--Seleccione--</option>
                                                <option value="O">OFICINA</option>
                                                <option value="C">CAMPO</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Detalle Matrícula:</td>
                                            <td class="t-left">
                                                <select id="slct_concepto" class="input-xxlarge">
                                                <option value="">--Seleccione--</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Monto Pagado:</td>
                                            <td class="t-left"><input type="text" id="txt_monto_pagado" onKeyUp="ValidaMontoPagado();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Monto Deuda:</td>
                                            <td class="t-left"><input type="text" id="txt_monto_deuda" onKeyUp="ValidaMontoPagado();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Fecha Pago:</td>
                                            <td class="t-left"><input type="text" id="txt_fecha_pago" class="input-medium" value=""></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Tipo Documento:</td>
                                            <td class="t-left">
                                                <select id="slct_tipo_documento" class="input-medium" onChange="ValidaTipoPago();">
                                                <option value="">--Seleccione--</option>
                                                <option value="B">Boleta</option>
                                                <option value="V">Voucher</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="val_boleta" style="display:none">
                                            <td class="t-left label">Serie Boleta:</td>
                                            <td class="t-left"><input type="text" id="txt_serie_boleta" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)">
                                            &nbsp;
                                            <span class="t-left label">Nro Boleta:</span>
                                            <span class="t-left"><input type="text" id="txt_nro_boleta" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)"></span></td>
                                        </tr>
                                        <tr id="val_voucher" style="display:none">
                                            <td class="t-left label">Nro Voucher:</td>
                                            <td class="t-left"><input type="text" id="txt_nro_voucher" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)">
                                            <span class="t-left label">Banco:</span>
                                            &nbsp;
                                            <span class="t-left">
                                                <select id="slct_banco" class="input-large">
                                                <option value="">--Seleccione--</option>
                                                </select>
                                            </span>
                                            </td>
                                        </tr>
                                         
                                    </table>
                                </div>
                                
                                <div class="t-center">
                                    <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>PAGO PENSIÓN</div>
                                    <table>
                                        <tr>
                                            <td class="t-left label">Detalle Pensión:</td>
                                            <td class="t-left">
                                                <select id="slct_concepto_pension" class="input-xxlarge">
                                                <option value="">--Seleccione--</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Monto Pagado:</td>
                                            <td class="t-left"><input type="text" id="txt_monto_pagado_pension" onKeyUp="ValidaMontoPagadoPension();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Monto Deuda:</td>
                                            <td class="t-left"><input type="text" id="txt_monto_deuda_pension" onKeyUp="ValidaMontoPagadoPension();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Fecha Pago:</td>
                                            <td class="t-left"><input type="text" id="txt_fecha_pago_pension" class="input-medium" value=""></td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Tipo Documento:</td>
                                            <td class="t-left">
                                                <select id="slct_tipo_documento_pension" class="input-medium" onChange="ValidaTipoPagoPension();">
                                                <option value="">--Seleccione--</option>
                                                <option value="B">Boleta</option>
                                                <option value="V">Voucher</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="val_boleta_pension" style="display:none">
                                            <td class="t-left label">Serie Boleta:</td>
                                            <td class="t-left"><input type="text" id="txt_serie_boleta_pension" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)">
                                            &nbsp;
                                            <span class="t-left label">Nro Boleta:</span>
                                            <span class="t-left"><input type="text" id="txt_nro_boleta_pension" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)"></span></td>
                                        </tr>
                                        <tr id="val_voucher_pension" style="display:none">
                                            <td class="t-left label">Nro Voucher:</td>
                                            <td class="t-left"><input type="text" id="txt_nro_voucher_pension" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)">
                                            &nbsp;
                                            <span class="t-left label">Banco:</span>
                                            <span class="t-left">
                                                <select id="slct_banco_pension" class="input-large">
                                                <option value="">--Seleccione--</option>
                                                </select>
                                            </span>
                                            </td>
                                        </tr>
                                         
                                    </table>
                                </div>
                                <div class="formBotones">
                                    <a href="javascript:void(0)" onClick="Registrar();" class="btn btn-azul sombra-3d t-blanco">
                                    <i class="icon-white icon-download-alt"></i>
                                    <span>Registrar</span>
                                    </a>
                                </div>

                            </div>
                            <!-- fin formulario matricula -->
							
                        </div>
    				</div>
					<div id="frmTrabajador" title="MANTENIMIENTO TRABAJADOR">
						<div class="form">
						<table style="width:1000px;" align="center"><tr><td>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS PERSONALES</div>
                        <br>                        	
                        <table class="t-left">
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Nombre(s):</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre_t" class="input-large"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Paterno:
                            <input type="hidden" id="cvended">
                            <input type="hidden" id="tvended">
                            </td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_paterno_t" class="input-large"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Materno:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_materno_t" class="input-large"></td>
                        </tr>                        
                        </table>                        
                        <table class="t-left">
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Tipo Trabajador:</td>
                            <td>
                                <select id="slct_tipo_trabajador_t" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                <option value="p">Promotor(a)</option>
                                <option value="r">Recepcionista</option>
                                <option value="t">Teleoperador(a)</option>
                                </select>
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Email:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_email_t" class="input-large" ></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Tel/Cel:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_celular_t" class="input-medium" ></td>
                        </tr>
                        <tr>                            
                            <td class="ui-state-default"><span class="t-rojo">*</span>DNI</td>
                            <td>
                                <input type="text" onKeyPress="return sistema.validaDni(event,'txt_dni_t')" id="txt_dni_t" class="input-medium">
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Genero:</td>
                            <td>
                                <select id="slct_sexo_t" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                </select>
                            </td>
                            <td class="ui-state-default">Fecha Ingreso:</td>
                            <td><input type="text" id="txt_fecha_ingreso_t" class="input-medium" value="" ></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento_t" class="input-medium" onChange="cargarProvinciat();">
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia_t" class="input-medium" onChange="cargarDistritot();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito_t" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </table>                        
                        <table class="t-left">
                        <tr>
                        	<td class="ui-state-default">Código Interno:</td>
                            <td colspan="5">
                            <input type="text" id="txt_codigo_interno_t" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-medium" >
                            <td class="ui-state-default">Dirección:</td>
                            <td colspan="5">
                            <input type="text" id="txt_direccion_t" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>
                        </tr>
                        </table>                        
                        </td></tr>
                        </table>
						</div><!--Form-->
                        <div class="formBotones">
							<a href="javascript:void(0)" id="btnFormTrabajador" class="btn btn-azul sombra-3d t-blanco">
							<i class="icon-white icon-download-alt"></i>
							<span id="spanBtnFormTrabajador"></span>
							</a>
						</div>
					</div><!-- Mant Promotor y Recepcionista-->
            	</div>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
