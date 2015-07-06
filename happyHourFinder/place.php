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
            <!-- slideshow end -->
            <div class="col-sm-6">
                <h1><?php echo $name;?></h1>
                <div id="result"></div>
            </div>
        </div>
        <div id="comment"></div>
    </div>

</div><!-- main container end -->
<script src="js/place_detail.js"></script>
</body>
</html>