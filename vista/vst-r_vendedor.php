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
		<script type="text/javascript" src="../javascript/dao/DAOubigeo.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
        <script type="text/javascript" src="../javascript/js/js-r_vendedor.js"></script>
			
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
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Vendedor <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Reporte Vendedor(es) <? /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der" style="text-align: center">
							<div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                       
                                <!--Inicio tabla-->
                                <table >
                                       <tr> 
                                            <td class="t-left label">Paterno:</td>
                                            <td class="t-left">
                                                <input type="text" id="txt_paterno" onKeyPress="return sistema.validaLetras(event)" class="input-large">
                                            </td>                                           
                                        </tr>
                                        <tr>
                                        	<td class="t-left label">Materno:</td>
                                            <td class="t-left">
                                                <input type="text" id="txt_materno" onKeyPress="return sistema.validaLetras(event);" class="input-large">
                                            </td>
                                        </td>
                                        <tr>
                                        	<td class="t-left label">Nombre(s):</td>
                                            <td class="t-left">
                                                <input type="text" id="txt_nombre" onKeyPress="return sistema.validaLetras(event);" class="input-large">
                                            </td>
                                        </td>
                                        <tr>
                                            <td class="t-left label">Tipo Vendedor:</td>
                                            <td class="t-left">
                                                <select id="slct_vendedor" class="input-large"><option value="">--Seleccione--</option></select>
                                            </td>                                            
                                       </tr>                                       
                                    </table>
                                <!--fin talba-->                                
                                <br>
                                <div style="margin:15px 0px 10px 0px;">
                                    <a id="btn_mostar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)" style="margin-right: 10px">
                                        <i class="icon-white  icon-eye-open"></i>
                                        <span>Mostrar</span>
                                    </a>
                                    <a id="btn_exportar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                                        <i class="icon-white icon-download"></i>
                                        <span>Exportar</span>
                                    </a>
                                </div>
                                <br>
                                <style>
                                    .table-indicematricula td,
                                    .table-indicematricula th{
                                        border:1px solid #ccc;
                                    }
                                    
                                </style>
                                <!--tabla indice de matricula-->
                                <div class="corner_top" style="font-weight:bold">
                                <table width='100%' class="table-listado" style="display:none;border:1px solid #ccc;">
                                    <tr class="corner_top ui-state-default" align="center">
                                        <th class="t-center ">Nro</th>
                                        <th class="t-center ">PATERNO</th>
                                        <th class="t-center ">MATERNO</th>
                                        <th class="t-center ">NOMBRE</th>
                                        <th class="t-center ">DNI</th>
                                        <th class="t-center ">TELEFONO</th>
                                        <th class="t-center ">EMAIL</th>
                                        <th class="t-center ">DIRECCION</th>
                                        <th class="t-center ">DISTRITO</th>
                                        <th class="t-center ">FECHA DE INGRESO A TELESUP</th>
                                        <th class="t-center ">TIPO VENDEDOR</th>
                                        <th class="t-center ">CODIGO INT</th>
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
