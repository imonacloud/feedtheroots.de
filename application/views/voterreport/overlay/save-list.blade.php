<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><i class="icofont-save"></i> Save Filter Report Criteria</h3>
  <small class="muted">Save the current filter critera with selected columns</small>
</div>
<div class="modal-body">
  {{-- No action is especified because we want to post to the current URL --}}
  <form id="save-list-form" class="form-horizontal" method="post">
    <input type="hidden" id="do-list-save" name="do-list-save" value="1">
    {{ Form::token() }}
    <fieldset>
      <div id="save-list-name" class="control-group">
        <label class="control-label" for="inputWarning">Name</label>
        <div class="controls">
          <input id="save-list-name" name="save-list-name" type="text" value="{{ is_null($list) ? '' : $list->name }}">
          <span class="help-block">No more than 30 characters.</span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputError">Description</label>
        <div class="controls">
          <textarea id="save-list-description" name="save-list-description" type="text">{{ is_null($list) ? '' : $list->description }}</textarea>
          <span class="help-block">Brief Description about this list.</span>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          @if ( ! is_null($list) )
          <label class="checkbox pull-left">
              <input type="checkbox" id="save-as-new-list" name="save-as-new-list"> Save as new list  
          </label>  
          @endif
        </div>
      </div>
      
    </fieldset>
  </form>
</div>
<div class="modal-footer">
  <button id="btn-save-list" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save</button>
  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
</div>
