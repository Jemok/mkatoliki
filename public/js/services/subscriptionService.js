(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('subscriptionService',['localStorageService', '$http', function(localStorageService, $http){

            function getAll(onSuccess, onError){

                $http.get('api/subscriptions/?token='+localStorageService.get('token'), {
                })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });
            }


            return {
                getAll: getAll
            }

        }]);
})();