<?php
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
                <label for="usr">Item Name:</label>
                <input type="text" class="form-control" id="editName">
            </div>

            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Category
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="editItemCategory">
                        
                    </ul>
                </div>
            </div>


            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Status
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
    </div>
    </div>
    </div>
    <button id='editorWindowInit' data-toggle='modal' data-target='#editorWindow'></button>


    <!-- Add New Button -->
    <button type="button" class="btn btn-primary" onclick="addNewInit()">Add New</button><br><br>

    <!-- Category Table -->
    <?php
        require __DIR__ . '/../Class/itemClass.php';
        $itemObj = new Item();
        $resArr = json_decode($itemObj->view());

        require __DIR__ . '/../Class/categoryClass.php';
        $catObj = new Category();
        $catArr = json_decode($catObj->view_name());
        
        //var_dump ($cat_id_name);

        
    ?>

    <table class="table table-bordered justify-content-center">
        <thead>
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Category</th>
                <th class="text-center">Status</th>
                <th colspan='2' class="text-center">Operations</th>
            </tr>
        </thead>

<?php
    $i = -1;
    foreach ($resArr as $row){
        $i++;
        echo "<td> $row->item_name </td>";

        $flag = False;
        foreach ( $catArr as $cat_id_name){
            if ($cat_id_name->cat_id == $row->item_category){
                echo "<td> ". $cat_id_name->cat_name ." </td>";
                $flag = True;
                break;
            }
        }
        if ($flag == False){
            echo "<td>  </td>";
        }
        $status = $row->item_status == 1 ? "Available" : "Unavailable";
        echo "<td> $status </td>";
        echo "<td onclick='editInit($row->item_id, `$row->item_name`, $row->item_category, $row->item_status)'><i class='glyphicon glyphicon-pencil'></i> Edit </td>";
        echo "<td onclick='delInit($row->item_id, `$row->item_name`)'><i class='glyphicon glyphicon-trash'></i> Delete </td>";
        echo "</tr>";
    }
?>
    </table>
    <div id=res></div>
<?php
    }else{
        header("Location: $root"."login");
    }
?>

<script>
let delId;
let editId;
let catId = 0;
let itemStatus = 0;
$(document).ready(()=>{

    $('#navItem').addClass('active');
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

function delInit(id, name) {
    console.log("paid");
    
    $('#delRowName').html(`<ul>${name}</ul>`);
    $('#confirmDeletion').click();
    $('#delButton').click(()=>{
        delRow(id);
    })
    
}
function delRow(id){
    let data = {
        reqAction : "delete",
        item_id : id
    }

    const url = "Operation/itemOperation.php";
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


function addNewInit(){
    $('#inputModalTitle').html('Add New Item');
    
    $('#editItemCategory').html(" ");
    <?php foreach($catArr as $catIdName){ ?>
    $('#editItemCategory').html(
        $('#editItemCategory').html() + "<li><a onclick='setCatId(<?php echo $catIdName->cat_id?>)'><?php echo $catIdName->cat_name?></a></li>"
    )
    <?php }?>
    
    $('#editorWindow').modal();
    $('#saveButton').click(()=>{
        addNew();
    })
}

function addNew(){
    let data = {
        reqAction : "add",
        item_name : $(`#editName`).val(),
        item_category : catId,
        item_status : itemStatus
    }
    console.log(data);
    
    const url = "Operation/itemOperation.php";
    if (data.item_name == ""){
        return;
    }
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
function editInit(id, name, category, status){
    console.log('editinit ' + id);
    //editId = id;
    $('#inputModalTitle').html('Edit Current Item');

    $('#editItemCategory').html(" ");
    <?php foreach($catArr as $catIdName){ ?>

    $('#editItemCategory').html(
        $('#editItemCategory').html() + "<li><a onclick='setCatId(<?php echo $catIdName->cat_id?>)'><?php echo $catIdName->cat_name?></a></li>"
    )
    <?php }?>

    $('#editName').val(name);      
    catId = category;
    itemStatus = status;

    //$('#editCategory').modal();
    $('#editorWindow').modal();
    $('#saveButton').click(()=>{
        update(id);
    })
    //$('#editorWindowInit').click();
    /* let data = {
        reqAction : "edit",
        item_id : editId
    }

    const url = "Operation/itemOperation.php";
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
        //console.log(data);
        $('#editName').val(data[0]['item_name']);      
        catId = data[0]['item_category'];
        itemStatus = data[0]['item_status'];
    }); */
}


function setStatus(stat){
    itemStatus = stat;
}

function setCatId(inp){
    catId = inp;
}

function update(id){
    console.log('update');
    let data = {
        reqObj : "category",
        reqAction : "update",
        item_id : id,
        item_name : $(`#editName`).val(),
        cat_id : catId,
        item_status : itemStatus
    }
    
    const url = "Operation/itemOperation.php";
    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-type' : 'application/json'
        },
        body: JSON.stringify(data)
    })
    //.then((response)=>console.log(response.text()))
    .then(()=>reloadWindow());
}

function reloadWindow(){
    window.location.reload();
}
</script>
