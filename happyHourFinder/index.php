<?php
    session_start();
    require_once('database/connect.php');
    require_once('database/function.php');

    $status="";

    if ($_POST && $_POST['method']=='SignUp'){
        $name = $_POST['username'];
        $pass = $_POST['password'];
        if(isset($name) && isset($pass)){
            $username=filter_var($name,FILTER_SANITIZE_STRING);
            $password=filter_var($pass,FILTER_SANITIZE_STRING);

            $query="SELECT username FROM People WHERE username = ?";
            $arr = array($username);
            if($stmt = SQLI_Prepare($connect, $query, $arr)){
                $stmt->store_result();

                if($stmt->num_rows){
                    $status="Username Exists.";
                }else{ 
                    $stmt->close();
                    $query="INSERT INTO People (username, password) VALUES(?, ?)";
                    $arr = array($username,$password);
                    if($stmt = SQLI_Prepare($connect, $query, $arr)){
                        $status="Success";
                      }else{
                        die ("Mysql Error: " . $connect->error);
                    }
                    $stmt->close();
                }
            }else{
                die("Prepare Error: ". $connect->error);
            }
        }
    }elseif ($_POST && $_POST['method']=='Login'){
        $name = $_POST['username'];
        $pass = $_POST['password'];
        if(isset($name) && isset($pass)){
            $username=filter_var($name,FILTER_SANITIZE_STRING);
            $password=filter_var($pass,FILTER_SANITIZE_STRING);
            
            $query = "SELECT username, password From People where username = ? and password = ?";
            $arr = array($username,$password);
            if($stmt = SQLI_Prepare($connect, $query, $arr)){
                $stmt->store_result();
                if($stmt->num_rows){
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;  
                    $status="You have logged in.";
                    header('Location: profile.php?user='.$username);
                }else{
                    $status="Username or Password incorrect!";
                }
            }
        }
    }
?>

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
        <script>
            $(document).ready(function(){
                $('.pager').hide();
                $('.navform').load('inc/form.php?method=Login&class=navbar-form');
                $('#userForm').load('inc/form.php?method=Login');
                $('#in').on('click',function(){
                    $('#up').removeClass('active');
                    $('#in').addClass('active');
                    $('#userForm').load('inc/form.php?method=Login');
                });
                $('#up').on('click',function(){
                    $('#up').addClass('active');
                    $('#in').removeClass('active');
                    $('#userForm').load('inc/form.php?method=SignUp');
                });
            });
        </script>
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
                  <a class="navbar-brand" href="#">Happy Hour Finder</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="#">
                                <span class="glyphicon glyphicon-search" aria-hidden="true">                                           </span> Search for a restaurant
                            </a>
                        </li>
                        <li>
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
            
            <div class="row">
            <!--Sign up form goes here...-->
                <div class="form col-md-6">
                    <ul class="nav nav-tabs text-center">
                        <li role="presentation" class="active">
                            <a>
                                <i class="fa fa-search fa-3x"></i>&nbsp;
                                <h2>Search for a restaurant</h2>
                            </a>
                        </li>
                    </ul>
                    <div>
                        <form id="searchForm" class="form-horizontal" 
                              method="post" action="index.php">
                            <div class="form-group">
                              <label for="places">Select your place type:</label>
                              <select class="form-control" id="places" name="places">
                                <option>meal_delivery</option>
                                <option>meal_takeout</option>
                                <option>restaurant</option>
                                <option>bar</option>
                                <option>cafe</option>
                              </select>
                            </div>
                            
                            <div class="form-group text-center">
                                <div class="col-lg-offset-2 col-lg-8">
                                 <input type="hidden" name="array" id="array">  
                                 <input type="submit" 
                                           class="btn btn-success"
                                           id="searchsubmit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hidden-xs hidden-sm form col-md-4 col-md-offset-2 pull-right">
                    <div class="text-center">
                        <h4>
                            <?php echo $status; ?>
                        </h4>
                    </div>
                    <div class="btn-group btn-group-justified" role="group">
                        <ul class="nav nav-tabs text-center">
                            <li role="presentation" class="active" id="in">                            
                                <a><i class="fa fa-users fa-3x"></i>&nbsp;<h2>Login</h2></a>                                       </li>
                            <li role="presentation" id="up">                            
                                <a><i class="fa fa-user-plus fa-3x"></i>&nbsp;<h2>Sign Up</h2></a>                                 </li>
                        </ul>
                    </div>
                    <div id="userForm">

                        <!--form goes here...-->
                    </div><!--form ends here...-->
                </div>
            </div>
            
            <div class="row">
                <div class="container">
                    <nav>
                      <ul class="pager">
                        <li class="pull-left">
                            <a href="#" id="previous">
                                <i class="fa fa-backward fa-3x"></i><h3>Previous</h3></a></li>
                        <li class="pull-right">
                            <a href="#" id="next">
                                <i class="fa fa-forward fa-3x"></i><h3>Next</h3></a></li>
                      </ul>
                    </nav>
                    <div id="result">
                    </div>
                </div>
            </div>
        </div>
        <script src="js/search_res.js"></script>
    </body>
</html>