$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');
	$('#btn_exportar').click(function(){Exportar()});
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor","");
	
    $("#slct_instituto").multiselect({
    selectedList: 4 // 0-based index
    }).multiselectfilter();

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});
        
});

(function () {
    angular.module('myApp', [])

        .controller('rangoFechas', function($scope) {
            // fecha actual
            $scope.date = new Date();

            $scope.meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
            // mes actual en texto
            $scope.matriculaMes = $scope.meses[$scope.date.getMonth()];
            $scope.dias = [];
            $scope.anio = $scope.date.getFullYear();
            // rango de anios a mostrar
            $scope.anios = [
                $scope.date.getFullYear() -2 ,
                $scope.date.getFullYear() -1 ,
                $scope.date.getFullYear()
            ];
            //ultimo dia del mes
            $scope.lastDay = new Date($scope.anio, $scope.date.getMonth() + 1, 0).getDate();
            $scope.ActualizarDiasMes = function () {
                var i;

                $scope.dias = [];
                for (i = 1; i <= $scope.lastDay; i++) {
                    $scope.dias.push(i);
                }
            };

            $scope.actualizarRango = function () {
                // actualiza el ulitmo dia
                $scope.lastDay = new Date($scope.anio, $scope.meses.indexOf($scope.matriculaMes) + 1, 0).getDate();
                // actualiza el total de dias
                $scope.ActualizarDiasMes();
                //selecciona el presente dia del mes o el ultimo dia del mes antiguo
                if ($scope.meses[$scope.date.getMonth()] == $scope.matriculaMes && $scope.anio == $scope.date.getFullYear()) {
                    $scope.DiaIni = $scope.DiaFin = $scope.date.getDate();
                } else {
                    $scope.DiaIni = $scope.DiaFin = $scope.lastDay = new Date($scope.anio, $scope.meses.indexOf($scope.matriculaMes) + 1, 0).getDate();
                }
            };


            $scope.ActualizarDiasMes();
            $scope.DiaIni = $scope.DiaFin = $scope.date.getDate();





        });
})();

ActualizaCentroOpe=function(){
    personaDAO.listarOpeven(sistema.llenaSelect,"slct_opeven","");
};

Exportar=function(){
    if( $.trim($("#slct_vendedor").val())=="" ){
        sistema.msjAdvertencia("Debe seleccionar un tipo vendedor",2000);
        $("#slct_filial").focus();
    }else if( $.trim($("#slct_opeven").val()) == "" ){
        sistema.msjAdvertencia("Debe seleccionar un centro de operaciones",2000);
        $("#slct_instituto").focus();
    }else if( $("#txt_fecha_matric").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Matricula",2000);
        $("#txt_fecha_matric").focus();
    }else if( $("#txt_pago_mensual").val() == "" ){
        sistema.msjAdvertencia("Ingrese Pago Mensual",2000);
        $("#txt_pago_mensual").focus();
    }else{
	window.location='../reporte/excel/EXCELvendedores2.php?cinstit='+$("#slct_instituto").val().join(",")
                    +'&copeven='+$("#slct_opeven").val()
                    +'&dopeven='+$("#slct_opeven option[value='"+$("#slct_opeven").val()+"']").html()
                    +'&tvended='+$("#slct_vendedor").val()
                    +'&dvendedor='+$("#slct_vendedor option[value='"+$("#slct_vendedor").val()+"']").html()
                    +'&anio='+$("#anio option:selected").attr("label")
                    +'&mes='+$("#matriculaMes").val()
                    +'&ini='+$("#DiaIni option:selected").attr("label")
                    +'&fin='+$("#DiaFin option:selected").attr("label")
                    +'&usuario='+$("#hd_idUsuario").val();
    }
}

