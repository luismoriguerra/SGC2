<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SEGURA, Consultores de Dirección</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/tooltip/jquery.dimensions.js"></script>
		<script type="text/javascript" src="../javascript/includes/tooltip/jquery.tooltip.min.js"></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>
		
		<script type="text/javascript" src="../javascript/js/js-opciones.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOopciones.js"></script>
	</head>

	<body>
		<?require_once('ifrm-header.php')?>	
		<?require_once('ifrm-nav.php')?>	
		<div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:150px;">
					<ul class="lca">
						<li id="list_datos" onclick="sistema.activaPanel('list_datos','panel_datos')" class="active"><span><i class="icon-gray icon-list-alt"></i> Datos</span></li>
						<li id="list_contrasenia" onclick="sistema.activaPanel('list_contrasenia','panel_contrasenia')"><span><i class="icon-gray icon-lock"></i> Contraseña</span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-izq"></i></div>
				<div class="secc-der" id="secc-der">
					<div id="panel_datos" style="display:block">
						<div class="barra1"><i class="icon-gray icon-list-alt"></i> Datos Personales</div>
						<div class="cont-der">
							<table class="t-12">
								<tr>
									<td class="t-right label">Nombres</td>
									<td>:</td>
									<td class="t-izquierda"><span><?=$_SESSION['SECON']['nombres']?></span></td>
								</tr>
								<tr>
									<td class="t-right label">Ap. Paterno</td>
									<td>:</td>
									<td class="t-izquierda"><span><?=$_SESSION['SECON']['paterno']?></span></td>
								</tr>
								<tr>
									<td class="t-right label">Ap. Materno</td>
									<td>:</td>
									<td class="t-izquierda"><span><?=$_SESSION['SECON']['materno']?></span></td>
								</tr>
								<tr>
									<td class="t-right label">DNI</td>
									<td>:</td>
									<td class="t-izquierda"><span><?=$_SESSION['SECON']['dni']?></span></td>
								</tr>
							</table>
						</div>
					</div>
					<div id="panel_contrasenia" style="display:none">
						<div class="barra1"><i class="icon-gray icon-lock"></i> Modificar Contraseña</div>
						<div class="cont-der">
							<table class="t-12">
								<tr>
									<td class="t-right label">Contraseña Actual</td>
									<td>:</td>
									<td class="t-izquierda">
										<input type="password" id="txt_passActual">
										<i id="adv_1" title="Campo Obligatorio" style="display:none" class="icon-red icon-exclamation-sign"></i>
									</td>
								</tr>
								<tr>
									<td class="t-right label">Nueva Contraseña</td>
									<td>:</td>
									<td class="t-izquierda">
										<input type="password" id="txt_passNuevo">
										<i id="adv_2" title="Campo Obligatorio" style="display:none" class="icon-red icon-exclamation-sign"></i>
									</td>
								</tr>
								<tr>
									<td class="t-right label">Confirmar Nueva Contraseña</td>
									<td>:</td>
									<td class="t-izquierda">
										<input type="password" id="txt_passNuevoConf">
										<i id="adv_3" title="Campo Obligatorio" style="display:none" class="icon-red icon-exclamation-sign"></i>
									</td>
								</tr>
								<tr>
									<td colspan=3 class="t-center">
										<div style="margin:8px"><span id="actualizarContrasenia" class="btn btn-azul sombra-3d t-blanco"><i class="icon-white icon-download-alt"></i>Guardar</span></div>
									</td>
								</tr>
							</table>
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div id="capaMensaje" class="capaMensaje" style="display:none">
		</div>
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>