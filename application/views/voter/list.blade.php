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
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@columns', (! is_null($list) ? array($list->id) : array())) }}", null, false, false);
    });

    $("a[id='btn-save-list']").click(function(event){
      event.preventDefault();
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@save_list', (! is_null($list) ? array($list->id) : array())) }}", null, false, false);
    });


    $("a[id*='-del-list-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var list_id    = id_split[3];
      
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@delete_list') }}/" + list_id, null, false, false);   
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

  });
</script>    
@endsection            

@section('content-header')
    <ul class="content-header-action pull-right">
        <li class="divider"></li>
        <li>
            <a href="{{ URL::to_action('voter@list') }}">
                <div class="badge-circle grd-teal color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-teal">{{ number_format($total_voters) }} <span class="helper-font-small color-silver-dark">Voters</span></div>
            </a>
        </li>
        <li class="divider"></li>
        @if(!Input::had('do_my_voters_search'))
        <li>
            <a href="{{ URL::to_action('voter@my_list', (! is_null($list) ? array($list->id) : array()) ) }}">
                <div class="badge-circle grd-green color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-green">{{ number_format($total_my_voters) }} <span class="helper-font-small color-silver-dark">My Voters</span></div>
            </a>
        </li>
        <li class="divider"></li>
        @endif
        <li>
            <a href="{{ URL::to('voters') }}">
                <div class="badge-circle grd-red color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-red">{{ number_format($total_no_my_voters) }} <span class="helper-font-small color-silver-dark">to conquer</span></div>
            </a>
        </li>
    </ul>
    <h2><i class="icofont-group"></i> {{ Input::had('do_my_voters_search') ? 'My voters' : 'Voters' }}</h2>
@endsection

@section('content-breadcrumb')
    <!--breadcrumb-nav-->
    <ul class="breadcrumb-nav pull-right">
        <li class="divider"></li>
        
        @if (Input::old('do_search')==1)
        <li class="btn-group">
            <a id="btn-save-list" href="#" role="button" class="btn btn-small btn-link">
                <i class="icofont-save"></i> {{ __('voters.save_current_list') }}  
            </a>
        </li>
        <li class="divider"></li>
        @endif
        
        <li class="btn-group">
            <a id="btn-advance-search" href="#" role="button" class="btn btn-small btn-link">
                <i class="icofont-search"></i> {{ __('general.advance_search') }}  
            </a>
        </li>
        <li class="divider"></li>
        <li class="btn-group">
            <a id="btn-print-list" href="#" role="button" class="btn btn-small btn-link">
                <i class="icofont-print"></i> {{ __('general.print') }}
            </a>
        </li>
        <li class="divider"></li>
        <li class="btn-group">
            <a id="btn-change-columns" href="#" role="button" class="btn btn-small btn-link">
                <i class="icofont-columns"></i> {{ __('general.columns') }}
            </a>
        </li>
        @if (!is_null($list))
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" class="btn btn-small btn-link dropdown-toggle" data-toggle="dropdown">
                <i class="icofont-cogs"></i> List Options
                <i class="icofont-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <!--
                <li><a href="#" id="btn-edit-list-{{ Input::old('list-id') }}">Edit</a></li>
                 -->
                <li><a href="#" id="mnu-del-list-{{ $list->id }}">Delete</a></li>
            </ul>
        </li>  
        @endif
    </ul>
    
     <!--/breadcrumb-nav-->
    <!--breadcrumb-->
    <ul class="breadcrumb">
        <li><a href="{{ URL::to_action('voter@list') }}"><i class="icofont-group"></i> {{ __('voters.title') }}</a> <span class="divider">&rsaquo;</span></li>
        @if (Input::old('do_search')==1)
          <li><a href="{{ URL::to_action('voter@list') }}">{{ __('voters.list') }}</a> <span class="divider">&rsaquo;</span></li>
          @if (!is_null($list))
            <li><a href="{{ URL::to_action('voter@list', array($list->id)) }}">{{ $list->name }}</a> <span class="divider">&rsaquo;</span></li>           
          @endif
          <li class="active">{{ __('general.search') }}</li>
        @else 
          @if (!is_null($list))
            <li><a href="{{ URL::to_action('voter@list') }}">{{ __('voters.list') }}</a> <span class="divider">&rsaquo;</span></li>
            @if(Input::had('do_my_voters_search'))
              <li><a href="{{ URL::to_action('voter@list', array($list->id)) }}">{{ $list->name }}</a> <span class="divider">&rsaquo;</span></li>
              <li class="active">My Voters</li>
            @else
              <li class="active">{{ $list->name }}</li>
            @endif
          @else
            <li class="active">{{ __('voters.list') }}</li>              
          @endif
        @endif
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">

    @include('voter/voter-filters-form')

    @if (count($voters->results) > 0)
    <div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
      <div class="row-fluid">
        <div class="span6">
          <form class="form-search">
              <input id="do_search" name="do_search" type="hidden" value="1">
              @if(Input::had('quick_search'))
              <div class="input-append">
                <input id="quick_search" name="quick_search" class="input-large search-query grd-white" maxlength="23" placeholder="{{ __('voters.quick_search_label') }}" type="text" value="{{ Input::old('quick_search') }}"> 
                <button id="btn-clear-quick-search" class="btn btn-warning" title="remove filter - back to list"><i class="icon-remove icon-white"></i></button>
              </div>
              @else
              <input id="quick_search" name="quick_search" class="input-large search-query grd-white" maxlength="23" placeholder="{{ __('voters.quick_search_label') }}" type="text" value="{{ Input::old('quick_search') }}">
              @endif
          </form>
        </div>
        <div class="span6">
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
                <th>{{ $property['display'] }}</th>
              @endforeach
              <th></th>
            </tr>
        </thead>
        <tbody>                             
          @foreach ($voters->results as $voter)
            <tr>
              @foreach($selected_columns as $selected_column => $property)
                <td style="vertical-align: middle;">{{ $property['getValue']($voter, true) }}</td>
              @endforeach
              <td style="vertical-align: middle;">
                  <div class="btn-group" style="margin: 0;">
                        <button class="btn btn-mini dropdown-toggle btn-inverse" data-toggle="dropdown">{{ __('general.actions') }} <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a id="mnu-quick-view-{{ $voter->id }}" href="#"><b>Quick View</b></a></li> 
                          <li><a href="{{ URL::to_action('voter@view', array($voter->id)) }}">View all information</a></li>
                          <li class="divider"></li>
                          <li><a id="btn-print-voter-{{ $voter->id }}" href="#">Print</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Follow Up</a></li>
                        </ul>
                  </div>
                </td>
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


