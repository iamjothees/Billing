<!-- Deletion Confirmation Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Confirm Delete</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure to delete selected row?
        </div>
        <li id="delRowName" class="h5">  </li>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary"  data-dismiss="modal" id="delButton">Delete</button>
        </div>
        </div>
    </div>
    </div>
    <button id='confirmDeletion' data-toggle='modal' data-target='#confirmDelete'></button>
