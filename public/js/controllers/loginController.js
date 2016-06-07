(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('LoginController', ['$scope', '$http', '$location', 'userService', 'localStorageService', 'mainService', function($scope, $http, $location, userService, localStorageService, mainService){
            //Initiate the login in process


            $scope.login = function(){
                $scope.$emit('LOAD');

                userService.login(
                    $scope.email,
                    $scope.password,

                    function(response){

                        localStorageService.set('token', response.data.token);


                        $location.path('/');
                    },
                    function(response){

                        $scope.$emit('UNLOAD');

                        //Invalid credentials
                        if(response.data.error.status_code === 401){

                            //alert("Invalid email or password, try again!");

                            $scope.loginError = response.data.error.status_code;

                        }
                        //Internal server error
                        if(response.data.error.status_code === 500){

                            $scope.loginError = response.data.error.status_code;

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