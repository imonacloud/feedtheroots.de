@if (isset($warnings) && is_array($warnings) && count($warnings)>0)
	<div class="alert">
	  <button class="close" data-dismiss="alert">&times;</button>
	  @if(count($warnings)<=1)
	  @foreach($warnings as $warning)
	    {{ $warning }}
	  @endforeach
	  @else
	  <ul>
	  @foreach($warnings as $warning)
	    <li>{{ $warning }}</li>
	  @endforeach
	  </ul>
	  @endif
	</div>
@endif