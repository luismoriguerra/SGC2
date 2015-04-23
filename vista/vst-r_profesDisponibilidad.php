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
		
		<script type="text/javascript" src="../javascript/includes/underscore.js"></script>
    <script type="text/javascript" src="../javascript/includes/backbone.js"></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
        
    <script type="text/javascript" src="../javascript/dao/DAOcencap.js"></script>		
		<script type="text/javascript" src="../javascript/dao/DAOhorario.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>    
    <script type="text/javascript" src="../javascript/dao/DAOprofesDisponibilidad.js"></script>		
    <script type="text/javascript" src="../javascript/dao/DAOprofes.js"></script>		
    <script type="text/javascript" src="../javascript/jqGrid/JQGridDocente.js"></script>
    <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
    <script src="../javascript/js/js-r-profesDisponibilidad.js"></script>
	<style>
	#pg_pager_table_persona .ui-icon-plus,
	#pg_pager_table_persona .ui-icon-pencil
	{
		display:  none;
	}

	</style>
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Centros de Captación <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Mantenimiento de Profesores <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
			<? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */  ?>
                            <div>
                            </div>
                            <input type="hidden" id="cencap" value="">
                            <section>
                              <article style="margin-right:3px">
                               <!--  <table id="table_cencap"></table>
                                <div id="pager_table_cencap"></div> -->
                                <table id="table_docente"></table>
                                <div id="pager_table_docente"></div>
                              </article>
                            </section>
                        </div>
    				</div>
    				<table style="width:90%" id="HorarioDisponible">
    					
    					<tr id="" style="">
                                          <td colspan="6">
                                          	<table width="100%" id="diasDisponibles">
                                            <tr class="barra4 contentBarra t-blanco t-left">
                                              <th><i class="icon-white icon-th"></i></th>
                                              <th>Dia <input type="hidden" name="" id="txt_cant_dis" value="0"></th>
                                              <th>Hora Inicio</th>
                                              <th>Hora Fin</th>
                                              <th>Estado</th>
                                              <th>Actualiza Descripcion</th>
                                            </tr>
                                            
                                            </table>
                                          </td>
                                      </tr>
                                      <tr id="OperacionModulos" style="">
                                          <td colspan="7">
                                              <span class="formBotones" id="btn_NuevoModulo">
                                				<a href="javascript:void(0)" onClick="AgregarRow();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-plus"></i>
                                                <span>Agregar mas horas</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones" id="btn_GuardaNuevo" style="d">
                                				<a href="javascript:void(0)" onClick="GuardarDisponibilidad();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-check"></i>
                                                <span>Guardar Horario Disponible</span>
                                                </a>
                                           	  </span>
                                              <span class="formBotones">
                                				<a href="javascript:void(0)" onClick="Cancelar();" class="btn btn-azul sombra-3d t-blanco">
                                                <i class="icon-white icon-trash"></i>
                                                <span>Descartar Cambios</span>
                                                </a>
                                           	  </span>
                                            </td>
                                          </tr>
    				</table>
<table style="text-align: center;width: 100%">
            <tr>
                <td  align="center">
                <span class="formBotones">
                    <a href="javascript:void(0)" onClick="Exportar_Disponibilidad();" class="btn btn-azul sombra-3d t-blanco" id="sendData">
                        <i class="icon-white icon-check"></i>
                        <span>Exportar en Listado</span>
                    </a>
                </span>
            </td>
        </tr>
     </table>
            	</div>
			</div>
		</div>
        <?php require_once('frmProfes.php'); ?>        
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?php require_once('ifrm-footer.php'); ?>	

<script type="text/template" id="TemplateDisponible">

<tr class="newrow row-<%= id %>">
	<td></td>
	<td>
<input type="hidden" value="0" id="cdispro_<%= id %>">
	<select name="slct_dia_<%= id %>" id="slct_dia_<%= id %>">
		<option value="01">DOMINGO</option>
		<option value="02">LUNES</option>
		<option value="03">MARTES</option>
		<option value="04">MIERCOLES</option>
		<option value="05">JUEVES</option>
		<option value="06">VIERNES</option>
		<option value="07">SABADO</option>
	</select>
	</td>
	<td>
	<select name="" id="slct_hini_h_<%= id %>" class="hini">
  <% for(var i= 0 ; i< 24 ; i++){   %><option value="<% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %>"><% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %></option><%  } %>
  </select>
  <select name="" id="slct_hini_m_<%= id %>">
  <% for(var i= 0 ; i< 60 ; i++){   %><option value="<% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %>"><% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %></option><%  } %>
  </select>
  </td>
	<td>
	<select name="" id="slct_hfin_h_<%= id %>" class="hfin">
  <% for(var i= 0 ; i< 24 ; i++){   %><option value="<% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %>"><% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %></option><%  } %>
  </select>
  <select name="" id="slct_hfin_m_<%= id %>">
  <% for(var i= 0 ; i< 60 ; i++){   %><option value="<% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %>"><% if(i<10){ %><%= '0'+i %><% } else{ %><%= i %><% } %></option><%  } %>
  </select>
  </td>
  <td>
  <select name="" id="slct_estado_<%= id %>">
  <option value="1">Activo</option>
  <option value="0">Inactivo</option>
  </select>
  </td>
	<td>
		<span class="formBotones newbotones_<%=id%>">
			<a href="javascript:void(0)" onClick="removerRow(<%= id %>);" class="btn btn-azul sombra-3d t-blanco">
            <i class="icon-white icon-trash"></i>
            <span></span>
            </a>
       	  </span>
	</td>
	</tr>
</script>

	</body>
</html>
