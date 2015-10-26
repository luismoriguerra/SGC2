$(document).ready(function(){

    $('#nav-reportes').addClass('active');//aplica estilo al menu activo
    institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
    $("#slct_instituto, #slct_filial").multiselect({
        selectedList: 4,
        click: function(event, ui){
            cargarCarrera("");
        },
        checkAll: function(){
            cargarCarrera("");
        },
        uncheckAll: function(){
            cargarCarrera("");
        }, // 0-based index
        optgrouptoggle: function(){
            cargarCarrera("");
        },
        afterSelect: function(value){
            cargarCarrera("");
        }
    }).multiselectfilter();

    $("#slct_carrera").multiselect({
        selectedList: 4 // 0-based index
    }).multiselectfilter();

    $(':text[id^="txt_fecha"]').datepicker({
        dateFormat:'yy-mm-dd',
        dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        nextText:'Siguiente',
        prevText:'Anterior'
    });

    //$("#slct_filial").change(function(){cargarCarrera("");});
    //$("#slct_instituto").change(function(){cargarCarrera("");});


});


(function () {
    angular.module('myApp',[])
        .controller('angularController', ['$scope','$http',function($scope, $http) {

            $scope.loaded = false;

            $scope.ListarPostulantes = function() {

                $scope.postulantes = [];
                $scope.loaded = false;


                var cfilial=$("#slct_filial").multiselect("getChecked").map(function(){return this.value;}).get().join(",");
                var cinstit=$("#slct_instituto").multiselect("getChecked").map(function(){return this.value;}).get().join(",");
                var ccarrer=$("#slct_carrera").multiselect("getChecked").map(function(){return this.value;}).get().join(",");
                var fechini=$("#txt_fecha_inicio").val();
                var fechfin=$("#txt_fecha_fin").val();

                var url ='../controlador/controladorSistema.php?' +
                    'comando=inscrito' +
                    '&accion=cargarPostulantes&' +
                    'cfilial='+cfilial+'&cinstit='+cinstit+'&ccarrer='+ccarrer+
                    '&usuario='+$("#hd_idUsuario").val()+'&fechini='+fechini+'&fechfin='+fechfin;

                $http.get(url).
                    success(function(data, status, headers, config) {
                        $scope.postulantes = data;
                        $scope.loaded = true;
                    }).
                    error(function(data, status, headers, config) {

                    });

            }



            $scope.guardarNotas = function () {
                grupoAcademicoDAO.guardarPostulantesNotas(JSON.stringify($scope.postulantes));
                $scope.postulantes = [];
                $scope.loaded = false;
            };


        }]);
})();


cargarCarrera=function(marcado){
    var cfilial=$("#slct_filial").multiselect("getChecked").map(function(){return this.value;}).get();
    var cinstit=$("#slct_instituto").multiselect("getChecked").map(function(){return this.value;}).get();

    if (cfilial && cinstit) {
        carreraDAO.cargarCarreraInstitucionMultiple(sistema.llenaSelectGrupo,'slct_carrera', "", "Carreras");

    }
}






