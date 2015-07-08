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
                                <option>meal_takeaway</option>
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
                        <?php if($status!="") { 
                            if($status == "Username Exists." 
                               || $status == "Username or Password incorrect!"){ 
                                echo '<div class="alert alert-danger fade in">'; 
                            } elseif($status == "Success") {
                                echo '<div class="alert alert-success fade in">'; 
                            } 
                            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                            echo $status; 
                            echo '</div>'; 
                        } ?>               
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