$(document).ready(function(){

    //$('#nav-reportes').addClass('active');//aplica estilo al menu activo
    //carreraDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
    //institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    //institucionDAO.cargarFilial(sistema.llenaSelectGrupo,'slct_filial','','Filial');	
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');

    //$('#btn_listar').click(function(){
    //    VisualizarGrupos();
    //});

    //$("#slct_instituto,#slct_filial").change(function(){CargaSemestre()});
    $("#slct_instituto,#slct_filial").multiselect({
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
        .controller('angularController', ['$scope','$http',function($scope, $http) {

            $scope.noResultados = true;

            $scope.cargarPostulantes = function() {
                var url ='../controlador/controladorSistema.php?' +
                    'comando=grupo_academico' +
                    '&action=cargarPostulantes' +
                    '&cfilial='+$("#slct_filial").val().join(",") +
                    '&cinstit='+$("#slct_instituto").val().join(",")+
                    '&fechini='+$("#txt_fecha_inicio").val()+
                    '&fechfin='+$("#txt_fecha_fin").val();

                $scope.cargando = true;
                $scope.noResultados = false;
                $scope.postulantes = [];
                $http.get(url).
                    success(function(data, status, headers, config) {

                        $scope.postulantes = data.data.map(function(item){
                            return {
                                nombre : item.nombre,
                                nota : item.notaalu || 0,
                                minima : item.notacar || 0,
                                estado : item.postest || "Desaprobado"
                            }
                        });
                        $scope.cargando = false;
                        $scope.noResultados = !$scope.postulantes.length;

                    }).
                    error(function(data, status, headers, config) {

                    });
            }

            $scope.actualizarPostulante = function (index , nota) {
                var pos = $scope.postulantes[index];

                var minima = pos.notacar || 0;
                if (nota >= minima){
                    $scope.postulantes[index].estado = "Aprobado";
                } else {
                    $scope.postulantes[index].estado = "Desaprobado";
                }
            }





        }]);
})();
