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
        
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOcurso.js"></script>
		<script type="text/javascript" src="../javascript/js/js-mant_cursos.js"></script>
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
						<li id="mant_concept" onClick="sistema.activaPanel('mant_curso','panel_mant_curso')" class="active"><span><i class="icon-gray icon-list-alt"></i> Cursos </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    <div id="panel_mant_curso" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>MANTENIMIENTO DE CURSOS</b></div>         
                        <div class="cont-der">
                          <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                      <tr>                                     
                                          <td class="t-left label">Institución:</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_instituto" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>                            
                                      </tr> 
                                      <tr>
                                          <td class="t-left label">Curso:</td>
                                          <td colspan="5" class="t-left">
                                              <select id="slct_curso" class="input-xxlarge"><option value="">--Selecione--</option></select>
                                              &nbsp;
                                              <span class="formBotones" id="btn_NuevoCurso">
                                				<a href="javascript:void(0)" onClick="NuevoCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-download-alt"></i>
                                                <span>Agregar Curso</span>
                                                </a>
                                           	  </span>
                                              &nbsp;
                                              <span class="formBotones" id="btn_ActualizaCurso">
                                				<a href="javascript:void(0)" onClick="ModificaCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-refresh"></i>
                                                <span>Modificar Curso</span>
                                                </a>
                                           	  </span>
                                          </td>
                                      </tr>
                                      <tr id="valNuevoCurso" style="display:none">
                                          <td class="t-left label">Nuevo Curso:</td>
                                          <td colspan="5" class="t-left">
                                              <input type="text" id="txt_NuevoCurso" value="" class="input-xlarge"/>
                                          </td>
                                        </tr>
                                        <tr id="valNuevoCurso2" style="display:none">
                                          <td class="t-left label">Abreviatura:</td>
                                          <td colspan="5" class="t-left">
                                              <input type="text" id="txt_NuevoAbrev" value="" class="input-xlarge"/>
                                              &nbsp;
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="GuardarNuevoCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-ok"></i>
                                                <span>Guardar</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="CancelarNuevoCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-remove"></i>
                                                <span>Cancelar</span>
                                                </a>
                                           	  </span>
                                          </td>
                                        </tr>
                                        <tr id="valModificaCurso" style="display:none">
                                          <td colspan="6">
                                          	<table>
                                            <tr>
                                          	  <td class="t-left label">Curso:</td>
                                         	  <td colspan="5" class="t-left">
                                              	<input type="text" id="txt_ModifCurso" value="" class="input-xlarge"/>
                                          	  </td>
                                        	</tr>
                                        	<tr>
                                          	  <td class="t-left label">Abreviatura:</td>
                                          	  <td colspan="5" class="t-left">
                                              	<input type="text" id="txt_ModifAbrev" value="" class="input-xlarge"/>
                                              	&nbsp;
                                              	<span class="formBotones">
                                                    <a href="javascript:void(0)" onClick="GuardarModifCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                    <i class="icon-white icon-ok"></i>
                                                    <span>Guardar</span>
                                                    </a>
                                           	  	</span>
                                              	<span class="formBotones">
                                                    <a href="javascript:void(0)" onClick="CancelarModifCurso();" class="btn btn-azul sombra-3d t-blanco">
                                                    <i class="icon-white icon-remove"></i>
                                                    <span>Cancelar</span>
                                                    </a>
                                           	  	</span>
                                          	  </td>
                                       	 	</tr>
                                            </table>
                                          </td>
                                        </tr>
                                  </table>
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
