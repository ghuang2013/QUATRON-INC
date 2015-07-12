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
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <a data-toggle="collapse">
                            <i class="fa fa-camera fa-3x"></i><br>
                            <h2 class="hidden-xs">Photos</h2>
                        </a>
                    </div>
                    <div class="panel-body">
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
                </div>
            </div>
            <!-- slideshow ends -->
            <!-- company info -->
            <div class="col-sm-6">
                <div class="panel-group" 
                     id="accordion_head">
                  <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <a data-toggle="collapse" 
                           data-parent="#accordion_head"
                           href="#company_collapse">
                           <i class="fa fa-phone fa-3x"></i>
                          <h2 class="hidden-xs"><?php echo $name;?></h2>
                        </a>
                    </div>
                    <div id="company_collapse" 
                         class="panel-collapse collapse">
                      <div class="panel-body">
                          <div id="contact_info">
                              <!--items added in place_details.js-->
                          </div>
                      </div>
                    </div>
                  </div>

                    <div class="panel panel-primary text-center">
                        <div class="panel-heading">
                            <a data-toggle="collapse" 
                               data-parent="#accordion_head"
                               href="#hours_collapse">
                               <i class="fa fa-clock-o fa-3x"></i>
                              <h2 class="hidden-xs">Business Hours</h2>
                            </a>
                        </div>
                        <div id="hours_collapse" 
                             class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div id="opening_hours">
                                  <!--items added in place_details.js-->
                              </div>
                          </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a data-toggle="collapse" 
                               data-parent="#accordion_head" 
                               href="#commentCollapse">
                                <i class="fa fa-comments fa-3x"></i>
                               <h2 class="hidden-xs">Reviews From Google Users</h2>
                            </a>
                        </div>
                        <div id="commentCollapse" 
                             class="panel-collapse collapse">
                            <div class="panel-body">
                                <div id="comment">
                                     <!--items added in place_details.js-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><br>

    </div>

</div><!-- main container end -->
<script src="js/place_detail.js"></script>
</body>
</html>