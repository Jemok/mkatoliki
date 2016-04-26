(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('SignupController', ['$scope', '$location' ,'$http', 'userService', function($scope, $location, $http, userService){

            //Initialize the user registration process
            $scope.signup = function(){
                userService.signup(
                    $scope.name,
                    $scope.email,
                    $scope.phone_number,
                    $scope.password,
                    function(response){

                        alert('Great! You were signed in! Welcome, ' +$scope.name + '!');

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
})();