<table class="table">
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