<form class="form" method="post">
<input type="hidden" id="change-columns" name="change-columns" value="1">
<div id="columnsModal" class="modal hide fade" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-columns"></i> Available Columns</h3>
    <small class="muted">Select the columns you want to see, print or export in the current list</small>
  </div>
  <div class="modal-body">
    @include('general/columns-options')
  </div>
  <div class="modal-footer">
    <!--
    @if (Input::old('list-id'))
    <label class="pull-left label label-info">
      <input id="save-list-column" name="save-list-column" type="checkbox"> Set as default to current list
    </label>   
    @endif
    -->
    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save changes</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
</div>
</form>