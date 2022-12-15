<?php
    session_start();
    require __DIR__ . '/../Class/loginCredentials.php';
    //$_SESSION['uName'] = "Admin";
    if (!isset($_SESSION)){
        header("Location: $root"."login");
    }else if ($loginDet['uName'] === $_SESSION['uName']){
    require __DIR__ . '/header.php';
    require __DIR__ . '/alert.php';
    require __DIR__ . '/modal.php';
?>

    <!-- CAtegory PAGE -->

    <!-- Editor window Modal -->
    <div class="modal fade" id="editorWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="inputModalTitle"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="usr">Category Name:</label>
                <input type="text" class="form-control" id="editName">
            </div>
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Category Status
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="editStatus">
                        <li><a onclick='setStatus(1)'>Available</a></li>
                        <li><a onclick='setStatus(0)'>Unavailable</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editorWindow" id='saveButton'>Save Changes</button>
        </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick='delRow()'>Save Changes</button>
        </div> -->
        </div>
    </div>
    </div>
    <button id='editorWindowInit' data-toggle='modal' data-target='#editorWindow'></button>


    <!-- Add New Button -->
    <button type="button" class="btn btn-primary" onclick="addNewInit()">Add New</button><br><br>

    <!-- Category Table -->
    <?php
        require __DIR__ . '/../Class/categoryClass.php';
        $catObj = new Category();
        $resArr = json_decode($catObj->view());
        //echo $resArr;

        
    ?>

    <table class="table table-bordered justify-content-center">
        <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Status</th>
                <th colspan='2' class="text-center">Operations</th>
            </tr>
        </thead>

<?php
    foreach ($resArr as $row){
        echo "<td> $row->cat_name </td>";
        $row->cat_status = $row->cat_status == 1 ? "Available" : "Unavailable";
        echo "<td> $row->cat_status </td>";
        echo "<td onclick=editInit($row->cat_id)><i class='glyphicon glyphicon-pencil'></i> Edit </td>";
        echo "<td onclick='delInit($row->cat_id)'><i class='glyphicon glyphicon-trash'></i> Delete </td>";
        echo "</tr>";
    }
?>
    </table>
<?php
    }else{
        header("Location: $root"."login");
    }
?>

<script>
let delId;
let editId;
let categoryStatus = 0;
$(document).ready(()=>{

    $('#navCategory').addClass('active');
    $('#confirmDeletion').hide();
    $('#editorWindowInit').hide();
    $("#alertInit").hide();
    
    /* function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");
        
        // Applying the top margin on modal to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    // Align modal when it is displayed
    $(".modal").on("shown.bs.modal", alignModal);
    
    // Align modal when user resize the window
    $(window).on("resize", function(){
        $(".modal:visible").each(alignModal);
    }); */

})
function delInit(id) {
    $('#confirmDeletion').click();
    delId = id;
}
function editWindowInit(id) {
    edit();
}

function delRow(){
    console.log("Hit delete <> " + delId);
    let data = {
        reqAction : "delete",
        cat_id : delId
    }

    const url = "Operation/categoryOperation.php";
    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type' : 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then((response)=>response.text())
    .then((data)=>{
        reloadWindow();
    });
}


function addNewInit(){
    $('#inputModalTitle').html('Add New Category');
    $('#editName').val("");      
    categoryStatus = 0;    
    $('#editorWindow').modal();
    $('#saveButton').click(()=>{
        addNew();
    })
}

function addNew(){
    let data = {
        reqAction : "add",
        cat_name : $(`#editName`).val(),
        cat_status : categoryStatus
    }
    console.log(data);

    if (data.cat_name == ""){
        return;
    }
    
    
    const url = "Operation/categoryOperation.php";
    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type' : 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(()=>reloadWindow());
}

function editInit(id){
    editId = id;
    $('#inputModalTitle').html('Edit Current Category');
    $('#editorWindow').modal();
    $('#saveButton').click(()=>{
        update();
    })
    //$('#editorWindowInit').click();
    let data = {
        reqAction : "edit",
        cat_id : editId
    }

    const url = "Operation/categoryOperation.php";
    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type' : 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then((response)=>response.json())
    .then((data)=>{
        //$('#res').html(data);
        //console.log(data[0]["cat_name"]);
        $('#editName').val(data[0].cat_name);      
        categoryStatus = data[0]['cat_status'];    
    });
}


function setStatus(stat){
    categoryStatus = stat;
}

function update(){
    let data = {
        reqObj : "category",
        reqAction : "update",
        cat_id : editId,
        cat_name : $(`#editName`).val(),
        cat_status : categoryStatus
    }
    console.log(data);
    
    const url = "Operation/categoryOperation.php";
    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type' : 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(()=>reloadWindow());
}

function reloadWindow(){
    window.location.reload();
}
</script>
