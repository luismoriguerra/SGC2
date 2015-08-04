$(document).ready(function(){	
	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	//institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');

	ubigeoDAO.cargarDepartamento(sistema.llenaSelect,'slct_departamento,#slct_departamento2,#slct_departamento_c,#slct_departamento_t','');
	personaDAO.listarFiltro(sistema.llenaSelect,"slct_vendedor,#slct_tipo_trabajador_t","");

	institucionDAO.cargarInstitucionValidaG(guardarDatos,'slct_instituto','','Instituto');



});

window.instituciones = [];
guardarDatos = function (data) {
	window.instituciones = data;

}

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
	angular.module('myApp', ['ui.bootstrap', 'gm.datepickerMultiSelect'])
		.controller('angularController', ['$scope','$http',function($scope, $http) {

			$scope.noResultados = false;

			$scope.actualizarOpeven = function () {
				personaDAO.listarOpeven(sistema.llenaSelect,"slct_opeven","");
			};

			$scope.actualizarLista = function() {

				$scope.instituciones = window.instituciones;

				var url ='../controlador/controladorSistema.php?' +
					'comando=persona' +
					'&accion=jqgrid_trabajador' +
					'&page=1' +
					'&rows=9000' +
					'&accion=jqgrid_trabajador' +
					'&cestado=1' +
					'&tvended='+$scope.slctVendedor +
					'&copeven='+$scope.slct_openve;
				$scope.cargando = true;
				$scope.noResultados = false;
				$scope.vendedores = [];
				$scope.sueldoComun = '';
				$http.get(url).
					success(function(data, status, headers, config) {
						$scope.vendedores = data.rows.map(function (ven) {
							var faltas = [];

							if (ven.cell[20]) {
								faltas = ven.cell[20].split("D");
								// PASAMOS LOS DATOS A POSITIVOS
								for (var i=0; faltas[i]; i++) {
									faltas[i] = faltas[i]*1;
								}
							}

							return {
								id: ven.id,
								nombre: ven.cell[3] + " " + ven.cell[1] + " " + ven.cell[2],
								estado: ven.cell[17],
								sueldo: parseFloat(ven.cell[19]),
								descuento: parseFloat(ven.cell[21]),
								horario: ven.cell[22],
								identity: angular.identity,
								activeDate: null,
								montele: parseFloat(ven.cell[23]),
								dinstit: ven.cell[24],
								selectedDates: faltas  // index 20
							}
						});
						$scope.cargando = false;
						$scope.noResultados = !$scope.vendedores.length;

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

			$scope.actualizarTodosHorarios = function () {
				if ($scope.vendedores.length) {
					$scope.vendedores.forEach(function (ven) {
						ven.horario = $scope.horariogeneral;
					});
				}
			};

			$scope.actualizarTodosTelefono = function () {
				if ($scope.vendedores.length) {
					$scope.vendedores.forEach(function (ven) {
						ven.montele = $scope.montotelefonogeneral;
					});
				}
			};

			$scope.actualizarTodosInstitucion = function () {
				if ($scope.vendedores.length) {
					$scope.vendedores.forEach(function (ven) {
						ven.dinstit = $scope.institutogeneral;
					});
				}
			};

			$scope.guardarTodos = function () {
				personaDAO.guardarSueldosVendedores(JSON.stringify($scope.vendedores));
			};

			$scope.open = function($event, vendedor) {
				$event.preventDefault();
				$event.stopPropagation();

				//$scope.opened = true;
				$('#ff-'+vendedor.id).dialog({
					autoOpen : false,
					show : 'fade',hide : 'fade',
					modal:true,
					width:'400',height:'auto',
					dialogClass: "no-close",
					buttons: [
						{
							text: "OK",
							click: function() {
								$( this ).dialog( "close" );

							}
						}
					]
				}).dialog("open");
			};

			$scope.removeFromSelected = function (ven , dt) {
				ven.selectedDates.splice(ven.selectedDates.indexOf(dt), 1);
			}

		}]);
})();