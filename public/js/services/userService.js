(function() {
    angular
        .module('mkatolikiApp')
        .factory('userService', ['$http', 'localStorageService', '$location', function($http, localStorageService, $location){

            function checkIfLoggedIn(){

                if(localStorageService.get('token')){
                    return true;
                }
            }

            //Signup new app user
            function signup(name, email, password, phone_number, onSuccess, onError){
                $http.post('/api/auth/signup', {
                    name: name,
                    email: email,
                    phone_number: phone_number,
                    password: password
                })
                 .then(function(response){
                        localStorageService.set('token', response.data.token);
                        onSuccess(response);
                    }, function(response){
                        onError(response);
                    });
            }

            //Login a user into the app
            function login(email, password, onSuccess, onError){
                $http.post('/api/auth/login',{
                    email: email,
                    password:password
                })
                 .then(function(response){

                     //localStorageService.set('token', response.data.token);
                        onSuccess(response);

                       //return $location.path('/');

                    }, function(response){
                         onError(response);
                    });
            }

            //Logout a user out of the application
            function logout(onSuccess, onError){

                $http.post('/api/auth/logout?token='+localStorageService.get('token'), {
                    })
                    .then(function(response){
                       onSuccess(response);
                    }, function(response){
                        onError(response);
                    });
            }

            //Get the token that is currently set on local storage
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
})();