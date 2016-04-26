(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('JumuiyaController', ['$scope', '$http', 'userService', 'jumuiyaService', 'rawJumuiyaService', 'parishService', 'stationService', function($scope, $http , userService, jumuiyaService, rawJumuiyaService, parishService, stationService){

            $scope.refresh = function(){

                $scope.$emit('LOAD');


                jumuiyaService.getAll(function(response){

                    $scope.jumuiyas = response;

                    $scope.$emit('UNLOAD');

                }, function(){

                    alert('Some errors occurred while communicating with the service, Try Again Later');
                });
            }

            $scope.refresh_raw_jumuiyas = function(){

                $scope.$emit('LOAD');


                rawJumuiyaService.getAll(function(response){

                    $scope.raw_jumuiyas = response;

                    $scope.$emit('UNLOAD');

                }, function(){

                    alert('Some errors occurred while communicating with the service, Try Again Later');
                });
            }

            $scope.refresh_parishes = function(){

                $scope.$emit('LOAD');


                parishService.getAll(function(response){

                    $scope.parishes = response;

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
                    happening_on: $scope.currentHappeningOn,
                    raw_jumuiya_id: $scope.currentRawJumuiyaId,
                    'more_details': $scope.currentDetails


                }, function(){


                    $scope.currentJumuiyaReset();
                    $scope.refresh();
                }, function(response){

                    alert('Some error occurred while creating the jumuiya');

                });
            }

            $scope.create_parish = function(){

                parishService.create({


                    parish_name: $scope.currentParishName

                }, function(){


                    $scope.currentParishReset();
                    $scope.refresh();
                }, function(response){

                    alert('Some error occurred while creating the jumuiya');

                });
            }

            $scope.create_station = function(){

                stationService.create({

                    station_name: $scope.currentStationName,
                    parish_id: $scope.currentParishId

                }, function(){


                    $scope.currentStationReset();
                    $scope.refresh();
                }, function(response){

                    alert('Some error occurred while creating the jumuiya');

                });
            }


            $scope.currentParishReset = function(){

                $scope.currentParishName = "";
            }


            $scope.currentStationReset = function(){

                $scope.currentStationName = "";


            }


            $scope.currentJumuiyaReset = function(){

                $scope.currentLocation = "";
                $scope.currentHappeningOn = "";
                $scope.currentRawJumuiyaId = "";
                $scope.currentDetails = "";

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
            $scope.refresh_raw_jumuiyas();
            $scope.refresh_parishes();
            $scope.currentJumuiyaReset();

        }]);

})();