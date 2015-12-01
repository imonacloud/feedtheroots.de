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

	'voter' => array(

    'quick_search' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model){ return null; },
            'filter'      => function($query, $input=array()) {
                                $criteria = $input['quick_search'];
                                // Create a nested que for this condition.
                                $query->where(function($query) use($criteria){
                                   $quick_search =  $criteria;
                                   $query->where('voter_id', 'like', "%{$criteria}%");
                                   $query->or_where(DB::raw("CONCAT(lastname, ', ', firstname)"), 'like', "%{$criteria}%");
                                });
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
            'filter'      => function($query, $input=array()) {
                                $id = $input['id'];
                                $query->where('id', '=', $id);
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
                               if($clickable) {
                                 return '<a href="'.URL::to('voter').'/view/'.$model->id.'" class="lnk">'.$model->voter_id.'</a>';  
                               } 
                               else { return $model->voter_id; }  
                              
                             },
            'filter'      => function($query, $input=array()) {
                                $id = $input['voter_id'];
                                $query->where('voter_id', '=', $id);
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
            'getValue'    => function($model, $clickable=false){ return ($model->lastname.', '.$model->firstname.' '.$model->middle_ini); }, 
            'filter'      => function($query, $input=array()) {
                              $fullname = $input['fullname'];
                              $query->where(DB::raw("CONCAT(lastname, ', ', firstname, ' ', middle_ini)"), '=', $fullname);
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
          'filter'      => function($query, $input=array()) {
                             $title = $input['title'];  
                             if(is_array($title)) {
                               $query->where_in('title', $title); 
                             } else {
                               $query->where('title', '=', $title);
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
            'filter'      => function($query, $input=array()) {
                              $firstname = $input['firstname'];
                              $query->where('firstname', 'like', "%{$firstname}%");
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
            'filter'      => function($query, $input=array()) {
                                $middle_initial = $input['middle_ini'];
                                $query->where('middle_ini', '=', $middle_initial);
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
            'filter'      => function($query, $input=array()) {
                               $lastname = $input['lastname'];
                               $query->where('lastname', 'like', "%{$lastname}%");
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
            'filter'      => function($query, $input=array()) {
                                $surn_suffix = $input['surn_suff'];  
                                if(is_array($surn_suffix)) {
                                  $query->where_in('surn_suff', $surn_suffix); 
                                } else {
                                  $query->where('surn_suff', '=', $surn_suffix);
                                }
                              },
    ),
    /*
     * My Voters Indicator      
     */     
    'mine' => array(
            'selectable'  => true,  
            'display'     => "Mine",
            'relationship' => null,
            'description' => "my-voters indicator. Posible Value: Y and N/BLANK",
            'getValue'    => function($model, $clickable=false){ return $model->mine; },
            'filter'      => function($query, $input=array()) {
                                $query->where_mine('Y');
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
            'filter'      => function($query, $input=array()) {
                              $ethnicity_id = $input['ethnicity_id'];  
                              if(is_array($ethnicity_id)) {
                                $query->where_in('ethnicity_id', $ethnicity_id); 
                              } else {
                                $query->where('ethnicity_id', '=', $ethnicity_id);
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
            'filter'      => function($query, $input=array()) {
                              $ethnicgroup_id = $input['ethnicgroup_id'];  
                              if(is_array($ethnicgroup_id)) {
                                $query->where_in('ethnicgroup_id', $ethnicgroup_id); 
                              } else {
                                $query->where('ethnicgroup_id', '=', $ethnicgroup_id);
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
            'filter'      => function($query, $input=array()) {
                              $prime = $input['prime'];
                              // Prime has to be a valid between 1 and 3  
                              if($prime>3) { $prime=0; }
                              if($prime>0) {
                                $query->where('prime'.$prime, '=', 'Y');
                              } else { // If prime is 0, we will show all voters that have been marked as a prime 1, 2 or 3 
                                $query->where(function($query){
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
            'getValue'    => function($model, $clickable=false){ return $model->prime1; }, 
            'filter'      => function($query, $input=array()) {
                              $query->where_prime1('Y');
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
            'getValue'    => function($model, $clickable=false){ return $model->prime2; }, 
            'filter'      => function($query, $input=array()) {
                              $query->where_prime2('Y');
                            },     
    ),
    /*
     * Triple Prime   
     */     
    'prime2' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Triple Prime",
            'description' => "has voted three times in the last 3 election",
            'getValue'    => function($model, $clickable=false){ return $model->prime2; }, 
            'filter'      => function($query, $input=array()) {
                              $query->where_prime3('Y');
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
            'filter'      => function($query, $input=array()) {
                              $gender = $input['gender'];
                              // gender has to be male or female. If not, we going to use male as a default gender
                              if($gender!='M' && $gender!='F') { $gender='M'; }
                              $query->where_sex($gender);
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
                               $format="Y-m-d";
                               $dob = strtotime($model->birthdate); 
                               return date($format, $dob); 
                             }, 
            'filter'      => function($query, $input=array()) {
                              $birthdate = $input['birthdate'];
                              $query->where('birthdate', '=', $birthdate);
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
            'filter'      => function($query, $input=array()) {
                              $birthdate_from = $input['birthdate_from'];
                              $birthdate_to = $input['birthdate_to'];
                              if($birthdate_to!='') {
                                $query->where_between('birthdate', $birthdate_from, $birthdate_to);
                              // If not end-range was specified, we will show all voters greater than the start-range age.
                              } else {
                                $query->where('birthdate', '>=', $birthdate_from);
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
            'filter'      => function($query, $input=array()) {
                              $age = intval($input['age']);
                              $query->where('age', '=', $age);
                              $pagination['age'] = $age;
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
            'filter'      => function($query, $input=array()) {
                              $age_from = intval($input['age_from']);
                              $age_to = intval($input['age_to']);
                              if($age_to>0) {
                                $query->where_between('age', $age_from, $age_to);
                              // If not end-range was specified, we will show all voters greater than the start-range age.
                              } else {
                                $query->where('age', '>=', $age_from);
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
            'filter'      => function($query, $input=array()) {
                              $religion_id = $input['religion_id'];  
                              if(is_array($religion_id)) {
                                $query->where_in('religion_id', $religion_id); 
                              } else {
                                $query->where('religion_id', '=', $religion_id);
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
            'getValue'    => function($model, $clickable=false){ return $model->phonesource ? $model->phonesource->name : null; }, 
            'filter'      => function($query, $input=array()) {
                              $phonesource_id = $input['phonesource_id'];  
                              if(is_array($phonesource_id)) {
                                $query->where_in('phonesource_id', $phonesource_id); 
                              } else {
                                $query->where('phonesource_id', '=', $phonesource_id);
                              }
                            },   
    ),
    /*
     * Phone Number   
     */     
    'phone_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Phone Number",
            'description' => "telephone number",
            'getValue'    => function($model, $clickable=false){ return $model->phone_number; }, 
            'filter'      => function($query, $input=array()) {
                              $phone_number = $input['phone_number'];
                              $query->where('phone_number', '=', $phone_number);
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
            'filter'      => function($query, $input=array()) {
                              $occupation_id = $input['occupation_id'];  
                              if(is_array($occupation_id)) {
                                $query->where_in('occupation_id', $occupation_id); 
                              } else {
                                $query->where('occupation_id', '=', $occupation_id);
                              }
                            },   
    ),
    /*
     * Pollsite  
     */     
    'pollsite_id' => array(
            'selectable'  => true,  
            'relationship' => "pollsite",
            'display'     => "Pollsite",
            'description' => "polling site",
            'getValue'    => function($model, $clickable=false){ return $model->pollsite ? $model->pollsite->code: ''; }, 
            'filter'      => function($query, $input=array()) {
                              $pollsite_id = intval($input['pollsite_id']);
                              $query->where('pollsite_id', '=', $pollsite_id);
                            },   
    ),
    /*
     * Precinct Name
     */     
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
    /*
     * Precinct Number
     */     
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
    /*
     * Address Type  
     */     
    'addresstype_id' => array(
            'selectable'  => true, 
            'relationship' => "addresstype", 
            'display'     => "Address Type",
            'description' => "address type",
            'getValue'    => function($model, $clickable=false){ return $model->addresstype? $model->addresstype->name: null; }, 
            'filter'      => function($query, $input=array()) {
                              $addresstype_id = $input['addresstype_id'];  
                              if(is_array($addresstype_id)) {
                                $query->where_in('addresstype_id', $addresstype_id); 
                              } else {
                                $query->where('addresstype_id', '=', $addresstype_id);
                              }
                            },   
    ),
    /*
     * Address  
     */     
    'address' => array(
            'selectable'  => true,  
            'display'     => "Address",
            'description' => "this is the resident address",
            'getValue'    => function($model, $clickable=false){ return $model->address; }, 
            'filter'      => function($query, $input=array()) {
                              $address = $input['address'];
                              $query->where('address', 'like', "%{$address}%");
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
            'filter'      => function($query, $input=array()) {
                              $house_number = $input['house_number'];
                              $query->where('house_number', 'like', "%{$house_number}%");
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
            'filter'      => function($query, $input=array()) {
                              $pre_direction = $input['pre_direction'];
                              $query->where('pre_direction', '=', $pre_direction);
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
            'filter'      => function($query, $input=array()) {
                              $street_name = $input['street_name'];
                              $query->where('street_name', 'like', "%{$street_name}%");
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
            'filter'      => function($query, $input=array()) {
                              $post_direction = $input['post_direction'];
                              $query->where('post_direction', '=', $post_direction);
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
            'filter'      => function($query, $input=array()) {
                              $street_suffix = $input['street_suffix'];
                              $query->where('street_suffix', '=', $street_suffix);
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
            'filter'      => function($query, $input=array()) {
                              $apt_number = $input['apt_number'];
                              $query->where('apt_number', 'like', "%{$apt_number}%");
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
            'filter'      => function($query, $input=array()) {
                              $city = $input['city'];
                              $query->where('city', 'like', "%{$city}%");
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
            'filter'      => function($query, $input=array()) {
                              $state = $input['state'];
                              $query->where('state', 'like', "%{$state}%");
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
            'filter'      => function($query, $input=array()) {
                              $zip = $input['zip'];
                              $query->where('zip', '=', $zip);
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
            'filter'      => function($query, $input=array()) {
                              $zip4 = $input['zip4'];
                              $query->where('zip4', '=', $zip4);
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
            'filter'      => function($query, $input=array()) {
                              $zipcode = $input['zipcode'];
                              $query->where(DB::raw("CONCAT(zip, '-', zip4)"), '=', $zipcode);
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
            'filter'      => function($query, $input=array()) {
                              $mail_address = $input['mail_address'];
                              $query->where('mail_address', 'like', "%{$mail_address}%");
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
            'filter'      => function($query, $input=array()) {
                              $mail_city = $input['mail_city'];
                              $query->where('mail_city', 'like', "%{$mail_city}%");
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
            'filter'      => function($query, $input=array()) {
                              $mail_state = $input['mail_state'];
                              $query->where('mail_state', 'like', "%{$mail_state}%");
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
            'filter'      => function($query, $input=array()) {
                              $mail_zip = $input['mail_zip'];
                              $query->where('mail_zip', '=', $mail_zip);
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
            'filter'      => function($query, $input=array()) {
                              $mail_zip4 = $input['mail_zip4'];
                              $query->where('mail_zip4', '=', $mail_zip4);
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
            'filter'      => function($query, $input=array()) {
                              $mail_zipcode = $input['mail_zipcode'];
                              $query->where(DB::raw("CONCAT(mail_zip, '-', mail_zip4)"), '=', $mail_zipcode);
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
            'filter'      => function($query, $input=array()) {
                              $educationlevel_id = $input['educationlevel_id'];  
                              if(is_array($educationlevel_id)) {
                                $query->where_in('educationlevel_id', $educationlevel_id); 
                              } else {
                                $query->where('educationlevel_id', '=', $educationlevel_id);
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
            'filter'      => function($query, $input=array()) {
                              $language_id = $input['language_id'];  
                              if(is_array($language_id)) {
                                $query->where_in('language_id', $language_id); 
                              } else {
                                $query->where('language_id', '=', $language_id);
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
            'filter'      => function($query, $input=array()) {
                              $incomelevel_id = $input['incomelevel_id'];  
                              if(is_array($incomelevel_id)) {
                                $query->where_in('incomelevel_id', $incomelevel_id); 
                              } else {
                                $query->where('incomelevel_id', '=', $incomelevel_id);
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
            'filter'      => function($query, $input=array()) {
                              $persons_household = $input['persons_household'];
                              $query->where('persons_household', '=', $persons_household);
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
            'filter'      => function($query, $input=array()) {
                              $havechild = $input['havechild'];
                              $query->where('havechild', '=', $havechild);
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
            'filter'      => function($query, $input=array()) {
                              $household_veteran = $input['household_veteran'];
                              $query->where('household_veteran', '=', $household_veteran);
                            },   
    ),
    
    /*
     * Registration Date  
     */     
    'registration_date' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Registration Date",
            'description' => "registration date in YYYY-MM-DD format",
            'getValue'    => function($model, $clickable=false){
                               $format="Y-m-d";
                               $dob = strtotime($model->registration_date); 
                               return date($format, $dob); 
                             }, 
            'filter'      => function($query, $input=array()) {
                              $registration_date = $input['registration_date'];
                              $query->where('registration_date', '=', $registration_date);
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
            'filter'      => function($query, $input=array()) {
                              $registration_date_from = $input['registration_date_from'];
                              $registration_date_to = $input['registration_date_to'];
                              if($registration_date_to!='') {
                                $query->where_between('registration_date', $registration_date_from, $registration_date_to);
                              // If not end-range was specified, we will show all voters greater than the start-range age.
                              } else {
                                $query->where('registration_date', '>=', $registration_date_from);
                              }
                            },     
    ),
    /*
     * Pollsite Code
     */     
    'pollsite_code' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $pollsite_code = $input['pollsite_code'];
                              $query->raw_where(" exists (select 1 from pollsites p where voters.pollsite_id=p.id AND p.code='{$pollsite_code}')");
                            },   
    ),
    /*
     * Precinct Number
     */     
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
    
    /*
     * Assembly District
     */     
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
    
    /*
     * Senate District
     */     
    'st_up_hous' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Senate District",
            'description' => "senate district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $st_up_hous = $input['st_up_hous'];
                              $query->where('st_up_hous', '=', $st_up_hous);
                            },   
    ),
    
    /*
     * Congress District
     */     
    'cong_dist' => array(
            'selectable'  => true,
            'relationship' => null,  
            'display'     => "Congress District",
            'description' => "congress district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $cong_dist = $input['cong_dist'];
                              $query->where('cong_dist', '=', $cong_dist);
                            },   
    ),

    /*
     * School District
     */     
    'schl_dist' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "School District",
            'description' => "school district",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $schl_dist = $input['schl_dist'];
                              $query->where('schl_dist', '=', $schl_dist);
                            },   
    ),

    /*
     * School District
     */     
    'ward' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Ward",
            'description' => "ward",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) {
                              $ward = $input['ward'];
                              $query->where('ward', '=', $ward);
                            },   
    ),
    /*
     * Status
     */     
    'status_id' => array(
            'selectable'  => true,  
            'relationship' => "status",
            'display'     => "Status",
            'description' => "voting status of the voter as identified by the state or county voter register",
            'getValue'    => function($model, $clickable=false){ return $model->status ? $model->status->name : null; }, 
            'filter'      => function($query, $input=array()) {
                              $status_id = $input['status_id'];  
                              if(is_array($status_id)) {
                                $query->where_in('status_id', $status_id); 
                              } else {
                                $query->where('status_id', '=', $status_id);
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
            'filter'      => function($query, $input=array()) {
                              $party_id = $input['party_id'];  
                              if(is_array($party_id)) {
                                $query->where_in('party_id', $party_id); 
                              } else {
                                $query->where('party_id', '=', $party_id);
                              }
                            },   
    ),

    
    
  ),
  /*
   * default voter column list to be displayed.
   */   
  'voter-default' => array('voter_id', 'fullname', 'state', 'city', 'pollsite_id', 'precinct_number'),

  /*
  |--------------------------------------------------------------------------
  | Columns Configuration for CANVASS table
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
  'canvass' => array(

    'quick_search' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; },
            'filter'      => function($query, $input=array()) {
                                $criteria = $input['quick_search'];
                                $query->where('name', 'like', "%{$criteria}%");
                             },
    ),
    'list_filter' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; },
            'filter'      => function($query, $input=array()) {
                                $user_id = 0;
                                if(Request::cli() && $input['owner_id']>0) {
                                  $user_id = $input['owner_id'];
                                } else {
                                  $user_id = Auth::user()->id;
                                }

                                $list_filter = 1;
                                if(isset($input['list_filter']) && intval($input['list_filter'])>0) {
                                  $list_filter = $input['list_filter'];
                                  if(!Request::cli()) {
                                    Session::put('canvasses-list-filter', $list_filter);  
                                  }
                                } else if(!Request::cli() && Session::has('canvasses-list-filter')) {
                                  $list_filter = Session::get('canvasses-list-filter'); 
                                }

                                if($list_filter==2) {
                                  $query->where('user_id', '=', $user_id);  
                                } else if($list_filter==3) {
                                  $query = $query->raw_where("EXISTS (SELECT 1 FROM canvass_user cu WHERE canvasses.id = cu.canvass_id AND cu.user_id = ".$user_id.")");  
                                } else { // 1 or 0 is the defult.
                                  $query = $query->where(function($query) use($user_id){
                                                    $query->where('user_id', '=', $user_id);
                                                    $query->raw_or_where("EXISTS (SELECT 1 FROM canvass_user cu WHERE canvasses.id = cu.canvass_id AND cu.user_id = ".$user_id.")");
                                            });  
                                }

                             },
    ),
    'id' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "System ID",
            'description' => "Unique Canvass ID",
            'getValue'    => function($model, $clickable=false){ 
                                if($clickable) {
                                  return '<a href="'.URL::to('canvass').'/view/'.$model->id.'" class="lnk">'.$model->id.'</a>';  
                                } 
                                else { 
                                  return $model->id; 
                                }
                             },
            'filter'      => function($query, $input=array()) {
                                $id = $input['id'];
                                $query->where('id', '=', $id);
                             },
    ),
    'name' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Name",
            'description' => "Canvass Name",
            'getValue'    => function($model, $clickable=false){ 
                                $name = $model->name;
                                if(Input::has('quick_search')) {
                                  $name = Text::highlight($name, Input::get('quick_search'));
                                }
                                if($clickable) {
                                   return '<a href="'.URL::to('canvass').'/view/'.$model->id.'" class="lnk">'.$name.'</a>';  
                                } 
                                else { 
                                  return $name; 
                                }  
                             },
            'filter'      => function($query, $input=array()) {
                                $name = $input['name'];
                                $query->where('name', 'like', "%{$name}%");
                             },
    ),
    'total_voters' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Voters",
            'description' => "Total of voters in this canvass",
            'getValue'    => function($model, $clickable=false){ 
                               if($clickable && count($model->voters)>0) {
                                 return '<a href="#" class="lnk" id="view-canvass-voters-'.$model->id.'">'.count($model->voters)."</a>"; 
                               } else {
                                 return count($model->voters);  
                               }
                             },
            'filter'      => function($query, $input=array()) {
                                //Do nothinig...
                             },
    ),
    'total_contacted_voters' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Contacted Voters",
            'description' => "Total of contacted voters in this canvass",
            'getValue'    => function($model, $clickable=false){ 
                               if($clickable && count($model->contacted_voters)>0) {
                                 return '<a href="#" class="lnk" id="view-canvass-contacted-voters-'.$model->id.'">'.count($model->contacted_voters)."</a>"; 
                               } else {
                                 return count($model->contacted_voters);
                               }
                             },
            'filter'      => function($query, $input=array()) {
                                //Do nothinig...
                             },
    ),
    'created_at' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Created By",
            'description' => "Created by",
            'getValue'    => function($model, $clickable=false){ 
                                $format="Y-m-d h:i:s A";
                                $date = strtotime($model->created_at); 
                                return date($format, $date);  
                             },
            'filter'      => function($query, $input=array()) {
                                $created_at = $input['created_at'];
                                $query->where('created_at', '=', $created_at);
                             },
    ),
    'created_by' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Created By",
            'description' => "Created by",
            'getValue'    => function($model, $clickable=false){ return $model->user->name; },
            'filter'      => function($query, $input=array()) {
                                $created_by = $input['created_by'];
                                $query->where('created_by', '=', $created_by);
                             },
    ),



  ),  
  /*
   * default voter column list to be displayed.
   */   
  'canvass-default' => array('name', 'total_voters', 'total_contacted_voters', 'created_at', 'created_by'),


);

/*----------------------------------------------------
 * DYNAMIC COLUMN CREATION:
 * Add vote vistory filter to the voters columns.
 *-----------------------------------------------------*/
foreach(Cache::remember('ElectiontypeList', function() {return Electiontype::where_in('id', array(1, 3, 4))->get();}, 30) as $electiontype) {
  $return['voter']['election_history_'.$electiontype->id] = array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; }, 
            'filter'      => function($query, $input=array()) use($electiontype) {
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
                                
                                switch($selection) {
                                  // Has voted
                                  case 1: 
                                    $query->raw_where(count($years)." = (select count(0) from votehistory vh where voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='Y' and vh.electiontype_id='".$electiontype->id."')");
                                    break;
                                  case 2: // has not voted
                                    $query->raw_where(count($years)." = (select count(0) from votehistory vh where voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='N' and vh.electiontype_id='".$electiontype->id."')");
                                    break; //
                                  case 3: // Has voted at least
                                    $at_least = intval(Input::get('at_least_'.$electiontype->id, 5));
                                    $query->raw_where($at_least." >= (select count(0) from votehistory vh where voters.id=vh.voter_id AND vh.year in ('".implode("','", $years)."') and vh.voted='N' and vh.electiontype_id='".$electiontype->id."')");
                                    break;
                                }
                               
                              }
                              
                            },   
    );
} 

return $return;                              