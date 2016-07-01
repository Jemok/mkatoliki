(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('prayerService', ['Restangular', 'userService', 'localStorageService', '$http', function(Restangular, userService, localStorageService, $http){

            function getAll(onSuccess, onError){

                $http.get('api/prayers/?token='+localStorageService.get('token'), {
                })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });
//                Restangular.all('api/prayers').getList().then(function(response){
//
//                    onSuccess(response);
//                }, function(response){
//
//                    onError(response);
//                });
            }

            function getById(prayerId, onSuccess, onError){

                Restangular.one('api/prayers', prayerId).get().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/prayers').post(data).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function update(prayerId, data, onSuccess, onError){

                Restangular.one('api/prayers').customPUT(data, prayerId).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function remove(prayerId, onSuccess, onError){

                Restangular.one('api/prayers', prayerId).remove().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

//            Restangular.setDefaultHeaders({'Authorization' : 'Bearer' + userService.getCurrentToken()});

            return {

                getAll: getAll,
                getById: getById,
                create: create,
                update: update,
                remove: remove
            }
        }]);



})();