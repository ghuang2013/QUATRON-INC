<?php

    $id = $_GET['id'];
    $name = $_GET['name'];

?>

<?php
    $on = "page2";
    require_once('inc/head.php');
?>
    <div class="container">
        <h1><?php echo $name;?></h1>
        <input type="hidden" id="id" value="<?php echo $id;?>">
        <div id="result"></div>
        <div id="comment"></div>
    </div>

</div><!-- main container end -->
<script src="js/place_detail.js"></script>
</body>
</html>