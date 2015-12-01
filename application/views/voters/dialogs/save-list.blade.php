<div id="saveModal" class="modal hide fade" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-save"></i> Save Current Filtered List</h3>
    <small class="muted">Save the current list so you can use it or work on it later.</small>
  </div>
  <div class="modal-body">
    <form id="save-list-form" class="form-horizontal" action="{{ URL::full() }}" method="post">
      <input type="hidden" id="list-save" name="list-save" value="1">
      <fieldset>
        <div id="save-list-name" class="control-group">
          <label class="control-label" for="inputWarning">Name</label>
          <div class="controls">
            <input id="save-list-name" name="save-list-name" type="text" value="{{ Input::old('list-name')}}">
            <span class="help-block">No more than 30 characters.</span>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputError">Description</label>
          <div class="controls">
            <textarea id="save-list-description" name="save-list-description" type="text">{{ Input::old('list-description')}}</textarea>
            <span class="help-block">Brief Description about this list.</span>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <div class="modal-footer">
    @if (Input::old('list-id') )
    <label class="checkbox pull-left">
        <input type="checkbox" id="save-new-list" name="save-new-list"> Save as new list  
    </label>  
    @endif
    <button id="btn-save-list" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $("#btn-save-list").click(function(event){
    event.preventDefault();
    
    var error = false;
      
    var name = $("input[id='save-list-name']").val().trim();
    
    if(name == '') {
      error = true;
      $("div[id='save-list-name']").addClass("error");
    } else {     
    	$("div[id='save-list-name']").removeClass("error");
    }
    
    if(!error) {
      $("#save-list-form").submit();
    }
    return false;
  });  
});
</script>