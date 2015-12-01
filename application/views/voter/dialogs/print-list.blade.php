<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><i class="icofont-print"></i> Print Voters</h3>
  <small class="muted">The system will generate a file so you can download it and print it out.</small>
</div>
<div class="modal-body">
  <form id="print-list-form" class="form-horizontal" method="post">
    {{-- protecting this form from cross-site request forgeries--}}
    {{ Form::token() }}
    <input type="hidden" id="do_print" name="do_print" value="1">
    @include('general/print-options')
    <hr>
    <div class="control-group">      
      <label class="control-label" for="print-template">Template</label>
      <div class="controls">
        {{ Form::select('print-template', $templates, null, array('id'=>'print-template', 'rel'=>'select2', 'class'=>'span10')) }}
        <BR><BR><span class="help-block muted">Output report template.</span>     
      </div>    
    </div>  
  </form>
</div>
<div class="modal-footer">
  <button id="btn-print-list" class="btn btn-primary"><i class="icon-cog icon-white"></i> Generate Downloadable File</button>
  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
</div>
