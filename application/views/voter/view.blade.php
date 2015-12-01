@layout('layouts/main')

@section('additional-header-injection')
<script type="text/javascript">
  $(document).ready(function() {
  
    /*
     * general editable Fields
     */
     /*
    $("span[id*='editable_']").editable({
      emptytext: ' - '
    });
  */

    $('a[id*="editable_"]').click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        $('#' + $(this).data('editable') ).editable('toggle');
    });

    /*
     * Email Editable field
     */
    $("span[id='editable_email']").editable({
      emptytext: ' - ',
      validate: function(value) {
        if( ! $.trim(value) == '' ) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if( ! regex.test(value) ) {
            return 'Invalid email format';
          }
        }
      },
      url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      }
    });

    /*
     * Email Editable field
     */
    $("span[id*='editable_phone_']").editable({
      emptytext: ' - ',
      url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      }
    });

    /*
     * Ethnicity Editable field
     */
    $("span[id='editable_ethnicity']").editable({
        prepend: " - ",
        source: [
        @foreach(Ethnicity::all() as $ethnicity)
            {value: {{ $ethnicity->id }}, text: '{{ $ethnicity->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });   


    /*
     * Ethnicity Group Editable field
     */
    $("span[id='editable_ethnicgroup']").editable({
        prepend: " - ",
        source: [
        @foreach(Ethnicgroup::all() as $ethnicgroup)
            {value: {{ $ethnicgroup->id }}, text: '{{ $ethnicgroup->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

    /*
     * Language Editable field
     */
    $("span[id='editable_language']").editable({
        prepend: " - ",
        source: [
        @foreach(Language::all() as $language)
            {value: {{ $language->id }}, text: '{{ $language->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

    /*
     * Religion Editable field
     */
    $("span[id='editable_religion']").editable({
        prepend: " - ",
        source: [
        @foreach(Religion::all() as $religion)
            {value: {{ $religion->id }}, text: '{{ $religion->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

    /*
     * Occupation Editable field
     */
    $("span[id='editable_occupation']").editable({
        prepend: " - ",
        source: [
        @foreach(Occupation::all() as $occupation)
            {value: {{ $occupation->id }}, text: '{{ $occupation->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

    /*
     * Education Level Editable field
     */
    $("span[id='editable_educationlevel']").editable({
        prepend: " - ",
        source: [
        @foreach(Educationlevel::all() as $educationlevel)
            {value: {{ $educationlevel->id }}, text: '{{ $educationlevel->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

    /*
     * Income Level Editable field
     */
    $("span[id='editable_incomelevel']").editable({
        prepend: " - ",
        source: [
        @foreach(Incomelevel::all() as $incomelevel)
            {value: {{ $incomelevel->id }}, text: '{{ $incomelevel->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    }); 

    /*
     * Marital Status Editable field
     */
    $("span[id='editable_maritalstatus']").editable({
        prepend: " - ",
        source: [
        @foreach(Maritalstatus::all() as $maritalstatus)
            {value: {{ $maritalstatus->id }}, text: '{{ $maritalstatus->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    }); 
    
    /*
     * Time Zone Editable field
     */
    $("span[id='editable_timezone']").editable({
        prepend: " - ",
        source: [
        @foreach(Timezone::all() as $timezone)
            {value: {{ $timezone->id }}, text: '{{ $timezone->name }}'},
        @endforeach
        ],
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    }); 

    /*
     * My Voters Editable field
     */
    $("span[id='editable_mine']").editable({
        prepend: " - ",
        source: [
          {value: 'Y', text: 'Yes'},
          {value: 'N', text: 'No'},
        ],
        display: function(value, sourceData) {
             var colors = {"": "gray", 'Y': "green", 'N': "red"},
                 elem = $.grep(sourceData, function(o){return o.value == value;});
                 
             if(elem.length) {    
                 $(this).text(elem[0].text).css("color", colors[value]); 
             } else {
                 $(this).empty(); 
             }
        },   
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    }); 

    /*
     * Address Status Editable field
     */
    $("span[id='editable_addressstatus']").editable({
        prepend: " - ",
        source: [
        @foreach(Addressstatus::all() as $addressstatus)
            {value: {{ $addressstatus->id }}, text: '{{ $addressstatus->name }}'},
        @endforeach
        ],
        display: function(value, sourceData) {
             var colors = {
              @foreach(Addressstatus::all() as $addressstatus)
                "{{ $addressstatus->id }}": "{{ $addressstatus->color }}", 
              @endforeach  
             },
                 elem = $.grep(sourceData, function(o){return o.value == value;});
                 
             if(elem.length) {    
                 $(this).text(elem[0].text).css("color", colors[value]); 
             } else {
                 $(this).empty(); 
             }
        },   
        url: function(params) {
        var d = new $.Deferred;
        submitChange(d, params);
      },  
    });  

     
  });

function submitChange(d, params) {
  $.post("{{ URL::to_action('voter@set_proterty') }}", params, function (result) {
    if(result['error']) {
      $('.notifications').notify({
          message: { html: result['error']}, 
          type: 'error', 
          fadeOut: { enabled: false }
      }).show(); 
    } else {
      $('.notifications').notify({
          message: { html: result['html'] }, 
          type: 'info'
      }).show();
      d.resolve();
    }

    if(result['callback']) {
      var fn = result['callback'];
      if(typeof window[fn] === 'function') {
        window[fn]();
      }   
    }

    return d.promise();
    
  }, 'json').error(function(data) {
    showError(data);
  });
}

function showError(data) {
  var html = ' \
      <div class="modal-header"> \
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> \
      <h2 class="color-red"><i class="icofont-exclamation-sign"></i> Unhandled Exception</h2> \
    </div> \
    <div class="modal-body" id="modal-body"> ' + data.responseText.replace('<h2>Unhandled Exception</h2>', '') + ' </div> \
    <div class="modal-footer"> \
      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button> \
    </div>'; 
    $("#MyDialog").html(html);
    $("#MyDialog").modal().removeClass("large");
}

</script>
@endsection        

@section('content-header')

    <ul class="content-header-action pull-right">
        
        <!--
        @if($voter->isMine())
        <li>
            <a id="all_voters" href="#">
                <div class="badge-circle grd-green color-white"><i class="icofont-thumbs-up"></i></div>
                <div class="action-text color-green">&nbsp;0 <span class="helper-font-small color-silver-dark">&nbsp;</span></div>
            </a>
        </li>
        @else
        <li>
            <a id="all_voters" href="#">
                <div class="badge-circle grd-red color-white"><i class="icofont-thumbs-down"></i></div>
                <div class="action-text color-red">&nbsp; <span class="helper-font-small color-silver-dark">&nbsp;</span></div>
            </a>
        </li>
        @endif
      -->
    </ul>

    <h2><img src="{{ $voter->photo_thumb_url }}" style="width: 40px; height: 40px;" class="img-circle"> {{ $voter->fullname }} <small>(Voter ID: <strong>{{ $voter->voter_id }}</strong>)</small></h2>
    
@endsection

@section('content-breadcrumb')
    <!--breadcrumb-nav-->
    <ul class="breadcrumb-nav pull-right">
        <!--
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" class="btn btn-small btn-link">
                 <span class="color-green"><i class="icofont-ok-sign"></i></span> Mark as My Voter
            </a>
        </li>
      -->
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" class="btn btn-small btn-link">
                <i class="icofont-print"></i> {{ __('general.print') }}
            </a>
        </li>
    </ul>
    
     <!--/breadcrumb-nav-->
    <!--breadcrumb-->
    <ul class="breadcrumb">
        <li><a href="{{ URL::to_action('voter@list') }}"><i class="icofont-group"></i> Voters</a> <span class="divider">&rsaquo;</span></li>
        <li><a href="{{ URL::to_action('voter@view', array($voter->id)) }}"> {{ $voter->voter_id }}</a> <span class="divider">&rsaquo;</span></li>
        <li class="active">View</li>              
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">

    @include('errors')
    @include('successes')
    
    

    <div id="voter-container" class="voter-container">
      <div class="row-fluid">
        <div class="span12">
          <div class="alert alert-info">Editable fields are marked with <i class="icofont-edit"></i> icon. Click on the icon to edit it.</div>
        </div>
    </div>

      <div class="row-fluid">
        <div class="span4">
          <!-- General --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>General</span>
            </div>
            <div class="box-body">
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Title</th><td>{{ $voter->title }}</td>
                  </tr>
                  <tr>
                    <th>First Name</th><td>{{ $voter->firstname }}</td>
                  </tr>
                  <tr>
                    <th>Middle Initial</th><td>{{ $voter->middle_ini }}</td>
                  </tr>
                  <tr>
                    <th>Middle Name</th><td>{{ $voter->middlename }}</td>
                  </tr>
                  <tr>
                    <th>Last Name</th><td>{{ $voter->lastname }}</td>
                  </tr>
                  <tr>
                    <th>Surname Suffix</th><td>{{ $voter->surn_suffix }}</td>
                  </tr>
                  <tr>
                    <th>Birthdate</th><td>{{ $voter->dob }}</td>
                  </tr>
                  <tr>
                    <th>Age</th><td>{{ $voter->age }}</td>
                  </tr>
                  <tr>
                    <th>Marital Status</th>
                    <td>
                      <span id="editable_maritalstatus" data-type="select" data-pk="maritalstatus_id" data-toggle="manual" data-original-title="Select the voter's Marital Status" data-value="{{ $voter->maritalstatus_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_maritalstatus" data-editable="editable_maritalstatus" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                </thead>  
              </table>
            </div>
          </div>
          <!-- Profile --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Profile</span>
            </div>
            <div class="box-body">     
              <table class="table table-condensed responsive">
                <thead>     
                  <tr>
                    <th>Language</th>
                    <td>
                      <span id="editable_language" data-type="select" data-pk="language_id" data-toggle="manual" data-original-title="Select the voter's Language" data-value="{{ $voter->language_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_language" data-editable="editable_language" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Religion</th>
                    <td>
                      <span id="editable_religion" data-type="select" data-pk="religion_id" data-toggle="manual" data-original-title="Select the voter's Religion" data-value="{{ $voter->religion_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_religion" data-editable="editable_religion" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Occupation</th>
                    <td>
                      <span id="editable_occupation" data-type="select" data-pk="occupation_id" data-toggle="manual" data-original-title="Select the voter's Occupation" data-value="{{ $voter->occupation_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_occupation" data-editable="editable_occupation" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Education Level</th>
                    <td>
                      <span id="editable_educationlevel" data-type="select" data-pk="educationlevel_id" data-toggle="manual" data-original-title="Select the voter's Education Level" data-value="{{ $voter->educationlevel_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_educationlevel" data-editable="editable_educationlevel" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Income Level</th>
                    <td>
                      <span id="editable_incomelevel" data-type="select" data-pk="incomelevel_id" data-toggle="manual" data-original-title="Select the voter's Income Level" data-value="{{ $voter->incomelevel_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_incomelevel" data-editable="editable_incomelevel" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                </thead>
              </table>  
            </div>
          </div>

          <!-- Ethnicity --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Ethnicity</span>
            </div>
            <div class="box-body">
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Country Of Origin</th>
                    <td>
                      <span id="editable_ethnicity" data-type="select" data-pk="ethnicity_id" data-toggle="manual" data-original-title="Select the voter's Country of Origin" data-value="{{ $voter->ethnicity_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_ethnicity" data-editable="editable_ethnicity" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Ethnicity Group</th>
                    <td>
                      <span id="editable_ethnicgroup" data-type="select" data-pk="ethnicgroup_id" data-toggle="manual" data-original-title="Select the voter's Ethnicity Group" data-value="{{ $voter->ethnicgroup_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_ethnicgroup" data-editable="editable_ethnicgroup" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                 </thead> 
              </table>
            </div>
          </div>  
        </div>
        <div class="span4">
          
          <!-- Contacts --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Contacts</span>
            </div>
            <div class="box-body">
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Email</th>
                    <td>
                      <span id="editable_email" data-pk="email" data-toggle="manual" data-original-title="Add or Edit Voter's Email Address" data-value="{{ $voter->email }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }">{{ $voter->email }}</span>
                      <a href="#" id="editable_email" data-editable="editable_email" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Cel Number</th>
                    <td>
                      <span id="editable_phone_number" data-pk="phone_number" data-toggle="manual" data-original-title="Add or Edit Voter's Cel Phone Number" data-value="{{ $voter->phone_number }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }">{{ $voter->phone_number }}</span>
                      <a href="#" id="editable_phone_number" data-editable="editable_phone_number" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Home Number</th>
                    <td>
                      <span id="editable_phone_home" data-pk="home_number" data-toggle="manual" data-original-title="Add or Edit Voter's Home Phone Number" data-value="{{ $voter->home_number }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }">{{ $voter->home_number }}</span>
                      <a href="#" id="editable_home_number" data-editable="editable_phone_home" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Work Number</th>
                    <td>
                      <span id="editable_phone_work" data-pk="work_number" data-toggle="manual" data-original-title="Add or Edit Voter's Work Phone Number" data-value="{{ $voter->work_number }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }">{{ $voter->work_number }}</span>
                      <a href="#" id="editable_work_number" data-editable="editable_phone_work" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Time Zone</th>
                    <td>
                      <span id="editable_timezone" data-type="select" data-pk="timezone_id" data-toggle="manual" data-original-title="Select the voter's Time Zone" data-value="{{ $voter->timezone_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_timezone" data-editable="editable_timezone" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                 </thead> 
              </table>
            </div>  
          </div>

          <!-- Address --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Address</span>
            </div>
            <div class="box-body">  
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Address</th><td>{{ $voter->address }}</td>
                  </tr>
                  <tr>
                    <th>City</th><td>{{ $voter->city }}</td>
                  </tr>
                  <tr>
                    <th>State</th><td>{{ $voter->state }}</td>
                  </tr>
                  <tr>
                    <th>Zipcode</th><td>{{ $voter->zip }} - {{ $voter->zip4 }}</td>
                  </tr>
                  <tr>
                    <th>Latitude</th><td>{{ $voter->latitude }}</td>
                  </tr>
                  <tr>
                    <th>Logitude</th><td>{{ $voter->logitude }}</td>
                  </tr>
                  <tr>
                    <th>Address Status</th>
                    <td>
                      <span id="editable_addressstatus" data-type="select" data-pk="addressstatus_id" data-toggle="manual" data-original-title="Select the voter's Address Status" data-value="{{ $voter->addressstatus_id }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_addressstatus" data-editable="editable_addressstatus" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                 </thead> 
              </table>
            </div>
          </div>

          <!-- Mail Address --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Mail Address</span>
            </div>
            <div class="box-body">     
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Address</th><td>{{ $voter->mail_address }}</td>
                  </tr>
                  <tr>
                    <th>City</th><td>{{ $voter->mail_city }}</td>
                  </tr>
                  <tr>
                    <th>State</th><td>{{ $voter->mail_state }}</td>
                  </tr>
                  <tr>
                    <th>Zipcode</th><td>{{ $voter->mail_zip }}-{{ $voter->mail_zip4 }}</td>
                  </tr>
                </thead>
              </table> 
            </div>
          </div>

          <!-- Household --> 
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Household</span>
            </div>
            <div class="box-body">     
              <table class="table table-condensed responsive">
                <thead>
                  <tr>
                    <th>Household Income Level</th><td>{{ ($voter->householdincomelevel_id>0 ? $voter->householdincomelevel->name : '') }}</td>
                  </tr>
                  <tr>
                    <th>Number of people in the household</th><td>{{ $voter->persons_household }}</td>
                  </tr>
                  <tr>
                    <th>Presence of children in household</th><td>{{ $voter->havechild }}</td>
                  </tr>
                  <tr>
                    <th>A veteran exists in the household</th><td>{{ $voter->household_veteran }}</td>
                  </tr>
                 </thead> 
              </table>
            </div> 
          </div>    
        </div>

        <div class="span4">
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Voter Information</span>
            </div>
            <div class="box-body">     
              <table class="table table-condensed responsive">
                <thead> 
                  <tr>
                    <th>Voter Id</th><td>{{ $voter->voter_id }}</td>
                  </tr>
                  <tr>
                    <th>My voter</th>
                    <td>
                      <span id="editable_mine" data-type="select" data-pk="mine" data-toggle="manual" data-original-title="is this voter following my campaign?" data-value="{{ $voter->mine }}" data-params="{csrf_token: '{{ Session::token() }}', voter_id: '{{ $voter->id }}' }"></span>
                      <a href="#" id="editable_mine" data-editable="editable_mine" style="float: right"><i class="icofont-edit"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <th>Assembly District</th><td>{{ ($voter->assemblydistrict_id>0 ? $voter->assemblydistrict->number : '') }}</td>
                  </tr>
                  <tr>
                    <th>Pollsite</th><td>{{ ($voter->pollsite_id>0 ? $voter->pollsite->name : '') }}</td>
                  </tr>
                  <tr>
                    <th>Election District</th><td>{{ ($voter->electiondistrict_id>0 ? $voter->electiondistrict->number : '') }}</td>
                  </tr>
                  <tr>
                    <th>Senate District</th><td>{{ $voter->senate_district }}</td>
                  </tr>
                  <tr>
                    <th>Congress District</th><td>{{ $voter->congress_district }}</td>
                  </tr>
                  <tr>
                    <th>Civil Court District</th><td>{{ $voter->civil_court_district }}</td>
                  </tr>
                  <tr>
                    <th>Council District</th><td>{{ $voter->council_district }}</td>
                  </tr>
                  <tr>
                    <th>Party</th><td>{{ ($voter->party_id>0 ? $voter->party->name : '') }}</td>
                  </tr>
                  <tr>
                    <th>Status</th><td>{{ ($voter->status_id>0 ? $voter->status->name : '') }}</td>
                  </tr>
                  <tr>
                    <th>Registered Date</th><td>{{ $voter->reg_date }}</td>
                  </tr>

                </thead>
              </table>
            </div>
          </div>
          <div class="box corner-all">
            <div class="box-header grd-white">
              <span>Vote History</span>
            </div>
            <div class="box-body">    
              <table class="table table-bordered invoice responsive">
                <thead>
                  @foreach($voter->votehistory()->where_voted('Y')->order_by('electiontype_id', 'ASC')->order_by('year', 'ASC')->get() as $votehistory)
                  <tr>
                    <td>{{ $votehistory->electiontype->name }} {{ $votehistory->year }}</td>
                  </tr>
                  @endforeach
                 </thead> 
              </table>
            </div> 
          </div>                                                                      
        </div>
      </div>
    </div>
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
          <li {{ (!Input::old('list-id') ? 'class="active"': '') }}>
              <a href="{{ URL::to('voters') }}">
                  <i class="icofont-list"></i>
                  <span>Default</span>
              </a>
          </li>
          
      </ul>
  </div>
  
  <div class="divider-content"><span></span></div>
  
</div><!--/Voter Lists -->
@parent
@endsection                   