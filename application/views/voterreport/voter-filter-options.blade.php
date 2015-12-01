<ul class="nav nav-tabs" id="AdvanceSearchTab">
  <li class="active"><a href="#general">General</a></li>
  <li><a href="#contact">Contact</a></li>
  <li><a href="#profile">Profile</a></li>
  <li><a href="#ethnicity">Ethniticy</a></li>
  <li><a href="#address">Address</a></li>
  <li><a href="#household">Household</a></li>
  <li><a href="#election_info">Election Info</a></li>
  <li><a href="#vote_history">Vote History</a></li>
  <li><a href="#voter_other_filter">Others</a></li>
</ul>
 
<div class="tab-content">

  <!-- General Tab-->
  <div class="tab-pane active" id="general">
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="title">Title</label>
          <div class="controls">
            <select class="span12" id="title" name="title[]" rel="select2" multiple>
              @foreach(Cache::remember('VotertitleList', function() {return Votertitle::all();}, 60) as $votertitle)
              <option {{ in_array($votertitle->name, is_array(Input::old('title')) ? Input::old('title') : array() ) ? 'selected' : '' }}>{{ $votertitle->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>  
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="firstname">First Name</label>
          <div class="controls">
            <input class="span12" id="firstname" name="firstname" type="text" value="{{ Input::old('firstname') }}">
          </div>
        </div>  
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="middle_ini">M.I.</label>
          <div class="controls">
            <input class="span12" id="middle_ini" name="middle_ini" type="text" maxlength="1" value="{{ Input::old('middle_ini') }}">
          </div>
        </div>  
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="Last Name">Last Name</label>
          <div class="controls">
            <input class="span12" id="lastname" name="lastname" type="text" value="{{ Input::old('lastname') }}">
          </div>
        </div>  
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="surn_suffix">Suffix</label>
          <div class="controls">
            <select class="span12" id="surn_suffix" name="surn_suffix[]" rel="select2" multiple>
              @foreach(Cache::remember('VotersuffixList', function() {return Votersuffix::all();}, 60) as $votersuffix)
              <option {{ in_array($votersuffix->name, is_array(Input::old('surn_suffix')) ? Input::old('surn_suffix') : array() ) ? 'selected' : '' }}>{{ $votersuffix->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>  
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="gender">Gender</label>
          <div class="controls">
            <select class="span12" id="gender" name="gender" rel="select2_nullable">
              <option selected></option>
              <option value="M" {{ Input::old('gender')=='M' ? 'selected' : '' }}>Male</option>
              <option value="F" {{ Input::old('gender')=='F' ? 'selected' : '' }}>Female</option>
            </select>
          </div>
        </div>  
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="birthdate">Birthdate</label>
          <div class="controls">
            <div id="birthdate" name="birthdate" class="input-append date span12" rel="datepicker">
              <input id="birthdate" name="birthdate" data-format="XXXX-MM-dd" type="text" class="span10" value="{{ Input::old('birthdate') }}"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
        </div>  
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="birthdate">Birthdate Range</label>
          <div class="controls">
            <div id="birthdate_from" name="birthdate_from" class="input-append date span6" rel="datepicker">
              <input id="birthdate_from" name="birthdate_from" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('birthdate_from') }}" placeholder="From"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
            <div id="birthdate_to" name="birthdate_to" class="input-append date span6" rel="datepicker">
              <input id="birthdate_to" name="birthdate_to" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('birthdate_to') }}" placeholder="To"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
        </div>  
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="age">Age</label>
          <div class="controls">
            <input class="span12" id="age" name="age" type="number" value="{{ Input::old('age') }}">
          </div>
        </div>
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="age_range">Age Range</label>
          <div class="controls">
            <input class="span6" id="age_from" name="age_from" type="number" placeholder="From" value="{{ Input::old('age_from') }}">
            <input class="span6" id="age_to" name="age_to" type="number" placeholder="To" value="{{ Input::old('age_to') }}">
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="religion_id">Religion</label>
          <div class="controls">
            <select class="span12" id="religion_id" name="religion_id[]" rel="select2" multiple>
              @foreach(Cache::remember('ReligionList', function() {return Religion::all();}, 60) as $religion)
              <option value="{{ $religion->id }}" {{ in_array($religion->id, is_array(Input::old('religion_id')) ? Input::old('religion_id') : array() ) ? 'selected' : '' }}>{{ $religion->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div> 
    </div>  
    <div class="row-fluid">
      <div class="span5">
        <div class="control-group">
          <label class="control-label" for="language_id">Language</label>
          <div class="controls">
            <select class="span12" id="language_id" name="language_id[]" rel="select2" multiple>
              @foreach(Cache::remember('LanguageList', function() {return Language::all();}, 60) as $language)
              <option value="{{ $language->id }}" {{ in_array($language->id, is_array(Input::old('language_id')) ? Input::old('language_id') : array() ) ? 'selected' : '' }}>{{ $language->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="title">Marital Status</label>
          <div class="controls">
            <select class="span12" id="maritalstatus_id" name="maritalstatus_id[]" rel="select2" multiple>
              @foreach(Cache::remember('MaritalstatusList', function() {return Maritalstatus::all();}, 60) as $maritalstatus)
              <option value="{{ $maritalstatus->id }}" {{ in_array($maritalstatus->id, is_array(Input::old('maritalstatus_id')) ? Input::old('maritalstatus_id') : array() ) ? 'selected' : '' }}>{{ $maritalstatus->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>  
      </div>
    </div>
  </div>
  
  <!-- Contact -->
  <div class="tab-pane" id="contact">
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="phonesource_id">Phone Source</label>
          <div class="controls">
            <select class="span12" id="phonesource_id" name="phonesource_id[]" rel="select2" multiple>
              @foreach(Cache::remember('PhonesourceList', function() {return Phonesource::all();}, 60) as $phonesource)
              <option value="{{ $phonesource->id }}" {{ in_array($phonesource->id, is_array(Input::old('phonesource_id')) ? Input::old('phonesource_id') : array() ) ? 'selected' : '' }}>{{ $phonesource->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="phone_code">Phone Code</label>
          <div class="controls">
            <input class="span12" id="phone_code" name="phone_code" type="telephone" value="{{ Input::old('phone_code') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="phone_number">Cel Phone Number</label>
          <div class="controls">
            <input class="span12" id="phone_number" name="phone_number" type="telephone" value="{{ Input::old('phone_number') }}">
          </div>
        </div>
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="home_number">Home Phone Number</label>
          <div class="controls">
            <input class="span12" id="home_number" name="home_number" type="telephone" value="{{ Input::old('home_number') }}">
          </div>
        </div>
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="work_number">Work Phone Number</label>
          <div class="controls">
            <input class="span12" id="work_number" name="work_number" type="telephone" value="{{ Input::old('work_number') }}">
          </div>
        </div>
      </div>      
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="dnc">Nacional Do-Not-Call List</label>
          <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="dnc" value="Y" {{ Input::old('dnc') ? 'checked' : '' }}> Exclude voters with this flag 
            </label>
          </div>
        </div>
      </div>    
    </div>
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="email">Email</label>
          <div class="controls">
            <input class="span12" id="email" name="email" type="email" value="{{ Input::old('email') }}">
          </div>
        </div>
      </div>
    </div>  
  </div>    
  
  <!-- Profile -->
  <div class="tab-pane" id="profile">
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="occupation_id">Occupation</label>
          <div class="controls">
            <select class="span12" id="occupation_id" name="occupation_id[]" rel="select2" multiple>
              @foreach(Cache::remember('OccupationList', function() {return Occupation::all();}, 60) as $occupation)
              <option value="{{ $occupation->id }}" {{ in_array($occupation->id, is_array(Input::old('occupation_id')) ? Input::old('occupation_id') : array() ) ? 'selected' : '' }}>{{ $occupation->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="educationlevel_id">Education Lavel</label>
          <div class="controls">
            <select class="span12" id="educationlevel_id" name="educationlevel_id[]" rel="select2" multiple>
              @foreach(Cache::remember('EducationlevelList', function() {return Educationlevel::all();}, 60) as $educationlevel)
              <option value="{{ $educationlevel->id }}" {{ in_array($educationlevel->id, is_array(Input::old('educationlevel_id')) ? Input::old('educationlevel_id') : array() ) ? 'selected' : '' }}>{{ $educationlevel->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>  
    </div>  
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="incomelevel_id">Income level</label>
          <div class="controls">
            <select class="span12" id="incomelevel_id" name="incomelevel_id" rel="select2_nullable">
              <option selected></option>
              @foreach(Cache::remember('IncomelevelList', function() {return Incomelevel::all();}, 60) as $incomelevel)
              <option value="{{ $incomelevel->id }}" {{ in_array($educationlevel->id, is_array(Input::old('incomelevel_id')) ? Input::old('incomelevel_id') : array() ) ? 'selected' : '' }}>{{ $incomelevel->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span6">
        <!--<div class="control-group">
          <label class="control-label" for="education_id">Education</label>
          <div class="controls">
            <select class="span12" id="education_id" name="education_id[]" rel="select2" multiple>
              <option selected></option>
              @foreach(Cache::remember('EducationList', function() {return Education::all();}, 60) as $education)
              <option value="{{ $education->id }}" {{ in_array($education->id, is_array(Input::old('education_id')) ? Input::old('education_id') : array() ) ? 'selected' : '' }}>{{ $education->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>-->
      </div>
    </div>
  </div>
  
  <!-- Ethnicity Tab-->
  <div class="tab-pane" id="ethnicity">
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="ethnicity_id">Country of Origin</label>
          <div class="controls">
            <select class="span12" id="ethnicity_id" name="ethnicity_id[]" placeholder="Ethnicity" rel="select2" multiple>
              @foreach(Cache::remember('EthnicityList', function() {return Ethnicity::all();}, 60) as $ethnicity)
              <option value="{{ $ethnicity->id }}" {{ in_array($ethnicity->id, is_array(Input::old('ethnicity_id')) ? Input::old('ethnicity_id') : array() ) ? 'selected' : '' }}>{{ $ethnicity->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>  
      <div class="span6">  
        <div class="control-group">
          <label class="control-label" for="ethnicgroup_id">Ethncity Group</label>
          <div class="controls">
            <select class="span12" id="ethnicgroup_id" name="ethnicgroup_id[]" placeholder="Ethnicity Group" rel="select2" multiple>
              @foreach(Cache::remember('EthnicgroupList', function() {return Ethnicgroup::all();}, 60) as $ethnicgroup)
              <option value="{{ $ethnicgroup->id }}" {{ in_array($ethnicgroup->id, is_array(Input::old('ethnicgroup_id')) ? Input::old('ethnicgroup_id') : array() ) ? 'selected' : '' }}>{{ $ethnicgroup->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>    
      </div>      
    </div>  
    <div class="row-fluid">
      <div class="span6">  
        <div class="control-group">
          <label class="control-label" for="ethniccode_id">Ethniccode</label>
          <div class="controls">
            <select class="span12" id="ethniccode_id" name="ethniccode_id[]" placeholder="Ethnicity Group" rel="select2" multiple>
              @foreach(Cache::remember('EthniccodeList', function() {return Ethniccode::all();}, 60) as $ethniccode)
              <option value="{{ $ethniccode->id }}" {{ in_array($ethniccode->id, is_array(Input::old('ethniccode_id')) ? Input::old('ethniccode_id') : array() ) ? 'selected' : '' }}>{{ $ethniccode->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>    
      </div>  
    </div>
  </div>
  
  <!-- Address Tab-->
  <div class="tab-pane" id="address">
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="addresstype_id">Address Types</label>
          <div class="controls">
            <select class="span12" id="addresstype_id" name="addresstype_id[]" rel="select2" multiple>
              @foreach(Cache::remember('AddresstypeList', function() {return Addresstype::all();}, 60) as $addresstype)
              <option value="{{ $addresstype->id }}" {{ in_array($addresstype->id, is_array(Input::old('addresstype_id')) ? Input::old('addresstype_id') : array() ) ? 'selected' : '' }}>{{ $addresstype->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="addressstatus_id">Address Status</label>
          <div class="controls">
            <select class="span12" id="addressstatus_id" name="addressstatus_id[]" rel="select2" multiple>
              @foreach(Addressstatus::all() as $addressstatus)
              <option value="{{ $addressstatus->id }}" {{ in_array($addressstatus->id, is_array(Input::old('addressstatus_id')) ? Input::old('addressstatus_id') : array() ) ? 'selected' : '' }}>{{ $addressstatus->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>
    </div>
    <br>
    <div class="row-fluid">
      <div class="span1">
        <div class="control-group">
          <label class="control-label" for="house_number">House#</label>
          <div class="controls">
            <input class="span12" id="house_number" name="house_number" type="text" value="{{ Input::old('house_number') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="pre_direction">Pre Direction</label>
          <div class="controls">
            <select class="span12" id="pre_direction" name="pre_direction" rel="select2_nullable">
              <option selected></option>
              @foreach(Cache::remember('DirectionList', function() {return Direction::all();}, 60) as $direction)
              <option value="{{ $direction->code }}" {{ Input::old('pre_direction')=='N' ? 'selected' : '' }}>{{ $direction->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>  
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="street_name">Street Name</label>
          <div class="controls">
            <input class="span12" id="street_name" name="street_name" type="text" value="{{ Input::old('street_name') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="post_direction">Post Direction</label>
          <div class="controls">
            <select class="span12" id="post_direction" name="post_direction" rel="select2_nullable">
              <option selected></option>
              @foreach(Cache::remember('DirectionList', function() {return Direction::all();}, 60) as $direction)
              <option value="{{ $direction->code }}" {{ Input::old('post_direction')=='N' ? 'selected' : '' }}>{{ $direction->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="street_suffix">Street Suffix</label>
          <div class="controls">
            <select class="span12" id="street_suffix" name="street_suffix" rel="select2_nullable">
              <option selected></option>
              @foreach(Cache::remember('StreetsuffixList', function() {return Streetsuffix::all();}, 60) as $streetsuffix)
              <option value="{{ $streetsuffix->code }}" {{ $streetsuffix->code==Input::old('street_suffix') ? 'selected' : '' }}>{{ $streetsuffix->code }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div> 
      <div class="span1">
        <div class="control-group">
          <label class="control-label" for="apt_number">Apt#</label>
          <div class="controls">
            <input class="span12" id="apt_number" name="apt_number" type="text" value="{{ Input::old('apt_number') }}">
          </div>
        </div>       
      </div>
    </div>
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="apt_name">Apt Name</label>
          <div class="controls">
            <input class="span12" id="apt_name" name="apt_name" type="text" value="{{ Input::old('apt_name') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="city">City</label>
          <div class="controls">
            <input class="span12" id="city" name="city" type="text" value="{{ Input::old('city') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="state">State</label>
          <div class="controls">
            <input class="span12" id="state" name="state" type="text" maxlength="2" value="{{ Input::old('state') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="state">Country</label>
          <div class="controls">
            <select class="span12" id="country_id" name="country_id[]" rel="select2" multiple>
              @foreach(Cache::remember('CountryList', function() {return Country::all();}, 60) as $country)
              <option value="{{ $country->id }}" {{ in_array($country->id, is_array(Input::old('country_id')) ? Input::old('country_id') : array() ) ? 'selected' : '' }}>{{ $country->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="zip">Zipcode & Zip4</label>
          <div class="controls">
            <input class="span6" id="zip" name="zip" type="text" maxlength="5" value="{{ Input::old('zip') }}">
            - <input class="span4" id="zip4" name="zip4" type="text" maxlength="4" value="{{ Input::old('zip4') }}">
          </div>
        </div>       
      </div>
    </div>
    <!-- latitude -->
    <div class="row-fluid">
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="latitude">Latitude</label>
          <div class="controls">
            <input class="span12" id="latitude" name="latitude" type="number" value="{{ Input::old('latitude') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="longitude">Longitude</label>
          <div class="controls">
            <input class="span12" id="longitude" name="longitude" type="number" value="{{ Input::old('longitude') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="home_sequence">Home Sequence</label>
          <div class="controls">
            <input class="span12" id="home_sequence" name="home_sequence" type="number" value="{{ Input::old('home_sequence') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="household_number">House hold number</label>
          <div class="controls">
            <input class="span12" id="household_number" name="household_number" type="number" value="{{ Input::old('household_number') }}">
          </div>
        </div>       
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="homeownerindicator_id">Home Owner Indicator</label>
          <div class="controls">
            <select class="span12" id="homeownerindicator_id" name="homeownerindicator_id[]" rel="select2" multiple>
              @foreach(Cache::remember('Homeownerindicator', function() {return Homeownerindicator::all();}, 60) as $homeownerindicator)
              <option value="{{ $homeownerindicator->id }}" {{ in_array($homeownerindicator->id, is_array(Input::old('homeownerindicator_id')) ? Input::old('homeownerindicator_id') : array() ) ? 'selected' : '' }}>{{ $homeownerindicator->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
     <!-- home market value -->
    <div class="row-fluid">      
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="homemarketvalue_id">Home Market Value</label>
          <div class="controls">
            <select class="span12" id="homemarketvalue_id" name="homemarketvalue_id[]" rel="select2" multiple>
              @foreach(Cache::remember('Homemarketvalue', function() {return Homemarketvalue::all();}, 60) as $homemarketvalue)
              <option value="{{ $homemarketvalue->id }}" {{ in_array($homemarketvalue->id, is_array(Input::old('homemarketvalue')) ? Input::old('homemarketvalue') : array() ) ? 'selected' : '' }}>{{ $homemarketvalue->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="homeowner_id">Home Owner</label>
          <div class="controls">
            <select class="span12" id="homeowner_id" name="homeowner_id[]" rel="select2" multiple>
              @foreach(Cache::remember('Homeowner', function() {return Homeowner::all();}, 60) as $homeowner)
              <option value="{{ $homeowner->id }}" {{ in_array($homeowner->id, is_array(Input::old('homeowner')) ? Input::old('homeowner') : array() ) ? 'selected' : '' }}>{{ $homeowner->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <!-- mailling address -->
    <p><h4>Mailling Address</h4></p>
    <div class="row-fluid">
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="mail_address">Address</label>
          <div class="controls">
            <input class="span12" id="mail_address" name="mail_address" type="text" value="{{ Input::old('mail_address') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="mail_city">City</label>
          <div class="controls">
            <input class="span12" id="mail_city" name="mail_city" type="text" value="{{ Input::old('mail_city') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="mail_state">State</label>
          <div class="controls">
            <input class="span12" id="mail_state" name="mail_state" type="text" maxlength="2" value="{{ Input::old('mail_state') }}">
          </div>
        </div>       
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="mail_zip">Zipcode & Zip4</label>
          <div class="controls">
            <input class="span6" id="mail_zip" name="mail_zip" type="text" maxlength="5" value="{{ Input::old('mail_zip') }}">
            - <input class="span4" id="mail_zip4" name="mail_zip4" type="text" maxlength="4" value="{{ Input::old('mail_zip4') }}">
          </div>
        </div>       
      </div>
    </div>
  </div>
  
  <!-- Household Tab-->
  <div class="tab-pane" id="household">
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="householdincomelevel_id">Household Income Level</label>
          <div class="controls">
            <select class="span12" id="householdincomelevel_id" name="householdincomelevel_id" rel="select2_nullable">
              <option></option>
              @foreach(Cache::remember('HouseholdincomelevelList', function() {return Householdincomelevel::all();}, 60) as $householdincomelevel)
              <option value="{{ $householdincomelevel->id }}" {{ in_array($householdincomelevel->id, is_array(Input::old('householdincomelevel_id')) ? Input::old('householdincomelevel_id') : array() ) ? 'selected' : '' }}>{{ $householdincomelevel->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="persons_household">Persons</label>
          <div class="controls">
            <input class="span12" id="persons_household" name="persons_household" type="text" maxlength="2" value="{{ Input::old('persons_household') }}">
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="havechild">Child(ren)</label>
          <div class="controls">
            <select class="span12" id="havechild" name="havechild" rel="select2_nullable">
              <option selected></option>
              <option value="Y" {{ Input::old('havechild')=='Y' ? 'selected' : '' }}>Yes</option>
              <option value="N" {{ Input::old('havechild')=='N' ? 'selected' : '' }}>No</option>
              <option value=" " {{ Input::old('havechild')==' ' ? 'selected' : '' }}>Unknow</option>
            </select>
          </div>
        </div>       
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="household_veteran">Veteran</label>
          <div class="controls">
            <select class="span12" id="household_veteran" name="household_veteran" rel="select2_nullable">
              <option selected></option>
              <option value="Y" {{ Input::old('household_veteran')=='Y' ? 'selected' : '' }}>Yes</option>
              <option value="N" {{ Input::old('household_veteran')=='N' ? 'selected' : '' }}>No</option>
              <option value=" " {{ Input::old('household_veteran')==' ' ? 'selected' : '' }}>Unknow</option>
            </select>
          </div>
        </div>       
      </div>
    </div>  
  </div>
  <!-- Election Info-->
  <div class="tab-pane" id="election_info">
    <div class="row-fluid">      
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="registration_date">Registration Date</label>
          <div class="controls">
            <div id="registration_date" name="registration_date" class="input-append date span12" rel="datepicker">
              <input id="registration_date" name="registration_date" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('registration_date') }}"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
        </div>  
      </div>
      <div class="span8">
        <div class="control-group">
          <label class="control-label" for="registration_date_from">Registration Date Range</label>
          <div class="controls">
            <div id="registration_date_from" name="registration_date_from" class="input-append date span6" rel="datepicker">
              <input id="registration_date_from" name="registration_date_from" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('registration_date_from') }}" placeholder="From"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
            <div id="birthdate_to" name="registration_date_to" class="input-append date span6" rel="datepicker">
              <input id="registration_date_to" name="registration_date_to" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('registration_date_to') }}" placeholder="To"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
        </div>  
      </div>
    </div>
    <hr>
    <div class="row-fluid">
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="congress_district">Congress District</label>
          <div class="controls">
            <input class="span12" id="congress_district" name="congress_district" type="number" value="{{ Input::old('congress_district') }}">
          </div>
        </div>   
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="senate_district">Senate District</label>
          <div class="controls">
            <input class="span12" id="senate_district" name="senate_district" type="number" value="{{ Input::old('senate_district') }}">
          </div>
        </div>   
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="council_district">Council Distrinct</label>
          <div class="controls">
            <input class="span12" id="council_district" name="council_district" type="number" value="{{ Input::old('council_district') }}">
          </div>
        </div>   
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="civil_court_district">Civil Court Distrinct</label>
          <div class="controls">
            <input class="span12" id="civil_court_district" name="civil_court_district" type="number" value="{{ Input::old('civil_court_district') }}">
          </div>
        </div>   
      </div>
    </div>


    <?php
    // Get account assembly, pollsite and eds configurations
    $electiondistricts = array();
    
    if(Auth::user()->is_admin()) {
      // All election distrincts assigned to the account.
      $electiondistricts = Auth::user()->account->datagroup->electiondistricts;
    } else {
      // All election distrincts that the user has permission to see/work....
      $electiondistricts = Auth::user()->electiondistricts;
    }

    $pollsite_ids = array();
    $assembly_ids = array();
    $elections = array();
    foreach ($electiondistricts as $electiondistrict) {
      if(!in_array($electiondistrict->pollsite_id, $pollsite_ids)) {
        $pollsite_ids[]=$electiondistrict->pollsite_id;
      }

      if(!in_array($electiondistrict->assemblydistrict_id, $assembly_ids)) {
        $assembly_ids[]=$electiondistrict->assemblydistrict_id;
      }

      $elections[$electiondistrict->id] = $electiondistrict->number; 
      
    }
    
    ?>

    <div class="row-fluid">
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="assemblydistrict_id">Assembly District</label>
          <div class="controls">
            
            <select class="span12" id="assemblydistrict_id" name="assemblydistrict_id" rel="select2_nullable">
              <option></option>
              @foreach(Assemblydistrict::where_in('id', $assembly_ids)->get() as $assemblydistrict)
              <option value="{{ $assemblydistrict->id }}" {{ $assemblydistrict->id == Input::old('assemblydistrict_id') ? 'selected' : '' }}>{{ $assemblydistrict->number }}</option>                      
              @endforeach
            </select>
          </div>
        </div>   
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="pollsite_id">Poll Site</label>
          <div class="controls">
            <select class="span12" id="pollsite_id" name="pollsite_id[]" placeholder="Pollsite" rel="select2" multiple>
              @foreach(Cache::remember('PollsiteList', function() {return Pollsite::all();}, 60) as $pollsite)
              <option value="{{ $pollsite->id }}" {{ in_array($pollsite->id, is_array(Input::old('pollsite_id')) ? Input::old('pollsite_id') : array() ) ? 'selected' : '' }}>{{ $pollsite->name }}</option>                      
              @endforeach
            </select>       

          </div>
        </div>   
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="electiondistrict_id">Election District</label>
          <div class="controls">
            <select class="span12" id="pollsite_id" name="pollsite_id[]" placeholder="Ethnicity" rel="select2" multiple>
              @foreach(Cache::remember('PollsiteList', function() {return Pollsite::all();}, 60) as $pollsite)
              <option value="{{ $pollsite->id }}" {{ in_array($pollsite->id, is_array(Input::old('pollsite_id')) ? Input::old('pollsite_id') : array() ) ? 'selected' : '' }}>{{ $pollsite->name }}</option>                      
              @endforeach
            </select>
            
            <select class="span12" id="sel_electiondistrict_id" name="sel_electiondistrict_id" rel="select2_nullable" {{ Input::had('electiondistrict_id') ? '' : 'disabled' }}>
              <option></option>
            </select>

            <input type="hidden" value="{{ Input::old('electiondistrict_id') }}" id="electiondistrict_id" name="electiondistrict_id">

          </div>
        </div>   
      </div>
    </div>
      
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="status_id">Status</label>
          <div class="controls">
            <select class="span12" id="status_id" name="status_id" rel="select2" multiple>
              @foreach(Cache::remember('StatusList', function() {return Status::all();}, 30) as $status)
              <option value="{{ $status->id }}" {{ $status->id==Input::old('status_id') ? 'selected' : '' }}>{{ $status->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>   
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label" for="party_id">Party</label>
          <div class="controls">
            <select class="span12" id="party_id" name="party_id" rel="select2" multiple>
              @foreach(Cache::remember('PartyList', function() {return Party::all();}, 30) as $party)
              <option value="{{ $party->id }}" {{ $party->id==Input::old('party_id') ? 'selected' : '' }}>{{ $party->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>   
      </div>
    </div>  
  </div>
                    
  <!-- Vote History Tab-->
  <div class="tab-pane" id="vote_history">
    <div class="row-fluid">
      @foreach(Cache::remember('ElectiontypeList', function() {return Electiontype::where_in('id', array(1, 3, 4))->get();}, 30) as $electiontype)
      <div class="span4">
        <div class="box corner-all">
          <div class="box-header grd-white color-silver-dark corner-top">
              <div class="header-control">
                  <a href="#" id="btn-clear-election-{{ $electiontype->id }}" data-toggle="tooltip" data-original-title="Remove Selection"><i class="icofont-trash"></i></a>
              </div>
              <span><i class="icofont-flag"></i> {{ $electiontype->name }}</span>
          </div>
          <div class="box-body">
            <div class="control-group">  
              <div class="controls">
                <label class="radio">
                    <input type="radio" name="election_history_{{ $electiontype->id }}" value="1" {{ Input::old('election_history_'.$electiontype->id)==1 ? 'checked' : '' }}> Has voted
                </label>
                <label class="radio">
                    <input type="radio" name="election_history_{{ $electiontype->id }}" value="2" {{ Input::old('election_history_'.$electiontype->id)==2 ? 'checked' : '' }}> Has not voted
                </label>
                <label class="radio inline">
                    <input type="radio" name="election_history_{{ $electiontype->id }}" value="3" {{ Input::old('election_history_'.$electiontype->id)==3 ? 'checked' : '' }}> Has voted at least 
                </label>
                <input type="text" id="at_least_{{ $electiontype->id }}" name="at_least_{{ $electiontype->id }}" class="span2">
              </div>
            </div>
            <h6>Select Year (Blank means all):</h6> 
            @foreach($electiontype->votehistory()->distinct()->order_by('year', 'desc')->take(5)->get('year') as $votehistory)
            <div class="control-group">  
              <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" name="year_{{ $electiontype->id }}[]" value="{{ $votehistory->year }}" {{ in_array($votehistory->year, (array) Input::old('year_'.$electiontype->id)) ? 'checked' : '' }}> {{ $votehistory->year }}
                </label>
              </div>
            </div>
            @endforeach
          </div> 
        </div>  
      </div>
      @endforeach
    </div>  
  </div>


  <!-- others -->
  <div class="tab-pane" id="voter_other_filter">
    <div class="row-fluid">      
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="random_number">Random Number</label>
          <div class="controls">
            <input class="span12" id="random_number" name="random_number" type="number" value="{{ Input::old('random_number') }}">
          </div>
        </div>
      </div>
      <div class="span3">
        <div class="control-group">
          <label class="control-label" for="timezone_id">Timezone</label>
          <div class="controls">
            <select class="span12" id="timezone_id" name="timezone_id[]" rel="select2" multiple>
              @foreach(Cache::remember('TimezoneList', function() {return Timezone::all();}, 60) as $timezone)
              <option value="{{ $timezone->id }}" {{ in_array($timezone->id, is_array(Input::old('timezone_id')) ? Input::old('timezone_id') : array() ) ? 'selected' : '' }}>{{ $timezone->name }}</option>                      
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="st_up_hous">Set up house</label>
          <div class="controls">
            <input class="span12" id="st_up_hous" name="st_up_hous" type="text" value="{{ Input::old('st_up_hous') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="st_lo_hous">Set lo house</label>
          <div class="controls">
            <input class="span12" id="st_lo_hous" name="st_lo_hous" type="text" value="{{ Input::old('st_lo_hous') }}">
          </div>
        </div>
      </div>  
    </div>     
    <hr>
    <div class="row-fluid">     
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="cong_dist">Cong Dist.</label>
          <div class="controls">
            <input class="span12" id="cong_dist" name="cong_dist" type="text" value="{{ Input::old('cong_dist') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="schl_dist">Schl dist</label>
          <div class="controls">
            <input class="span12" id="schl_dist" name="schl_dist" type="text" value="{{ Input::old('schl_dist') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="ward">Ward</label>
          <div class="controls">
            <input class="span12" id="ward" name="ward" type="text" value="{{ Input::old('ward') }}">
          </div> 
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="is_voluntary">Is Voluntary</label>
          <div class="controls">
            <input class="span12" id="is_voluntary" name="is_voluntary" type="text" maxlength= '1' value="{{ Input::old('is_voluntary') }}">
          </div> 
        </div>
      </div>
    </div>
    <div class="row-fluid">     
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="mine">Mine</label>
          <div class="controls">
            <input class="span12" id="mine" name="mine" type="text" maxlength= '1' value="{{ Input::old('mine') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="prime1">prime 1</label>
          <div class="controls">
            <input class="span12" id="prime1" name="prime1" type="text" maxlength= '1' value="{{ Input::old('prime1') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="prime2">prime 2</label>
          <div class="controls">
            <input class="span12" id="prime2" name="prime2" type="text" maxlength= '1' value="{{ Input::old('prime2') }}">
          </div>
        </div>
      </div>
      <div class="span2">
        <div class="control-group">
          <label class="control-label" for="prime3">prime 3</label>
          <div class="controls">
            <input class="span12" id="prime3" name="prime3" type="text" maxlength= '1' value="{{ Input::old('prime3') }}">
          </div>
        </div>
      </div>
      <div class="span4">
        <div class="control-group">
          <label class="control-label" for="created_at">Created Date</label>
          <div class="controls">
            <div id="created_at" name="created_at" class="input-append date span12" rel="datepicker">
              <input id="created_at" name="created_at" data-format="yyyy-MM-dd" type="text" class="span10" value="{{ Input::old('created_at') }}"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>  
  <!-- end other -->  



</div>

<script type="text/javascript">
  $(document).ready(function() {

    @if(Input::had('assemblydistrict_id'))
      loadPollsiteOptions("{{ Input::old('assemblydistrict_id') }}", "{{ Input::old('pollsite_id', 0) }}");

      @if(Input::had('pollsite_id'))
        loadElectionDistrictOptions("{{ Input::old('assemblydistrict_id') }}", "{{ Input::old('pollsite_id', 0) }}", "{{ Input::old('electiondistrict_id', 0) }}");
      @endif
    @endif  

    $("#assemblydistrict_id").change(function() {
        var assemblydistrict_id = $("#assemblydistrict_id").select2("val");
        if(assemblydistrict_id>0) {

          $("#sel_pollsite_id").select2("val", '');
          $("#pollsite_id").val("");
          $("#sel_pollsite_id").select2({'placeholder': '<i class="icofont-spinner icofont-spin"></i> Loading...'});

          $("#sel_electiondistrict_id").select2("val", '');
          $("#electiondistrict_id").val("");
          $("#sel_electiondistrict_id").select2("disable");

          loadPollsiteOptions(assemblydistrict_id, 0);

        } else {
          $("#sel_pollsite_id").select2("val", '');
          $("#pollsite_id").val("");
          $("#sel_pollsite_id").select2("disable");

          $("#sel_electiondistrict_id").select2("val", '');
          $("#electiondistrict_id").val("");
          $("#sel_electiondistrict_id").select2("disable");
        }
    });

    $("#sel_pollsite_id").change(function() {
        var pollsite_id = $("#sel_pollsite_id").select2("val");
        $("#pollsite_id").val(pollsite_id);

        if(pollsite_id>0) {
          var assemblydistrict_id = $("#assemblydistrict_id").select2("val");
          
          $("#sel_electiondistrict_id").select2("val", '');
          $("#electiondistrict_id").val("");
          $("#sel_electiondistrict_id").select2({'placeholder': '<i class="icofont-spinner icofont-spin"></i> Loading...'});

          loadElectionDistrictOptions(assemblydistrict_id, pollsite_id, 0);

        } else {
          $("#sel_electiondistrict_id").select2("val", '');
          $("#electiondistrict_id").val("");
          $("#sel_electiondistrict_id").select2("disable");
        }
    });

    $("#sel_electiondistrict_id").change(function() {
      var electiondistrict_id = $("#sel_electiondistrict_id").select2("val");
      $("#electiondistrict_id").val(electiondistrict_id);
    });

    
    /*
     * Voter Filter Form - Clear election 
     */
    $("a[id*='btn-clear-election-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var electiontype_id    = id_split[3];
      
      
      $('input[name*="election_history_' + electiontype_id + '"]:checked').each(function(){
          $(this).prop('checked', false);  
      });
      
      $("input[name*='year_" + electiontype_id + "']").prop('checked', false);
      
      return false;
    });
    
    /*
     * Voter Filter Form - Clear all fields
     */
    $("#btn-advance-search-clear").click(function(event){
      event.preventDefault();
      
      $("#title").select2("val", "");
      $("#firstname").val("");
      $("#middle_ini").val("");
      $("#lastname").val("");
      $("#surn_suffix").select2("val", "");
      $("#gender").select2("val", "");
      $("input[id*='birthdate']").val("");
      $("input[id*='age']").val("");
      $("#religion_id").select2("val", "");
      $("#phonesource_id").select2("val", "");
      $("#phone_number").val("");
      $("#phone_code").val("");
      $("#language_id").select2("val", "");
      
      $("#occupation_id").select2("val", "");
      $("#timezone_id").select2("val", "");
      $("#latitude").val("");
      $("#longitude").val("");
      $("#apt_name").val("");
      $("#home_sequence").val("");
      $("#educationlevel_id").select2("val", "");
      $("#incomelevel_id").select2("val", "");
      $("#education_id").select2("val", "");

      $("#ethnicity_id").select2("val", "");
      $("#ethnicgroup_id").select2("val", "");
      $("#ethniccode_id").select2("val", "");
      $("#homeownerindicator_id").select2("val", "");
      $("#homemarketvalue_id").select2("val", "");
      $("#homeowner_id").select2("val", "");
      $("#maritalstatus_id").select2("val", "");
      $("#country_id").select2("val", "");
      $("#st_up_hous").val("");
      $("#st_lo_hous").val("");
      $("#random_number").val("");
      $("#cong_dist").val("");
      $("#schl_dist").val("");
      $("#ward").val("");
      $("#is_voluntary").val("");
      $("#mine").val("");
      $("#prime1").val("");
      $("#prime2").val("");
      $("#prime3").val(""); 

      
      $("#addresstype_id").select2("val", "");
      $("#house_number").val("");
      $("#pre_direction").select2("val", "");
      $("#street_name").val("");
      $("#post_direction").select2("val", "");
      $("#street_suffix").select2("val", "");
      $("#apt_number").val("");
      $("#city").val("");
      $("#state").val("");
      $("#zip").val("");
      $("#zip4").val("");
      $("#mail_address").val("");
      $("#mail_city").val("");
      $("#mail_state").val("");
      $("#mail_zip").val("");
      $("#mail_zip4").val("");
      $("input[id*='created_at']").val("");
      
      $("#householdincomelevel_id").select2("val", "");
      $("#persons_household").val("");
      $("#havechild").select2("val", "");
      $("#household_veteran").select2("val", ""); 
      
      $("input[id*='registration_date']").val("");
      $("input[id*='registration_date_from']").val("");
      $("input[id*='registration_date_to']").val("");

      $("input[id*='congress_district']").val("");
      $("input[id*='senate_district']").val("");
      $("input[id*='council_district']").val("");
      $("input[id*='civil_court_district']").val("");      

      $("#assemblydistrict_id").select2("val", "");
      $("#sel_pollsite_id").select2("val", "");
      $("#pollsite_id").val("");
      $("#sel_electiondistrict_id").select2("val", "");
      $("#electiondistrict_id").val("");

      $("#status_id").select2("val", "");
      $("#party_id").select2("val", "");
      
      @foreach(Electiontype::where_in('id', array(1, 3, 4))->get() as $electiontype)
      $('input[name*="election_history_{{ $electiontype->id }}"]:checked').each(function(){
          $(this).prop('checked', false);  
      });
      
      $("#at_least_{{ $electiontype->id }}").val("");
      
      $("input[name*='year_{{ $electiontype->id }}']").prop('checked', false);
      @endforeach
      
      return false;
    });   
  });


function loadPollsiteOptions(assemblydistrict_id, selected_pollsite_id) {
  $.get("{{ URL::to_action('account@pollsites') }}/" + assemblydistrict_id, null, function (result) {

    //$("#pollsite_id").select2("data", result);
    $('#sel_pollsite_id').html('<option></option>');
    $.each(result,function(index,value){
      var selected = '';
      if(selected_pollsite_id == result[index].id) { 
        selected = 'selected';
      }
      $('#sel_pollsite_id').append('<option value="' + result[index].id+ '" ' + selected + '>'+result[index].text+'</option>');
    });
    
    $("#sel_pollsite_id").select2({
      placeholder: '',
      allowClear: true,
      minimumResultsForSearch: 10,
    });
    
    $("#sel_pollsite_id").select2("enable");

  }, 'json').error(function(data) {
    alert(data.responseText);
  });
}


function loadElectionDistrictOptions(assemblydistrict_id, pollsite_id, selected_electiondistrict_id) {
  $.get("{{ URL::to_action('account@electiondistricts') }}/" + assemblydistrict_id + '/' + pollsite_id, null, function (result) {

    //$("#pollsite_id").select2("data", result);
    $('#sel_electiondistrict_id').html('<option></option>');
    $.each(result,function(index,value){
      var selected = '';
      if(selected_electiondistrict_id == result[index].id) { 
        selected = 'selected';
      }
      $('#sel_electiondistrict_id').append('<option value="' + result[index].id+ '" '+selected+'>'+result[index].number+'</option>');
    });
    
    $("#sel_electiondistrict_id").select2({
      placeholder: '',
      allowClear: true,
      minimumResultsForSearch: 10,
    });
    

    $("#sel_electiondistrict_id").select2("enable");

  }, 'json').error(function(data) {
    alert(data.responseText);
  });
}

</script>