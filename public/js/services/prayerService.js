(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('prayerService', ['Restangular', 'userService', function(Restangular, userService){

            function getAll(onSuccess, onError){

                Restangular.all('api/prayers').getList().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
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