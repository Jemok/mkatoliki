var mkatolikiAppControllers =angular.module('mkatolikiAppControllers', [

    'mkatolikiAppServices'
]);

mkatolikiAppControllers.controller('LoginController', ['$scope', '$http', '$location', 'userService', function($scope, $http, $location, userService){

    $scope.login = function(){
        userService.login(
            $scope.email, $scope.password,

            function(response){
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the login process. Try again later');
            }
        );
    }

    $scope.email = '';
    $scope.passwprd = '';

    if(userService.checkIfLoggedIn()){
        $location.path('/');
    }
}]);

mkatolikiAppControllers.controller('mkatolikiController', ['$scope', function($scope){
    $scope.$on('LOAD', function(){$scope.loading=true});
    $scope.$on('UNLOAD', function(){$scope.loading=false});

}]);

mkatolikiAppControllers.controller('SignupController', ['$scope', '$location' ,'$http', 'userService', function($scope, $location, $http, userService){

    $scope.signup = function(){
        userService.signup(
            $scope.name, $scope.email, $scope.password,
            function(response){
                alert('Great! You are now signed in! Welcome, ' +$scope.name + '!');

                $location.path('/');
            },
            function(response){

                alert('Something went wrong with the sign up process. Try again later');
            }
        );
    }

    $scope.name = '';
    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn()){
        $location.path('/');
    }
}]);

mkatolikiAppControllers.controller('PrayerController', ['$scope', '$http', 'userService', 'prayerService', function($scope, $http , userService, prayerService){

    $scope.refresh = function(){

        $scope.$emit('LOAD');


        prayerService.getAll(function(response){

            $scope.prayers = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try Again Later');
        });
    }

    $scope.create = function(){

        prayerService.create({

            title: $scope.currentTitle,
            body: $scope.currentBody

        }, function(){

            $('#addPrayerModal').modal('toggle');

            $scope.currentPrayerReset();
            $scope.refresh();
        }, function(response){

            alert('Some error occurred while creating the prayer');

        });
    }

    $scope.remove = function(prayerId){

        if(confirm('Are you sure you want to remove this prayer?')){

            prayerService.remove(prayerId, function(){

                alert('Prayer removed Successfully.');
                $scope.refresh();

            }, function(){
                alert('Some errors occurred while deleting the Prayer')
            });
        }
    }

    $scope.currentPrayerReset = function(){

        $scope.currentTitle = "";
        $scope.currentBody = "";

    }


    $scope.load = function(prayerId){

        prayerService.getById(prayerId, function(response){

            $scope.currentPrayerId = response.prayer.id;
            $scope.currentTitle = response.prayer.title;
            $scope.currentBody = response.prayer.body;


            $('#updatePrayerModal').modal('toggle');



        }, function(){

            alert('Some Errors Occurred, Try again later');
        });
    }

    $scope.update = function(){

        prayerService.update(

            $scope.currentPrayerId,
            {
                title: $scope.currentTitle,
                body: $scope.currentBody
            },function(response){

                $('#updatePrayerModal').modal('toggle');
                $scope.currentPrayerReset();
                $scope.refresh();


            }, function(response){

                alert('Some error occurred while updating, Try again');
            }


        );
    }




    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.prayers = [];

    $scope.refresh();
    $scope.currentPrayerReset();

}]);

