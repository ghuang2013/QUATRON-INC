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

<?php
    $on = "page1";
    require_once('inc/head.php');
?>        
            
            <div class="row">
                <div class="form col-md-8">
                    <ul class="nav nav-tabs text-center" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#nearby" aria-controls="nearby" role="tab" data-toggle="tab">
                                <i class="fa fa-search fa-3x"></i>
                                <h4>Nearby Search</h4>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#zipcode" aria-controls="zipcode" role="tab" data-toggle="tab">
                                <i class="fa fa-map-marker fa-3x"></i>
                                <h4>Search By Zipcode</h4>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="nearby">
                            <form id="genericSearchForm"
                                  class="form-horizontal" 
                                  method="post" 
                                  action="index.php">
                                <div class="form-group">
                                    <?php
                                        require('inc/places_dropdown_list.html');
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-lg-offset-2 col-lg-8"> 
                                     <input type="submit" 
                                               class="btn btn-success"
                                               id="searchsubmit">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="zipcode">
                            <form id="advancedSearchForm"
                                  class="form-horizontal" 
                                  method="post"
                                  action="index.php">
                                <div class="form-group">
                                    <label for="places" class="col-sm-4 control-label">Enter your zipcode/address:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="zip-code" 
                                               placeholder="ex) Orlando, Florida 32812" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php
                                        require('inc/places_dropdown_list.html');
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-lg-offset-2 col-lg-8">
                                     <input type="submit" 
                                               class="btn btn-success"
                                               id="searchsubmit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="hidden-xs hidden-sm form col-md-4 pull-right">
                        <?php 
                            if($status!="") { 
                                if($status == "Username Exists." 
                                   || $status == "Username or Password incorrect!"){ 
                                    echo '<div class="alert alert-danger fade in">'; 
                                } elseif($status == "Success") {
                                    echo '<div class="alert alert-success fade in">'; 
                                } 
                                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                echo $status; 
                                echo '</div>'; 
                            } 
                        ?>               
                    
                    <ul class="nav nav-tabs text-center">
                        <li role="presentation" class="active" id="in">                            
                            <a><i class="fa fa-key fa-3x"></i>&nbsp;
                                <h4>Login</h4>
                            </a>                                       
                        </li>
                        <li role="presentation" id="up">                            
                            <a><i class="fa fa-user fa-3x"></i>&nbsp;
                                <h4>Sign Up</h4>
                            </a>                                 
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="userForm">
                            <!--
                                Dynamic Form: 
                                User sign-up/login form will be loaded here using ajax function defined in effect_main.js
                                effect_main.js contains handler for the tab switching event
                                A generic form is defined in inc/form.php
                            -->
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="container">
                    <?php
                        require('inc/pagination.php');
                    ?>
                    <div id="result">
                    </div>
                    <?php
                        require('inc/pagination.php');
                    ?>
                </div>
            </div>

        </div>
        <script src="js/search_res.js"></script>
        <script src="js/effect_main.js"></script>
    </body>
</html>