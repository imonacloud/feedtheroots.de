@layout('layouts/main')

@section('additional-js-header-injection')
  @parent
  var list_baseurl = "{{ URL::to_action('voters@list') }}";
@endsection        

@section('content-header')
    <ul class="content-header-action pull-right">
        <li class="divider"></li>
        <li>
            <a href="{{ URL::to('voters') }}">
                <div class="badge-circle grd-teal color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-teal">{{ $total_voters }} <span class="helper-font-small color-silver-dark">Voters</span></div>
            </a>
        </li>
        <li class="divider"></li>
        @if(!Input::had('mine'))
        <li>
            <a href="{{ URL::to('voters') }}/mine">
                <div class="badge-circle grd-green color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-green">{{ $total_my_voters }} <span class="helper-font-small color-silver-dark">My Voters</span></div>
            </a>
        </li>
        <li class="divider"></li>
        @endif
        <li>
            <a href="{{ URL::to('voters') }}">
                <div class="badge-circle grd-red color-white"><i class="icofont-{{ Input::old('do_search')==1 ? 'filter' : 'group' }}"></i></div>
                <div class="action-text color-red">{{ $total_no_my_voters }} <span class="helper-font-small color-silver-dark">to conquer</span></div>
            </a>
        </li>
    </ul>
    <h2><i class="icofont-group"></i> {{ __('voters.title') }}</h2>
@endsection

@section('content-breadcrumb')
    <!--breadcrumb-nav-->
    <ul class="breadcrumb-nav pull-right">
        <li class="divider"></li>
        
        @if (Input::old('do_search')==1)
        <li class="btn-group">
            <a href="#saveModal" role="button" class="btn btn-small btn-link" data-toggle="modal">
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
            <a href="#VotersPrintModal" role="button" data-toggle="modal" class="btn btn-small btn-link">
                <i class="icofont-print"></i> {{ __('general.print') }}
            </a>
        </li>
        <!--
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" class="btn btn-small btn-link dropdown-toggle" data-toggle="dropdown">
                <i class="icofont-download-alt"></i> {{ __('general.export') }}
                <i class="icofont-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#">PDF</a></li>
                <li><a href="#">CVS</a></li>
                <li><a href="#">HTML</a></li>
            </ul>
        </li>
        -->
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#columnsModal" role="button" data-toggle="modal" class="btn btn-small btn-link">
                <i class="icofont-columns"></i> {{ __('general.columns') }}
            </a>
        </li>
        @if (Input::old('list-id'))
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" class="btn btn-small btn-link dropdown-toggle" data-toggle="dropdown">
                <i class="icofont-cogs"></i> List Options
                <i class="icofont-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" id="btn-edit-list-{{ Input::old('list-id') }}">Edit</a></li>
                <li><a href="#" id="btn-del-list-{{ Input::old('list-id') }}">Delete</a></li>
            </ul>
        </li>  
        @endif
    </ul>
    
     <!--/breadcrumb-nav-->
    <!--breadcrumb-->
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('voters') }}"><i class="icofont-group"></i> {{ __('voters.title') }}</a> <span class="divider">&rsaquo;</span></li>
        @if (Input::old('do_search')==1)
          <li><a href="{{ URL::to('voters') }}">{{ __('voters.list') }}</a> <span class="divider">&rsaquo;</span></li>
          @if (Input::old('list-id'))
            <li><a href="{{ URL::to('voters') }}/list/{{ Input::old('list-id') }}">{{ Input::old('list-name') }}</a> <span class="divider">&rsaquo;</span></li>            
          @endif
          <li class="active">{{ __('general.search') }}</li>
        @else 
          @if (Input::old('list-id'))
            <li><a href="{{ URL::to('voters') }}/list/{{ Input::old('list-id') }}">{{ __('voters.list') }}</a> <span class="divider">&rsaquo;</span></li>
            <li class="active">{{ Input::old('list-name') }}</li>
          @else
            <li class="active">{{ __('voters.list') }}</li>              
          @endif
        @endif
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">

    @include('voters/voter-filters-form')
    
    @if (count($voters->results) > 0)
    <div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
      <div class="row-fluid">
        <div class="span6">
          <form class="form-search">
              <input id="do_search" name="do_search" type="hidden" value="1">
              <input id="quick_search" name="quick_search" class="input-large search-query grd-white" maxlength="23" placeholder="{{ __('voters.quick_search_label') }}" type="text">
          </form>
        </div>
        <div class="span6">
          <div class="dataTables_length pull-right" id="dataTables_length">
            <label>
              <form class="form-search" id="per_page_form">
                <select id="perPage" name="perPage" size="1" style="width: 70px;">
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
                <td>{{ $property['getValue']($voter, true) }}</td>
              @endforeach
              <td>
                  <div class="btn-group" style="margin: 0;">
                        <button class="btn btn-mini dropdown-toggle btn-inverse" data-toggle="dropdown">{{ __('general.actions') }} <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="#"><b>Quick View</b></a></li>
                          <li><a href="#">View all information</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Voting History</a></li>
                          <li><a href="#">Follow Up</a></li>
                        </ul>
                  </div>
                </td>
            </tr>
          @endforeach
            
        </tbody>
      </table>
      <div class="row-fluid">
        <div class="span12">
          {{ $voters->links() }}
        </div>
      </div>  
    </div>
    @else
      {{ __('voters.not_found') }}
    @endif
  </div>
</div>  


<!-- Modal -->
  @include('voters/dialogs/search')
  @include('voters/dialogs/columns')

  <!-- save list modal -->
  @if (Input::old('do_search')==1)
    @include('voters/dialogs/save-list')
  @endif
  <!-- print modal -->
  @include('voters/dialogs/print')
  

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
            <li {{ (!Input::old('list-id') ? 'class="active"': '') }}>
                <a href="{{ URL::to('voters') }}">
                    <i class="icofont-list"></i>
                    <span>Default</span>
                </a>
            </li>
            @foreach($voterlists as $voterlist)
            <li {{ (Input::old('list-id') == $voterlist->id ? 'class="active"' : '') }} >
                <a href="{{ URL::to('voters') }}/list/{{ $voterlist->id }}" rel="popover" data-original-title="{{ $voterlist->name }}" data-content="{{ $voterlist->description }}" data-toggle="popover" data-trigger="hover" data-placement="left" title="">
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