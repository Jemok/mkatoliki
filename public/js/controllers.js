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

mkatolikiAppControllers.controller('mkatolikiController', ['$scope', '$location', function($scope, $location){
    $scope.$on('LOAD', function(){$scope.loading=true});
    $scope.$on('UNLOAD', function(){$scope.loading=false});

    $scope.location = $location;
}]);

mkatolikiAppControllers.controller('SignupController', ['$scope', '$location' ,'$http', 'userService', function($scope, $location, $http, userService){

    $scope.signup = function(){
        userService.signup(
            $scope.name, $scope.email, $scope.password, $scope.phone_number,
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

mkatolikiAppControllers.controller('ReflectionController', ['$scope', '$http', 'userService', 'reflectionService', 'mainService', function($scope, $http , userService, reflectionService, mainService){


    var in10Days = new Date();
    in10Days.setDate(in10Days.getDate() + 10);

   // $scope.date1 = new Date('2016-03-29T21:00:00Z')

    $scope.date1 = "";

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


        if($scope.date1 === ""){

            return "";
        }

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

    $scope.refresh_readings = function(){

        $scope.$emit('LOAD');

        mainService.getAll(function(response){

            $scope.readings = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try again later!')

        });
    }


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

        var item = document.getElementById('reading_id');

       var reading_id =item.getAttribute('class');

//        alert(reading_id);




        reflectionService.create({

            reflection_body: $scope.currentReflectionBody,
            reading_id : reading_id,
            reflection_date : $scope.date1


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
    $scope.refresh_readings();

    $scope.currentReflectionReset();

}]);

mkatolikiAppControllers.controller('HappeningController', ['$scope', '$http', 'userService', 'happeningService', function($scope, $http , userService, happeningService){

    $scope.refresh = function(){

        $scope.$emit('LOAD');


        happeningService.getAll(function(response){

            $scope.happenings = response;

            $scope.$emit('UNLOAD');

        }, function(){

            alert('Some errors occurred while communicating with the service, Try Again Later');
        });
    }

    $scope.create = function(){

        happeningService.create({

            event_title: $scope.currentTitle,
            event_body: $scope.currentBody,
            event_excerpt: $scope.currentExcerpt,
            event_date: $scope.currentDate


        }, function(){

            $('#addHappeningModal').modal('toggle');

            $scope.currentHappeningReset();
            $scope.refresh();
        }, function(response){

            alert('Some error occurred while creating the happening event');

        });
    }

    $scope.remove = function(happeningId){

        if(confirm('Are you sure you want to remove this happening event?')){

            happeningService.remove(happeningId, function(){

                alert('Happening event removed Successfully.');
                $scope.refresh();

            }, function(){
                alert('Some errors occurred while deleting the happening event')
            });
        }
    }

    $scope.currentHappeningReset = function(){

        $scope.currentTitle = "";
        $scope.currentBody = "";
        $scope.currentExcerpt = "";
        $scope.currentDate = "";

    }

    $scope.load = function(happeningId){

        happeningService.getById(happeningId, function(response){

            $scope.currentHappeningId = response.happening.id;
            $scope.currentTitle = response.happening.event_title;
            $scope.currentBody = response.happening.event_body;
            $scope.currentExcerpt = response.happening.event_excerpt;
            $scope.currentDate = response.happening.event_date;

            $('#updateHappeningModal').modal('toggle');
        }, function(){

            alert('Some Errors Occurred, Try again later');
        });
    }




    $scope.update = function(){

        happeningService.update(

            $scope.currentHappeningId,
            {
                event_title: $scope.currentTitle,
                event_body: $scope.currentBody,
                event_excerpt: $scope.currentExcerpt,
                event_date: $scope.currentDate
            },function(response){

                $('#updateHappeningModal').modal('toggle');
                $scope.currentHappeningReset();
                $scope.refresh();

            }, function(response){

                alert('Some error occurred while updating, Try again');
            }
        );
    }

    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.happenings = [];

    $scope.refresh();
    $scope.currentHappeningReset();

}]);



mkatolikiAppControllers.controller('MainController', ['$scope', '$http', '$location', 'userService', 'mainService', function($scope, $http, $location, userService, mainService){

    var in10Days = new Date();
    in10Days.setDate(in10Days.getDate() + 10);

  $scope.date1 = new Date('2016-03-29T21:00:00Z')

     //$scope.date1 = "";

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


        if($scope.date1 === ""){

            return "";
        }

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

        alert('hi jemo mercy');

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

//    $scope.update = function(){
//
//        mainService.update(
//
//        $scope.currentReadingId,
//        {
//            first_reading: $scope.currentFirstReading,
//            second_reading: $scope.currentSecondReading,
//            responsorial: $scope.currentResponsorial,
//            gospel: $scope.currentGospel
//        },
//        function(response){
//
//            $('#updateReadingModal').modal('toggle');
//
//            $scope.currentReadingReset();
//            $scope.refresh();
//
//        }, function(response){
//
//                alert('Some errors occurred while updating')
//            }
//
//        );
//    }

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


            reading_date: $scope.currentReadingDate,
            reading_day: $scope.currentReadingDate,
            first_reading_title: $scope.currentFirstReadingTitle,
            first_reading_book: $scope.currentFirstReadingBook,
            first_reading_body: $scope.currentFirstReadingBody,


            second_reading_title: $scope.currentSecondReadingTitle,
            second_reading_book: $scope.currentSecondReadingBook,
            second_reading_body: $scope.currentSecondReadingBody,


            responsorial_title: $scope.currentResponsorialTitle,
            responsorial_book: $scope.currentResponsorialBook,
            responsorial_body_one: $scope.currentResponsorialBodyOne,
            responsorial_body_two: $scope.currentResponsorialBodyTwo,
            responsorial_body_one_verse: $scope.currentResponsorialPsalmVerse,


            gospel_title: $scope.currentGospelTitle,
            gospel_book: $scope.currentGospelBook,
            gospel_body: $scope.currentGospelBody

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
        $scope.currentReadingDate = "";


        $scope.currentFirstReadingTitle = "";
        $scope.currentFirstReadingBook = "";
        $scope.currentFirstReadingBody = "";

        $scope.currentSecondReadingTitle = "";
        $scope.currentSecondReadingBook = "";
        $scope.currentSecondReadingBody = "";

        $scope.currentResponsorialTitle = "";
        $scope.currentResponsorialBook = "";
        $scope.currentResponsorialBodyOne = "";
        $scope.currentResponsorialBodyTwo = "";
        $scope.currentResponsorialPsalmVerse = "";



        $scope.currentGospelTitle = "";
        $scope.currentGospelBook = "";
        $scope.currentGospelBody = "";


    }


    if(!userService.checkIfLoggedIn()){

        $location.path('/login');
    }

    $scope.readings = [];


    $scope.currentReadingReset();
    $scope.refresh();

}]);