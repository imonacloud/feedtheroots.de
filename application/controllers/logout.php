<?php

class Logout_Controller extends Base_Controller {
 
  //public $restful = true;
    
  public function __construct() {
    parent::__construct();
  }
  
  public function action_index()  {
    Auth::logout();
    return Redirect::to('login');
  }

}  