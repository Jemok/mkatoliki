


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
    when('/prayers-create', {
            templateUrl: 'partials/prayers/create.html',
            controller: 'PrayerController'
    }).
    when('/prayer-types', {
            templateUrl: 'partials/prayer-types/index.html',
            controller: 'PrayerTypeController'
    }).
    when('/prayer-type-create', {
            templateUrl: 'partials/prayer-types/create.html',
            controller: 'PrayerController'
    }).
    when('/jumuiya', {
         templateUrl: 'partials/jumuiya/index.html',
         controller: 'JumuiyaController'
    }).
    when('/create-jumuiya', {
            templateUrl: 'partials/jumuiya/create.html',
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
    when('/reflections-reading/:reading_id', {
            templateUrl: 'partials/readings/show.html',
            controller: 'ReadingController'
    }).
    when('/happenings', {
            templateUrl: 'partials/happenings/index.html',
            controller: 'HappeningController'
    })
        .
        when('/create-happenings', {
            templateUrl: 'partials/happenings/create.html',
            controller: 'HappeningController'
        })
      .
     when('/parishes', {
            templateUrl: 'partials/parishes/index.html',
            controller: 'ParishController'
        }).
        when('/create-parishes', {
            templateUrl: 'partials/parishes/create.html',
            controller: 'JumuiyaController'
        }).
        when('/stations', {
            templateUrl: 'partials/stations/index.html',
            controller: 'StationController'
        }).
        when('/create-stations', {
            templateUrl: 'partials/stations/create.html',
            controller: 'StationController'
        }).
        when('/stations', {
            templateUrl: 'partials/stations/index.html',
            controller: 'StationController'
        }).
        when('/create-stations', {
            templateUrl: 'partials/stations/create.html',
            controller: 'JumuiyaController'
        }).
        when('/raw-jumuiya', {
            templateUrl: 'partials/raw-jumuiya/index.html',
            controller: 'RawJumuiyaController'
        }).
        when('/create-raw-jumuiya', {
            templateUrl: 'partials/raw-jumuiya/create.html',
            controller: 'HappeningController'
        }).
    otherwise({
            redirectTo: '/'
    });

}]);