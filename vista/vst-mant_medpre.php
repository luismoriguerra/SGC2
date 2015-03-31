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
		<script src="../javascript/jqGrid/JQGridMedpre.js"></script>
        <script src="../javascript/dao/DAOMedpre.js"></script>
        <script src="../javascript/dao/DAOinstitucion.js"></script>
        <script src="../javascript/js/js-mant_Medpre.js"></script>

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
            <li id="list_matricula" onClick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Medios de Prensa <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
        </ul>
        </div>
        <div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
        <div class="secc-der" id="secc-der">
                    
        <div id="panel_matricula" style="display:block">
            <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>MANTENIMIENTO DE MEDIOS DE COMUNICACIÓN MASIVA <? /*aqui va el titulo q presentara  */ ?></b></div>         
            <div class="cont-der">
            <? /*
                            No se usa el filtro de Instituto, ya que se considerarán grupos de usuarios generales.<br>
                            Porque se da la opcion de ver todo a los usuarios.
                                            */  ?>
                <div>
                </div>
                <input type="hidden" id="moding" value="">
                <section>
                  <article style="margin-right:3px">
                    <table id="table_medpre"></table>
                    <div id="pager_table_medpre"></div>
                  </article>
                </section>
            </div>
    </div>

            	</div>
			</div>
		</div>
        <?require_once('frmMedpre.php')?>        
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
