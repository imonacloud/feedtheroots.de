<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3 class="color-red">Are you sure you want to delete this list?</h3>
  <small class="muted">Deleting a list means that you are deleting the logical group NOT the voters.</small>
</div>
<div class="modal-body">
  <form id="delete-list-form" class="form" method="post" action="{{ URL::to_action('voter@delete_list', array($list->id)) }}">
    {{ Form::token() }}
    <fieldset>
      <table class="table table-condensed">
        <thead> 
          <tr>
            <th>System ID</th>
            <td>{{ $list->id }}</td>
          </tr>
          <tr>
            <th>List Name</th>
            <td>{{ $list->name }}</td>
          </tr>
          <tr>
            <th>List Description</th>
            <td>{{ $list->description }}</td>
          </tr>
        </thead>  
      </table>
      
    </fieldset>
  </form>
</div>
<div class="modal-footer">
  <button id="btn-delete-list" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</button>
  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
</div>
