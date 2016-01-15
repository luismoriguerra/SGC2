(function(){

  angular.module("inscripcion", [])
    .controller('inscripcionCtrl', function($scope){

      $scope.load = function() {
        $scope.data = {sdfsd:"sdf"}
      };

      //don't forget to call the load function
      $scope.load();

    });




})();