(function() {

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('jumuiyaService', ['Restangular', 'userService', function(Restangular, userService){

            function getAll(onSuccess, onError){

                Restangular.all('api/jumuiyas').getList().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function getById(jumuiyaId, onSuccess, onError){

                Restangular.one('api/jumuiyas', jumuiyaId).get().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/jumuiyas').post(data).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function update(jumuiyaId, data, onSuccess, onError){

                Restangular.one('api/jumuiyas').customPUT(data, jumuiyaId).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function remove(jumuiyaId, onSuccess, onError){

                Restangular.one('api/jumuiyas', jumuiyaId).remove().then(function(response){

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