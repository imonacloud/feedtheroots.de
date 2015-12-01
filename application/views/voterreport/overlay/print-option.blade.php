<form id="print-report" class="form-horizontal" action="{{ URL::to_action('voterreport@list') }}/<?php echo $id; ?>" method="get"> 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-print"></i> Download Report</h3>
    
  </div>
  <div class="modal-body">
    
      {{-- protecting this form from cross-site request forgeries--}}
   
      <input type="hidden" id="do_print" name="download" value="pdf">
      @include('voterreport/overlay/print-option-field')
      <hr>
      <div class="control-group">      
        <label class="control-label" for="print-template">Layout</label>
        <div class="controls">
          <select name="print-template" id='print-template' rel='select2' class='span10'>            
            <option value="">{{ 'Please select' }}</option>
            @foreach($templates as $id => $value)    
              <option value="{{ $id }}">{{ $value }}</option>
            @endforeach            
          </select>      
         
          <BR><BR><span class="help-block muted">Output report layout.</span>     
        </div>    
      </div>  
   
  </div>
  <div class="modal-footer">
    <input type="submit" id="btn-print-list" value="Download Report" class="btn btn-primary" />
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
</form>
