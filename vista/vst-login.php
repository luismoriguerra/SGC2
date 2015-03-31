<!DOCTYPE html>
<html>
	<head>
		<title>Telesup</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		
		<script type="text/javascript" src="../javascript/sistema.js"></script>

		<script type="text/javascript" src="../javascript/js/js-login.js"></script>
		<script type="text/javascript" src="../javascript/dao/DAOlogin.js"></script>

	</head>
	<body>
		<div id="capaOscura" class="capaOscura" style="display:none;top:0px"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<div class="t-left">
			<div class="login">
				<div style="display:inline-block;"><img src="../images/candado.jpg"></div>
				<div class="form-login" style="display:inline-block;">
					<div style="text-align:right;padding-right:40px;"><span id="msg_usuario" style="display:none" class="t-rojo">Ingrese Usuario <i class="icon-red icon-remove-circle"></i></span></div>
					<label class="label-login t-gris">Usuario :</label>
					<input type="text" id="txt_usuario" autofocus>
					<div style="text-align:right;padding-right:40px"><span id="msg_password" style="display:none" class="t-rojo">Ingrese Contraseña <i class="icon-red icon-remove-circle"></i></span></div>
					<label class="label-login t-gris">Contraseña :</label>
					<input type="password" id="txt_password">
					<div style="text-align:right;margin-top:10px">
						<span id="btn-loguea" class="btn btn-azul sombra-3d"><i class="icon-white icon-lock"></i> INICIAR SESION</span>
					</div>
					<div id="mensaje" class="t-blanco t-12" style="text-align:right;padding-top:15px;"></div>
				</div>
			</div>			
		</div>
	</body>
</html>