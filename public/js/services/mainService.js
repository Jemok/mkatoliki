(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('mainService', ['Restangular', 'userService', function(Restangular, userService){

            function getAll(onSuccess, onError){

                Restangular.all('api/readings').getList().then(function(response){

                    onSuccess(response);
                }, function(){

                    onError(response);
                });

            }

            function getById(readingId, onSuccess, onError){

                Restangular.one('api/readings', readingId).get().then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                });
            }

            function create(data, onSucess, onError){

                Restangular.all('api/readings').post(data).then(function(response){

                    onSucess(response);
                }, function(response){

                    onError(response);
                });
            }

            function update(readingId, data, onSuccess, onError){

                Restangular.one('api/readings').customPUT(data, readingId).then(function(response){

                    onSuccess(response);
                }, function(response){

                    onError(response);
                })
            }

            function remove(readingId, onSuccess, onError){

                Restangular.one('api/readings', readingId).remove().then(function(){
                    onSuccess();
                }, function(response){
                    onError(response);
                });
            }

            Restangular.setDefaultHeaders({'Authorization' : 'Bearer' + userService.getCurrentToken()});

            return{

                getAll: getAll,
                getById: getById,
                create: create,
                update: update,
                remove: remove
            }
        }]);

})();