
<div class="row-fluid">
  <div class="span12">

    <fieldset>
      <!-- start select box container -->
      <h3><i class="icofont-columns"></i> Select column to add filter</h3>
      
      <div class="control-group span3 pull-left">
  
        <select id="filter-select" class="" name="filtercolumns" size="30" style="height: 300px;">
          @foreach($columns as $actual => $column) 
            <?php if (isset($data->filters['Filter']) && isset($data->filters['Filter'][$actual])) { ?>
              <option data-type="{{ $column['datatype'] }}" value="{{ $actual }}" disabled>{{ $column['display'] }} </option>
            <?php } else { ?>
              <option data-type="{{ $column['datatype'] }}" value="{{ $actual }}">{{ $column['display'] }}</option>
            <?php } ?>
          @endforeach
         
        </select>

      </div>
      <div id="set-filter" class="control-group span3" 
      style="height:300px;margin-right: 0px;border:1px solid silver;padding:2px;overflow:auto">

        <?php
        if (!empty($data->filters['Filter'])) :     

          foreach($data->filters['Filter'] as $key => $field) {
         
            if (!empty($key)) { ?>

              <div style="margin:0 0 2px" data-holder="<?php echo $key; ?>" class="text-info breadcrumb <?php echo $key; ?>">
                <strong><?php echo $columns[$key]['display'] ?></strong>
                <button aria-hidden="true" class="close" type="button">×</button>
              </div>  
              <?php              
            }
          }
        endif;    
        ?>     
          <!-- here we show the selected field -->
      </div>
      <!-- end select box container -->

      <!-- add filter bucket -->
      <?php $bocketShowHide = !empty($data->filters['Filter']) ? 'hide' : 'hide'; ?>
      <div id="provide-filter" class="span5 well form-horizontal <?php echo $bocketShowHide ?>">
        <div style="margin-left:-100px">
          <div class="control-group">
            <label class="control-label" for="">Column</label>
            <div class="controls">
              <input type="text" class="condition-get" name="" data-content="" value="" disabled />
            </div>
          </div> 
          <div class="control-group">
            <label class="control-label" for="">Match</label>
            <div class="controls">
              <select id="filter-match-type" class="" name="match-type">
                @foreach($matchType as $actual => $value)                      
                  <option value="{{ $actual }}">{{ $value }}</option>                    
                @endforeach
              </select>
            </div>
          </div>
          <div class="control-group" id="set-fill">
            <label class="control-label" for="">Filter by</label>
            <div class="controls">
              <input type="text" class="condition-fill" name="" place-holder="Please provide inputs" />
              <select class="hide" id="county_id" name="country" >
                @foreach(Cache::remember('CountryList', function() {return Country::all();}, 60) as $country)
                <option value="{{ $country->id }}" {{ in_array($country->id, is_array(Input::old('country_id')) ? Input::old('country_id') : array() ) ? 'selected' : '' }}>{{ $country->name }}</option>                      
                @endforeach
              </select>
              <select class="hide" id="state" name="state" >               
                @foreach(Cache::remember('StateList', function() {return State::all();}, 60) as $state)
                <option value="{{ $state->id }}" {{ in_array($state->id, is_array(Input::old('state_id')) ? Input::old('state_id') : array() ) ? 'selected' : '' }}>{{ $state->name }}</option>                      
                @endforeach              
              </select>
              <select class="hide" id="city" name="city" >               
                @foreach(Cache::remember('CityList', function() {return City::all();}, 60) as $city)
                <option value="{{ $city->id }}" {{ in_array($city->id, is_array(Input::old('city_id')) ? Input::old('city_id') : array() ) ? 'selected' : '' }}>{{ $city->name }}</option>                      
                @endforeach              
              </select>             
              <select class="hide" id="ethnicity_id" name="ethnicity_id" placeholder="Ethnicity">
                @foreach(Cache::remember('EthnicityList', function() {return Ethnicity::all();}, 60) as $ethnicity)
                <option value="{{ $ethnicity->id }}" {{ in_array($ethnicity->id, is_array(Input::old('ethnicity_id')) ? Input::old('ethnicity_id') : array() ) ? 'selected' : '' }}>{{ $ethnicity->name }}</option>                      
                @endforeach
              </select>
              <select class="hide" id="ethnicgroup_id" name="ethnicgroup_id" placeholder="Ethnicity Group">
                @foreach(Cache::remember('EthnicgroupList', function() {return Ethnicgroup::all();}, 60) as $ethnicgroup)
                <option value="{{ $ethnicgroup->id }}" {{ in_array($ethnicgroup->id, is_array(Input::old('ethnicgroup_id')) ? Input::old('ethnicgroup_id') : array() ) ? 'selected' : '' }}>{{ $ethnicgroup->name }}</option>                      
                @endforeach
              </select>
              <select class="hide" id="sex" name="sex" >               
                <option value="M">Male</option>
                <option value="F">Female</option>                
              </select>
            </div>
          </div>
          <div class="control-group hide" id="addMoreStrainer">
            <label class="control-label" for="">Add more</label>
            <div class="controls">
              <select id="next-filter-append" class="" name="match-type">                      
                <option value="AND">{{ 'Next filter with AND' }}</option>
                <option value="OR">{{ 'Next filter with OR' }}</option>
              </select>                  
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <?php
              $counter = 1;  
              if (!empty($data->filters['Filter'])) :                    
                foreach($data->filters['Filter'] as $field) {
                  if (is_array($field)) {
                    foreach($field as $rule) { 
                      $counter++;
                    }
                  }
                }
              endif; 
              ?>
              <a class="btn" counter="<?php echo $counter; ?>" id="add-filter-job" href="javascript:;">Add to strainer</a>
              &nbsp;&nbsp;&nbsp;                 
              <a class="addMultiple hide btn btn-primary" id="done-filter-job" selected-column="" title="click to move for next column filter" href="javascript:;">Done</a>
              <div class="control-group">
                <a class="btn-link addMultiple hide" id="add-more-filter-job" href="javascript:;">Click here to add more filter for this field</a>
              </div>
            </div>
          </div>
        </div>          
      </div>
      <!-- end filter bucket -->      

    </fieldset>
  </div>

  <!-- make preview of filter -->
  <div class="span11 put-filter-env">
    <div class="control-group">
      <div id="production">
        <input type="hidden" class="initial hide" name=data[Filter][] value="" />
        <?php
        if (!empty($data->filters['Filter'])) :   
          $clauseId = 0;      
          foreach($data->filters['Filter'] as $field) {
            if (is_array($field)) {
              foreach($field as $rule) { 
                $clauseId++;        
                ?>
                  <input class="<?php echo $rule['from']; ?> clauseId-<?php echo $clauseId; ?>" type="hidden" 
                  value="<?php echo $rule['merge']; ?>" name="data[Filter][<?php echo $rule['from']; ?>][<?php echo $clauseId; ?>][merge]">
                  <input class="<?php echo $rule['from']; ?> clauseId-<?php echo $clauseId; ?>" type="hidden" 
                  value="<?php echo $rule['from']; ?>" name="data[Filter][<?php echo $rule['from']; ?>][<?php echo $clauseId; ?>][from]">
                  <input class="<?php echo $rule['from']; ?> clauseId-<?php echo $clauseId; ?>" type="hidden" 
                  value="<?php echo $rule['match']; ?>" name="data[Filter][<?php echo $rule['from']; ?>][<?php echo $clauseId; ?>][match]">
                  <input class="<?php echo $rule['from']; ?> clauseId-<?php echo $clauseId; ?>" type="hidden" 
                  value="<?php echo $rule['when']; ?>" name="data[Filter][<?php echo $rule['from']; ?>][<?php echo $clauseId; ?>][when]">
                <?php
              }
            }
          }
        endif;    
        ?>      

      </div>         
      <div id="development" class="text-info bold" style="padding:2px;border: 1px solid silver;min-height:60px;">
        <?php
        if (!empty($data->filters['Filter'])) :   
          $clauseId = 0;      
          foreach($data->filters['Filter'] as $field) {
            if (is_array($field)) {
              foreach($field as $rule) { 
                $clauseId++;
                ?>
                <span style="margin:1px" class="label <?php echo $rule['from']; ?>">
                  <?php echo '<span class="prepend"> '.$rule['merge'].' </span>'.' '.$columns[$rule['from']]['display'].' '.$matchType[$rule['match']].' '. $rule['when']; ?>                 
                  <button type="button" class="close" aria-hidden="true" style="margin-top:-22px" clauseid="<?php echo $clauseId; ?>" selected-column="<?php echo $rule['from']; ?>">×</button>
                </span>
                <?php
              }
            }
          }
        endif;    
        ?>        
      </div>
    </div>
  </div>
 
  <!--<a href="#sorttab" id="tab-name" class="btn">Save</a>
  <a class="btn hide" id="tab-name-edit" href="javascript:;">Edit</a>-->
</div>
 
<div class="modal-footer">
  <a href="#sorttab" id="tab-filter" class="btn btn-large btn-info">Next</a>   
</div> 