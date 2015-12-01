<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><i class="icofont-group"></i> {{ $dialog_title }}</h3>
  <small class="muted">{{ $dialog_description }}</small>
  <input id="search123" class="search-query pull-right" placeholder="{{ __('voters.quick_search_label') }}" value="{{ Input::old('quick_search') }}">
</div>
<div class="modal-body">
  <input type="hidden" id="dialog-url" value="{{ $dialog_url }}">
  @if (count($voters->results) > 0)
      <table class="table table-striped table-hover table-condensed responsive">
        <thead>
            <tr>
              @foreach($selected_columns as $selected_column => $property)
                <th>{{ $property['display'] }}</th>
              @endforeach
            </tr>
        </thead>
        <tbody>                             
          @foreach ($voters->results as $voter)
            <tr>
              @foreach($selected_columns as $selected_column => $property)
                <td style="vertical-align: middle;">{{ $property['getValue']($voter, true) }}</td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      {{ __('voters.not_found') }}
    @endif  
</div>
<div class="modal-footer">
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left; vertical-align: bottom">
      <small><strong>{{ $record_info }}</strong></small>
      {{ $voters->links(1) }}
      </td>
      <td style="text-align: right; vertical-align: bottom">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
      </td>
    </tr>
  </table>
  
</div>



<script type="text/javascript">

$(document).ready(function()
{
      //alert('hifrominside'); 
      $("a[id*='-quick-view-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var voter_id    = id_split[3];
     
      openNewGeneralDialogAndGetContent("http://192.34.56.157:8081/voter/quick_view/" + voter_id, null, false, false,'voter_specific');
     //openGeneralDialogAndGetContent("http://192.34.56.157:8081/voter/quick_view/" + voter_id, null, false, false);
    });

});

</script>

