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
        
        <script type="text/javascript" src="../javascript/dao/DAOcencap.js"></script>		
		<script type="text/javascript" src="../javascript/dao/DAOhorario.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>		
        <script type="text/javascript" src="../javascript/dao/DAOprofes.js"></script>		
        <script type="text/javascript" src="../javascript/jqGrid/JQGridDocente.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
        <script src="../javascript/js/js-profesHorarios.js"></script>
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
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Horario de Profesores <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
                            <div>
                            </div>
                            <input type="hidden" id="cencap" value="">
                            <section>
                              <article style="margin-right:3px">
                                <table id="table_docente"></table>
                                <div id="pager_table_docente"></div>
                              </article>
                            </section>
                            <table style="text-align: center;width: 100%">
                            	<tr>
                <td  align="center">
                <input type="hidden" value="" id="gruequi">
                <span class="formBotones" id="btn_NuevoConcepto">
                    <input type="hidden" value="1" id="txt_cant_cur" >
                    <a href="javascript:void(0)" onClick="Exportar_grilla();" class="btn btn-azul sombra-3d t-blanco">
                        <i class="icon-white icon-plus"></i>
                        <span>Exportar Horario en Grilla</span>
                    </a>
                </span>
                <span class="formBotones">
                    <a href="javascript:void(0)" onClick="ExportarDocenteListado();" class="btn btn-azul sombra-3d t-blanco" id="sendData">
                        <i class="icon-white icon-check"></i>
                        <span>Exportar Horario en Listado</span>
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
        <?PHP require_once('frmProfes.php')?>        
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
