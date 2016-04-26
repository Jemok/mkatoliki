(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('LoginController', ['$scope', '$http', '$location', 'userService', 'mainService', function($scope, $http, $location, userService, mainService){
            //Initiate the login in process
            $scope.login = function(){
                userService.login(
                    $scope.email,
                    $scope.password,

                    function(response){

                    },
                    function(response){

                        //Invalid credentials
                        if(response.data.error.status_code === 401){

                            alert("Invalid email or password, try again!");
                        }
                        //Internal server error
                        if(response.data.error.status_code === 500){

                            alert("Ooops, something went wrong!! Our bad!");
                        }
                    }
                );
            }

            //Initialize scope
            $scope.email = '';
            $scope.password = '';

            //Redirect to / if a user is logged in
            if(userService.checkIfLoggedIn()){
                $location.path('/');
            }
        }]);
})();