@section('sidebar-right-header')
<div class="sr-header-right">
  <h2><span class="label label-info">0</span></h2>
</div>

<div class="sr-header-left">
  <p class="bold" style="text-align: left;">Total Voters</p>
  <small class="muted">Total voters in the current list</small>
</div>
@endsection


@section('sidebar-right-control')
    <li class="active"><a href="#tab1" data-toggle="tab" title="My voter lists"><i class="icofont-list-alt"></i></a></li>
    @parent
@endsection

@section('sidebar-right-content')
  <!--/Voter Lists -->
  <div class="tab-pane fade active in" id="tab1">
    <h5>My voter lists</h5>
    <div class="divider-content"><span></span></div>
    
    <div class="side-nav">
        <ul class="nav-side">
            <li {{ (is_null($list) ? 'class="active"': '') }} >
                <a href="{{ URL::to_action('voter@list') }}" rel="popover" data-original-title="All Voters" data-content="All voters that I have permission to see or work. This is the default list that's why it can't be removed from here." data-toggle="popover" data-trigger="hover" data-placement="left" title="">
                    <i class="icofont-list"></i>
                    <span>All Voters</span>
                </a>
            </li>
            @foreach($voterlists as $voterlist)
            <li {{ (! is_null($list) && $list->id == $voterlist->id ? 'class="active"' : '') }} >
                <a href="{{ URL::to_action('voter@list', array($voterlist->id)) }}" rel="popover" data-original-title="{{ $voterlist->name }}" data-content="{{ $voterlist->description }}" data-toggle="popover" data-trigger="hover" data-placement="left" title="">
                    <i class="icofont-list"></i>
                    <span>{{ $voterlist->name }}</span>
                </a>
                <a href="#" id="btn-del-list-{{ $voterlist->id }}" class="close" data-original-title="Delete this list" data-toggle="tooltip">&times;</a>
                 
            </li>  
            @endforeach
        </ul>
    </div>
    
    <div class="divider-content"><span></span></div>
  </div><!--/Voter Lists -->
@parent
@endsection                   