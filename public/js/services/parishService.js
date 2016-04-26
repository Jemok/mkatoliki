(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('parishService', ['Restangular', 'userService', function(Restangular, userService){

            function getAll(onSuccess, onError){

                Restangular.all('api/parishes').getList().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function getById(reflectionId, onSuccess, onError){

                Restangular.one('api/reflections', reflectionId).get().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/parishes').post(data).then(function(response){

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