<?php

$return =  array(

	/*
	|--------------------------------------------------------------------------
	| Columns Configuration for voter table
	|--------------------------------------------------------------------------
	|
	| Here you simply specify the column name, display name and the filter 
  | that will be applied to the model in case we want to filter by this column. 
  | The display name is the header text in a table. Here's the description of 
  | each array element:
  |  
	| selectable: This this column will be shown in the "select column" dialog
  | relationship: the name of the relation ship that needs to be earger loaded. 
  | display: value to be displayed to identify this column (table header, etc.)
  | description: column description - brief description.
  | getValue: method that return this values from the model. Usefull when the column is retreive from relation model.
  | filter: function that will apply the filter over the column.
  | 
	*/

	'columns' => array(

    'quick_search' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model){ return null; },
            'filter'      => function(&$query, $input=array()) {
                                $criteria = $input['quick_search'];
                                // Create a nested que for this condition.
                                $query = $query->where(function($query) use($criteria){
                                   //$quick_search =  $criteria;
                                   $query->where('voter_id', 'like', "%{$criteria}%");
                                   $query->or_where(DB::raw("CONCAT(lastname, ', ', firstname, ' ', middle_ini)"), 'like', "%{$criteria}%");
                                });
                              },
    ),
    /*
     * Voter's Photo Columns
     */     
    'photo' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Photo",
            'description' => "User's thumb mini photo",
            'getValue'    => function($model, $clickable=false){ 
                                //if($clickable) {
                                  return '<img src="'.$model->photo_thumb_mini_url.'">';
                                //} 
                                //else { 
                                //  return $model->id; 
                                //}
                             },
            'filter'      => function($query, $input=array()) {
                                $id = $input['id'];
                                $query->where('id', '=', $id);
                             },
    ),
    /*
     * System ID      
     */     
    'id'           => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "System Id",
            'description' => "voter's system ID - Internal System ID",
            'getValue'    => function($model, $clickable=false){ return $model->id; },
            'filter'      => function(&$query, $input=array()) {
                                $id = $input['id'];
                                
                                if(is_array($id)) {
                                   $query = $query->where_in('id', $id); 
                                } else {
                                   $query = $query->where('id', '=', $id);
                                }
                              },
    ),
    /*
     * Voter ID      
     */     
    'voter_id'           => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Voter Id",
            'description' => "voter identification number assigned by county or the state.",
            'getValue'    => function($model, $clickable=false){
                                $voter_id = $model->voter_id;
                                // Show the text hilghlighted when quick search
                                if(Input::has('quick_search')) {
                                  $voter_id = Text::highlight($voter_id, Input::get('quick_search'));
                                }
                                if($clickable) {
                                   return '<a id="btn-quick-view-'.$model->id.'" href="#" class="lnk">'.$voter_id.'</a>';  
                                } 
                                else { 
                                  return $voter_id; 
                                }  
                             },
            'filter'      => function(&$query, $input=array()) {
                                $id = $input['voter_id'];
                                $query = $query->where('voter_id', '=', $id);
                              },
    ),
    /*
     * Full Name
     */     
    'fullname' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Full Name",
            'description' => "voter's full name. Format: lastname, firstname middle_initial",
            'getValue'    => function($model, $clickable=false) { 
                                //return ($model->lastname.', '.$model->firstname.' '.$model->middle_ini); 
                                $name = $model->fullname;
                                // Show the text hilghlighted when quick search
                                if(Input::has('quick_search')) {
                                  $name = Text::highlight($name, Input::get('quick_search'));
                                }
                                return $name; 
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $fullname = $input['fullname'];
                              $query = $query->where(DB::raw("CONCAT(lastname, ', ', firstname, ' ', middle_ini)"), '=', $fullname);

                            },   
    ),
    /*
     * Title Column. The title filter does not support like search because this
     * field contains "specific" values: Mr, Ms, Dr, Etc.     
     */     
    'title' => array(  
          'selectable'  => true,
          'relationship' => null,
          'display'     => "Title",
          'description' => "voter's title (Mr. Mrs. Dr. etc.)",
          'getValue'    => function($model, $clickable=false){ return $model->title; },
          'filter'      => function(&$query, $input=array()) {
                             $title = $input['title'];  
                             if(is_array($title)) {
                               $query = $query->where_in('title', $title); 
                             } else {
                               $query = $query->where('title', '=', $title);
                             }
                           },
    ),
    /*
     * First Name Column.      
     */     
    'firstname' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "First Name",
            'description' => "voter's First Name",
            'getValue'    => function($model, $clickable=false){ return $model->firstname; },
            'filter'      => function(&$query, $input=array()) {
                              $firstname = $input['firstname'];
                              $query = $query->where('firstname', 'like', "%{$firstname}%");
                            },
    ),
    /*
     * Middle Initial Column. This is a 1 character field.      
     */     
    'middle_ini' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Middle Initial",  
            'description' => "single Character voter's middle initial",
            'getValue'    => function($model, $clickable=false){ return $model->middle_ini; },
            'filter'      => function(&$query, $input=array()) {
                                $middle_initial = $input['middle_ini'];
                                $query = $query->where('middle_ini', '=', $middle_initial);
                              },
    ),
    /*
     * First Name Column.      
     */     
    'lastname' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Last Name",
            'description' => "voter's Last Name",
            'getValue'    => function($model, $clickable=false){ return $model->lastname; },
            'filter'      => function(&$query, $input=array()) {
                               $lastname = $input['lastname'];
                               $query = $query->where('lastname', 'like', "%{$lastname}%");
                             },
    ),
    /*
     * Surname Suffix Column.      
     */     
    'surn_suff' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Surname Suffix",
            'description' => "voter's surname (Jr. Sr. etc...)",
            'getValue'    => function($model, $clickable=false){ return $model->surn_suff; },
            'filter'      => function(&$query, $input=array()) {
                                $surn_suffix = $input['surn_suff'];  
                                if(is_array($surn_suffix)) {
                                  $query = $query->where_in('surn_suff', $surn_suffix); 
                                } else {
                                  $query = $query->where('surn_suff', '=', $surn_suffix);
                                }
                              },
    ),
    
    /*
     * My Voters Indicator.
     */     
    'mine' => array(
            'selectable'  => true,  
            'display'     => "Mine",
            'relationship' => null,
            'description' => "my-voters indicator. Posible Value: Y and N/BLANK",
            'getValue'    => function($model, $clickable=false) { 
                               return $model->mine=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             },
            'filter'      => function(&$query, $input=array()) {
                                $query = $query->where_mine('Y');
                              },
    ),
    /*
     * Ethniticy    
     */     
    'ethnicity_id' => array(
            'selectable'  => true,  
            'relationship' => "ethnicity",
            'display'     => "Ethniticy",
            'description' => "country of origin",
            'getValue'    => function($model, $clickable=false){ return $model->ethnicity ? $model->ethnicity->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ethnicity_id = $input['ethnicity_id'];  
                              if(is_array($ethnicity_id)) {
                                $query = $query->where_in('ethnicity_id', $ethnicity_id); 
                              } else {
                                $query = $query->where('ethnicity_id', '=', $ethnicity_id);
                              }
                            },
    ),
    /*
     * Ethniticy Group    
     */     
    'ethnicgroup_id' => array(
            'selectable'  => true,  
            'relationship' => "ethnicgroup",
            'display'     => "Ethniticy Group",
            'description' => "grouping of ethnicities",
            'getValue'    => function($model, $clickable=false){ return $model->ethnicgroup ? $model->ethnicgroup->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ethnicgroup_id = $input['ethnicgroup_id']; 

                              if(is_array($ethnicgroup_id)) {
                                $query = $query->where_in('ethnicgroup_id', $ethnicgroup_id); 
                              } else if($ethnicgroup_id==='0') {
                                 $query = $query->where_null('ethnicgroup_id'); 
                              } else {
                                $query = $query->where('ethnicgroup_id', '=', $ethnicgroup_id);
                              }
                            },   
    ),
    /*
     * Prime Voter   
     */     
    'prime' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering.... 
            'relationship' => null,
            'display'     => "Primes",
            'description' => "prime voters",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $prime = $input['prime'];
                              // Prime has to be a valid between 1 and 3  
                              if($prime>3) { $prime=0; }
                              if($prime>0) {
                                $query = $query->where('prime'.$prime, '=', 'Y');
                              } else { // If prime is 0, we will show all voters that have been marked as a prime 1, 2 or 3 
                                $query = $query->where(function($query){
                                   $query->where('prime1',  '=', 'Y');
                                   $query->or_where('prime2',  '=', 'Y');
                                   $query->or_where('prime3',  '=', 'Y');
                                });
                              }
                            },     
    ),
    /*
     * Prime Voter   
     */     
    'prime1' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Prime Voters",
            'description' => "has voted one time in the last 3 election",
            'getValue'    => function($model, $clickable=false) { 
                              return $model->prime1=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $query = $query->where_prime1('Y');
                            },     
    ),
    /*
     * Double Prime   
     */     
    'prime2' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Double Prime",
            'description' => "has voted two times in the last 3 election",
            'getValue'    => function($model, $clickable=false) { 
                              return $model->prime2=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $query = $query->where_prime2('Y');
                            },     
    ),
    /*
     * Triple Prime   
     */     
    'prime3' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Triple Prime",
            'description' => "has voted three times in the last 3 election",
            'getValue'    => function($model, $clickable=false) { 
                               return $model->prime3=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $query = $query->where_prime3('Y');
                            },     
    ),
    /*
     * Gender  
     */     
    'gender' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Gender",
            'description' => "M - Male, F - Female, Blank - Not provided and not a commonly gender-specific",
            'getValue'    => function($model, $clickable=false){ return $model->sex; }, 
            'filter'      => function(&$query, $input=array()) {
                              $gender = $input['gender'];
                              // gender has to be male or female. If not, we going to use male as a default gender
                              if($gender!='M' && $gender!='F') { $gender='M'; }
                              $query = $query->where_sex($gender);
                            },     
    ),
    /*
     * Birthdate  
     */     
    'birthdate' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Birthdate",
            'description' => "date of birth in YYYY-MM-DD format",
            'getValue'    => function($model, $clickable=false){
                               //$format="Y-m-d";
                               //$dob = strtotime($model->birthdate); 
                               //return date($format, $dob); 
                               return $model->dob;
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $birthdate = $input['birthdate'];
                              # Birth date format is XXXX-MONTH-DAY
                              $birthdate = str_replace('XXXX-', '', $birthdate);
                              //echo $birthdate;
                              $query = $query->raw_where("DATE_FORMAT(birthdate, '%m-%d') = ?", array($birthdate));
                              //$query = $query->where('birthdate', '=', $birthdate);
                            },     
    ),
    /*
     * Birthdate range  
     */     
    'birthdate_from' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $birthdate_from = $input['birthdate_from'];
                              $birthdate_to = $input['birthdate_to'];
                              if($birthdate_to!='') {
                                $query = $query->where_between('birthdate', $birthdate_from, $birthdate_to);
                              // If not end-range was specified, we will show all voters greater than the start-range age.
                              } else {
                                $query = $query->where('birthdate', '>=', $birthdate_from);
                              }
                            },     
    ),
    /*
     * Age  
     */     
    'age' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Age",
            'description' => "Age calculated from provided birthdate",
            'getValue'    => function($model, $clickable=false){ return $model->age; }, 
            'filter'      => function(&$query, $input=array()) {
                              $age = intval($input['age']);
                              $query = $query->where('age', '=', $age);
                            },     
    ),
    /*
     * Age Range  
     */     
    'age_from' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $age_from = intval($input['age_from']);
                              $age_to = intval($input['age_to']);
                              if($age_to>0) {
                                $query = $query->where_between('age', $age_from, $age_to);
                              // If not end-range was specified, we will show all voters greater than the start age range.
                              } else {
                                $query = $query->where('age', '>=', $age_from);
                              }
                            },     
    ),
    /*
     * Religion   
     */     
    'religion_id' => array(
            'selectable'  => true,  
            'relationship' => "religion",
            'display'     => "Religion",
            'description' => "religion",
            'getValue'    => function($model, $clickable=false){ return $model->religion ? $model->religion->name : ''; }, 
            'filter'      => function(&$query, $input=array()) {
                              $religion_id = $input['religion_id'];  
                              if(is_array($religion_id)) {
                                $query = $query->where_in('religion_id', $religion_id); 
                              } else {
                                $query = $query->where('religion_id', '=', $religion_id);
                              }
                            },   
    ),
    
    /*
     * Phone Source   
     */     
    'phonesource_id' => array(
            'selectable'  => true,  
            'relationship' => "phonesource",
            'display'     => "Phone Source",
            'description' => "source of telephone number",
            'getValue'    => function($model, $clickable=false) { 
                               return $model->phonesource ? $model->phonesource->name : null;
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $phonesource_id = $input['phonesource_id'];  
                              if(is_array($phonesource_id)) {
                                $query = $query->where_in('phonesource_id', $phonesource_id); 
                              } else {
                                $query = $query->where('phonesource_id', '=', $phonesource_id);
                              }
                            },   
    ),
    /*
     * Cel Phone Number   
     */     
    'phone_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Cel Phone",
            'description' => "Cel Phone Number",
            'getValue'    => function($model, $clickable=false){ return $model->phone_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $phone_number = $input['phone_number'];
                              $query = $query->where('phone_number', '=', $phone_number);
                            },   
    ),
    /*
     * Home Phone Number   
     */     
    'home_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Home Phone",
            'description' => "Home Phone Number",
            'getValue'    => function($model, $clickable=false){ return $model->home_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $home_number = $input['home_number'];
                              $query = $query->where('home_number', '=', $home_number);
                            },   
    ),
    /*
     * Work Phone Number   
     */     
    'work_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Work Number",
            'description' => "Work Phone Number",
            'getValue'    => function($model, $clickable=false){ return $model->work_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $work_number = $input['work_number'];
                              $query = $query->where('work_number', '=', $work_number);
                            },   
    ),
    /*
     * Federal Do Not Call List 
     */     
    'dnc' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => '<abbr title="Federal Do Not Call List">DNC</abbr>',
            'description' => "Federal Do Not Call Flag",
            'getValue'    => function($model, $clickable=false){ return $model->dnc=='Y' ? 'Yes' : 'No' ; }, 
            'filter'      => function(&$query, $input=array()) {
                              $dnc = $input['dnc'];
                              $query = $query->where('dnc', '=', $dnc);
                            },   
    ),

    /*
     * Ocupation  
     */     
    'occupation_id' => array(
            'selectable'  => true,  
            'relationship' => "occupation",
            'display'     => "Occupation",
            'description' => "indicates the detailed occupation of the individual",
            'getValue'    => function($model, $clickable=false){ return $model->occupation ? $model->occupation->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $occupation_id = $input['occupation_id'];  
                              if(is_array($occupation_id)) {
                                $query = $query->where_in('occupation_id', $occupation_id); 
                              } else {
                                $query = $query->where('occupation_id', '=', $occupation_id);
                              }
                            },   
    ),
    
    /*
     * Pollsite Column. This columns is a foreign key to the pollsites table.  
     * You can filter by one pollsite or by more than one.
     */     
    'pollsite_id' => array(
            'selectable'   => true,  
            'relationship' => "pollsite",
            'display'      => "Pollsite",
            'description'  => "Voter's poll site.",
            'getValue'     => function($model, $clickable=false){ return $model->pollsite ? $model->pollsite->name: ''; }, 
            'filter'       => function(&$query, $input=array()) {
                              $pollsite_id = $input['pollsite_id'];
                              if(is_array($pollsite_id)) {
                                $query = $query->where_in('pollsite_id', $pollsite_id); 
                              } else {
                                $query = $query->where('pollsite_id', '=', $pollsite_id);
                              }
                           },   
    ),

    /*
     * Election district Column. This columns is a foreign key to the electiondistricts table.  
     * You can filter by one ED or by more than one.
     */     
    'electiondistrict_id' => array(
            'selectable'   => true,  
            'relationship' => "electiondistrict",
            'display'      => "ED",
            'description'  => "Voter's election districts.",
            'getValue'     => function($model, $clickable=false){ return $model->electiondistrict ? $model->electiondistrict->number: ''; }, 
            'filter'       => function(&$query, $input=array()) {
                              $electiondistrict_id = $input['electiondistrict_id'];
                              if(is_array($electiondistrict_id)) {
                                $query = $query->where_in('electiondistrict_id', $electiondistrict_id); 
                              } else {
                                $query = $query->where('electiondistrict_id', '=', $electiondistrict_id);
                              }
                            },   
    ),

    /*
     * Assembly district Column. This columns is a foreign key to the assemblydistricts table.  
     * Function that will be use to filter by ED. You can filter by one ED or by more than one.
     */     
    'assemblydistrict_id' => array(
            'selectable'   => true,  
            'relationship' => "assemblydistrict",
            'display'      => "Assembly",
            'description'  => "Voter's assembly district.",
            'getValue'     => function($model, $clickable=false){ return $model->assemblydistrict ? $model->assemblydistrict->number: ''; }, 
            'filter'       => function(&$query, $input=array()) {
                              $assemblydistrict_id = $input['assemblydistrict_id'];
                              if(is_array($assemblydistrict_id)) {
                                $query = $query->where_in('assemblydistrict_id', $assemblydistrict_id); 
                              } else {
                                $query = $query->where('assemblydistrict_id', '=', $assemblydistrict_id);
                              }
                            },   
    ),

    /*
     * congress district Column. 
     */     
    'congress_district' => array(
            'selectable'   => true,  
            'relationship' => null,
            'display'      => "Congress",
            'description'  => "Voter's congress district.",
            'getValue'     => function($model, $clickable=false){ return $model->congress_district; }, 
            'filter'       => function(&$query, $input=array()) {
                              $congress_district = $input['congress_district'];
                              if(is_array($congress_district)) {
                                $query = $query->where_in('congress_district', $congress_district); 
                              } else {
                                $query = $query->where('congress_district', '=', $congress_district);
                              }
                            },   
    ),

    /*
     * Council district Column. 
     */     
    'council_district' => array(
            'selectable'   => true,  
            'relationship' => null,
            'display'      => "Council",
            'description'  => "Voter's council district.",
            'getValue'     => function($model, $clickable=false){ return $model->council_district; }, 
            'filter'       => function(&$query, $input=array()) {
                              $council_district = $input['council_district'];
                              if(is_array($council_district)) {
                                $query = $query->where_in('council_district', $council_district); 
                              } else {
                                $query = $query->where('council_district', '=', $council_district);
                              }
                            },   
    ),
    
    /*
     * Senate district Column. 
     */     
    'senate_district' => array(
            'selectable'   => true,  
            'relationship' => null,
            'display'      => "Senate",
            'description'  => "Voter's senate district.",
            'getValue'     => function($model, $clickable=false){ return $model->senate_district; }, 
            'filter'       => function(&$query, $input=array()) {
                              $senate_district = $input['senate_district'];
                              if(is_array($senate_district)) {
                                $query = $query->where_in('senate_district', $senate_district); 
                              } else {
                                $query = $query->where('senate_district', '=', $senate_district);
                              }
                            },   
    ),
    
    /*
     * Civil Court District Column. 
     */     
    'civil_court_district' => array(
            'selectable'   => true,  
            'relationship' => null,
            'display'      => "Civil Court",
            'description'  => "Voter's civi court district.",
            'getValue'     => function($model, $clickable=false){ return $model->civil_court_district; }, 
            'filter'       => function(&$query, $input=array()) {
                              $civil_court_district = $input['civil_court_district'];
                              if(is_array($civil_court_district)) {
                                $query = $query->where_in('civil_court_district', $civil_court_district); 
                              } else {
                                $query = $query->where('civil_court_district', '=', $civil_court_district);
                              }
                            },   
    ),

    /*
     * Judicial District Column. 
     */     
    'judicial_district' => array(
            'selectable'   => true,  
            'relationship' => null,
            'display'      => "Judicial",
            'description'  => "Voter's Judicial district.",
            'getValue'     => function($model, $clickable=false){ return $model->judicial_district; }, 
            'filter'       => function(&$query, $input=array()) {
                              $judicial_district = $input['judicial_district'];
                              if(is_array($judicial_district)) {
                                $query = $query->where_in('judicial_district', $judicial_district); 
                              } else {
                                $query = $query->where('judicial_district', '=', $judicial_district);
                              }
                            },   
    ),

    
    /*
     * Precinct Name
     */    
     /* commented by mpeguero. we won't use the precinct number any more. 
      * We going to use electiondistrinct_id instead. 
    'precinct_name' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Precinct Name",
            'description' => "precinct name (ED name)",
            'getValue'    => function($model, $clickable=false){ return $model->precinct_name; }, 
            'filter'      => function($query, $input=array()) {
                              $precinct_name = $input['precinct_name'];
                              $query->where('precinct_name', '=', $precinct_name);
                            },   
    ), 
    */
    /*
     * Precinct Number
     */     
    /* commented by mpeguero. we won't use the precinct number any more. 
     * We going to use electiondistrinct_id instead. 
    'precinct_number' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Precinct Number",
            'description' => "precinct number (ED)",
            'getValue'    => function($model, $clickable=false){ return $model->precinct_number; }, 
            'filter'      => function($query, $input=array()) {
                              $precinct_number = $input['precinct_number'];
                              $query->where('precinct_number', '=', $precinct_number);
                            },   
    ),
    */
    /*
     * Address Type  
     */     
    'addresstype_id' => array(
            'selectable'  => true, 
            'relationship' => "addresstype", 
            'display'     => "Address Type",
            'description' => "address type",
            'getValue'    => function($model, $clickable=false){ return $model->addresstype? $model->addresstype->name: null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $addresstype_id = $input['addresstype_id'];  
                              if(is_array($addresstype_id)) {
                                $query = $query->where_in('addresstype_id', $addresstype_id); 
                              } else {
                                $query = $query->where('addresstype_id', '=', $addresstype_id);
                              }
                            },   
    ),

    /*
     * Address Status  
     */     
    'addressstatus_id' => array(
            'selectable'  => true, 
            'relationship' => "addressstatus", 
            'display'     => "Address Status",
            'description' => "address Status",
            'getValue'    => function($model, $clickable=false){ 
                              return $model->addressstatus? '<span style="color: '.$model->addressstatus->color.'">'.$model->addressstatus->name.'</span>' : null; 
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $addressstatus_id = $input['addressstatus_id'];  
                              if(is_array($addressstatus_id)) {
                                $query = $query->where_in('addressstatus_id', $addressstatus_id); 
                              } else {
                                $query = $query->where('addressstatus_id', '=', $addressstatus_id);
                              }
                            },   
    ),

    /*
     * Address  
     */     
    'address' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Address",
            'description' => "this is the resident address",
            'getValue'    => function($model, $clickable=false){ return $model->address; }, 
            'filter'      => function(&$query, $input=array()) {
                              $address = $input['address'];
                              $query = $query->where('address', 'like', "%{$address}%");
                            },   
    ),
    /*
     * House Number  
     */     
    'house_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "House Number",
            'description' => "home address number",
            'getValue'    => function($model, $clickable=false){ return $model->house_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $house_number = $input['house_number'];
                              $query = $query->where('house_number', 'like', "%{$house_number}%");
                            },   
    ),
    /*
     * Pre Direction  
     */     
    'pre_direction' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Pre Direccion",
            'description' => "address pre direction: North, South, East Or West",
            'getValue'    => function($model, $clickable=false){ return $model->pre_direction; }, 
            'filter'      => function(&$query, $input=array()) {
                              $pre_direction = $input['pre_direction'];
                              $query = $query->where('pre_direction', '=', $pre_direction);
                            },   
    ),
    
    /*
     * Street name  
     */     
    'street_name' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Street Name",
            'description' => "street address name",
            'getValue'    => function($model, $clickable=false){ return $model->pre_direction; }, 
            'filter'      => function(&$query, $input=array()) {
                              $street_name = $input['street_name'];
                              $query = $query->where('street_name', 'like', "%{$street_name}%");
                            },   
    ),
    /*
     * Post Direction  
     */     
    'post_direction' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Post Direccion",
            'description' => "address post direction: North, South, East Or West",
            'getValue'    => function($model, $clickable=false){ return $model->post_direction; }, 
            'filter'      => function(&$query, $input=array()) {
                              $post_direction = $input['post_direction'];
                              $query = $query->where('post_direction', '=', $post_direction);
                            },   
    ),
    /*
     * Street Suffix  
     */     
    'street_suffix' => array(
            'selectable'  => true,
            'relationship' => null,  
            'display'     => "Street Suffix",
            'description' => "street address suffix: Ave, St, etc",
            'getValue'    => function($model, $clickable=false){ return $model->street_suffix; }, 
            'filter'      => function(&$query, $input=array()) {
                              $street_suffix = $input['street_suffix'];
                              $query = $query->where('street_suffix', '=', $street_suffix);
                            },   
    ),
    /*
     * Apartment Number 
     */     
    'apt_number' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Apt",
            'description' => "apartment number",
            'getValue'    => function($model, $clickable=false){ return $model->apt_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $apt_number = $input['apt_number'];
                              $query = $query->where('apt_number', 'like', "%{$apt_number}%");
                            },   
    ),
    /*
     * city
     */     
    'city' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "City",
            'description' => "residence city",
            'getValue'    => function($model, $clickable=false){ return $model->city; }, 
            'filter'      => function(&$query, $input=array()) {
                              $city = $input['city'];
                              $query = $query->where('city', 'like', "%{$city}%");
                            },   
    ),
    /*
     * State
     */     
    'state' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "State",
            'description' => "residence state",
            'getValue'    => function($model, $clickable=false){ return $model->state; }, 
            'filter'      => function(&$query, $input=array()) {
                              $state = $input['state'];
                              $query = $query->where('state', 'like', "%{$state}%");
                            },   
    ),
    /*
     * Zipcode 5-digit
     */     
    'zip' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Zip",
            'description' => "residence zipcode",
            'getValue'    => function($model, $clickable=false){ return $model->zip; }, 
            'filter'      => function(&$query, $input=array()) {
                              $zip = $input['zip'];
                              $query = $query->where('zip', '=', $zip);
                            },   
    ),
    /*
     * Zipcode 4-digit
     */     
    'zip4' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Zip4",
            'description' => "residence zip+4",
            'getValue'    => function($model, $clickable=false){ return $model->zip4; }, 
            'filter'      => function(&$query, $input=array()) {
                              $zip4 = $input['zip4'];
                              $query = $query->where('zip4', '=', $zip4);
                            },   
    ),
    /*
     * Full Zipcode
     */     
    'zipcode' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Zipcode",
            'description' => "residence full zipcode format (zip5-zip4)",
            'getValue'    => function($model, $clickable=false){ return ($model->zip.'-'.$model->zip4); }, 
            'filter'      => function(&$query, $input=array()) {
                              $zipcode = $input['zipcode'];
                              $query = $query->where(DB::raw("CONCAT(zip, '-', zip4)"), '=', $zipcode);
                            },   
    ),
    /*
     * Mail Address
     */     
    'mail_address' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Mail Address",
            'description' => "this is the complete mail address",
            'getValue'    => function($model, $clickable=false){ return $model->mail_address; }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_address = $input['mail_address'];
                              $query = $query->where('mail_address', 'like', "%{$mail_address}%");
                            },   
    ),
    /*
     * Mail Address City
     */     
    'mail_city' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Mail City",
            'description' => "mail address city",
            'getValue'    => function($model, $clickable=false){ return $model->mail_city; }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_city = $input['mail_city'];
                              $query = $query->where('mail_city', 'like', "%{$mail_city}%");
                            },   
    ),
    /*
     * Mail Address State
     */     
    'mail_state' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Mail State",
            'description' => "mail address state",
            'getValue'    => function($model, $clickable=false){ return $model->mail_state; }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_state = $input['mail_state'];
                              $query = $query->where('mail_state', 'like', "%{$mail_state}%");
                            },   
    ),
    /*
     * Mail Zipcode 5-digit
     */     
    'mail_zip' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Mail Zip",
            'description' => "mail address zip code (5-digit)",
            'getValue'    => function($model, $clickable=false){ return $model->mail_zip; }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_zip = $input['mail_zip'];
                              $query = $query->where('mail_zip', '=', $mail_zip);
                            },   
    ),
    /*
     * Mail Zipcode 4-digit
     */     
    'mail_zip4' => array(
            'selectable'  => true,
            'relationship' => null,  
            'display'     => "Mail Zip4",
            'description' => "mail address zip code (4-digit)",
            'getValue'    => function($model, $clickable=false){ return $model->mail_zip4; }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_zip4 = $input['mail_zip4'];
                              $query = $query->where('mail_zip4', '=', $mail_zip4);
                            },   
    ),
    /*
     * Full Zipcode
     */     
    'mail_zipcode' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Mail Zipcode",
            'description' => "full mail zipcode format (zip5-zip4)",
            'getValue'    => function($model, $clickable=false){ return ($model->mail_zip.'-'.$model->mail_zip4); }, 
            'filter'      => function(&$query, $input=array()) {
                              $mail_zipcode = $input['mail_zipcode'];
                              $query = $query->where(DB::raw("CONCAT(mail_zip, '-', mail_zip4)"), '=', $mail_zipcode);
                            },   
    ),
    /*
     * Education Level
     */     
    'educationlevel_id' => array(
            'selectable'  => true, 
            'relationship' => "educationlevel", 
            'display'     => "Education Level",
            'description' => "education level",
            'getValue'    => function($model, $clickable=false){ return $model->educationlevel ? $model->educationlevel->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $educationlevel_id = $input['educationlevel_id'];  
                              if(is_array($educationlevel_id)) {
                                $query = $query->where_in('educationlevel_id', $educationlevel_id); 
                              } else {
                                $query = $query->where('educationlevel_id', '=', $educationlevel_id);
                              }
                            },   
    ),
    /*
     * Language
     */     
    'language_id' => array(
            'selectable'  => true,  
            'relationship' => "language",
            'display'     => "Language",
            'description' => "spoken language",
            'getValue'    => function($model, $clickable=false){ return $model->language ? $model->language->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $language_id = $input['language_id'];  
                              if(is_array($language_id)) {
                                $query = $query->where_in('language_id', $language_id); 
                              } else {
                                $query = $query->where('language_id', '=', $language_id);
                              }
                            },   
    ),
    /*
     * Income Level
     */     
    'incomelevel_id' => array(
            'selectable'  => true,  
            'relationship' => "incomelevel",
            'display'     => "Income Level",
            'description' => "income level",
            'getValue'    => function($model, $clickable=false){ return $model->incomelevel ? $model->incomelevel->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $incomelevel_id = $input['incomelevel_id'];  
                              if(is_array($incomelevel_id)) {
                                $query = $query->where_in('incomelevel_id', $incomelevel_id); 
                              } else {
                                $query = $query->where('incomelevel_id', '=', $incomelevel_id);
                              }
                            },   
    ),
    /*
     * Persons household
     */     
    'persons_household' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Persons Household",
            'description' => "number of people in the household",
            'getValue'    => function($model, $clickable=false){ return $model->persons_household; }, 
            'filter'      => function(&$query, $input=array()) {
                              $persons_household = $input['persons_household'];
                              $query = $query->where('persons_household', '=', $persons_household);
                            },   
    ),
    /*
     * Has child(ren)
     */     
    'havechild' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Has Child(ren)",
            'description' => "Indicates presence of children in household Valid Values; Y=Yes, N=No, <blank> = Unknown",
            'getValue'    => function($model, $clickable=false){ return $model->havechild; }, 
            'filter'      => function(&$query, $input=array()) {
                              $havechild = $input['havechild'];
                              $query = $query->where('havechild', '=', $havechild);
                            },   
    ),
    /*
     * Veteran Household
     */     
    'household_veteran' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Veteran Household",
            'description' => "Indicates that a veteran exists in the household. Y= Yes, 0= No, Blank = Unknown",
            'getValue'    => function($model, $clickable=false){ return $model->household_veteran; }, 
            'filter'      => function(&$query, $input=array()) {
                              $household_veteran = $input['household_veteran'];
                              $query = $query->where('household_veteran', '=', $household_veteran);
                            },   
    ),
    
    /*
     * Registration Date  
     */     
    'registration_date' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => '<abbr title="Registration Date">Reg. Date</abbr>',
            'description' => "registration date in YYYY-MM-DD format",
            'getValue'    => function($model, $clickable=false){
                               //$format="Y-m-d";
                               //$dob = strtotime($model->registration_date); 
                               //return date($format, $dob); 
                               return $model->reg_date;
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $registration_date = $input['registration_date'];
                              $query = $query->where('registration_date', '=', $registration_date);
                            },     
    ),
    /*
     * Registration Date range  
     */     
    'registration_date_from' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $registration_date_from = $input['registration_date_from'];
                              $registration_date_to = $input['registration_date_to'];
                              if($registration_date_to!='') {
                                $query = $query->where_between('registration_date', $registration_date_from, $registration_date_to);
                              // If not end-range was specified, we will show all voters greater than the start-range age.
                              } else {
                                $query = $query->where('registration_date', '>=', $registration_date_from);
                              }
                            },     
    ),
    /*
     * Pollsite Code
     */  
     /*   
    'pollsite_code' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $pollsite_code = $input['pollsite_code'];
                              $query = $query->raw_where(" exists (select 1 from pollsites p where voters.pollsite_id=p.id AND p.code='{$pollsite_code}')");
                            },   
    ),
    */
    /*
     * Precinct Number
     */     
    /*
    'precinct_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Precinct Number",
            'description' => "precinct number",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $precinct_number = $input['precinct_number'];
                              $query->where('registration_date', '=', $precinct_number);
                            },   
    ),
    */
    /*
     * Assembly District
     */ 
     /*    
    'st_lo_hous' => array(
            'selectable'  => true,
            'relationship' => null,  
            'display'     => "Assembly District",
            'description' => "assembly district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $st_lo_hous = $input['st_lo_hous'];
                              $query->where('st_lo_hous', '=', $st_lo_hous);
                            },   
    ),
    */
    /*
     * Senate District
     */     
    /*
    'st_up_hous' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Senate District",
            'description' => "senate district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $st_up_hous = $input['st_up_hous'];
                              $query = $query->where('st_up_hous', '=', $st_up_hous);
                            },   
    ),
    */
    /*
     * Congress District
     */     
    /*
    'cong_dist' => array(
            'selectable'  => true,
            'relationship' => null,  
            'display'     => "Congress District",
            'description' => "congress district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $cong_dist = $input['cong_dist'];
                              $query = $query->where('cong_dist', '=', $cong_dist);
                            },   
    ),
    */ 
    /*
     * School District
     */     
    /*
    'schl_dist' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "School District",
            'description' => "school district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $schl_dist = $input['schl_dist'];
                              $query = $query->where('schl_dist', '=', $schl_dist);
                            },   
    ),
    */ 
    /*
     * School District
     */
     /*     
    'ward' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Ward",
            'description' => "ward",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ward = $input['ward'];
                              $query = $query->where('ward', '=', $ward);
                            },   
    ),
    */
    /*
     * Status
     */     
    'status_id' => array(
            'selectable'  => true,  
            'relationship' => "status",
            'display'     => "Status",
            'description' => "voting status of the voter as identified by the state or county voter register",
            'getValue'    => function($model, $clickable=false){ return $model->status ? $model->status->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $status_id = $input['status_id'];  
                              if(is_array($status_id)) {
                                $query = $query->where_in('status_id', $status_id); 
                              } else {
                                $query = $query->where('status_id', '=', $status_id);
                              }
                            },   
    ),
    
    /*
     * Party
     */     
    'party_id' => array(
            'selectable'  => true,  
            'relationship' => "party",
            'display'     => "Party",
            'description' => "party affiliation",
            'getValue'    => function($model, $clickable=false){ return $model->party ? $model->party->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $party_id = $input['party_id'];  
                              if(is_array($party_id)) {
                                $query = $query->where_in('party_id', $party_id); 
                              } else {
                                $query = $query->where('party_id', '=', $party_id);
                              }
                            },   
    ),

    /*-------------------------------------------------------------------------------------
     * Phone banking columns.....
     */ 

    /*
     * Filter voters that belongs to a phone banking.
     */     
    'phonebanking_id' => array(
            'selectable'  => false,  
            'relationship' => "",
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $phonebanking_id = $input['phonebanking_id'];  
                              $phonebanking_result = $input['phonebanking_result'];  
                              $phonebanking_result_id = $input['phonebanking_result_id'];  
                              
                              $table_prefix='';
                              if(Auth::user()->account_id>1) {
                                $table_prefix = Auth::user()->account_id.'_voters';
                              }

                              if($phonebanking_result=='contacted') {
                                if($phonebanking_result_id>0) {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM phonebanking_voter pbv 
                                                                       WHERE pbv.phonebanking_id = ? 
                                                                         AND pbv.phonebankingcontactresult_id = ?
                                                                         AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($phonebanking_id, $phonebanking_result_id));
                                } else {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM phonebanking_voter pbv 
                                                                       WHERE pbv.phonebanking_id=? 
                                                                         AND pbv.phonebankingcontactresult_id IS NOT NULL
                                                                         AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($phonebanking_id));
                                }
                              } else if($phonebanking_result=='callresult') {
                                if($phonebanking_result_id>0) {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM phonebanking_voter pbv 
                                                                       WHERE pbv.phonebanking_id = ? 
                                                                         AND pbv.phonebankingcallresult_id = ?
                                                                         AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($phonebanking_id, $phonebanking_result_id));
                                } else {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM phonebanking_voter pbv 
                                                                       WHERE pbv.phonebanking_id=? 
                                                                         AND pbv.phonebankingcallresult_id IS NOT NULL
                                                                         AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($phonebanking_id));
                                }

                              } else if($phonebanking_result=='nonprocessed') {
                                $query = $query->raw_where("EXISTS (SELECT 1 
                                                                      FROM phonebanking_voter pbv 
                                                                     WHERE pbv.phonebanking_id=? 
                                                                       AND pbv.phonebankingcallresult_id IS NULL
                                                                       AND pbv.phonebankingcontactresult_id IS NULL
                                                                       AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                    ) ", array($phonebanking_id));
                              
                              } else {
                                $query = $query->raw_where("EXISTS (SELECT 1 
                                                                      FROM phonebanking_voter pbv 
                                                                     WHERE pbv.phonebanking_id=? 
                                                                       AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                    ) ", array($phonebanking_id));
                                
                              }

                              
                               
                            },   
    ),

    

    /*
     * Phone Banking call results
     */
    'phonebankingcallresult_id' => array(
            'selectable'  => false,  
            'relationship' => null,
            'display'     => '<abbr title="Phone Banking">PB</abbr> Call Result',
            'description' => null,
            'getValue'    => function($model, $clickable=false) { 
                               // Phone banking ID has to be set in order to get the result

                               if(Input::has('phonebanking_id')) {
                                 $phonebanking_id = Input::get('phonebanking_id');
                                 //$callresult_id = 0;
                                 $callresult = $model->phonebankings()
                                                     ->pivot()
                                                     ->where('phonebanking_id', '=', $phonebanking_id)
                                                     ->first();  
                                 if(is_null($callresult)) {
                                  return null;
                                 }                       
                                 $callresult_id = $callresult->phonebankingcallresult_id;  


                                 $callresult = Phonebankingcallresult::find($callresult_id);
                                 if(is_null($callresult)) {
                                  return null;
                                 } else {
                                  return '<font color="'.$callresult->color.'">'.$callresult->name.'</font>';
                                 }  
                               } else {
                                return null;
                               }
                               
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              // do nothing yet
                            },   
    ),

    /*
     * Phone Banking contact results
     */
    'phonebankingcontactresult_id' => array(
            'selectable'  => false,  
            'relationship' => null,
            'display'     => '<abbr title="Phone Banking">PB</abbr> Contact Result',
            'description' => null,
            'getValue'    => function($model, $clickable=false) { 
                               // Phone banking ID has to be set in order to get the result

                               if(Input::has('phonebanking_id')) {
                                 $phonebanking_id = Input::get('phonebanking_id');
                                 //$callresult_id = 0;
                                 $contactresult = $model->phonebankings()
                                                        ->pivot()
                                                        ->where('phonebanking_id', '=', $phonebanking_id)
                                                        ->first();
                                 if(is_null($contactresult)) {
                                  return null;
                                 }                       
                                 $contactresult_id = $contactresult->phonebankingcontactresult_id;  
                                 $contactresult = Phonebankingcontactresult::find($contactresult_id);
                                 if(is_null($contactresult)) {
                                  return null;
                                 } else {
                                  return '<font color="'.$contactresult->color.'">'.$contactresult->name.'</font>';
                                 }  
                               } else {
                                return null;
                               }
                               
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              // do nothing yet
                            },   
    ),


    /*-------------------------------------------------------------------------------------
     * Canvass columns.....
     */ 

    /*
     * Filter voters that belongs to canvass.
     */     
    'canvass_id' => array(
            'selectable'  => false,  
            'relationship' => "",
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $canvass_id = $input['canvass_id'];  
                              $canvass_result = $input['canvass_result'];  
                              $canvass_result_id = $input['canvass_result_id'];  
                              
                              $table_prefix='';
                              if(Auth::user()->account_id>1) {
                                $table_prefix = Auth::user()->account_id.'_';
                              }

                              if($canvass_result=='contacted') {
                                if($canvass_result_id>0) {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM {$table_prefix}canvass_voter cv 
                                                                       WHERE cv.canvass_id = ? 
                                                                         AND cv.canvasscontactresult_id = ?
                                                                         AND cv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($canvass_id, $canvass_result_id));
                                } else {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM {$table_prefix}canvass_voter pbv 
                                                                       WHERE pbv.canvass_id=? 
                                                                         AND pbv.canvasscontactresult_id IS NOT NULL
                                                                         AND pbv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($canvass_id));
                                }
                              } else if($canvass_result=='not_home') {
                                if($canvass_result_id>0) {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM {$table_prefix}canvass_voter cv 
                                                                       WHERE cv.canvass_id = ? 
                                                                         AND cv.canvassnothomeresult_id = ?
                                                                         AND cv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($canvass_id, $canvass_result_id));
                                } else {
                                  $query = $query->raw_where("EXISTS (SELECT 1 
                                                                        FROM {$table_prefix}canvass_voter cv 
                                                                       WHERE cv.canvass_id=? 
                                                                         AND cv.canvassnothomeresult_id IS NOT NULL
                                                                         AND cv.voter_id = `{$table_prefix}voters`.id
                                                                      ) ", array($canvass_id));
                                }

                              } else if($canvass_result=='nonprocessed') {
                                $query = $query->raw_where("EXISTS (SELECT 1 
                                                                      FROM {$table_prefix}canvass_voter cv 
                                                                     WHERE cv.canvass_id=? 
                                                                       AND cv.canvassnothomeresult_id IS NULL
                                                                       AND cv.canvasscontactresult_id IS NULL
                                                                       AND cv.voter_id = `{$table_prefix}voters`.id
                                                                    ) ", array($canvass_id));
                              
                              } else {
                                $query = $query->raw_where("EXISTS (SELECT 1 
                                                                      FROM {$table_prefix}canvass_voter cv 
                                                                     WHERE cv.canvass_id=? 
                                                                       AND cv.voter_id = `{$table_prefix}voters`.id
                                                                    ) ", array($canvass_id));
                                
                              }

                              
                               
                            },   
    ),

    /*
     * Canvass Select Column... This columns is being in use for ajax dialogs
     */
    'canvass_select' => array(
            'selectable'  => false,  
            'relationship' => null,
            'display'     => '',
            'description' => null,
            'getValue'    => function($model, $clickable=false) { 
                               $canvass_id = Input::get('canvass_id', 0);
                               return '<a href="'.URL::to_action('canvass@view', array($canvass_id, $model->id)).'" class="link">[Select]</a>';
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              // do nothing yet
                            },   
    ),

    /*
     * Canvass not-home results
     */
    'canvassnothomeresult_id' => array(
            'selectable'  => false,  
            'relationship' => null,
            'display'     => 'Canvass Not-Home Result',
            'description' => null,
            'getValue'    => function($model, $clickable=false) { 
                               // Canvass ID has to be set in order to get the result
                               

                               if(Input::has('canvass_id')) {
                                 $canvass_id = Input::get('canvass_id');
                                 //$callresult_id = 0;
                                 $nothomeresult = $model->canvasses()
                                                        ->pivot()
                                                        ->where('canvass_id', '=', $canvass_id)
                                                        ->first();  
                                 if(is_null($nothomeresult)) {
                                  return null;
                                 }                       
                                 $nothomeresult_id = $nothomeresult->canvassnothomeresult_id;  


                                 $nothomeresult = Canvassnothomeresult::find($nothomeresult_id);
                                 if(is_null($nothomeresult)) {
                                  return null;
                                 } else {
                                  return '<font color="'.$nothomeresult->color.'">'.$nothomeresult->name.'</font>';
                                 }  
                               } else {
                                return null;
                               }
                               
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              // do nothing yet
                            },   
    ),

    /*
     * Canvass contact results
     */
    'canvasscontactresult_id' => array(
            'selectable'  => false,  
            'relationship' => null,
            'display'     => 'Canvass Contact Result',
            'description' => null,
            'getValue'    => function($model, $clickable=false) { 
                               
                               // Canvass ID has to be set in order to get the result
              

                               if(Input::has('canvass_id')) {
                                 $canvass_id = Input::get('canvass_id');
                                 //$callresult_id = 0;

                                 $contactresult = $model->canvasses()
                                                        ->pivot()
                                                        ->where('canvass_id', '=', $canvass_id)
                                                        ->first();
                                 
                                 if(is_null($contactresult)) {
                                  return null;
                                 }

                                 
                                 $contactresult_id = $contactresult->canvasscontactresult_id;  
                                 $contactresult = Canvasscontactresult::find($contactresult_id);
                                 if(is_null($contactresult)) {
                                  return null;
                                 } else {
                                  return '<font color="'.$contactresult->color.'">'.$contactresult->name.'</font>';
                                 }  
                               } else {
                                return null;
                               }
                               
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              // do nothing yet
                            },   
    ),
    

    
    
  ),
  /*
   * default voter column list to be displayed.
   */   
  'default-columns' => array('voter_id', 'fullname', 'state', 'city', 'assemblydistrict_id', 'pollsite_id', 'electiondistrict_id'),


);

