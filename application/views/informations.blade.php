@if (isset($informations) && is_array($informations) && count($informations)>0)
	<div class="alert alert-info">
	  <button class="close" data-dismiss="alert">&times;</button>
	  @if(count($informations)<=1)
	  @foreach($informations as $information)
	    {{ $information }}
	  @endforeach
	  @else
	  <ul>
	  @foreach($informations as $information)
	    <li>{{ $information }}</li>
	  @endforeach
	  </ul>
	  @endif
	</div>
@endif