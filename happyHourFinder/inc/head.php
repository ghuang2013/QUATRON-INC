<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Happy Hour Finder</title>
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" 
              href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet"
              href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/myLib.js"></script>
        <scirpt src="../js/effect_main.js"></scirpt>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" 
                          data-toggle="collapse" 
                          data-target="#bs-example-navbar-collapse-1"
                          aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Happy Hour Finder</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="<?php if($on=="page1") echo "active"; ?>">
                            <a href="index.php">
                                <span class="glyphicon glyphicon-search" aria-hidden="true">                                           </span> Search for a restaurant
                            </a>
                        </li>
                        <li class="<?php if($on=="page2") echo "active"; ?>">
                            <a href="#">
                                <span class="glyphicon glyphicon-user" aria-hidden="true">                                             </span> Review a restaurant
                            </a>
                        </li>
                    </ul>
                    <div class="hidden-lg navbar-left navform">

                    </div>
                </div>
            </nav>
            <div class="jumbotron">
                <div class="container">
                    <h1>Happy Hour Finder</h1>
                        <p>
                            Some description...(Maybe insert a nice picture for the jumbotron background)             </p>
                    <button class="btn btn-success">Get Started</button>
                </div>
            </div>