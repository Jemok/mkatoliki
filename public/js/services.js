var mkatolikiAppServices = angular.module('mkatolikiAppServices', [

    'LocalStorageModule',
    'restangular'
]);

mkatolikiAppServices.factory('userService', ['$http', 'localStorageService', function($http, localStorageService){

    function checkIfLoggedIn(){

        if(localStorageService.get('token')){
            return true;
        }else{

            return false;
        }
    }

    function signup(name, email, password, onSuccess, onError){

        $http.post('/api/auth/signup', {
            name: name,
            email: email,
            password: password
        }).
        then(function(response){
                localStorageService.set('token', response.data.token);
                onSuccess(response);
        }, function(response){
                onError(response);
        });
    }

    function login(email, password, onSuccess, onError){

        $http.post('/api/auth/login',{

            email: email,
            password:password
        }).
        then(function(response){

            localStorageService.set('token', response.data.token);
            onSuccess(response);
        }, function(response){

                onError(response);
        });

    }

    function logout(){
        localStorageService.remove('token');
    }

    function getCurrentToken(){

        return localStorageService.get('token');
    }

    return {

        checkIfLoggedIn: checkIfLoggedIn,
        signup: signup,
        login: login,
        logout: logout,
        getCurrentToken: getCurrentToken
    }
}]);

mkatolikiAppServices.factory('mainService', ['Restangular', 'userService', function(Restangular, userService){

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

mkatolikiAppServices.factory('prayerService', ['Restangular', 'userService', function(Restangular, userService){

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


mkatolikiAppServices.factory('jumuiyaService', ['Restangular', 'userService', function(Restangular, userService){

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

mkatolikiAppServices.factory('reflectionService', ['Restangular', 'userService', function(Restangular, userService){

    function getAll(onSuccess, onError){

        Restangular.all('api/reflections').getList().then(function(response){

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

mkatolikiAppServices.factory('happeningService', ['Restangular', 'userService', function(Restangular, userService){

    function getAll(onSuccess, onError){

        Restangular.all('api/happenings').getList().then(function(response){

            onSuccess(response);
        }, function(response){

            onError(response);
        });
    }

    function getById(happeningId, onSuccess, onError){

        Restangular.one('api/happenings', happeningId).get().then(function(response){

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



