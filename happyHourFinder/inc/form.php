
<div>
    <form class="<?php if(isset($_GET['class'])) echo $_GET['class'];else echo 'form-horizontal';?>" method="post" action="">

        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <div>
                <input type="text" name="username" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <div>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="form-group text-center">
            <div>
                <input type="hidden" name="method" value="<?php echo $_GET['method']; ?>">
                <input type="submit" name="<?php echo $_GET['method']; ?>" 
                       text="<?php echo $_GET['method']; ?>" class="btn btn-success"
                       value="<?php echo $_GET['method']; ?>">
            </div>
        </div>                                                                                              </form>
</div>

