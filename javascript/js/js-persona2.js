$(document).ready(function(){	
	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	ubigeoDAO.cargarDepartamento(sistema.llenaSelect,'slct_departamento,#slct_departamento2,#slct_departamento_c,#slct_departamento_t','');
	personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor,#slct_tipo_trabajador_t","");
})

ActVisualiza=function(){	
	$("#mantenimiento_jqgrid_vended").html('<div style="margin-right:3px">'+
												'<table id="table_jqgrid_vended"></table>'+
												'<div id="pager_table_jqgrid_vended"></div>'+
											'</div >');
	jqGridPersona.jqgridVended();
    
    //CARGAR SELECT OPEVEN
   
    personaDAO.listarOpeven(sistema.llenaSelect,"slct_opeven","");
    
    
}

cargarProvincia=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento','slct_provincia','');	
}

cargarDistrito=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento','slct_provincia','slct_distrito','');
}

cargarProvincia2=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento2','slct_provincia2','');	
}

cargarDistrito2=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento2','slct_provincia2','slct_distrito2','');
}

cargarProvinciat=function(){
	ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','');	
}

cargarDistritot=function(){
	ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_t','slct_provincia_t','slct_distrito_t','');
};


(function () {
	angular.module('myApp', [])
		.controller('angularController', ['$scope','$http',function($scope, $http) {

			$scope.actualizarLista = function() {
				var url ='../controlador/controladorSistema.php?' +
					'comando=persona' +
					'&accion=jqgrid_trabajador' +
					'&page=1' +
					'&rows=9000' +
					'&accion=jqgrid_trabajador' +
					'&cestado=1' +
					'&tvended='+$scope.slctVendedor;

				$scope.vendedores = [];
				$scope.sueldoComun = '';
				$http.get(url).
					success(function(data, status, headers, config) {
						$scope.vendedores = data.rows.map(function (ven) {
							return {
								id: ven.id,
								nombre: ven.cell[3] + " " + ven.cell[1] + " " + ven.cell[2],
								estado: ven.cell[17],
								sueldo: parseInt(ven.cell[19], 10)
							}
						});
					}).
					error(function(data, status, headers, config) {

					});

			}

			$scope.actualizarTodosLosSueldos = function () {
				if ($scope.vendedores.length) {
					$scope.vendedores.forEach(function (ven) {
						ven.sueldo = $scope.sueldoComun;
					});
				}
			};

			$scope.guardarTodos = function () {
				var datosAGuardar = [],
					sueldo;

				$scope.vendedores.forEach(function (ven) {
					sueldo = (ven.sueldo) ? ven.sueldo : 0;
					datosAGuardar.push(ven.id + "*" + sueldo);
				});

				datosAGuardar = datosAGuardar.join("|");
				personaDAO.guardarSueldosVendedores(datosAGuardar);
			};



		}]);
})();