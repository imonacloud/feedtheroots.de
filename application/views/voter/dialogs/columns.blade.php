<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><i class="icofont-columns"></i> Select columns to display</h3>
  <small class="muted">Select the columns you want to display in the current list.</small>
</div>
<div class="modal-body">
  <form id="change-colums-form" class="form" method="post">
  {{ Form::token() }}
  <input type="hidden" id="do-change-columns" name="do-change-columns" value="1">
  @include('general/columns-options')
  </form>
</div>
<div class="modal-footer">
  <button id="btn-change-columns" class="btn btn-primary"><i class="icon-ok icon-white"></i> Apply</button>
  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
</div>

