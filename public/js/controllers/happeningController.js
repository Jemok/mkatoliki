(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('HappeningController', ['$scope', '$http', 'userService', 'happeningService', 'rawJumuiyaService', 'localStorageService', function($scope, $http , userService, happeningService, rawJumuiyaService, localStorageService){

            $scope.refresh = function(){

                $scope.$emit('LOAD');

                happeningService.getAll(function(response){

                    $scope.happenings = response.data;

                    console.log($scope.happenings);


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

                    $scope.successTextAlert = "Event was successfully created";
                    $scope.showSuccessAlert = true;

                    $scope.switchBool = function(value) {
                        $scope[value] = !$scope[value];
                    };

                    $scope.currentHappeningReset();
                    $scope.refresh();
                }, function(response){

                    alert('Some error occurred while creating the happening event');

                });
            }

            $scope.create_raw = function(){


                rawJumuiyaService.create({

                    jumuiya_name: $scope.currentName,
                    jumuiya_image_link: $scope.currentImageLink

                }, function(){

                    alert('Created');

                    $scope.currentJumuiyaReset();
                    $scope.refresh();
                }, function(response){

                    alert('Some error occurred while creating the jumuiya');

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



})();