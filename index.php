<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<?php
    $error = [];
    $userDet = [];
    //echo "index";
    require __DIR__ . '/rootInfo.php';
    require __DIR__ . '/Class/loginCredentials.php';
    session_start();
    //$_SESSION['uName'] = "Amin";
    if (empty($_SESSION)){
        $request = $_SERVER['REQUEST_URI'];
        //echo $request . "<br>" . $root;
        $page = __DIR__ . "/include/error404.php";
        switch ($request) {
            case $root.'':
            case $root.'login':
            case $root.'login.php':
                //echo $request . "<br>" . $root;
                $page = __DIR__ . "/Operation/login.php";
                break;
        }
        require $page;
    }
    else if ($loginDet['uName'] === $_SESSION['uName'] ){
        $request = $_SERVER['REQUEST_URI'];
        //echo $request . "<br>" . $root;
        $page = "error404.php";
        switch ($request) {
            case $root.'login':
            case $root.'login.php':
                $page =  __DIR__ . "/Operation/login.php";
                break;
            case $root.'logout':
            case $root.'logout.php':
                $page = __DIR__ . "/Operation/logout.php";
                break;
            case $root.'home':
            case $root.'':
            case $root.'home.php':
                $page = __DIR__ . "/include/home.php";
                break;
            case $root.'category':
            case $root.'category.php':
                $page = __DIR__ . "/include/category.php";
                break;
            case $root.'item':
            case $root.'item.php':
                $page = __DIR__ . "/include/item.php";
                break;
        }
        //echo $page;
        require $page ;
    }
    else {
        header("Location: $root"."login");
    }
?>
</body>
</html>