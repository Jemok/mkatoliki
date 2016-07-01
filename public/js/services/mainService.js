(function(){

    'use strict';

    angular
        .module('mkatolikiApp')
        .factory('mainService', ['Restangular', 'userService', '$http', 'localStorageService', function(Restangular, userService, $http, localStorageService){


            function getAll(last_page ,onSuccess, onError){

                $http.get('api/readings/?last_page='+last_page+'&token='+localStorageService.get('token'), {
                    })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });

                // Restangular.all('api/readings').getList().then(function(response){
                //
                //     onSuccess(response);
                //
                // }, function(response){
                //
                //     onError(response);
                //
                // });
            }

            function getAllForReflections(onSuccess, onError){

                $http.get('api/readings/all/?token='+localStorageService.get('token'), {
                    })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });

                // Restangular.all('api/readings').getList().then(function(response){
                //
                //     onSuccess(response);
                //
                // }, function(response){
                //
                //     onError(response);
                //
                // });
            }

            function getById(readingId, onSuccess, onError){

                $http.get('api/readings/'+readingId+'?token='+localStorageService.get('token'), {
                })
                    .then(function(response){
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });

//                Restangular.one('api/readings', readingId).get().then(function(response){
//
//                    onSuccess(response);
//                }, function(response){
//
//                    onError(response);
//                });
            }

            function create(data, onSuccess, onError){

                Restangular.all('api/readings').post(data).then(function(response){

                    onSuccess(response);
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

            Restangular.setDefaultHeaders({'Authorization' : 'Bearer' + localStorageService.get('token')});


            return{

                getAll: getAll,
                getAllForReflections: getAllForReflections,
                getById: getById,
                create: create,
                update: update,
                remove: remove
            }
        }]);

})();