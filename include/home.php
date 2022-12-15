<?php
    require __DIR__ . '/../Class/loginCredentials.php';
    //$_SESSION['uName'] = "Admin";
    if (!isset($_SESSION)){
        header("Location: $root"."login");
    }else if ($loginDet['uName'] === $_SESSION['uName']){
    require 'header.php';
?>
    <!-- HOME PAGE -->
<?php
    }else{
        header("Location: $root"."login");
    }
?>

<script src="script.js"></script>
<script>
    $(document).ready(()=>{
        $('#navHome').addClass('active');
    })
</script>
