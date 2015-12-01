<div id="searchModal" class="modal hide fade" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-search"></i> {{ __('general.advance_search') }}</h3>
    <small class="muted">You can search for voters by typing any of the following criterias (Not case sensitive).</small>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
      <fieldset>
        <div class="control-group">
          <label class="control-label" for="inputWarning">First Name</label>
          <div class="controls">
            <input id="inputWarning" type="text">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputError">Last Name</label>
          <div class="controls">
            <input id="inputError" type="text">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputInfo">Gender</label>
          <div class="controls">
            <select id="e1">
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            DOB <input id="inputSuccess" type="text" class="span4 datepicker" data-date-format="mm/dd/yy">
          </div>
        </div>
        <hr>
        <div class="control-group">
          <label class="control-label" for="inputSuccess">House #</label>
          <div class="controls">
            <input id="inputSuccess" type="text" class="span2">
            Street <input id="inputSuccess" type="text" class="span5">
            Suffix <input id="inputSuccess" type="text" class="span2">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputSuccess">City</label>
          <div class="controls">
            <input id="inputSuccess" type="text" class="span5">
            State <input id="inputSuccess" type="text" class="span2">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputSuccess">Zipcode</label>
          <div class="controls">
            <input id="inputSuccess" type="text" class="span3">
            - <input id="inputSuccess" type="text" class="span2">
          </div>
        </div>
        <hr>
        <div class="control-group">
          <label class="control-label" for="inputSuccess">Poll Site</label>
          <div class="controls">
            <input id="inputSuccess" type="text" class="span3">
            Precinct Number <input id="inputSuccess" type="text" class="span2">
          </div>
        </div>
        <hr>
        <div class="control-group">
          <label class="control-label">Group</label>
          <div class="controls">
              <label class="checkbox">
                <input name="inputCheckbox" id="inlineCheckbox1" value="option1" type="checkbox"> Prime Voter
              </label>
              <label class="checkbox">
                <input name="inputCheckbox" id="inlineCheckbox1" value="option1" type="checkbox"> Double Prime
              </label>
              <label class="checkbox">
                <input name="inputCheckbox" id="inlineCheckbox1" value="option1" type="checkbox"> Triple Prime
              </label>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary"><i class="icon-search icon-white"></i> Search</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
</div>