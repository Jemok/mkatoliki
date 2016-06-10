(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('SubscriptionController', ['subscriptionService', '$scope', '$http', 'userService', function(subscriptionService, $scope, $http, userService){

            $scope.refresh = function(){


                subscriptionService.getAll(function(response){

                    $scope.users = response.data;

                    console.log($scope.users);

                }, function(response){

                })

            }

            $scope.subscribe = function(user_id, subscription_id){



                $http({
                    url: 'api/subscribe',
                    method: "POST",
                    params: {user_id:  user_id, subscription_id: subscription_id, token: userService.getCurrentToken()}
                }).success(function (response, status, headers, config) {


                    $scope.refresh();
                });
            }

            $scope.unsubscribe = function(user_id, subscription_id){



                $http({
                    url: 'api/unsubscribe',
                    method: "POST",
                    params: {user_id:  user_id, subscription_id: subscription_id, token: userService.getCurrentToken()}
                }).success(function (response, status, headers, config) {


                    $scope.refresh();
                });
            }

            $scope.readings = [];

            $scope.refresh();
        }]);

})();