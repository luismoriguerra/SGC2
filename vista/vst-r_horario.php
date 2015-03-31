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
        <script type="text/javascript" src="../javascript/includes/underscore.js"></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
		
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.filter.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.min.js"></script>
        
        <script type="text/javascript" src="../javascript/dao/DAOhorario.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>		
        <script type="text/javascript" src="../javascript/jqGrid/JQGridDocente.js"></script>
        <script type="text/javascript" src="../javascript/js/js-horario2.js"></script>
		<script>
        $().ready(function(){
           // jQuery("#v_lista_grupo table tr td:nth-last-child(1)").remove();
        });

        
        </script>	
        <style>
        #v_lista_grupo table tr td.view{
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
						<li id="list_matricula" onClick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ranking <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
                        <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>REPORTE DE HORARIOS PROGRAMADOS<?   /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
							<div class="t-center">

                            <fieldset id='filtro' style="border:double">
                            <legend><b><font size="+1">FILTROS</font></b></legend>                             
                            
                                <!--Inicio tabla-->
                                <table style="width:90%">
                                       <tr> 
                                            <td class="t-left label">Filial:</td>
                                            <td class="t-left">
                                                <select id="slct_filial" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Filial">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>                                           
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Institución:</td>
                                            <td class="t-left">
                                                <select id="slct_instituto" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                    <optgroup label="Instituto">
                                                        <option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label">Ciclo:</td>
                                            <td class="t-left">
                                                <select id="slct_ciclo" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="t-left label input-large">Fechas de Inicio de Grupos:</td>
                                            <td class="t-left">
                                            Del:
                                            <input type="text" id="txt_fecha_inicio" class="input-medium" value="">
                                            Al
                                            <input type="text" id="txt_fecha_fin" class="input-medium" value="">
                                            </td>
                                       </tr>                                        
                                </table>
                                <!--fin talba-->                                
                                <br>
                                <div style="margin:15px 0px 10px 0px;">
                                    <a id="btn_listar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                                        <i class="icon-white icon-th"></i>
                                        <span>Listar</span>
                                    </a>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                   
                                    <span style="margin:15px 0px 10px 0px;">
                                        <a id="btn_listar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)" onClick="ExportarGrupos();">
                                            <i class="icon-white icon-th"></i>
                                            <span>Exportar Seleccionados</span>
                                        </a>
                                    </span>
                                    
                                </div>
                                <br>
                                <div id="v_lista_grupo" style="display:none;">
                                	<div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table>
                                        <tr class="" align="center">  
                                            <td class="t-center label" ><input id="checkall" type="checkbox" onChange="sistema.checkall('lista_grupos','checkall')"></td>                                                                                  
                                            <td class="t-center label" width="70">FILIAL</td>
                                            <td class="t-center label" width="70">INSTITUCION</td>
                                            <td class="t-center label" width="150">CURRICULA</td>
                                            <td class="t-center label" width="150">CARRERA</td>
                                            <td class="t-center label" width="90">TURNO</td>
                                            <td class="t-center label" width="90">INICIO</td>
                                            <td class="t-center label" width="150">F.INICIO/F FINAL</td>
                                            <td class="t-center label" width="150">HORARIO</td>
                                            <td class="t-center label" >T.A</td>
                                            <td class="t-center label view" >[/]</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 200px">
                                    <table id="lista_grupos" cellspacing="1" cellpadding="1" border="1"> </table>
                                    </div>
                                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onClick="sistema.mostrar_cerrar_buscar('txtGruposAcademicos','buscarGruposAcademicos')">
                                        <i id="buscarGruposAcademicos" class="icon-gray icon-search"></i>
                                        </span>
                                        
                                        <span style="display:inline-block;vertical-align:top">
                                        <input id="txtGruposAcademicos" class="input_buscar" type="text" style="width: 150px;display: none;" onKeyUp="sistema.buscarEnTable(this.value,'lista_grupos')">
                                        </span>
                                    </div>
                            	</div><!--fin listado de grupos-->   
                            </fieldset>                             
                            <br>
                            <fieldset id='horario' style="border:double;display:none">
                            <legend><b><font size="+1">HORARIOS</font></b>
                                    <a class="btn btn-azul sombra-3d t-blanco" onClick='ToogleFiltro();'>
                                        <i class="icon-white icon-zoom-out"></i>                                        
                                    </a>
                            </legend>

                                <br>
                                <div id="v_lista_curso" style="display:none;">
                                    <div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table>
                                        <tr class="" align="center">                                        
                                            <td class="t-center label" width="220">CURSO</td>
                                            <td class="t-center label" width="60">F. Ini Pre</td>
                                            <td class="t-center label" width="60">F. Fin Pre</td>
                                            <td class="t-center label" width="60">F. Ini Vir</td>
                                            <td class="t-center label" width="60">F. Fin Vir</td>
                                            <td class="t-center label" width="220">DOCENTE</td>                                            
                                            <td class="t-center label" >[/]</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 400px">
                                    <table id="lista_cursos" cellspacing="1" cellpadding="1" border="1"> </table>
                                    </div>
                                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onClick="sistema.mostrar_cerrar_buscar('txtCursosAcademicos','buscarCursosAcademicos')">
                                        <i id="buscarCursosAcademicos" class="icon-gray icon-search"></i>
                                        </span>
                                        
                                        <span style="display:inline-block;vertical-align:top">
                                        <input id="txtCursosAcademicos" class="input_buscar" type="text" style="width: 150px;display: none;" onKeyUp="sistema.buscarEnTable(this.value,'lista_cursos')">
                                        </span>
                                    </div>
                                </div><!--fin listado de grupos-->   
                                <br><br>
                                <div id='actualizacion' style='display:none'>
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>CURSO ACADÉMICO</div>
                                <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
                                    <tr>
                                        <td class="t-left label input-xlarge"><b>Curso:</b></td>
                                        <td>
                                            <input type="text" id="txt_curso" class="input-xlarge" disabled>
                                            <input type="hidden" id="ccuprpr" value=''>
                                            <input type="hidden" id="cinstit" value=''>    
                                            <input type="hidden" id="cfilial" value=''>                                            
                                        </td>                            
                                    </tr>
                                    <tr>
                                        <td class="t-left label input-xlarge"><b>Docente:</b></td>
                                        <td>
                                            <input type="text" id="txt_docente" class="input-xlarge" disabled>
                                            <input type="hidden" id="cprofes">
                                            <span class="formBotones">
                                                <a href="javascript:void(0)" onClick="ListarDocente();" id="btnMantDocente" class="btn btn-azul sombra-3d t-blanco">
                                                    <i class="icon-white icon-search"></i>
                                                    <span id="spanBtnMantDocente"></span>
                                                </a>
                                            </span>
                                        </td>                            
                                    </tr>
                                    <tr id="mantenimiento_docente" style="display:none">
                                        <td colspan="2">
                                          <div style="margin-right:3px">
                                            <table id="table_docente"></table>
                                            <div id="pager_table_docente"></div>
                                          </div >                             
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t-left label input-mediun"><b>F. Ini Pre:</b></td>
                                        <td class="t-left">                                            
                                            <input type="text" id="txt_fecha_ini_pre" class="input-medium" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t-left label input-mediun"><b>F. Fin Pre:</b></td>
                                        <td class="t-left">                                            
                                            <input type="text" id="txt_fecha_fin_pre" class="input-medium" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t-left label input-mediun"><b>F. Ini Vir:</b></td>
                                        <td class="t-left">                                            
                                            <input type="text" id="txt_fecha_ini_vir" class="input-medium" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t-left label input-mediun"><b>F. Fin Vir:</b></td>
                                        <td class="t-left">                                            
                                            <input type="text" id="txt_fecha_fin_vir" class="input-medium" value="">
                                        </td>
                                    </tr>                                    
                                </table>
                                <br><br>
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>HORARIOS PROGRAMADOS</div>
                                <table id='detalle_actualizacion'>
                                    <tr>
                                        <td class="t-left label" >
                                          <b>Dia: </b><input type="hidden" value="1" id="txt_cant_hor" >
                                        </td>
                                        <td class="t-left label" >
                                          <b>Hora: </b>
                                        </td>
                                        <td class="t-left label" >
                                          <b>Tipo: </b>
                                        </td>
                                        <td class="t-left label" >
                                          <b>Tipo Ambiente: </b>
                                        </td>
                                        <td class="t-left label" >
                                          <b>Ambiente: </b>
                                        </td>
                                        <td class="t-left label" >
                                          <b>Tiempo Tolerancia: </b>
                                        </td>
                                        <td class="t-left label" >
                                          <b>Estado: </b>
                                        </td>
                                    </tr>
                                    <tr style="display:none" class="FormData">                                       
                                        <td class="t-left">
                                          <select id="slct_dia" style="width:120px">
                                          <option value="">--Seleccione--</option>
                                          </select>
                                        </td>                                      
                                        <td class="t-left">
                                          <select id="slct_hora" style="width:120px">
                                          <option value="">--Seleccione--</option>
                                          </select>
                                        </td>                                     
                                        <td class="t-left">
                                          <select id="slct_tipo" style="width:120px">
                                          <option value="">--Seleccione--</option>
                                          <option value="T">Teórico</option>
                                          <option value="P">Práctico</option>
                                          </select>
                                        </td>
                                        <td class="t-left">
                                          <select id="slct_tipo_ambiente" style="width:120px" onChange='ActualizaAmbiente(this.value,this.id);'>
                                          <option value="">--Seleccione--</option>
                                          </select>
                                        </td>                                      
                                        <td class="t-left">
                                          <select id="slct_ambiente" style="width:120px">
                                          <option value="">--Seleccione--</option>
                                          </select>
                                        </td>                                                                               
                                        <td class="t-left">
                                          <select id="slct_tiempo_tolerancia" style="width:120px">
                                          <option value="">--Seleccione--</option>
                                          </select>
                                        </td>                                      
                                        <td class="t-left">&nbsp;
                                          <select id="slct_estado">
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                          </select>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td colspan="2" align="center">
                                          <a id="btnAgregarHorario" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                                          <span>Agregar</span><span class="icon-white icon-plus"></span>
                                          </a>
                                        </td>
                                        <td colspan="2" align="center">
                                          <a id="btnFormHorario" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                                          <span>Guardar</span><span class="icon-white icon-check"></span>
                                          </a>
                                        </td>                                        
                                    </tr>
                                </table>
                            </fieldset>



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