mkatolikiAppControllers.controller('JumuiyaController', ['$scope', '$http', 'userService', 'jumuiyaService', function($scope, $http , userService, jumuiyaService){

    $scope.refresh = function(){

        $scope.$emit('LOAD');


        jumuiyaService.getAll(function(response){

            $scope.jumuiyas = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try Again Later');
        });
    }

    $scope.remove = function(jumuiyaId){

        if(confirm('Are you sure you want to remove this Jumuiya Event?')){

            jumuiyaService.remove(jumuiyaId, function(){

                alert('Jumuiya Event removed Successfully.');
                $scope.refresh();

            }, function(){
                alert('Some errors occurred while deleting the Jumuiya Event')
            });
        }
    }

    $scope.create = function(){

        jumuiyaService.create({

            location: $scope.currentLocation,
            happening_on: $scope.currentHappeningOn

        }, function(){

            $('#addJumuiyaModal').modal('toggle');

            $scope.currentJumuiyaReset();
            $scope.refresh();
        }, function(response){

            alert('Some error occurred while creating the jumuiya');

        });
    }

    $scope.currentJumuiyaReset = function(){

        $scope.currentLocation = "";
        $scope.currentHappeningOn = "";

    }


    $scope.load = function(jumuiyaId){

        jumuiyaService.getById(jumuiyaId, function(response){

            $scope.currentJumuiyaId = response.jumuiya.id;
            $scope.currentLocation = response.jumuiya.location;
            $scope.currentHappeningOn = response.jumuiya.happening_on;


            $('#updateJumuiyaModal').modal('toggle');



        }, function(){

            alert('Some Errors Occurred, Try again later');
        });
    }

    $scope.update = function(){

        jumuiyaService.update(

            $scope.currentJumuiyaId,
            {
                location: $scope.currentLocation,
                happening_on: $scope.currentHappeningOn
            },function(response){

                $('#updateJumuiyaModal').modal('toggle');
                $scope.currentJumuiyaReset();
                $scope.refresh();


            }, function(response){

                alert('Some error occurred while updating, Try again');
            }


        );
    }




    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.jumuiyas = [];

    $scope.refresh();
    $scope.currentJumuiyaReset();

}]);

mkatolikiAppControllers.controller('ReflectionController', ['$scope', '$http', 'userService', 'reflectionService', function($scope, $http , userService, reflectionService){

    $scope.refresh = function(){

        $scope.$emit('LOAD');


        reflectionService.getAll(function(response){

            $scope.reflections = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try Again Later');
        });
    }

    $scope.create = function(){

        reflectionService.create({

            body: $scope.currentBody

        }, function(){

            $('#addReflectionModal').modal('toggle');

            $scope.currentReflectionReset();
            $scope.refresh();
        }, function(response){

            alert('Some error occurred while creating the reflection');

        });
    }

    $scope.remove = function(reflectionId){

        if(confirm('Are you sure you want to remove this reading?')){

            reflectionService.remove(reflectionId, function(){

                alert('Reflection removed Successfully.');
                $scope.refresh();

            }, function(){
                alert('Some errors occurred while deleting the reflection')
            });
        }
    }

    $scope.currentReflectionReset = function(){

        $scope.currentBody = "";

    }


    $scope.load = function(reflectionId){

        reflectionService.getById(reflectionId, function(response){

            $scope.currentReflectionId = response.reflection.id;
            $scope.currentBody = response.reflection.body;


            $('#updateReflectionModal').modal('toggle');



        }, function(){

            alert('Some Errors Occurred, Try again later');
        });
    }

    $scope.update = function(){

        reflectionService.update(

            $scope.currentReflectionId,
            {
                body: $scope.currentBody
            },function(response){

                $('#updateReflectionModal').modal('toggle');
                $scope.currentReflectionReset();
                $scope.refresh();


            }, function(response){

                alert('Some error occurred while updating, Try again');
            }


        );
    }




    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.reflections = [];

    $scope.refresh();
    $scope.currentReflectionReset();

}]);


