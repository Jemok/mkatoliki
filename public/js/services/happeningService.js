(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('happeningService', ['Restangular', 'userService', 'localStorageService', '$http', function(Restangular, userService, localStorageService, $http){



            function getAll(onSuccess, onError){

                $http.get('api/happenings/?token='+localStorageService.get('token'), {
                })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });
//                Restangular.all('api/happenings').getList().then(function(response){
//
//                    onSuccess(response);
//                }, function(response){
//
//                    onError(response);
//                });
            }

            function getById(happeningId, onSuccess, onError){

                Restangular.one('api/happenings', happeningId).get().then(function(response){

                    //console.log(response.happening);
                    onSuccess(response);

                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/happenings').post(data).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function update(happeningId, data, onSuccess, onError){

                Restangular.one('api/happenings').customPUT(data, happeningId).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function remove(happeningId, onSuccess, onError){

                Restangular.one('api/happenings', happeningId).remove().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            Restangular.setDefaultHeaders({'Authorization' : 'Bearer' + userService.getCurrentToken()});

            return {

                getAll: getAll,
                getById: getById,
                create: create,
                update: update,
                remove: remove
            }
        }]);
})();