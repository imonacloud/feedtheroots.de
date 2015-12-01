<div class="row-fluid">
  <div class="span12">
    @if (count($voters->results) > 0)
    <div id="datatables_wrapper" class="dataTables_wrapper form-inline" role="grid">
      <!--
      <div class="row-fluid">
        <div class="span12">
          <form class="form-search">
              <input id="quick_search" name="quick_search" class="input-large search-query grd-white" maxlength="23" placeholder="{{ __('voters.quick_search_by_id') }}" type="text">
          </form>
        </div>
      </div>
      -->
      <table id="datatables" class="table table-bordered table-striped table-hover responsive">
        <thead>
            <tr>
                <th>{{ __('voters.id') }}</th>
                <th>{{ __('voters.name') }}</th>
                {{ Input::old('ethnicgroup_id')!='' ? "<th>Ethnicity</th>" : "" }}
                {{ Input::old('age')!='' || Input::old('age_range')!='' ? "<th>Age</th>" : "" }}
                <th>{{ __('voters.state') }}</th>
                <th>{{ __('voters.city') }}</th>
                <th>{{ __('voters.polling_site') }}</th>
                <th>{{ __('voters.ed') }}</th>
                <!--                                                  
                <th></th>
                -->
            </tr>
        </thead>
        <tbody>
          @foreach ($voters->results as $voter)
            <tr>                 
                <td>
                
                @if (Input::old('do_search')==1)
                {{ Text::highlight($voter->voter_id, Input::old('quick_search')) }}
                @else
                {{ $voter->voter_id }}
                @endif
                
                </td>
                <td>
                @if (Input::old('do_search')==1)
                {{ Text::highlight($voter->name, Input::old('quick_search')) }}
                @else
                {{ $voter->name }}
                @endif
                </td>
                {{ Input::old('ethnicgroup_id')!='' ? "<td>".$voter->ethnicity->name."</td>" : '' }}
                {{ Input::old('age')!='' || Input::old('age_range')!='' ? "<td>".$voter->age."</td>" : "" }}
                <td>{{ $voter->state }}</td>
                <td>{{ $voter->city }}</td>
                <td>{{ $voter->pollsite->code }}</td>
                <td>{{ $voter->precinct_number }}</td>
                <!--
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
                -->
               
            </tr>
          @endforeach
            
        </tbody>
      </table>
    </div>
    @else
      {{ __('voters.not_found') }}
    @endif
  </div>
</div>  
