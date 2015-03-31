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
 
        <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
        <script type="text/javascript" src="../javascript/js/js-persona4.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Persona <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Actualización de Documentos Entregados</b></div>                                 
                        <div class="cont-der" style="text-align: center">
							<? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */
							?>
                           <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>POSTULANTE</div>
                              <div style="margin-right:3px">
                                <table id="table_persona_ingalum"></table>
                                <div id="pager_table_persona_ingalum"></div>
                              </div >                             
                        <br>
                            <table class="t-left">
                                <input type='hidden' id='txt_cingalu' value=''>
                                <input type='hidden' id='txt_cgracpr' value=''>
                                <tr>
                                    <td class="ui-state-default"><span class="t-rojo">*</span>Paterno:</td>
                                    <td ><input type="text" id="txt_paterno" class="input-large" disabled></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default" ><span class="t-rojo">*</span>Materno:</td>
                                    <td ><input type="text" id="txt_materno" class="input-large" disabled></td>
                                </tr>
                                <tr>
                                    <td class="ui-state-default" ><span class="t-rojo">*</span>Nombre:</td>
                                    <td ><input type="text" id="txt_nombre" class="input-large" disabled></td>
                                </tr>
                            </table>
                        <br>                                
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
                                        <select id="slct_modalidad_ingreso" class="input-medium" disabled>
                                        <option value="">--Selecione--</option>
                                        </select>
                                    </td>                                    
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
                                    <td class="ui-state-default"><span class="t-rojo">*</span>Devolución?:</td>
                                    <td>
                                        <select id="slct_devolucion" class="input-medium">
                                        <option value="0" selected>No</option>
                                        <option value="1">Si</option>
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
                        </div>
    				</div>

                    <div id='idboton' style="margin:15px 0px 10px 0px; display:none">
                        <a id="btn_registrar_retiro" onClick="Actualizar();" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                            <i class="icon-white icon-ok-sign"></i>
                            <span>Actualizar Documentos</span>
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
