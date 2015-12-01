@layout('layouts/print')

@section('content-body')
  @if (count($voters) > 0)
    <table class="table table-condensed">
      <thead>
        <tr>
            <th>#</th>
          @foreach($selected_columns as $selected_column => $property)
            <th>{{ $property['display'] }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>                             
        @foreach ($voters as $key => $voter)
        <tr>
          <td>{{ ($key + 1) }}</td>
          @foreach($selected_columns as $selected_column => $property)
            <td>{{ $property['getValue']($voter, false) }}</td>
          @endforeach
        </tr>
        
        {{-- Dispatch event to track progress --}}
        {{ Event::fire('report.progress', ((100/count($voters))*($key+1))) ? "" : "" }}
        
        @endforeach
          
      </tbody>
    </table>
  @else
    No voters were found in this reports.
  @endif
@endsection 