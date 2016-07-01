mkatolikiAppControllers.controller('ReadingController', function($scope, $rootScope, $routeParams, mainService) {

    mainService.getById($routeParams.reading_id, function(response){

        //console.log(response);

        $scope.currentFirstReadingBook = response.data.reading.first_reading_book;
        $scope.currentFirstReadingBody = response.data.reading.first_reading_body;
        $scope.currentSecondReadingBook = response.data.reading.second_reading_book;
        $scope.currentSecondReadingBody = response.data.reading.second_reading_body;
        $scope.currentResponsorialBook = response.data.reading.responsorial_book;
        $scope.currentResponsorialBodyOne = response.data.reading.responsorial_body_one;
        $scope.currentResponsorialBodyTwo = response.data.reading.responsorial_body_two;
        $scope.currentGospelBook = response.data.reading.gospel_book;
        $scope.currentGospelBody = response.data.reading.gospel_body;

    }, function(){

        alert('Some errors occurred, try again later');
    });


});