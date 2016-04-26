(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('PrayerController', ['$scope', '$http', 'userService', 'prayerService', 'prayerTypeService', function($scope, $http , userService, prayerService, prayerTypeService){

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

                    prayer_title: $scope.currentTitle,
                    prayer_body: $scope.currentBody,
                    prayer_type: $scope.currentType

                }, function(){

                    $scope.successTextAlert = "Prayer was successfully created";
                    $scope.showSuccessAlert = true;

                    $scope.switchBool = function(value) {
                        $scope[value] = !$scope[value];
                    };

                    $scope.currentPrayerReset();
                }, function(response){

                    alert('Some error occurred while creating the prayer');

                });
            }

            $scope.refresh_prayer_types = function(){

                $scope.$emit('LOAD');

                prayerTypeService.getAll(function(response){

                    $scope.prayer_types = response;

                    $scope.$emit('UNLOAD');

                }, function(){

                    alert('Some errors occurred while communicating with the service, Try Again Later');
                });
            }

            $scope.create_type = function(){

                prayerTypeService.create({

                    prayer_type_name: $scope.currentName,
                    prayer_type_description: $scope.currentDescription



                }, function(){

                    $scope.successTextAlert = "Prayer type was successfully created";
                    $scope.showSuccessAlert = true;

                    $scope.switchBool = function(value) {
                        $scope[value] = !$scope[value];
                    };
//            alert('Created');
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
                $scope.currentType = "";

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
            $scope.refresh_prayer_types();
            $scope.currentPrayerReset();

        }]);

})();