mkatolikiAppControllers.controller('MainController', ['$scope', '$http', '$location', 'userService', 'mainService', function($scope, $http, $location, userService, mainService){




    var in10Days = new Date();
    in10Days.setDate(in10Days.getDate() + 10);

   $scope.date1 = new Date('2016-03-29T21:00:00Z')
    $scope.dates = {
        //date1: new Date('2016-03-28'),
        date2: new Date('2015-03-01T12:30:00Z'),
        date3: new Date(),
        date4: new Date(),
        date5: in10Days,
        date6: new Date(),
        date7: new Date(),
        date8: new Date(),
        date9: null,
        date10: new Date('2015-03-01T09:00:00Z'),
        date11: new Date('2015-03-01T10:00:00Z')
    };

    $scope.open = {
        date1: false,
        date2: false,
        date3: false,
        date4: false,
        date5: false,
        date6: false,
        date7: false,
        date8: false,
        date9: false,
        date10: false,
        date11: false
    };

    $scope.getDate = function(){


        return $scope.date1.getTime();
    }



    // Disable today selection
    this.disabled = function(date, mode) {
        return (mode === 'day' && (new Date().toDateString() == date.toDateString()));
    };

    this.dateOptions = {
        showWeeks: false,
        startingDay: 1
    };

    this.timeOptions = {
        readonlyInput: false,
        showMeridian: false
    };

    this.dateModeOptions = {
        minMode: 'year',
        maxMode: 'year'
    };

    $scope.openCalendar = function(e, date) {
        $scope.open[date] = true;

    };

    // watch date4 and date5 to calculate difference
    var unwatch = $scope.$watch(function() {
        return that.dates;
    }, function() {
        if (that.dates.date4 && that.dates.date5) {
            var diff = that.dates.date4.getTime() - that.dates.date5.getTime();
            that.dayRange = Math.round(Math.abs(diff/(1000*60*60*24)))
        } else {
            that.dayRange = 'n/a';
        }
    }, true);

    $scope.$on('$destroy', function() {
        unwatch();
    });
    $scope.logout = function(){

        userService.logout();

        $location.path('/login');

    }

    $scope.load =function(readingId){

        mainService.getById(readingId, function(response){

            $scope.currentReadingId = response.reading.id;
            $scope.currentFirstReading = response.reading.first_reading;
            $scope.currentSecondReading = response.reading.second_reading;
            $scope.currentResponsorial = response.reading.responsorial;
            $scope.currentGospel = response.reading.gospel;


            $('#updateReadingModal').modal('toggle');

        }, function(){

            alert('Some errors occurred, try again later');
        });
    }

    $scope.update = function(){

        mainService.update(

        $scope.currentReadingId,
        {
            first_reading: $scope.currentFirstReading,
            second_reading: $scope.currentSecondReading,
            responsorial: $scope.currentResponsorial,
            gospel: $scope.currentGospel
        },
        function(response){

            $('#updateReadingModal').modal('toggle');

            $scope.currentReadingReset();
            $scope.refresh();

        }, function(response){

                alert('Some errors occurred while updating')
            }

        );
    }

    $scope.remove = function(readingId){

        if(confirm('Are you sure you want to remove this reading?')){

            mainService.remove(readingId, function(){

                alert('Reading removed Successfully.');
                $scope.refresh();

            }, function(){
                alert('Some errors occurred while deleting the reading')
            });
        }
    }

    $scope.create = function(){

        mainService.create({

            first_reading: $scope.currentFirstReading,
            second_reading: $scope.currentSecondReading,
            responsorial: $scope.currentResponsorial,
            gospel: $scope.currentGospel,
            mass_day: $scope.currentMassDay

        }, function(){

            $('#addReadingModal').modal('toggle');

            $scope.currentReadingReset();
            $scope.refresh();

        }, function(){

            alert('Some errors occurred while communicating with the service');
        });

    }

    $scope.refresh = function(){

        $scope.$emit('LOAD');

        mainService.getAll(function(response){

            $scope.readings = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try again later!')

        });
    }

    $scope.currentReadingReset = function(){
        $scope.currentFirstReading = "";
        $scope.currentSecondReading = "";
        $scope.currentResponsorial = "";
        $scope.currentGospel = "";
        $scope.currentMassDay = "";
    }


    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.readings = [];


    $scope.currentReadingReset();
    $scope.refresh();

}]);