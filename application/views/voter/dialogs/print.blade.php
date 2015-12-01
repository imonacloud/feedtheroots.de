  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-print"></i> {{ isset($voter) ? 'Print - "'.$voter->name.'"' : 'Print Current Voter List' }}</h3>
    <small class="muted">The system will generate a file so you can download it and print it out.</small>
  </div>
  <div class="modal-body">
    {{-- No action is especified because we want to post to the current URL --}}
    <form id="print-form" class="form-horizontal" method="post">
      {{-- protecting this form from cross-site request forgeries --}}
      {{ Form::token() }}
      {{-- this control flag indicates if we want to print a list or a single record--}}
      <input type="hidden" id="do_print" name="do_print" value="{{ isset($voter) ? 2 : 1 }}">
      @if(isset($voter)) 
      {{ Form::hidden('print-id', $voter->id, array('id'=>'print-id')); }}
      @endif

      @include('general/print-options')
      
      <hr>
      <div class="control-group">      
        <label class="control-label" for="print-template">Template</label>
        <div class="controls">
          {{ Form::select('print-template', $templates, null, array('id'=>'print-template', 'rel'=>'select2', 'class'=>'span9')) }}
          <span class="help-block muted" style="padding-top: 30px;">Select the output report template.</span>
        </div>    
      </div>  
      
    </form>
  </div>
  <div class="modal-footer">
    <button id="btn-print" class="btn btn-primary"><i class="icon-cog icon-white"></i> Generate Downloadable File</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>