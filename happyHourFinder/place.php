<?php
    $id = $_GET['id'];
    $name = $_GET['name'];
?>

<?php
    $on = "page2";
    require_once('inc/head.php');
?>
    <div class="container">
        <input type="hidden" id="id" value="<?php echo $id;?>">
        <div class="row">
            <!-- restaurants slide show -->
            <div class="col-sm-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <!--photo items added in place_details.js-->
                    </div>

                    <a class="left carousel-control" href="#carousel-example-generic" 
                     role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" 
                     role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- slideshow ends -->
            <!-- company info -->
            <div class="col-sm-6">
                <div class="panel-group" 
                     id="accordion"
                     role="tablist" 
                     aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading text-center" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" 
                           data-parent="#accordion" 
                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <h1><?php echo $name;?></h1>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" 
                         class="panel-collapse collapse in" 
                         role="tabpanel" 
                         aria-labelledby="headingOne">
                      <div class="panel-body">
                          <div id="result">
                              
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            
            <!-- company ends -->
        </div><br>
         
        <div class="row">
            <!-- comments -->
            <div class="col-sm-8">
                <div id="comment">
                    <div class="comment panel-group">
                    </div>
                </div>
            </div>
            <!-- comments end-->
        </div>
    </div>

</div><!-- main container end -->
<script src="js/place_detail.js"></script>
</body>
</html>