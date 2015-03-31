$(document).ready(function(){
    $("#nav-mantenimientos").addClass("ui-corner-all active");
    institucionDAO.ListaBancos(ListaBancos);
    jQGridCuenta.Cuenta();    
});

ListaBancos=function(data){
$("#cbanco").val(data)
}

