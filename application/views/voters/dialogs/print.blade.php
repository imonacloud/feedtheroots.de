<div id="VotersPrintModal" class="modal hide fade" style="display: none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-print"></i> Print Voters</h3>
    <small class="muted">The system will generate a file so you can download it and print it out.</small>
  </div>
  <div class="modal-body">
    <form id="print-form" class="form-horizontal" action="{{ URL::full() }}" method="post">
      <input type="hidden" id="do_print" name="do_print" value="1">
      @include('general/print-options')
    </form>
  </div>
  <div class="modal-footer">
    <button id="btn-print" class="btn btn-primary"><i class="icon-cog icon-white"></i> Generate File</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
</div>