$(document).ready(function(){

});

GenerarCronoAuto=function(){
    var sem=$("#slct_csemaca").val();
    if( $.trim(sem)=='' ){
        alert('Seleccione semestre');
    }
    else{
        datos={
            semestre:sem,
            comando:'cronograma',
            accion:'autocronograma'
        };
        cronogramaDAO.autoCronograma(datos);
    }
};
