(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .controller('SubscriptionController', ['subscriptionService', '$scope', function(subscriptionService, $scope){

            $scope.refresh = function(){


                subscriptionService.getAll(function(response){

                    $scope.users = response.data;

                    console.log($scope.users);

                }, function(response){

                })

            }

            $scope.readings = [];

            $scope.refresh();
        }]);

})();