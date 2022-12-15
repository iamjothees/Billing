<div>
<?php
    foreach($error as $out){
?>
        <div class="alert alert-danger">
            <strong>Login Error!</strong> <?php echo $out; ?>
        </div>
<?php
    }
    unset($error);
?>
    </div>
    <link rel="stylesheet" href="styles/login.css">
    <div class="container text-center ">
        <form action="login" method="POST">
            <div class="input-group mt">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user padding-md"></i></span>
                <input id="uName" type="text" class="form-control" name="uName" placeholder="UserName" value=<?php echo $userDet['name']; ?>>
            </div><br>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock padding-md"></i></span>
                <input id="password" type="password" class="form-control" name="uPass" placeholder="Password">
            </div><br><br>

            <button type="submit" id="login" class="btn btn-default">Login</button>
        </form>
    </div>
