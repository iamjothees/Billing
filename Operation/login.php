
<?php
    session_start();
    require __DIR__ . '/../Class/loginCredentials.php';
    if (!(empty($_SESSION)) && ($loginDet["uName"] === $_SESSION["uName"])){
        header("Location: $root"."home");
    }else if(!empty($_POST)){
        $userDet['name'] = $_POST['uName'];
        $userDet['pass'] = $_POST['uPass']; 

        if ($userDet['name'] !== $loginDet["uName"]){
            $error[] = "Wrong Username";
        }
        if($userDet['pass'] !== $loginDet["uPass"]){
            $error[] = "Wrong Password";
        }
        if (empty($error)){
            $_SESSION['uName'] = $userDet['name'];
            $_SESSION['uPass'] = $userDet['pass'];
            header("Location: $root"."home");
        } else{
            require __DIR__ . '/../include/loginPage.php';
        }
    }
    else{
        require __DIR__ . '/../include/loginPage.php';
    }
?>
