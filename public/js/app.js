


var mkatolikiApp = angular.module('mkatolikiApp', [

    'ngRoute',
    'mkatolikiAppControllers',
    'ui.bootstrap',
    'ui.bootstrap.datetimepicker'
]);

mkatolikiApp.config(['$routeProvider', function($routeProvider){

    $routeProvider.
    when('/login', {
        templateUrl: 'partials/login.html',
        controller: 'LoginController'
    }).
    when('/signup', {
         templateUrl: 'partials/register.html',
         controller: 'SignupController'
    }).
    when('/', {
            templateUrl: 'partials/index.html',
            controller: 'MainController'
    }).
    when('/readings', {
         templateUrl: 'partials/readings/index.html',
         controller: 'ReadingController'
    }).
    when('/prayers', {
          templateUrl: 'partials/prayers/index.html',
          controller: 'PrayerController'
    }).
    when('/jumuiya', {
         templateUrl: 'partials/jumuiya/index.html',
         controller: 'JumuiyaController'
    }).
    when('/reflections', {
           templateUrl: 'partials/reflections/index.html',
            controller: 'ReflectionController'
    }).
    otherwise({
            redirectTo: '/'
    });
}]);