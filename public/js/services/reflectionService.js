(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('reflectionService', ['Restangular', 'userService', 'localStorageService', '$http', function(Restangular, userService, localStorageService, $http){

            function getAll(onSuccess, onError){

                $http.get('api/reflections?token='+localStorageService.get('token'), {
                    })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });

                // Restangular.all('api/reflections').getList().then(function(response){
                //
                //     onSuccess(response);
                // }, function(response){
                //
                //     onError(response);
                // });
            }

            function getById(reflectionId, onSuccess, onError){

                Restangular.one('api/reflections', reflectionId).get().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/reflections').post(data).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function update(reflectionsId, data, onSuccess, onError){

                Restangular.one('api/reflections').customPUT(data, reflectionsId).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function remove(reflectionId, onSuccess, onError){

                Restangular.one('api/reflections', reflectionId).remove().then(function(response){

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