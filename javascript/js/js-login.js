$(document).ready(function(){
	centrarLogin();	
	//$('#login').click(function(){alert("hello world");});
	$('#btn-loguea').click(loguea);
	$('#txt_usuario').keypress(loginEnterPress);
    $('#txt_password').keypress(loginEnterPress);
})
loginEnterPress=function(e){
    if(e.which == 13){ 
      loguea();
    }
}
loguea=function(){
	$('#msg_usuario, #msg_password').css('display','none');
	$('#mensaje').html('');
	if($.trim($('#txt_usuario').val())=='' && $.trim($('#txt_password').val())==''){
		$('#msg_usuario, #msg_password').css('display','block');
		return false;
	}
	if($.trim($('#txt_usuario').val())==''){
		$('#msg_usuario').css('display','block');
		return false;	
	}
	if($.trim($('#txt_password').val())==''){
		$('#msg_password').css('display','block');
		return false;	
	}
	loginDAO.login();
}
centrarLogin=function(){
	var height=(
			(screen.height)/2 //obtengo el alto de la ventana
			-( //le resto
			270)	
			//$('.login').css('height')). //obtengo el height de mi div-login me da aprox 320px
			//	substring(0,3) //con substring le quito las letras "px" para poderlo restar
		);
	$('.login').css('margin',height+'px 30px');
}