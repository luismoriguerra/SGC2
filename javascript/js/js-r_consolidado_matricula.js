$(document).ready(function(){
	
	$('#nav-reportes').addClass('active');
	$('#btn_exportar').click(function(){Exportar()});
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	$("#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
        
    $('#btn_mostar').click(function(){listarIndiceMatricula()});
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

		.controller('ConsolidadoMatricula', function($scope) {
			$scope.date = new Date();

			$scope.meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
			$scope.matriculaMes = $scope.meses[$scope.date.getMonth()];
			$scope.lastDay = new Date(new Date().getYear(), $scope.date.getMonth() + 1, 0).getDate();
			$scope.dias = [];
			$scope.ActualizarDiasMes = function () {
				var i;

				$scope.dias = [];
				for (i = 1; i <= $scope.lastDay; i++) {
					$scope.dias.push(i);
				}
			};

			$scope.ActualizarDiasMes();
			$scope.DiaIni = $scope.DiaFin = $scope.date.getDate();

			$scope.actualizarRango = function () {
				if ($scope.meses[$scope.date.getMonth()] == $scope.matriculaMes) {
					$scope.DiaIni = $scope.DiaFin = $scope.date.getDate();
				} else {
					$scope.DiaIni = $scope.DiaFin = $scope.lastDay = new Date(new Date().getYear(), $scope.meses.indexOf($scope.matriculaMes) + 1, 0).getDate();
					$scope.ActualizarDiasMes();
				}
			};



		});
})()




Exportar=function(){
    if( $.trim($("#slct_filial").val())=="" ){
        sistema.msjAdvertencia("Debe seleccionar una filial",2000);
        $("#slct_filial").focus();
    }else if( $.trim($("#slct_instituto").val()) == "" ){
        sistema.msjAdvertencia("Debe seleccionar una Institucion",2000);
        $("#slct_instituto").focus();
    }else if( $("#txt_fecha_matric").val() == "" ){
        sistema.msjAdvertencia("Ingrese Fecha Matricula",2000);
        $("#txt_fecha_matric").focus();
    }else{
	window.location='../reporte/excel/EXCELconsolidadoMatricula.php?cfilial='+$("#slct_filial").val().join(",")                    
                    +'&cinstit='+$("#slct_instituto").val().join(",")
                    +'&mes='+$("#matriculaMes").val()
                    +'&ini='+$("#DiaIni").val()
                    +'&fin='+$("#DiaFin").val()
                    +'&usuario='+$("#hd_idUsuario").val();
    }
}

