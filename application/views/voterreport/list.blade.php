@layout('layouts/main')

@section('additional-js-header-injection')
  @parent
  var list_baseurl = "{{ URL::to_action('voter@list') }}";
@endsection        

@section('additional-header-injection')
<script type="text/javascript">
  $(document).ready(function() {

    $("a[rel=popover]").popover();

    $("a[id*='-quick-view-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var voter_id    = id_split[3];
     
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@quick_view') }}/" + voter_id, null, false, false);
    });

    
    $("a[id='btn-print-list']").click(function(event){
      event.preventDefault();
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@print_list') }}/", null, false, false);
      return false;
    });

    $("a[id*='btn-print-voter-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var voter_id    = id_split[3];

      openGeneralDialogAndGetContent("{{ URL::to_action('voter@print') }}/" + voter_id, null, false, false);
    });

    $("a[id='btn-change-columns']").click(function(event){
      event.preventDefault();
      openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@columns', (! is_null($list) ? array($list->id) : array())) }}", null, false, false);
    });

    $("a[id='btn-save-list']").click(function(event){
      event.preventDefault();
      openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@save_list', (! is_null($list) ? array($list->id) : array())) }}", null, false, false);
    });


    $("a[id*='-del-list-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var list_id    = id_split[3];
      
      openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@delete_list') }}/" + list_id, null, false, false);   
    });

    
    $("button[id='btn-clear-quick-search']").click(function(event){
      event.preventDefault();
      window.location.href = "{{ URL::to_action('voter@list') }}";
      return false;
    });

    $("#perPage").change(function() {
        $("#per_page_form").submit();
    });

    $("#btn-advance-search").click(function(event){
      event.preventDefault();
      $("div[id='voter-filters-box']").slideToggle("slow");
      return false;
    });
    
    $("#btn-advance-search-cancel").click(function(event){
      event.preventDefault();
      $("div[id='voter-filters-box']").slideToggle("slow");
      return false;    
    });   


    /*$("a[id*='mnu-pdf']").click(function(event){      
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var list_id    = id_split[2];
      openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@print_option') }}/" + list_id, null, false, false);
      return false;
    });*/

   

  });
</script>    
@endsection            

@section('content-header')
<h2><a href="{{ URL::to_action('voterreport@index') }}" ><i class="icofont-file"></i> {{ 'Report' }}</a></h2>
     
@endsection

@section('content-breadcrumb')

    <ul class="breadcrumb-nav pull-right">
      <li class="divider"></li>
      <li class="btn-group">
        <a href="#" class="btn btn-small btn-link dropdown-toggle" data-toggle="dropdown">
            <i class="icofont-download"></i> {{ __('general.download') }}
            <i class="icofont-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
          @if (!is_null($list))                
            <li><a href="{{ URL::to_action('voterreport@list', array($list->id)) }}/?download=csv" id="btn-csv">CSV</a></li>                
            
          @else
            <li><a href="{{ URL::to_action('voterreport@list') }}/?download=csv" id="btn-csv">CSV</a></li>                
            
          @endif
        </ul>
      </li> 
    </ul> 
    <!--breadcrumb-nav-->
    @include('voterreport/nav-bar')    
 
    <!--breadcrumb-->
    <ul class="breadcrumb">
        <li><a href="{{ URL::to_action('voterreport@index') }}"><i class="icofont-group"></i> {{ 'Report' }}</a> <span class="divider">&rsaquo;&rsaquo;</span></li>
        @if (!is_null($list))
          <li><a href="{{ URL::to_action('voterreport@list', array($list->id)) }}">{{ $list->name }}</a> <span class="divider">&rsaquo;</span></li>           
        @endif
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">

    @include('voterreport/voter-filters-form') 

    @if (count($voters->results) > 0)
    <div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid" style="overflow-x:auto!important; ">
      <div class="row-fluid">
       
        <div class="span12">
          <div class="dataTables_length pull-right" id="dataTables_length">
            <label>
              <form class="form-search" id="per_page_form">
                <select id="perPage" name="perPage" size="1" style="width: 70px;" rel="select2">
                  <option {{ isset($perPage) && $perPage==10 ? 'selected="selected"' : '' }} value="10">10</option>
                  <option {{ isset($perPage) && $perPage==25 ? 'selected="selected"' : '' }} value="25">25</option>
                  <option {{ isset($perPage) && $perPage==50 ? 'selected="selected"' : '' }} value="50">50</option>
                  <option {{ isset($perPage) && $perPage==100 ? 'selected="selected"' : '' }} value="100">100</option>
                </select> {{ __('voters.records_per_page') }}
              </form>
            </label>
          </div>
        </div>
      </div>
      <table id="datatables" class="table table-bordered table-striped table-hover responsive">
        <thead>
            <tr>
              @foreach($selected_columns as $selected_column => $property)
                <th>
                  <?php 
                   
                  ?>

                  {{ $property['display'] }}               

              </th>
             
              @endforeach
              <!--<th></th>-->
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
      <div class="row-fluid">
        <div class="span6">
          {{ $record_info }}
        </div>
        <div class="span6" style="text-align: right">
          {{ $voters->links(1) }}
        </div>
      </div>  
    </div>
    @else
      Not voters found in the current list.
    @endif
  </div>
</div>  

@endsection



@section('sidebar-right-control')
    <li class="active"><a href="#tab1" data-toggle="tab" title="My voter lists"><i class="icofont-list-alt"></i></a></li>
    @parent
@endsection

@section('sidebar-right-content')  

  <!--/Voter Lists -->
@parent
@endsection                   