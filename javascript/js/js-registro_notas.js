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
            $scope.busquedaActivada = false;

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
                $scope.busquedaActivada = true;
                $scope.postulantes = [];
                $http.get(url).
                    success(function(data, status, headers, config) {

                        $scope.postulantes = data.data.map(function(item){
                            var min =  ( item.notacar &&  item.notacar > 0) ?  item.notacar : item.nota_min;
                            return {
                                id : item.cpostul,
                                nombre : item.nombre,
                                nota : item.notaalu || 0,
                                minima : min,
                                estado : item.postest || "No Ingreso",
                                carrera : item.carrera
                            }
                        });
                        $scope.cargando = false;
                        $scope.noResultados = !$scope.postulantes.length;

                    }).
                    error(function(data, status, headers, config) {

                    });
            }

            $scope.actualizarPostulante = function (pos) {
                var minima = pos.notacar || 0;
                if (pos.nota >= minima){
                    pos.estado = "Ingreso";
                } else {
                    pos.estado = "No Ingreso";
                }
            }

            $scope.GuardarPuntajePostulantes = function () {
                grupoAcademicoDAO.guardarPuntajePostulantes(JSON.stringify($scope.postulantes));
                $scope.noResultados = true;
            }

            var validar_fechas=function(){
                if($.trim($('#txt_fecha_inicio').val())=='' || $.trim($('#txt_fecha_fin').val())==''){//ninguno tenga campo en blanco
                    sistema.msjAdvertencia('Indicar Fechas: Inicio - Fin</b>',200,2000);return false;
                }
                return true;
            }

            $scope.ExportarPostulantes = function () {

                if( $.trim($("#slct_filial").val())=="" ){
                    sistema.msjAdvertencia("Debe seleccionar una filial",2000);
                    $("#slct_filial").focus();
                }else if( $.trim($("#slct_instituto").val()) == "" ) {
                    sistema.msjAdvertencia("Debe seleccionar una Institucion", 2000);
                    $("#slct_instituto").focus();
                }else if(validar_fechas()) {
                    window.location='../reporte/excel/EXCELpuntajesPostulantes.php?cfilial='+$("#slct_filial").val().join(",") +
                    '&cinstit='+$("#slct_instituto").val().join(",")+
                    '&fechini='+$("#txt_fecha_inicio").val()+
                    '&fechfin='+$("#txt_fecha_fin").val();

                }
            }




        }]);
})();
