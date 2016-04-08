


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
    when('/readings-create', {
         templateUrl: 'partials/readings/create.html',
         controller: 'MainController'
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
    when('/reflections-create', {
            templateUrl: 'partials/reflections/create.html',
            controller: 'ReflectionController'
    }).
    when('/happenings', {
            templateUrl: 'partials/happenings/index.html',
            controller: 'HappeningController'
    }).
    otherwise({
            redirectTo: '/'
    });
}]);