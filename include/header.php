<?php   
  require __DIR__ . '/../rootInfo.php';
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $root?>home">Billing</a>
    </div>
    <ul class="nav navbar-nav">
      <li id="navHome"><a href="<?php echo $root?>home">Home</a></li>
      <li id="navCategory"><a href="<?php echo $root?>category">Category</a></li>
      <li id="navItem"><a href="<?php echo $root?>item">Item</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right m-5">
    <li  id="logout"><a href="<?php echo $root?>logout">Logout</a></li>
    
    </ul>
  </div>
</nav>

<!-- Alert Box -->
<!-- 
<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Alert</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body text-center h4 alert" id="alertBody">
          
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reloadWindow()">Ok</button>
      </div>
      </div>
  </div>
</div> -->
<!-- <button id='alertInit' data-toggle='modal' data-target='#alert'></button> -->