/*----------------------------------------------------
 * DYNAMIC COLUMN CREATION:
 * Add vote vistory filter to the voters columns.
 *-----------------------------------------------------*/
foreach(Cache::remember('ElectiontypeList', function() {return Electiontype::where_in('id', array(1, 3, 4))->get();}, 30) as $electiontype) {
  $return['columns']['election_history_'.$electiontype->id] = array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function(&$query, $input=array()) use($electiontype) {
                              
                              $selection = intval($input['election_history_'.$electiontype->id]);
                              if($selection>0) {
                                $years = null;
                                if (array_key_exists('year_'.$electiontype->id, $input)) {
                                  $years = $input['year_'.$electiontype->id];
                                } 
                                if(is_array($years)) {
                                  # nothign to do... this is what we were expecting
                                } else if(!empty($years) && intval($years)>0) {
                                  # if only one year was selected. we convert it to array so we can use the same single line of code below
                                  $years = array($years);
                                } else {
                                  # if nothing was selected it means that all(last 5) years has to be processed
                                  $years = array();
                                  foreach($electiontype->votehistory()->distinct()->order_by('year', 'desc')->take(5)->get('year') as $votehistory){
                                    $years[] = $votehistory->year;   
                                  }
                                }

                                // Get the table prefix for my table voters     
                                $table_prefix = '';
                                if(Auth::user()->account_id>1) {
                                  $table_prefix = Auth::user()->account_id.'_'; 
                                }
                                
                                switch($selection) {
                                  // Has voted
                                  case 1: 
                                    $query = $query->raw_where(count($years)." = (select count(0) from {$table_prefix}votehistory vh where {$table_prefix}voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='Y' and vh.electiontype_id='".$electiontype->id."')");
                                    break;
                                  case 2: // has not voted
                                    $query = $query->raw_where(count($years)." = (select count(0) from {$table_prefix}votehistory vh where {$table_prefix}voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='N' and vh.electiontype_id='".$electiontype->id."')");
                                    break; //
                                  case 3: // Has voted at least
                                    $at_least = intval(Input::get('at_least_'.$electiontype->id, 5));
                                    $query = $query->raw_where($at_least." >= (select count(0) from {$table_prefix}votehistory vh where {$table_prefix}voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='N' and vh.electiontype_id='".$electiontype->id."')");
                                    break;
                                }
                                
                              }
                              
                            },   
    );
} 

return $return;                              