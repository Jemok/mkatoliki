(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('SubscriptionController', ['subscriptionService', '$scope', '$http', 'userService', '$location', function(subscriptionService, $scope, $http, userService, $location){


            $scope.refresh = function(){

                $scope.$emit('LOAD');

                subscriptionService.getAll(function(response){

                    $scope.$emit('UNLOAD');

                    $scope.users = response.data;

                }, function(response){

                })

            }

            $scope.subscribe = function(user_id, subscription_id){

                $scope.$emit('LOAD');

                $http({
                    url: 'api/subscribe',
                    method: "POST",
                    params: {user_id:  user_id, subscription_id: subscription_id, token: userService.getCurrentToken()}
                }).success(function (response, status, headers, config) {

                    $scope.$emit('UNLOAD');

                    $scope.refresh();
                });
            }

            $scope.unsubscribe = function(user_id, subscription_id){

                $scope.$emit('LOAD');

                $http({
                    url: 'api/unsubscribe',
                    method: "POST",
                    params: {user_id:  user_id, subscription_id: subscription_id, token: userService.getCurrentToken()}
                }).success(function (response, status, headers, config) {

                    $scope.$emit('UNLOAD');
                    $scope.refresh();
                });
            }

            $scope.readings = [];

            $scope.refresh();
        }]);

})();