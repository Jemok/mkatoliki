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


        <script src="libs/js/angular.min.js"></script>
        <script src="libs/js/lodash.min.js"></script>
        <script src="libs/js/angular-route.min.js"></script>
        <script src="libs/js/angular-animate.min.js"></script>
        <script src="libs/js/angular-local-storage.min.js"></script>
        <script src="libs/js/ui-bootstrap-tpls.js"></script>
        <script src="libs/js/datetime-picker.min.js"></script>
        <script src="libs/js/restangular.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>
        <script src="js/filter.js"></script>

        <style>

            li {
                padding-top: 8px;
            }
        </style>

    </head>

    <body>
        <div class="container">



            <div ng-view data-ng-controller="mkatolikiController">
            </div>
        </div>

        <script src="libs/js/jquery.min.js"></script>
        <script src="libs/js/bootstrap.min.js"></script>
    </body>
</html>