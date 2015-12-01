@layout('layouts/main')

@section('additional-js-header-injection')
  @parent
  var list_baseurl = "{{ URL::to_action('voterreport@create_new') }}";
@endsection  

@section('additional-header-injection')
<script type="text/javascript">

    $(document).ready(function() {
	    $("a[id*='btn-delete-tpl-']").click(function(event) {	    
       	   event.preventDefault();
	       var id = $(this).attr('id');
	       var id_split    = id.split('-');
	       var voterreport_id  = id_split[3];	      
	       openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@tpl_delete') }}/" + voterreport_id, null, false, false);   
	       return false;
        });

        $("a[id*='btn-edit-tpl-']").click(function(event) {	    
       	   event.preventDefault();
	       var id = $(this).attr('id');
	       var id_split    = id.split('-');
	       var voterreport_id  = id_split[3];	      
	       openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@tpl_preview') }}/" + voterreport_id, null, false, false);   
	       return false;
        });
    });  

</script>
@endsection        

@section('content-header')
    <h2><i class="icofont-list"></i> {{ 'Report Layouts' }}</h2>
@endsection

@section('content-breadcrumb')

    @include('voterreport/nav-bar')
   
    <ul class="breadcrumb">
      <li><a href="{{ URL::to_action('voterreport@tpl_list') }}"><i class="icofont-group"></i> Layout List</a> <span class="divider">&rsaquo;</span></li>
    
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">  	

	<table id="datatables" class="table table-bordered table-striped table-hover responsive">
        <thead>
            <tr>
            	<th>Name</th>        
            	<th>Action</th>             
            </tr>
        </thead>
        <tbody>      
	        @foreach ($layouts->results as $layout)
	            <tr>
	            	<td style="vertical-align: middle;">{{ $layout->name }}</td>		           
		           
		            <td>
	                    <div class="btn-group" style="margin: 0;">
	                        <button class="btn btn-mini dropdown-toggle btn-inverse" data-toggle="dropdown">{{ __('general.actions') }} <span class="caret"></span></button>
	                        <ul class="dropdown-menu">
	                          <li><a id="btn-edit-tpl-{{ $layout->id }}" href="#"><b>Preview</b></a></li>
	                          <li class="divider"></li>
	                          <li><a href="/voterreport/tpl_new/{{ $layout->id }}">Edit</a></li>
	                          <li><a id="btn-delete-tpl-{{ $layout->id }}" href="#">Delete</a></li>
	                          <li class="divider"></li>	                 
	                        </ul>
	                    </div>
	                </td>
		    	</tr>
		    @endforeach  
            
        </tbody>
      </table>
      <div class="row-fluid">
        <div class="span4">
    
        </div>
        <div class="span6" style="text-align: right">
          {{ $layouts->links(1) }}
        </div>
      </div>  
   
  </div> 
</div>

@endsection

@section('sidebar-right-control')
    
    @parent
@endsection

@section('sidebar-right-content')
<!--/Voter Lists -->

@parent
@endsection                   