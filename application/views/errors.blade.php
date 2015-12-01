@if (isset($errors) && is_array($errors) && count($errors)>0)
	<div class="alert alert-error">
	  <button class="close" data-dismiss="alert">&times;</button>
	  @if(count($errors)<=1)
	  @foreach($errors as $error)
	    {{ $error }}
	  @endforeach
	  @else
	  <ul>
	  @foreach($errors as $error)
	    <li>{{ $error }}</li>
	  @endforeach
	  </ul>
	  @endif
	</div>
@endif