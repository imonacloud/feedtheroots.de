<div id="voter-filters-box" class="box corner-all" style="display:none">
    <div class="box-header grd-teal color-white corner-top">
        <!--
        <div class="header-control">
            <a data-box="close">&times;</a>
        </div>
        -->
        <span><i class="icofont-search"></i> {{ __('general.filter_report') }}</span>
    </div>
    <div class="box-body">
      <form id="advance-search-form" class="form" action="{{ URL::full() }}" method="get">
        <input id="do_search" name="do_search" type="hidden" value="1"> 
        @include('voterreport/voter-filter-options')
        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-small"><i class="icon-search icon-white"></i> Search</button>
          <button id="btn-advance-search-cancel" type="button" class="btn btn-small">Cancel</button>
          <button id="btn-advance-search-clear" type="button" class="btn btn-warning pull-right btn-small"><i class="icon-remove icon-white"></i> Clear all fields</button>
        </div>
      </form>  
    </div>
</div>