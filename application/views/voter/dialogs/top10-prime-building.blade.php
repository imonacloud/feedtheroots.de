<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3><i class="icofont-group"></i> {{ $dialog_title }}</h3>
  <small class="muted">{{ $dialog_description }}</small>
</div>
<div class="modal-body">
  @if (count($top_ten_building) > 0)
      <table class="table table-striped table-hover table-condensed responsive">
        <thead>
            <tr>
              <th>Address</th>
              <th>Total Prime Voters</th>
            </tr>
        </thead>
        <tbody>                             
          @foreach($top_ten_building as $building)
          <tr>
          <td>{{ $building->house_number }} {{ $building->street_name }} {{ $building->street_suffix }}, {{ $building->city }} {{ $building->state }} {{ $building->zipcode }}</td>
          <td>{{ $building->counted }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @else
      Not prime voters has been found.
    @endif  
</div>
<div class="modal-footer">
  <table style="width: 100%;">
    <tr>
      <td style="text-align: right; vertical-align: bottom">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
      </td>
    </tr>
  </table>
  
</div>
