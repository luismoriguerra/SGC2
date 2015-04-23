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
                
<!--                <script src="../javascript/jqGrid/JQGridPlancurricular.js"></script>-->
                
		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
      
      <script type="text/javascript" src="../javascript/dao/DAOsubir.js"></script>          
      <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
      <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
      <script type="text/javascript" src="../javascript/js/js-mant_asig_alu_con.js"></script>

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
						<li id="mant_concept" onClick="sistema.activaPanel('mant_modulos','panel_mant_modulo')" class="active"><span><i class="icon-gray icon-list-alt"></i> Plan curricular </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-der"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    <div id="panel_mant_modulo" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>GENERAR CURSOS DE PROCEDENCIA</b></div>         
                        <div class="cont-der">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                            <section>
                              <article style="margin-right:3px">
                                <table id="table_persona_ingalum"></table>
                                <div id="pager_table_persona_ingalum"></div>
                              </article>
                            </section>

                            <br>
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>DATOS DE PROCEDENCIA DEL ALUMNO</div>
                              <table style="width:70%">
                                <tr>                    
                                    <td class="t-left label" style="width:150px">Alumno:</td>                                    
                                    <td colspan='3' class="t-left">
                                      <span id='span_nombre' class='input-xxlarge'>&nbsp;</span>   
                                      <input type='hidden' id='txt_cingalu' value=''>
                                      <input type='hidden' id='txt_cgracpr' value=''>
                                    </td>                                          
                                </tr>
                                <tr>                    
                                    <td class="t-left label" style="width:150px">Institución Procedencia:</td>
                                    <td class="t-left">
                                      <span id='span_dinstip' class='input-large'>&nbsp;</span>
                                      <input type='text' id='txt_dinstpro' style='display:none'  value='' class='input-xlarge' onKeyPress="return sistema.validaLetras(event)" />                                     
                                    </td>
                                    <td class="t-left label" style="width:150px">Institución:</td>            
                                    <td class="t-left">
                                      <span id='span_dinstit' class='input-large'>&nbsp;</span>
                                    </td>                                          
                                </tr>
                                <tr>
                                    <td class="t-left label" style="width:150px">Carrera Procedencia:</td>
                                    <td class="t-left">
                                      <span id='span_dcarrep' class='input-large'>&nbsp;</span>
                                      <input type='text' id='txt_dcarpro' style='display:none' value='' class='input-xlarge' onKeyPress="return sistema.validaLetras(event)" />     
                                    </td>          
                                    <td class="t-left label" style="width:150px">Carrera:</td>
                                    <td  class="t-left">
                                      <span id='span_dcarrer' class='input-large'>&nbsp;</span>    
                                    </td>          
                                </tr>
                                <!--<tr>
                                  <td colspan='4'>
                                    <a id="btnActProc" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                                    <span id="spanBtnActProc">.::Actualizar::.</span><span class="icon-hdd"></span>
                                    </a>
                                  </td>
                                </tr>-->
                              </table>
                              <br><br>
                            <section>
                              <article style="margin-right:3px">
                                <table id="table_curso_proc"></table>
                                <div id="pager_table_curso_proc"></div>
                              </article>
                            </section>
                        </div>
    				        </div>
					
        </div>

        <? include_once('frmAluProc.php'); ?>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>

 <? //return sistema.validaNumeros(event) ?>