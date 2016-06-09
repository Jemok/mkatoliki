(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('MainController', ['$scope', '$http', '$location', 'userService', 'mainService', 'localStorageService', function($scope, $http, $location, userService, mainService, localStorageService){

            var in10Days = new Date();
            in10Days.setDate(in10Days.getDate() + 10);

            $scope.date1 = new Date('2016-03-29T21:00:00Z')

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

            $scope.$on('$destroy', function() {
                unwatch();
            });
            $scope.logout = function(){

                userService.logout(function(response){

                    localStorageService.remove('token')

                    $location.path('/login');

                }, function(){

                    alert('Some errors occurred, try again later');
                });


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

                    $scope.successTextAlert = "Reading was successfully created";
                    $scope.showSuccessAlert = true;

                    $scope.switchBool = function(value) {
                        $scope[value] = !$scope[value];
                    };
                    $scope.currentReadingReset();
                    $scope.refresh();

                }, function(){

                    alert('Some errors occurred while communicating with the service');
                });

            }

            $scope.refresh = function(){

                $scope.$emit('LOAD');

                $scope.lastpagez=1;

                mainService.getAll($scope.lastpage, function(response){

                    $scope.readings = response.data.data;

                    //console.log(response.data);

                    $scope.currentpage = response.data.current_page;

                    $scope.$emit('UNLOAD');

                }, function(response){

                });
            };


            $scope.loadMore = function() {

                $scope.lastpage +=1;
                $scope.$emit('LOAD');

                $http({
                    url: 'api/readings',
                    method: "GET",
                    params: {page:  $scope.lastpage, token: userService.getCurrentToken()}
                }).success(function (response, status, headers, config) {

                    $scope.$emit('UNLOAD');

                    console.log(response.data);
                    $scope.readings = $scope.readings.concat(response.data);

                });
            };

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


//            $scope.currentReadingReset();
            $scope.refresh();

        }]);

})();