(function(){

    angular
        .module('mkatolikiApp')
        .controller('ReflectionController', ['$scope', '$http', '$location', 'userService', 'reflectionService', 'mainService', function($scope, $http, $location, userService, reflectionService, mainService){



            var in10Days = new Date();
            in10Days.setDate(in10Days.getDate() + 10);

            $scope.date1 = new Date('2016-05-06T00:00:00Z')

            $scope.date1 = "";

            $scope.dates = {
                //date1: new Date('2016-03-28'),
//                date2: new Date('2015-03-01T12:30:00Z'),
//                date3: new Date(),
//                date4: new Date(),
//                date5: in10Days,
//                date6: new Date(),
//                date7: new Date(),
//                date8: new Date(),
//                date9: null,
//                date10: new Date('2015-03-01T09:00:00Z'),
//                date11: new Date('2015-03-01T10:00:00Z')
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

                mainService.getAllForReflections(function(response){

                    $scope.readings = response.data;
                    
                    $scope.$emit('UNLOAD');

                }, function(){


                });
            }


            $scope.refresh = function(){

                $scope.$emit('LOAD');

                reflectionService.getAll(function(response){

                    $scope.reflections = response.data;

                    $scope.$emit('UNLOAD');

                }, function(){

                });
            }

            $scope.create = function(){

                $scope.reflectionErrorCode = "";


                var item = document.getElementById('reading_id');

                var reading_id =item.getAttribute('class');

                $scope.$emit('LOAD');
                
                reflectionService.create({


                    reflection_body: $scope.currentReflectionBody,
                    reading_id : reading_id,
                    reflection_date : $scope.date1


                }, function(){

                    $scope.$emit('UNLOAD');

                    $scope.successTextAlert = "Reflection was successfully created";
                    $scope.showSuccessAlert = true;

                    $scope.switchBool = function(value) {
                        $scope[value] = !$scope[value];
                    };
                    $scope.currentReadingReset();
                    $scope.refresh();

                    $scope.currentReflectionReset();
                    $scope.refresh();

                }, function(response){

                    $scope.$emit('UNLOAD');

                    if(response.status == 500){
                        
                        $scope.reflectionErrorCode = 500;
                        
                    }
                    
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



})();