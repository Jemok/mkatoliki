var mkatolikiAppControllers =angular.module('mkatolikiAppControllers', [

    'mkatolikiAppServices'
]);


mkatolikiAppControllers.controller('mkatolikiController', ['$scope', '$location', function($scope, $location){
    $scope.$on('LOAD', function(){$scope.loading=true});
    $scope.$on('UNLOAD', function(){$scope.loading=false});

    $scope.location = $location;
}]);

mkatolikiAppControllers.controller('contentController', function($scope, $rootScope, $route) {

    var paths = ['/login'];

    $rootScope.$on('$locationChangeSuccess', function() {

        var $$route = $route.current.$$route;
        $scope.contentVisibility = $$route && paths.indexOf($$route.originalPath) < 0;

    });

});
