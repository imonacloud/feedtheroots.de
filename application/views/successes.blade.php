@if (isset($successes) && is_array($successes) && count($successes)>0)
	<div class="alert alert-success">
	  <button class="close" data-dismiss="alert">&times;</button>
	  @if(count($successes)<=1)
	  @foreach($successes as $success)
	    {{ $success }}
	  @endforeach
	  @else
	  <ul>
	  @foreach($successes as $success)
	    <li>{{ $success }}</li>
	  @endforeach
	  </ul>
	  @endif
	</div>
@endif