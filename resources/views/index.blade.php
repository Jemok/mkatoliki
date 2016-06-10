<!DOCTYPE html>
<html lang="en" data-ng-app="mkatolikiApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mkatoliki Missal Application</title>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link href="libs/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.16.1/select.min.js" rel="stylesheet">

        <script src="libs/js/angular.min.js"></script>
        <script src="libs/js/lodash.min.js"></script>
        <script src="libs/js/angular-route.min.js"></script>
        <script src="libs/js/angular-animate.min.js"></script>
        <script src="libs/js/angular-local-storage.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.16.1/select.min.css"></script>
        <script src="libs/js/ui-bootstrap-tpls.js"></script>
        <script src="libs/js/datetime-picker.min.js"></script>
        <script src="libs/js/restangular.min.js"></script>
        <script src="libs/js/bootstrap.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/services/baseService.js"></script>
        <script src="js/services/userService.js"></script>
        <script src="js/services/mainService.js"></script>
        <script src="js/services/prayerService.js"></script>
        <script src="js/services/jumuiyaService.js"></script>
        <script src="js/services/reflectionService.js"></script>
        <script src="js/services/happeningService.js"></script>
        <script src="js/services/prayerTypeService.js"></script>
        <script src="js/services/rawJumuiyaService.js"></script>
        <script src="js/services/parishService.js"></script>
        <script src="js/services/stationService.js"></script>
        <script src="js/services/subscriptionService.js"></script>




        <script src="js/controllers/baseController.js"></script>
        <script src="js/controllers/mainController.js"></script>
        <script src="js/controllers/loginController.js"></script>
        <script src="js/controllers/signupController.js"></script>
        <script src="js/controllers/prayerController.js"></script>
        <script src="js/controllers/jumuiyaController.js"></script>
        <script src="js/controllers/reflectionController.js"></script>
        <script src="js/controllers/happeningController.js"></script>
        <script src="js/controllers/readingController.js"></script>
        <script src="js/controllers/subscriptionController.js"></script>



        <script src="js/filter.js"></script>
        <script src="js/directives.js"></script>
    </head>

    <body class="global__wrapper">
            <div class="row global__navbar" data-ng-controller="contentController" ng-show="contentVisibility">
                <div class="gn__logo">
                    <div class="logo__name"><a href="#/">Mkatoliki</a></div>
                </div>
                <div class="gn__nav">
                    <ul class="nav">
                        <li class="nav__item"><a data-ng-controller="MainController" href="" data-ng-click="logout()" class="nav__link">Logout</a></li>
                    </ul>

                </div>
            </div>

            <div ng-view data-ng-controller="mkatolikiController" class="row global__wrapper"> </div>
    </body>
</html>