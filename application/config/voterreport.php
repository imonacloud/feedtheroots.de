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

      'voter-report-field' => array(
        'id' =>  array('selectable'  => true,  
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
        'voter_id' =>  array(
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
         * Middle Initial Column. This is a 1 character field.      
         */     
        'middlename' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Middle name",  
                'description' => "voter's middle name",
                'getValue'    => function($model, $clickable=false){ return $model->middlename; },
                'filter'      => function(&$query, $input=array()) {
                                    $middlename = $input['middlename'];
                                    $query = $query->where('middlename', '=', $middlename);
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
        'email' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Email",
                'description' => "voter's email",
                'getValue'    => function($model, $clickable=false){ return $model->email; },
                'filter'      => function(&$query, $input=array()) {
                                  $email = $input['email'];
                                  $query = $query->where('email', 'like', "%{$email}%");
                                },
        ),
        /*
         * Gender  
         */     
        'sex' => array(
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
        'phone_code' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Phone code",
                'description' => "Phone code",
                'getValue'    => function($model, $clickable=false){ return $model->phone_code; }, 
                'filter'      => function(&$query, $input=array()) {
                                  $phone_code = $input['phone_code'];
                                  $query = $query->where('phone_code', '=', $phone_code);
                                },
        ),
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
        'registration_date' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => 'Registration Date',
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
       /* 'registration_date_from' => array(
                'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
                'relationship' => null,
                'display'     => "Registration Date From",
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
        ),*/
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
     /*   'age_from' => array(
                'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
                'relationship' => null,
                'display'     => "Age From",
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
        ),*/
        'ethnicity_id' => array(
            'selectable'  => true,  
            'relationship' => "ethnicity",
            'display'     => "County of Origin",
            'description' => "indicates the detailed of country origin",
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
       /* 'ethnicconfidence_id' => array(
            'selectable'  => true,  
            'relationship' => "ethnicconfidence",
            'display'     => "County of Origin",
            'description' => "indicates the detailed of country origin",
            'getValue'    => function($model, $clickable=false){ return $model->ethnicity ? $model->ethnicity->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ethnicity_id = $input['ethnicity_id'];  
                              if(is_array($ethnicity_id)) {
                                $query = $query->where_in('ethnicity_id', $ethnicity_id); 
                              } else {
                                $query = $query->where('ethnicity_id', '=', $ethnicity_id);
                              }
                            },   
        ),*/
        'ethnicgroup_id' => array(
            'selectable'  => true,  
            'relationship' => "ethnicgroup",
            'display'     => "Ethinicity group",
            'description' => "indicates the detailed of native place",
            'getValue'    => function($model, $clickable=false){ return $model->ethnicgroup ? $model->ethnicgroup->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ethnicgroup_id = $input['ethnicgroup_id'];  
                              if(is_array($ethnicgroup_id)) {
                                $query = $query->where_in('ethnicgroup_id', $ethnicgroup_id); 
                              } else {
                                $query = $query->where('ethnicgroup_id', '=', $ethnicgroup_id);
                              }
                            },   
        ),
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
        'random_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "Random Number",
            'description' => "Random number",
            'getValue'    => function($model, $clickable=false){ return $model->random_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $random_number = $input['random_number'];  
                              if(is_array($random_number)) {
                                $query = $query->where_in('random_number', $random_number); 
                              } else {
                                $query = $query->where('random_number', '=', $random_number);
                              }
                            },   
        ),
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
        'timezone_id' => array(
            'selectable'  => true,  
            'relationship' => "timezone",
            'display'     => "Time Zone",
            'description' => "timezone",
            'getValue'    => function($model, $clickable=false){ return $model->timezone ? $model->timezone->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $timezone_id = $input['timezone_id'];  
                              if(is_array($timezone_id)) {
                                $query = $query->where_in('timezone_id', $timezone_id); 
                              } else {
                                $query = $query->where('timezone_id', '=', $timezone_id);
                              }
                            },   
        ),
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
       // 'mail_carrier_route' => 'mail_carrier_route',
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
        'apt_name' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Apt Name",
            'description' => "apartment name",
            'getValue'    => function($model, $clickable=false){ return $model->apt_name; }, 
            'filter'      => function(&$query, $input=array()) {
                              $apt_name = $input['apt_name'];
                              $query = $query->where('apt_name', 'like', "%{$apt_name}%");
                            },   
        ),
        'latitude' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Latitude",
            'description' => "latitude",
            'getValue'    => function($model, $clickable=false){ return $model->latitude; }, 
            'filter'      => function(&$query, $input=array()) {
                              $latitude = $input['latitude'];
                              $query = $query->where('latitude', 'like', "%{$latitude}%");
                            },   
        ),
        'longitude' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Longitude",
            'description' => "logitude",
            'getValue'    => function($model, $clickable=false){ return $model->longitude; }, 
            'filter'      => function(&$query, $input=array()) {
                              $longitude = $input['longitude'];
                              $query = $query->where('longitude', 'like', "%{$longitude}%");
                            },   
        ),
        'home_sequence' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => "Home Sequence",
            'description' => "home sequence",
            'getValue'    => function($model, $clickable=false){ return $model->home_sequence; }, 
            'filter'      => function(&$query, $input=array()) {
                              $home_sequence = $input['home_sequence'];
                              $query = $query->where('home_sequence', 'like', "%{$home_sequence}%");
                            },   
        ),
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
        'education_id' => array(
            'selectable'  => true, 
            'relationship' => "education", 
            'display'     => "Education",
            'description' => "education list",
            'getValue'    => function($model, $clickable=false){ return $model->education ? $model->education->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $education_id = $input['education_id'];  
                              if(is_array($education_id)) {
                                $query = $query->where_in('education_id', $education_id); 
                              } else {
                                $query = $query->where('education_id', '=', $education_id);
                              }
                            },   
        ),
        'ethniccode_id' => array(
            'selectable'  => true, 
            'relationship' => "ethniccode", 
            'display'     => "Ethniccode",
            'description' => "Ethniccode list",
            'getValue'    => function($model, $clickable=false){ return $model->ethniccode ? $model->ethniccode->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $ethniccode_id = $input['ethniccode_id'];  
                              if(is_array($ethniccode_id)) {
                                $query = $query->where_in('ethniccode_id', $ethniccode_id); 
                              } else {
                                $query = $query->where('ethniccode_id', '=', $ethniccode_id);
                              }
                            },   
        ),
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
        'household_number' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => "House Hold Number",
            'description' => "house hold number",
            'getValue'    => function($model, $clickable=false){ return $model->household_number; }, 
            'filter'      => function(&$query, $input=array()) {
                              $household_number = $input['household_number'];
                              $query = $query->where('household_number', '=', $household_number);
                            },   
        ),
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
        'homeownerindicator_id' => array(
            'selectable'  => true, 
            'relationship' => "homeownerindicator", 
            'display'     => "Home Owner Indicator",
            'description' => "Home Owner Indicator list",
            'getValue'    => function($model, $clickable=false){ return $model->homeownerindicator ? $model->homeownerindicator->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $homeownerindicator_id = $input['homeownerindicator_id'];  
                              if(is_array($homeownerindicator_id)) {
                                $query = $query->where_in('homeownerindicator_id', $homeownerindicator_id); 
                              } else {
                                $query = $query->where('homeownerindicator_id', '=', $homeownerindicator_id);
                              }
                            },   
        ),
        'homemarketvalue_id' => array(
            'selectable'  => true, 
            'relationship' => "homemarketvalue", 
            'display'     => "Home Market Value",
            'description' => "Home market value list",
            'getValue'    => function($model, $clickable=false){ return $model->homemarketvalue ? $model->homemarketvalue->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $homemarketvalue_id = $input['homemarketvalue_id'];  
                              if(is_array($homemarketvalue_id)) {
                                $query = $query->where_in('homemarketvalue_id', $homemarketvalue_id); 
                              } else {
                                $query = $query->where('homemarketvalue_id', '=', $homemarketvalue_id);
                              }
                            },   
        ),
        'homeowner_id' => array(
            'selectable'  => true, 
            'relationship' => "homeowner", 
            'display'     => "Home Owner",
            'description' => "Home owner",
            'getValue'    => function($model, $clickable=false){ return $model->homeowner ? $model->homeowner->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $homeowner_id = $input['homeowner_id'];  
                              if(is_array($homeowner_id)) {
                                $query = $query->where_in('homeowner_id', $homeowner_id); 
                              } else {
                                $query = $query->where('homeowner_id', '=', $homeowner_id);
                              }
                            },   
        ),
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
        'householdincomelevel_id' => array(
            'selectable'  => true, 
            'relationship' => "householdincomelevel", 
            'display'     => "House Hold Income level",
            'description' => "House hold income level",
            'getValue'    => function($model, $clickable=false){ return $model->householdincomelevel ? $model->householdincomelevel->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $householdincomelevel_id = $input['householdincomelevel_id'];  
                              if(is_array($householdincomelevel_id)) {
                                $query = $query->where_in('householdincomelevel_id', $householdincomelevel_id); 
                              } else {
                                $query = $query->where('householdincomelevel_id', '=', $householdincomelevel_id);
                              }
                            },   
        ),
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
        'maritalstatus_id' => array(
            'selectable'  => true, 
            'relationship' => "maritalstatus", 
            'display'     => "Marital Status",
            'description' => "Marital status",
            'getValue'    => function($model, $clickable=false){ return $model->maritalstatus ? $model->maritalstatus->name : null; }, 
            'filter'      => function(&$query, $input=array()) {
                              $maritalstatus_id = $input['maritalstatus_id'];  
                              if(is_array($maritalstatus_id)) {
                                $query = $query->where_in('maritalstatus_id', $maritalstatus_id); 
                              } else {
                                $query = $query->where('maritalstatus_id', '=', $maritalstatus_id);
                              }
                            },   
        ),
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
        'county_id' => array(
            'selectable'  => true,  
            'relationship' => "country",
            'display'     => "Country",
            'description' => "country list",
            'getValue'    => function($model, $clickable=false){ return $model->country ? $model->country->name : ''; }, 
            'filter'      => function(&$query, $input=array()) {
                              $county_id = $input['county_id'];  
                              if(is_array($county_id)) {
                                $query = $query->where_in('county_id', $county_id); 
                              } else {
                                $query = $query->where('county_id', '=', $county_id);
                              }
                            },   
        ),
        'st_up_hous' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Set up hou",
                'description' => "Set up hou",
                'getValue'    => function($model, $clickable=false){ return $model->st_up_hous; },
                'filter'      => function(&$query, $input=array()) {
                                  $st_up_hous = $input['st_up_hous'];
                                  $query = $query->where('st_up_hous', 'like', "%{$st_up_hous}%");
                                },
        ),
        'st_lo_hous' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Set lo hous",
                'description' => "Set lo house",
                'getValue'    => function($model, $clickable=false){ return $model->st_lo_hous; },
                'filter'      => function(&$query, $input=array()) {
                                  $st_lo_hous = $input['st_lo_hous'];
                                  $query = $query->where('st_lo_hous', 'like', "%{$st_lo_hous}%");
                                },
        ),
        'cong_dist' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Cong dist",
                'description' => "Cong dist",
                'getValue'    => function($model, $clickable=false){ return $model->cong_dist; },
                'filter'      => function(&$query, $input=array()) {
                                  $cong_dist = $input['cong_dist'];
                                  $query = $query->where('cong_dist', 'like', "%{$cong_dist}%");
                                },
        ),
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
        'schl_dist' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "schl dist",
                'description' => "schl dist",
                'getValue'    => function($model, $clickable=false){ return $model->schl_dist; },
                'filter'      => function(&$query, $input=array()) {
                                  $schl_dist = $input['schl_dist'];
                                  $query = $query->where('schl_dist', 'like', "%{$schl_dist}%");
                                },
        ),
        'ward' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Ward",
                'description' => "Ward",
                'getValue'    => function($model, $clickable=false){ return $model->ward; },
                'filter'      => function(&$query, $input=array()) {
                                  $ward = $input['ward'];
                                  $query = $query->where('ward', 'like', "%{$ward}%");
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
        'dnc' => array(
            'selectable'  => true,  
            'relationship' => null,
            'display'     => 'Federal Do Not Call List',
            'description' => "Federal Do Not Call Flag",
            'getValue'    => function($model, $clickable=false){ return $model->dnc=='Y' ? 'Yes' : 'No' ; }, 
            'filter'      => function(&$query, $input=array()) {
                              $dnc = $input['dnc'];
                              $query = $query->where('dnc', '=', $dnc);
                            },   
        ),
        'is_voluntary' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "Is voluntary",
                'description' => "Is voluntary",
                'getValue'    => function($model, $clickable=false){ return $model->is_voluntary; },
                'filter'      => function(&$query, $input=array()) {
                                  $is_voluntary = $input['is_voluntary'];
                                  $query = $query->where('is_voluntary', 'like', "%{$is_voluntary}%");
                                },
        ),
        'mine' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "mine",
                'description' => "mine",
                'getValue'    => function($model, $clickable=false){ return $model->mine; },
                'filter'      => function(&$query, $input=array()) {
                                  $mine = $input['mine'];
                                  $query = $query->where('mine', 'like', "%{$mine}%");
                                },
        ),
        'prime1' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "prime 1",
                'description' => "prime 1",
                'getValue'    => function($model, $clickable=false){ return $model->prime1; },
                'filter'      => function(&$query, $input=array()) {
                                  $prime1 = $input['prime1'];
                                  $query = $query->where('prime1', 'like', "%{$prime1}%");
                                },
        ),
        'prime2' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "prime 2",
                'description' => "prime 2",
                'getValue'    => function($model, $clickable=false){ return $model->prime2; },
                'filter'      => function(&$query, $input=array()) {
                                  $prime2 = $input['prime2'];
                                  $query = $query->where('prime2', 'like', "%{$prime2}%");
                                },
        ),
        'prime3' => array(
                'selectable'  => true,  
                'relationship' => null,
                'display'     => "prime 3",
                'description' => "prime 3",
                'getValue'    => function($model, $clickable=false){ return $model->prime3; },
                'filter'      => function(&$query, $input=array()) {
                                  $prime3 = $input['prime3'];
                                  $query = $query->where('prime3', 'like', "%{$prime3}%");
                                },
        ),
        /*'photo' => 'photo',*/
        'created_at' => array(
            'selectable'  => true, 
            'relationship' => null, 
            'display'     => 'Created Date',
            'description' => "Created Datedate in YYYY-MM-DD format",
            'getValue'    => function($model, $clickable=false){
                               //$format="Y-m-d";
                               //$dob = strtotime($model->registration_date); 
                               //return date($format, $dob); 
                               return $model->created_at;
                             }, 
            'filter'      => function(&$query, $input=array()) {
                              $created_at = $input['created_at'];
                              $query = $query->where('created_at', '=', $created_at);
                            },     
        ),
        /*'updated_at' => 'updated_at'*/
      ),
      'voter-report-default' => array(
        'voter_id' => 'voter_id',        
        'firstname' => 'firstname',
        'lastname' => 'lastname',
        'state' => 'state',   
        'city' => 'city',
        'sex' => 'sex' 
      ),
      'match-type' => array(
        '='    => 'Equals to', 
        '>'    => 'Greater than', 
        '<'    => 'Less than', 
        '>='   => 'Greater than equal to',
        '<='   => 'Less than equal to',
        'LIKE' => 'Contain'
      )
  );


return $return;                              