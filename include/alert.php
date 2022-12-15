<!-- Alert -->
<?php
    if ($_SESSION['res'][0] === 1){
?>
        <div class="alert alert-success">
            <strong>Success!</strong><?php echo $_SESSION['res'][1] ; ?>
        </div>
<?php
    }else if(($_SESSION['res'][0] === 1)){
?>
        <div class="alert alert-danger">
            <strong>Error!</strong><?php echo $_SESSION['res'][1] ; ?>
        </div>
<?php
    }
    unset($_SESSION['res']);
?>
    
