mkatolikiAppControllers.controller('ReadingController', function($scope, $rootScope, $routeParams, mainService) {

    mainService.getById($routeParams.reading_id, function(response){

        $scope.currentFirstReadingBook = response.reading.first_reading_book;
        $scope.currentFirstReadingBody = response.reading.first_reading_body;
        $scope.currentSecondReadingBook = response.reading.second_reading_book;
        $scope.currentSecondReadingBody = response.reading.second_reading_body;
        $scope.currentResponsorialBook = response.reading.responsorial_book;
        $scope.currentResponsorialBodyOne = response.reading.responsorial_body_one;
        $scope.currentResponsorialBodyTwo = response.reading.responsorial_body_two;
        $scope.currentGospelBook = response.reading.gospel_book;
        $scope.currentGospelBody = response.reading.gospel_body;


    }, function(){

        alert('Some errors occurred, try again later');
    });


});