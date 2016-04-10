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
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>
        <script src="js/filter.js"></script>
        <script src="js/directives.js"></script>
    </head>

    <body class="global__wrapper">
            <div class="row global__navbar" data-ng-controller="contentController" ng-show="contentVisibility">
                <div class="gn__logo">
                    <div class="logo__name">Mkatoliki</div>
                </div>
                <div class="gn__nav">
                    <ul class="nav">
                        <li class="nav__item"><a data-ng-controller="MainController" href="" data-ng-click="logout()" class="nav__link">Logout</a></li>
                    </ul>

                </div>
            </div>

            <div ng-view data-ng-controller="mkatolikiController" class="row global__wrapper">

        <script data-main="assets/js/main" src="assets/js/require.js"></script>

    </body>
</html>