<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

	<title>SGC2</title>
	<meta charset="utf-8">   
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" CONTENT="Shevchenko(Jorge Salcedo), jorgeshevchenk@gmail.com">
		<link rel="shortcut icon" href="../images/favicon.ico">
        
		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>

		 <script src="../javascript/jqGrid/JQGridTipoCaptacion.js"></script>
    	 <script src="../javascript/js/js-m_tipo_captacion.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Tipo Captación <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Mantenimiento Tipo Captacion <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
							<? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */
							?>
                            <section>
                              <article style="margin-right:3px">
                                <table id="table_tipo_captacion"></table>
                                <div id="pager_table_tipo_captacion"></div>
                              </article>
                            </section>
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
