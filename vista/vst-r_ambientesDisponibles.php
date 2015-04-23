<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SGC2</title>
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
		<script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
		<script type="text/javascript" src="../javascript/js/js-ambDisp.js"></script>
    </head>

	<body>
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?php require_once('ifrm-header.php'); ?>	
		<?php require_once('ifrm-nav.php'); ?>	
        <div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:0px;">
					<ul class="lca" style="display:none">
						<li id="mant_concept" onClick="sistema.activaPanel('mant_modulos','panel_mant_modulo')" class="active"><span><i class="icon-gray icon-list-alt"></i> Modulos </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    <div id="panel_mant_modulo" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>MANTENIMIENTO DE MODULOS</b></div>         
                        <div class="cont-der">
                          <div class="t-center">
                            <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                                   <table style="width:90%">
                                       <tr>                                  
                                          <td class="t-left label">ODE:</td>
                                            <td class="t-left">
                                                <select id="slct_filial" class="input-xlarge" style="" >
                                                  <optgroup label="Filial">
                                                    <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td> 
                                          <td class="t-left label">Ambientes:</td>
                                          <td colspan="5" class="t-left">
                                              <!-- <select id="slct_ambiente" class="input-xlarge"><option value="">--Selecione--</option></select> -->
                                              <select id="slct_ambiente" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                  <optgroup label="Ambiente">
                                                    <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                          </td>
                                          
                                      </tr>
                                      <tr>                                  
                                          <td class="t-left label">Institución:</td>
                                          <td class="t-left">
                                              <select id="slct_instituto" class="input-large"><option value="">--Selecione--</option></select>
                                          </td>
                                           <td class="t-left "></td>
                                          <td colspan="5" class="t-left"></td>
                                      </tr>
                                      <tr>
                                          <td colspan="6">&nbsp;</td>
                                      </tr>
                                     
                                      <tr id="OperacionModulos" style="">
                                          <td colspan="7">
                                              <span class="formBotones" id="btn_Exportar">
                                				        <a href="javascript:void(0)" onClick="ExportarAmbientes();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Exportar ambientes (Excel)</span>
                                                </a>
                                           	  </span>
                                              
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
