$(document).ready(function(){
	sistema.activaMenu('nav-opciones');
	$('#nav-opciones').css('display','block');
	$('#actualizarContrasenia').click(actualizarContrasenia);
	$('#adv_1,#adv_2,#adv_3').tooltip({	
			track: true,
			delay: 0,
			showURL: false,
			fixPNG: true,
			//showBody: " - ",
			extraClass: "advert",
			top: -12,
			left: 12
		});
})

actualizarContrasenia=function(){
	var x=sistema.requerido('txt_passActual');
	var y=sistema.requerido('txt_passNuevo');
	var z=sistema.requerido('txt_passNuevoConf');
	if(!x || !y || !z){
		return false;}
		
	if($('#txt_passNuevo').val()!=$('#txt_passNuevoConf').val()){
		sistema.msjAdvertencia('Contraseñas Nuevas no Coinciden');
		return false;
	}
    opcionesDAO.actualizarContrasenia();
}