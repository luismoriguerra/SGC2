<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>Telesup</title>
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

		<script type="text/javascript" src="../javascript/dao/DAOinscripcion.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOconcepto.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOcencap.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOubigeo.js"></script>
		<script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
        <script type="text/javascript" src="../javascript/js/js-persona.js"></script>
		<script type="text/javascript" src="../javascript/js/js-inscripcion.js"></script>

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
						<li id="list_inscripcion" onClick="sistema.activaPanel('list_inscripcion','panel_inscripcion')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ficha Inscripción </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
					<div id="panel_inscripcion" style="display:block">
						<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>FICHA DE INSCRIPCIÓN DEL POSTULANTE A LA UNIVERSIDAD PRIVADA TELESUP</b></div>         
					  <div class="cont-der">
                       <table style="width:1000px;" align="center"><tr><td>
                       <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DE ADMISION </div>
                        <br>                        	
                        <table class="t-left">                        
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>
                            <input type="hidden" id="cciclo" value="01">
                            ODE</td>
                            <td><input type="text" id="txt_ode" class="input-large" disabled></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Centro de Captación</td>
                            <td><select id="slct_centro_captacion"><option value="">--Seleccione--</option></select></td>
                        </tr>                        
                        <tr>
                            <td class="ui-state-default input-medium"><span class="t-rojo">*</span>Local Estudio:</td>
                            <td>
                            	<select id="slct_local_estudio" class="input-medium">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Institucion:</td>
                            <td>
                            	<select id="slct_local_instituto" class="input-medium">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Ciclo Académico:</td>
                            <td>
                            	<select id="slct_semestre" class="input-medium">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>                        
                        <tr>
                        	<td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                               	<div class="corner_top ui-state-default" style="font-weight:bold">
                                <table border="1" cellpadding="0" cellspacing="0">
                                    <tr class="" align="center">                              
                                        <td class="t-center " width="65px">TURNO</td>
                                        <td class="t-center " width="195px" >CARRERA</td>
                                        <td class="t-center " width="55px">CICLO ACADEMICO</td>
                                        <td class="t-center " width="42px" >INICIO</td>
                                        <td class="t-center " width="95px" >FECHA<BR>INICIO</td>
                                        <td class="t-center " width="170px" >HORARIO</td>
                                        <td class="t-center " width="55px" >META A<BR>MATR.</td>
                                        <td class="t-center " width="40px" >INSC. SIN<BR>POSI. A<BR>MATRIC</td>
                                        <td class="t-center " width="40px" >INSC. CON<BR>POSI. A<BR>MATRIC</td>
                                        <td class="t-center " width="40px" >MATRIC.</td>
                                        <td class="t-center " width="40px" >VACANTES</td>
                                        <td class="t-center " width="40px" >INDICE<BR>MATRIC.</td>
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
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Código de Libro:</td>
                            <td><input type="text" id="txt_codigo_libro_cod" maxlength="5" class="input-mini" disabled><input type="text" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',5)" id="txt_codigo_libro" maxlength="5" class="input-mini"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Código de Ficha Insc.:</td>
                            <td>SERIE<input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_codigo_ficha_insc1" onBlur="sistema.lpad(this.id,'0',3)" maxlength="3" class="input-mini">&nbsp;NRO<input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" onBlur="sistema.lpad(this.id,'0',8)" id="txt_codigo_ficha_insc2" maxlength="8" class="input-mini"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Fecha:</td>
                            <td><input type="text" id="txt_fecha" class="input-medium" value=""></td>
                        </tr>
                        </table>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> POSTULANTE</div>
                        <br>                        	
                        <table class="t-left">
                        <tr>
                        	<td class="ui-state-default">Persona</td>
                            <td>                            	
                            	<span class="formBotones">
                                    <a href="javascript:void(0)" onClick="ListarPersona();" id="btnMantPersona" class="btn btn-azul sombra-3d t-blanco">
                                        <i class="icon-white icon-search"></i>
                                        <span id="spanBtnMantPersona"></span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr id="mantenimiento_persona" style="display:none">
                        	<td colspan="2">
                              <div style="margin-right:3px">
                                <table id="table_persona"></table>
                                <div id="pager_table_persona"></div>
                              </div >                             
                            </td>
                        </tr>                        
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Paterno:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_paterno_c" class="input-large" disabled></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Materno:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_materno_c" class="input-large" disabled></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Nombre(s):
                            <input type="hidden" id="id_cperson">
                            </td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre_c" class="input-large" disabled></td>
                        </tr>                  
                        </table>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL POSTULANTE</div>
                        <br>
                        <table class="t-left">
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Estado Civil:</td>
                            <td>
                                <select id="slct_estado_civil_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                <option value="S">Soltero(a)</option>
                                <option value="C">Casado(a)</option>
                                <option value="D">Divorsiado(a)</option>
                                <option value="V">Viudo(a)</option>
                                <option value="C2">Comprometido(a)</option>
                                </select>
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>DNI</td>
                            <td>
                                <input type="text" onKeyPress="return sistema.validaDni(event,'txt_dni')" id="txt_dni_c" class="input-medium" disabled>
                            </td>
                            <td class="ui-state-default">Fecha Nacimiento:</td>
                            <td><input type="text" id="txt_fecha_nacimiento_c" class="input-medium" disabled></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Genero:</td>
                            <td>
                                <select id="slct_sexo_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                </select>
                            </td>                            
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Email:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_email_c" class="input-large" disabled></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Celular:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_celular_c" class="input-medium" disabled></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Tel Casa:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_casa_c" class="input-medium" disabled></td>
                            <td class="ui-state-default">Tel Ofic:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_oficina_c" class="input-medium" disabled></td>
                        </tr>                        
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </table>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL COLEGIO</div>
                        <br>
                        <TABLE class="t-left">
                        <tr>
                        	<td class="ui-state-default">Colegio:</td>
                            <td colspan="2">
                            	<input type="text" id="txt_colegio_c" class="input-large" disabled>                            </td>                            
                            <td class="ui-state-default">Tipo:</td>
                            <td>
                                <select id="slct_Tipo_c" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                <option value="1">Nacional</option>
                                <option value="2">Particular</option>
                                <option value="3">Parroquia</option>
                                <option value="4">FFAA</option>
                                <option value="5">FFPP</option>
                                </select>
                            </td>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento_c2" class="input-medium" disabled>
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia_c2" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                </select>                                   
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito_c2" class="input-medium" disabled>
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </TABLE>                        
                    </div>
                    <div>
                        <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>DOCUMENTOS ACADÉMICOS OBLIGATORIOS PARA EL PROCESO DE ADMISIÓN</div>
                        <div>
                        <br>
                            <table class="t-left">
                                <tr>
                                    <td class="ui-state-default"><span class="t-rojo">*</span>CÓD. Certificado de Estudios:</td>
                                    <td ><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" onChange="validarTotalG()" id="txt_cod_cert_est" class="input-large" ></td>
                                    <td class="ui-state-default" ><span class="t-rojo">*</span>CÓD. Partida de Nacimiento:</td>
                                    <td ><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" onChange="validarTotalG()" id="txt_cod_part_nac" class="input-large"></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default"><span class="t-rojo">*</span>Fotocopia de DNI:</td>
                                    <td>
                                            <select id="slct_rdo_fotoc_dni" onChange="validarTotalG()" class="input-mediun">
                                            <option value="0" selected=selected>No</option>
                                            <option value="1">Si</option>                          
                                            </select>
                                    </td>
                                    <td class="ui-state-default"><span class="t-rojo">*</span>Modalidad de Ingreso:</td>
                                    <td>
                                        <select id="slct_modalidad_ingreso" class="input-medium">
                                        <option value="">--Selecione--</option>
                                        </select>
                                    </td>
                                    <!--<td class="nueva_modalidad ui-state-default" style="display:none">Otra Modalidad de Ingreso:</td>
                                    <td style="display:none">
                                        <input type="text" onKeyPress="sistema.validaAlfanumerico(event)" id="txt_nueva_modalidad" class="nueva_modalidad input-large">
                                    </td>-->
                                </tr>                                
                                <tr>
                                    <td class="ui-state-default">Otro Documento:</td>
                                    <td>
                                    	<input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_otro_doc" style="width:96%">
                                    </td>
                                    <td></td>
                                    <td colspan="3"><input type="checkbox" checked=checked id="validatotal">FIRMO COMPROMISO DE HONOR</td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default"><span class="t-rojo">*</span>Nro Fotos:</td>
                                    <td>
                                        <select id="slct_nro_fotos" class="input-medium">
                                        <option value="0" selected>0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="postula_beca" style="display:none">
                                    <td class="ui-state-default"><span class="t-rojo">*</span>¿Postula solo a la Beca?:</td>
                                    <td>
                                        <select id="slct_solo_beca" class="input-medium">
                                        <option value="0" selected>NO</option>
                                        <option value="1">SI</option>                                
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS PARA EL PROCESO DE CONVALIDACIÓN </div>
                        <br>
                        <TABLE style="display:none" id="valida_proceso_convalidacion" class="t-left">
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>País Procedencia:</td>
                            <td>
                            	<select id="slct_pais_procedencia" class="input-large">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Tipo Institución:</td>
                            <td>
                            	<select id="slct_tipo_institucion" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="0">Instituto</option>
                                <option value="1">Universidad</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Institucion:</td>
                            <td>
                            	<input type="text" id="txt_institucion" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large">                            	
                            </td>                            
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Carrera Procedencia:</td>
                            <td>
                            	<input type="text" id="txt_carrera_procedencia" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large">
                            </td>                            
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Último Año que estudió:</td>
                            <td>
                            	<select id="slct_ultimo_año" class="input-medium">
                                <option value="">--Seleccione--</option>
                                <?
                                	for($i=date("Y");$i>(date("Y")*1-10);$i--){
									echo "<option value='".$i."'>".$i."</option>";
									}
								?>
                                </select>
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Último Ciclo realizado:</td>
                            <td>
                            	<select id="slct_ciclo" class="input-medium">
                                <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Documentos para Convalidación<br>(Certificados de Estudios,Sílabos):</td>
                            <td>
                            	<TEXTAREA id="txt_docum_vali" rows="4" class="input-large"> </TEXTAREA>
                            </td>                            
                        </tr>
                        </TABLE>                       
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> PAGO INSCRIPCIÓN </div>
                        <br>
                        <TABLE class="t-left">
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Tipo de Pago:</td>
                            <td>
                            	<select id="slct_tipo_pago_ins" class="input-medium" onChange="cargarConceptoIns();">
                                <option value="">--Seleccione--</option>
                                <option value="O">OFICINA</option>
                                <option value="C">CAMPO</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Detalle:</td>
                            <td>
                            	<select id="slct_concepto_ins" class="input-xxlarge" onChange="limpiaReg('_ins');">
                                <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Monto Pagado:</td>
                            <td><input type="text" id="txt_monto_pagado_ins" onKeyUp="ValidaMontoPagadoIns();" onBlur="validaRestoPago('_ins');" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Monto Deuda:</td>
                            <td><input type="text" id="txt_monto_deuda_ins" onKeyUp="ValidaMontoPagadoIns();"  onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Fecha Pago:</td>
                            <td><input type="text" id="txt_fecha_pago_ins" class="input-medium" value=""></td>
                        </tr>
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Tipo Documento:</td>
                            <td>
                            	<select id="slct_tipo_documento_ins" class="input-medium" onChange="ValidaTipoPagoIns();">
                                <option value="">--Seleccione--</option>
                                <option value="B">Boleta</option>
								<option value="V">Voucher</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="val_boleta_ins" style="display:none">
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Serie Boleta:</td>
                            <td><input type="text" id="txt_serie_boleta_ins" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',3);">
                            &nbsp;
                            <span class="ui-state-default"><span class="t-rojo">*</span>Nro Boleta:</span>
                            <span><input type="text" id="txt_nro_boleta_ins" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',7);"></span></td>
                        </tr>
                        <tr id="val_voucher_ins" style="display:none">
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Nro Voucher:</td>
                            <td><input type="text" id="txt_nro_voucher_ins" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',11);">
                            &nbsp;
                            <span class="ui-state-default"><span class="t-rojo">*</span>Banco:</span>
                            <span>
                            	<select id="slct_banco_ins" class="input-large">
                                <option value="">--Seleccione--</option>
                                </select>
                            </span></td>
                        </tr>
                        </TABLE>
                        <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>PAGO MATRÍCULA</div>
                            <br>
                            <table>                                
                                <tr>
                                    <td class="ui-state-default">Condicion de Pago:</td>
                                    <td class="t-left">
                                    <select id="slct_condicion_pago">
                                    <option value="">--Seleccione--</option>
                                    <option value="0">Pagante</option>
                                    <option value="1">Becado</option>
                                    </select>
                                    </td>                                            
                                </tr>
                                <tr id="valida_t_pagante" class="valida" style="display:none">
                                    <td class="ui-state-default">Tipo Pagante:</td>
                                    <td class="t-left">
                                    <select id="slct_tipo_beca">
                                    <option value="">--Seleccione--</option>
                                    </select>
                                    </td>                                            
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Tipo de Pago:</td>
                                    <td class="t-left">
                                        <select id="slct_tipo_pago" class="input-medium">
                                        <option value="">--Seleccione--</option>
                                        <option value="O">OFICINA</option>
                                        <option value="C">CAMPO</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Detalle Matrícula:</td>
                                    <td class="t-left">
                                        <select id="slct_concepto" class="input-xxlarge" onChange="limpiaReg('')">
                                        <option value="">--Seleccione--</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Pagado:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_pagado" onKeyUp="ValidaMontoPagado();" onBlur="validaRestoPago('');" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Deuda:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_deuda" onKeyUp="ValidaMontoPagado();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Fecha Pago:</td>
                                    <td class="t-left"><input type="text" id="txt_fecha_pago" class="input-medium" value=""></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Tipo Documento:</td>
                                    <td class="t-left">
                                        <select id="slct_tipo_documento" class="input-medium" onChange="ValidaTipoPago();">
                                        <option value="">--Seleccione--</option>
                                        <option value="B">Boleta</option>
                                        <option value="V">Voucher</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="val_boleta" style="display:none">
                                    <td class="ui-state-default">Serie Boleta:</td>
                                    <td class="t-left"><input type="text" id="txt_serie_boleta" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',3);">
                                    &nbsp;
                                    <span class="ui-state-default">Nro Boleta:</span>
                                    <span class="t-left"><input type="text" id="txt_nro_boleta" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',7);"></span></td>
                                </tr>
                                <tr id="val_voucher" style="display:none">
                                    <td class="ui-state-default">Nro Voucher:</td>
                                    <td class="t-left"><input type="text" id="txt_nro_voucher" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',11);">
                                    <span class="ui-state-default">Banco:</span>
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
                            <br>
                            <table>
                                <tr>
                                    <td class="ui-state-default">Detalle Pensión:</td>
                                    <td class="t-left">
                                        <select id="slct_concepto_pension" class="input-xxlarge" onChange="limpiaReg('_pension')">
                                        <option value="">--Seleccione--</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Pagado:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_pagado_pension" onKeyUp="ValidaMontoPagadoPension();" onBlur="validaRestoPago('_pension');" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Deuda:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_deuda_pension" onKeyUp="ValidaMontoPagadoPension();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Fecha Pago:</td>
                                    <td class="t-left"><input type="text" id="txt_fecha_pago_pension" class="input-medium" value=""></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Tipo Documento:</td>
                                    <td class="t-left">
                                        <select id="slct_tipo_documento_pension" class="input-medium" onChange="ValidaTipoPagoPension();">
                                        <option value="">--Seleccione--</option>
                                        <option value="B">Boleta</option>
                                        <option value="V">Voucher</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="val_boleta_pension" style="display:none">
                                    <td class="ui-state-default">Serie Boleta:</td>
                                    <td class="t-left"><input type="text" id="txt_serie_boleta_pension" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',3);">
                                    &nbsp;
                                    <span class="ui-state-default">Nro Boleta:</span>
                                    <span class="t-left"><input type="text" id="txt_nro_boleta_pension" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',7);"></span></td>
                                </tr>
                                <tr id="val_voucher_pension" style="display:none">
                                    <td class="ui-state-default">Nro Voucher:</td>
                                    <td class="t-left"><input type="text" id="txt_nro_voucher_pension" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',11);">
                                    &nbsp;
                                    <span class="ui-state-default">Banco:</span>
                                    <span class="t-left">
                                        <select id="slct_banco_pension" class="input-large">
                                        <option value="">--Seleccione--</option>
                                        </select>
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Promoción Económica <br>de la Admision:</td>
                                    <td class="t-left"><TEXTAREA id="txt_promocion_economica"  onKeyPress="return sistema.validaAlfanumerico(event)" rows="4" class="input-large" disabled> </TEXTAREA></td>
                                </tr> 
                            </table>
                        </div>
                        <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>PAGO  CONVALIDACIÓN</div>
                            <br>
                            <table style="display:none" id="valida_pago_convalidacion" class="t-left">
                                <tr>
                                    <td class="ui-state-default">Detalle:</td>
                                    <td class="t-left">
                                        <select id="slct_concepto_convalida" class="input-xxlarge" onChange="limpiaReg('_convalida')">
                                        <option value="">--Seleccione--</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Pagado:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_pagado_convalida" onKeyUp="ValidaMontoPagadoConvalida();" onBlur="validaRestoPago('_convalida');" onKeyPress="return sistema.validaNumeros(event)" class="input-medium"></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Monto Deuda:</td>
                                    <td class="t-left"><input type="text" id="txt_monto_deuda_convalida" onKeyUp="ValidaMontoPagadoConvalida();" onKeyPress="return sistema.validaNumeros(event)" class="input-medium" value="0" disabled></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Fecha Pago:</td>
                                    <td class="t-left"><input type="text" id="txt_fecha_pago_convalida" class="input-medium" value=""></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default">Tipo Documento:</td>
                                    <td class="t-left">
                                        <select id="slct_tipo_documento_convalida" class="input-medium" onChange="ValidaTipoPagoConvalida();">
                                        <option value="">--Seleccione--</option>
                                        <option value="B">Boleta</option>
                                        <option value="V">Voucher</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="val_boleta_convalida" style="display:none">
                                    <td class="ui-state-default">Serie Boleta:</td>
                                    <td class="t-left"><input type="text" id="txt_serie_boleta_convalida" maxlength="3" size="3" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',3);">
                                    &nbsp;
                                    <span class="ui-state-default">Nro Boleta:</span>
                                    <span class="t-left"><input type="text" id="txt_nro_boleta_convalida" maxlength="7" size="10" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',7);"></span></td>
                                </tr>
                                <tr id="val_voucher_convalida" style="display:none">
                                    <td class="ui-state-default">Nro Voucher:</td>
                                    <td class="t-left"><input type="text" id="txt_nro_voucher_convalida" maxlength="11" size="15" onKeyPress="return sistema.validaNumeros(event)" onBlur="sistema.lpad(this.id,'0',11);">
                                    &nbsp;
                                    <span class="ui-state-default">Banco:</span>
                                    <span class="t-left">
                                        <select id="slct_banco_convalida" class="input-large">
                                        <option value="">--Seleccione--</option>
                                        </select>
                                    </span>
                                    </td>
                                </tr> 
                            </table>
                        </div>                        
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> MARKETING </div>
                        <br>
                        <TABLE class="t-left">
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Medio de Captación:</td>
                            <td>
                            	<select id="slct_medio_captacion" class="input-medium" onChange="ValidaMedioCaptacion();">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>                            
                        </tr>
                        <tr id="val_captacion" style="display:none">
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Descripción de captación:</td>
                            <td>
                            	<input type="text" id="txt_medio_captacion" class="input-xlarge" onKeyPress="sistema.validaAlfanumerico(event)">
                            </td>
                        </tr>
                        <tr id="val_medio_prensa" style="display:none">
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Seleccionar:</td>
                            <td>
                            	<select id="slct_medio_prensa" class="input-large">
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="val_jqgrid_vended" style="display:none">
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Buscar:</td>
                            <td>
                            	<input type="text" id="txt_jqgrid_vended" class="input-large" disabled>
                                <input type="hidden" id="id_cvended_jqgrid">
                            	<span class="formBotones">
                                    <a href="javascript:void(0)" onClick="ListarJqgridVended();" id="btnMantJqgridVended" class="btn btn-azul sombra-3d t-blanco">
                                        <i class="icon-white icon-search"></i>
                                        <span id="spanBtnMantJqgridVended"></span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr id="mantenimiento_jqgrid_vended" style="display:none">
                        	<td colspan="2">
                              <div style="margin-right:3px">
                                <table id="table_jqgrid_vended"></table>
                                <div id="pager_table_jqgrid_vended"></div>
                              </div >                             
                            </td>
                        </tr>                       
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Recepcionista:</td>
                            <td>
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
                        </TABLE>
                       </td></tr>
                       <tr><td>
                        <div class="formBotones">
							<a href="javascript:void(0)" onClick="RegistrarInscrito();" class="btn btn-azul sombra-3d t-blanco">
							<i class="icon-white icon-download-alt"></i>
							<span>Registrar</span>
							</a>
						</div>
                       </td></tr></table>
					  </div><!-- Cont Der-->
                      
                      <div id="frmPersona" title="MANTENIMIENTO PERSONA">
						<div class="form">
						<table style="width:1000px;" align="center"><tr><td>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS PERSONALES DEL POSTULANTE</div>
                        <br>                        	
                        <table class="t-left">                        
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Paterno:
                            <input type="hidden" id="cperson">
                            </td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_paterno" class="input-large" maxlength="50"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Materno:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_materno" class="input-large" maxlength="50"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Nombre(s):</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre" class="input-large" maxlength="50"></td>
                        </tr>
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Estado Civil:</td>
                            <td>
                                <select id="slct_estado_civil" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="S">Soltero(a)</option>
                                <option value="C">Casado(a)</option>
                                <option value="D">Divorsiado(a)</option>
                                <option value="V">Viudo(a)</option>
                                <option value="C2">Comprometido(a)</option>
                                </select>
                            </td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>DNI</td>
                            <td>
                                <input type="text" onKeyPress="return sistema.validaDni(event,'txt_dni')" id="txt_dni" class="input-medium">
                            </td>                                                        
                        </tr>
                        <tr>
                        	<td class="ui-state-default">Fecha Nacimiento:</td>
                            <td><input type="text" id="txt_fecha_nacimiento" class="input-medium" ></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Genero:</td>
                            <td>
                                <select id="slct_sexo" class="input-medium">
                                <option value="">--Selecione--</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                </select>
                            </td>
                        </tr>
                      	</table>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> UBICACION DEL POSTULANTE</div>
                        <br>
                        <table class="t-left">
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Email:</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_email" class="input-large" maxlength="50"></td>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Celular:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_celular" class="input-medium" maxlength="15"></td>                            
                        </tr>            
                        <tr>
                        	<td class="ui-state-default"><span class="t-rojo">*</span>Tel Casa:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_casa" class="input-medium" maxlength="15"></td>
                            <td class="ui-state-default">Tel Ofic:</td>
                            <td><input type="text" onKeyPress="return sistema.validaNumeros(event)" id="txt_telefono_oficina" class="input-medium" maxlength="15"></td>
                        </tr>            
                        <tr>
                            <td class="ui-state-default">Dirección:</td>
                            <td colspan="5">
                            <input type="text" id="txt_direccion" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" maxlength="100">
                            </td>
                        </tr>
                        <tr>                        	
                            <td class="ui-state-default">Referencia:</td>
                            <td colspan="5">
                            <input type="text" id="txt_referencia" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento" class="input-medium" onChange="cargarProvincia();">
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia" class="input-medium" onChange="cargarDistrito();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>                        
                        <tr>
                        	<td class="ui-state-default">Nombre Empresa:</td>
                            <td>
                            <input type="text" id="txt_nombre_trabajo" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" >
                            </td>                        	
                            <td class="ui-state-default">Dirección Empresa:</td>
                            <td colspan="3">
                            <input type="text" id="txt_direccion2" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-xxlarge" >
                            </td>                            
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento2" class="input-medium" onChange="cargarProvincia2();" >
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia2" class="input-medium" onChange="cargarDistrito2();">
                                <option value="">--Selecione--</option>
                                </select>                                	
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito2" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </table>
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS DEL COLEGIO</div>
                        <br>
                        <TABLE class="t-left">
                        <tr>
                        	<td class="ui-state-default">Colegio:</td>
                            <td colspan="2">
                            	<input type="text" id="txt_colegio" onKeyPress="return sistema.validaAlfanumerico(event)" class="input-large" maxlength="50" >                            
                            </td>
                            <td class="ui-state-default">Tipo:</td>
                            <td>
                                <select id="slct_Tipo" class="input-medium" >
                                <option value="">--Selecione--</option>
                                <option value="1">Nacional</option>
                                <option value="2">Particular</option>
                                <option value="3">Parroquia</option>
                                <option value="4">FFAA</option>
                                <option value="5">FFPP</option>
                                </select>
                            </td>                            
                        </tr>
                        <tr>
                            <td class="ui-state-default">Departamento:</td>
                            <td>
                                <select id="slct_departamento3" class="input-medium" onChange="cargarProvincia3();" >
                                <option value="">--Selecione--</option>                                    
                                </select>
                            </td>
                            <td class="ui-state-default">Provincia</td>
                            <td>
                                <select id="slct_provincia3" class="input-medium" onChange="cargarDistrito3();">
                                <option value="">--Selecione--</option>
                                </select>                                   
                            </td>
                            <td class="ui-state-default">Distrito:</td>
                            <td>
                                <select id="slct_distrito3" class="input-medium" >
                                <option value="">--Selecione--</option>
                                </select>
                            </td>
                        </tr>
                        </TABLE>
                        </td></tr>
                        </table>
						</div><!--Form-->
                        <div class="formBotones">
							<a href="javascript:void(0)" id="btnFormPersona" class="btn btn-azul sombra-3d t-blanco">
							<i class="icon-white icon-download-alt"></i>
							<span id="spanBtnFormPersona"></span>
							</a>
						</div>
					  </div><!--Mant Persona-->
                        
                      <div id="frmTrabajador" title="MANTENIMIENTO TRABAJADOR">
						<div class="form">
						<table style="width:1000px;" align="center"><tr><td>							
                        <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> DATOS PERSONALES</div>
                        <br>                        	
                        <table class="t-left">                        
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
                        <tr>
                            <td class="ui-state-default"><span class="t-rojo">*</span>Nombre(s):</td>
                            <td><input type="text" onKeyPress="return sistema.validaAlfanumerico(event)" id="txt_nombre_t" class="input-large"></td>
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
                                <option value="e">Ex Alumno(a)</option>
                                <option value="d">Docente ó Autoridad</option>
                                <option value="w">Data WEB</option>
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
                        
					  </div><!-- Panel de Inscripcion-->
            	</div><!-- Secc Derecha-->
			</div><!-- Cuerpo-->
		</div><!-- Contenido-->
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
