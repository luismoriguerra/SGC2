$(document).ready(function(){
	/*dialog*/	
	$('#nav-mantenimiento').addClass('active');//aplica estilo al menu activo	
	/*datepicker*/
	$('#btnAceptar').click(actualizar);
	$('#txt_pass').val('');
	$('#txt_pass_r').val('');

});

actualizar=function(){    
	var pasnue=$('#txt_pass').val();
	var pasnuer=$('#txt_pass_r').val();
	if($.trim(pasnue)!=''){
		if(pasnue==pasnuer){
			grupusuDAO.modificarPass();
		}
		else{
			sistema.msjAdvertencia('Contraseñas no coinciden',200,2000);
		}
	}
	else{
		sistema.msjAdvertencia('Ingrese nueva contraseña',200,2000);
		$('#txt_pass').focus();
	}
}