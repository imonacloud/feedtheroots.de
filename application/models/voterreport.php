<?php
/*
 * Voter model. The voter table is a prefixed table, that's means that there is one voter table per account.
 */
class Voterreport extends Eloquent {
  // Table name variable. This name will change base on the account id.
  public static $table = 'voters';

  public static $timestamps = true;
  
  //---------------------------------------------------------------------------------------------------------------
  /**
   * Creates a new voter model instance 
   *
   * @param  void
   * @return void
   */
  public function __construct( $attributes = array(), $exists=false) {
    // call parent contructor
    parent::__construct($attributes, $exists);
   
    // Change the table name based on the user's account.
    // All user should point to the right voter table.
    $table_prefix=0;
    if (!Auth::guest()) $table_prefix = Auth::user()->account_id;
    // Account Id 1 is the default account. This is a test account and 
    // should be pointing to the voters table (without prefix)
    if(intval($table_prefix)!=1) {
      self::$table = $table_prefix.'_voters';
    }
    
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Get a new fluent query builder instance for the model.
   * We going to use this function to inject where condition 
   * to the main query such as data-filter that the user has permission
   * to see or work.
   *
   * @param void
   * @return Query
   */
  protected function query()  {
    //$query = new \Laravel\Database\Eloquent\Query($this);
    //return $query->where('application_id', '=', \App::get_id());
    $query = parent::query();

    // Filter user's voter target. The filter is being made by 
    // election distrincts and will only apply for non-administrator users.
    // Account administrator should see/work with all voters.
    if(!Auth::user()->is_admin()) {
      // get all election districts that the user has permission to see/work.
      $eds = Auth::user()->electiondistricts()->lists('id');
      // add the filter to the query.
      $query = $query->where_in('electiondistrict_id', $eds);  
    }
    
    return $query;
  }

  //---------------------------------------------------------------------------------------------------------------
  //   GETTERS METHODS
  //---------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Check if the user is administrator.
   *
   * @return true ir false
   */
  public function isMine() {
    return ($this->mine == 'Y');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets voter's name in the format: Lastname, Firstname
   *
   * @param void
   * @return String
   */
  public function get_name()  {
    return $this->lastname.', '.$this->firstname;
  }
  
  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets voter's name including the middle initial. Format: Lastname, Firstname MI
   *
   * @param void
   * @return String
   */
  public function get_fullname()  {
    return $this->lastname.', '.$this->firstname.' '.$this->middle_ini;
  } 

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets voter's full adress
   *
   * @param void
   * @return String
   */
  public function get_fulladdress()  {
    //return $this->house_number.' '.$this->street_name.' '.$this->street_suffix.', '.$this->city.' '.$this->state.' '.$this->zipcode;
    return $this->address.', '.$this->city.' '.$this->state.' '.$this->zipcode;
  } 

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets voter's date of birth
   *
   * @param void
   * @return String
   */
  public function get_dob()  {
    // This could be variable....
    $format="m/d/Y";
    $dob = strtotime($this->birthdate); 
    return date($format, $dob); 
  } 

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter's date of birth
   *
   * @param void
   * @return String
   */
  public function get_reg_date()  {
    // This could be variable....
    $format="m/d/Y";
    $reg_date = strtotime($this->registration_date); 
    return date($format, $reg_date); 
  } 



  //---------------------------------------------------------------------------------------------------------------
  /**
   * alias to zip column. Return the zipcode
   *
   * @param void
   * @return String
   */
  public function get_zipcode()  {
    return $this->zip;
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets full zipcode in the format: zip5 - zip4
   *
   * @param void
   * @return String
   */
  public function get_fullzipcode()  {
    return $this->zip.'-'.$this->zip4;
  } 

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets thumb-mini voter's photo 
   *
   * @param void
   * @return String
   */
  public function get_photo_thumb_mini_url() {
    if( ! is_null($this->photo) ) {
      $photo = path('public').'voters/photos/'.$this->photo_subdir().'/'.$this->voter_id."-thumb-mini.".$this->photo;
      if(!File::exists($photo)) {
        return URL::to_asset('img/voter-thumb-mini.jpg');
      }

      return URL::to_asset('voters/photos/'.$this->photo_subdir().'/'.$this->id."-thumb-mini.".$this->photo).'?ref='.Str::random(5); 
    } else {
      return URL::to_asset('img/voter-thumb-mini.jpg');
    }
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets thumb voter's photo 
   *
   * @param void
   * @return String
   */
  public function get_photo_thumb_url() {
    if(!is_null($this->photo)) {
      $photo = path('public').'voters/photos/'.$this->photo_subdir().'/'.$this->voter_id."-thumb.".$this->photo;
      if(!File::exists($photo)) {
        return URL::to_asset('img/voter-thumb.jpg');
      }

      return URL::to_asset('voters/photos/'.$this->photo_subdir().'/'.$this->voter_id."-thumb.".$this->photo).'?ref='.Str::random(5); 
    } else {
      return URL::to_asset('img/voter-thumb.jpg');
    }
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets voter's photo 
   *
   * @param void
   * @return String
   */
  public function get_photo_url() {
    if(!is_null($this->photo)) {
      $photo = path('public').'voters/photos/'.$this->photo_subdir().'/'.$this->voter_id.".".$this->photo;
      if(!File::exists($photo)) {
        return URL::to_asset('img/voter.jpg');
      }

      return URL::to_asset('voters/photos/'.$this->photo_subdir().'/'.$this->voter_id.".".$this->photo).'?ref='.Str::random(5); 
    } else {
      return URL::to_asset('img/voter.jpg');
    }
  }

  //---------------------------------------------------------------------------------------------------------------
  //   CUSTOM METHODS
  //---------------------------------------------------------------------------------------------------------------
  
  //---------------------------------------------------------------------------------------------------------------
  /**
   * The voter photo' subdirectory.
   *
   * @param void
   * @return String
   */
  private function photo_subdir()  {
    // Pending: This folder's name has to be generated based on the voter_id.
    // We can't copied all voters photos in one folder.
    return $this->id;
  } 

  //---------------------------------------------------------------------------------------------------------------
  //   RELATIONSHIP METHODS
  //---------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with pollsite model. 
   * One voter belongs to a one pollsite. One pollsite has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function pollsite()  {
    return $this->belongs_to('Pollsite');
  }

  /**---------------------------------------------------------------------------------------------------------------
   * one-to-one relationship with election distrinct model.
   * one voter belongs to a one election distrinct. One election distrinct has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function electiondistrict()  {
    return $this->belongs_to('Electiondistrict');
  }

  /**---------------------------------------------------------------------------------------------------------------
   * one-to-one relationship with assembly distrinct model.
   * one voter belongs to a one assembly distrinct. One assembly distrinct has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function assemblydistrict()  {
    return $this->belongs_to('Assemblydistrict');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * many-to-many relationship with canvasses table.
   * returns all canvasses that this voter belongs to.
   * The intermediate table between voters and cavasses follow the laravel conversion 
   * name (both table in singular, in an alphabetical order), so we don't need to specify it.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function canvasses()  {
    // because the intermediate table has more columns, we need to include them in the result...
    return $this->has_many_and_belongs_to('Canvass')
                ->with(array(
                    'canvassnothomeresult_id', 
                    'canvasscontactresult_id', 
                    'voluntary_flag', 
                    'note', 
                    'user_id', 
                    'updated_at', 
                    'created_at')
                  );
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * many-to-many relationship with phonebanking model.
   * returns all phone bankings that this voter belongs to.
   * The intermediate table between voters and phonebankings follow the laravel conversion 
   * name (both table in singular, in an alphabetical order), so we don't need to specify it.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function phonebankings()  {
    // because the intermediate table has more columns, we need to include them in the result...
    return $this->has_many_and_belongs_to('Phonebanking')
                ->with(array(
                    'phonebankingcallresult_id', 
                    'phonebankingcontactresult_id', 
                    'user_id', 
                    'updated_at', 
                    'created_at')
                  );
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Votehostiry model.
   * one voter has many vote history. One vote history belongs to a one voter.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function votehistory()  {
    return $this->has_many('Votehistory');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Ethnicgroup model.
   * one voter belongs to one Ethnicgroup. One Ethnicgroup has many voters.
   *
   * This Ethnicity group represent the origin contry that the voter came from.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function ethnicgroup()  {
    return $this->belongs_to('Ethnicgroup');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Ethnicity model.
   * one voter belongs to one Ethnicity. One Ethnicity has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function ethnicity()  {
    return $this->belongs_to('Ethnicity');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Phone Source
   * one voter belongs to one Phoen Source. One Phone Source has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function phonesource()  {
    return $this->belongs_to('Phonesource');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Address Type table
   * one voter belongs to one Address Type. One Address Type has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function addresstype()  {
    return $this->belongs_to('Addresstype');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * one-to-many relationship with Address Status table
   * one voter belongs to one Address Status. One Address Status has many voters.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function addressstatus()  {
    return $this->belongs_to('Addressstatus');
  }













  // one-to-one relationship... this table contains voluntary shift information.
  public function voluntary()  {
    return $this->has_one('Voluntary');
  }
  
  public function party()  {
    return $this->belongs_to('Party');
  }
  
  
  
  public function ethnicconfidence()  {
    return $this->belongs_to('Ethnicconfidence');
  }
  
  
  
  public function occupation()  {
    return $this->belongs_to('Occupation');
  }
  
  public function status()  {
    return $this->belongs_to('Status');
  }
  
  public function timezone()  {
    return $this->belongs_to('Timezone');
  }
  
  
  
  public function educationlevel()  {
    return $this->belongs_to('Educationlevel');
  }
  
  public function education()  {
    return $this->belongs_to('Education');
  }
  
  public function ethniccode()  {
    return $this->belongs_to('Ethniccode');
  }
  
  public function homemarketvalue()  {
    return $this->belongs_to('Homemarketvalue');
  }
  
  public function homeowner()  {
    return $this->belongs_to('Homeowner');
  }
  
  public function incomelevel()  {
    return $this->belongs_to('Incomelevel');
  }
  
  public function householdincomelevel()  {
    return $this->belongs_to('Householdincomelevel');
  }

  public function homeownerindicator()  {
    return $this->belongs_to('Homeownerindicator');
  }
  
  public function language()  {
    return $this->belongs_to('Language');
  }
  
  public function religion()  {
    return $this->belongs_to('Religion');
  }
  
  public function maritalstatus()  {
    return $this->belongs_to('Maritalstatus');
  }
  
  public function country()  {
    return $this->belongs_to('County');
  }
  
  
  

  /*
  public function canvass()  {
    return $this->belongs_to('Canvass');
  }

  
  
  public function canvassnothomeresult()  {
    return $this->belongs_to('Canvassnothomeresult');
  }
  
  public function canvasscontactresult()  {
    return $this->belongs_to('Canvasscontactresult');
  }
  
  
  */
  
}