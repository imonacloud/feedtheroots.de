<?php
/*
 * Login controller.
 */
class Login_Controller extends Base_Controller {
  // Activating RESTful controller actions, so we can separate the logic of populate and renders form, ect,
  public $restful = true;
    
  public function __construct() {
    //parent::__construct();
    Asset::add('jquery', 'js/jquery.js');
    Asset::add('bootstrap-js', 'js/bootstrap.min.js');
    Asset::add('bootstrap-css', 'css/bootstrap.css');
    Asset::add('bootstrap-css-responsive', 'css/bootstrap-responsive.css', 'bootstrap-css');
    Asset::add('login', 'css/login.css', 'bootstrap-css');
  }
  
  /**---------------------------------------------------------------------------------------------------------------
   * Shows the login form
   *
   * @param  void
   * @return View rendered
   */
  public function get_index()  {

    $this->successes = array();
    if(Session::has('successes')) {
      $this->successes = unserialize(Session::get('successes'));
      Session::forget('successes');
    }

    $this->warnings = array();
    if(Session::has('warnings')) {
      $this->warnings = unserialize(Session::get('warnings'));
      Session::forget('warnings');
    }

    return View::make('login.index', array(
      'successes' => $this->successes,
      'warnings' => $this->warnings,
    ));
  }
  
  /**---------------------------------------------------------------------------------------------------------------
   * do login
   *
   * @param  void
   * @return View rendered
   */
  public function post_index()  {
    Input::flash('except', 'password');
  
    $fields = array(
        'code' => Input::get('code'), 
        'email' => Input::get('email'),
        'password' => Input::get('password'),
    );

    $account = Account::where_code(Input::get('code', 0))->first();
    $account_id = 0;
    if(!is_null($account)) {
      $account_id = $account->id;
    }
    
    $rules = array(
      'code' => 'required|exists:accounts',
      'email' => 'required|email|exists_in_account:users,email,'.$account_id,
      'password' => 'required',
    );
    
    $validation = Validator::make($fields, $rules);
    
    if( $validation->fails() ) {
      // If the request was amde from ajax, return the appropiate form.
      if(Request::ajax()) {
        Input::flash();
        return Response::json(     
          array( 
            'error' => Response::view('login.dialog-login', array('validation' => $validation))->render(),
            'callback' => 'loginDlgInit',
            'html'   => '',
          )
        );     
      }
      return Redirect::to('login')->with_errors($validation);
    } else {
      
      $credentials = array(
          'username' => $fields['email'],
          'password' => $fields['password'],
          'account_id' => $account_id,
      );

      
      if ( Auth::attempt($credentials) ) {
        $user = Auth::user();
        // Check if the user account is confirmed or need to change the password.
        if($user->confirmed=='N') {
          // need to confirm the account before contimue
          return Redirect::to_action('login@confirm');          
        } 

        if($user->change_password_request=='Y') {
          // need to change the password before continue.
          return Redirect::to_action('login@change_password');          
        }

        // If the request was amde from ajax, return the appropiate form.
        if(Request::ajax()) {
          $redirect_url = Session::get('redirect-login-url');
          $redirect_inputs = unserialize(Session::get('redirect-login-inputs'));

          Session::forget('redirect-login-url');
          Session::forget('redirect-login-inputs');

          return Response::json(     
            array( 
              'error' => $redirect_url,
              'callback' => 'loginDlgInit',
              'html'   => '',
            )
          ); 
        }

        return Redirect::to('dashboard');

      }
      else {
        // If the request was amde from ajax, return the appropiate form.
        if(Request::ajax()) {
          Input::flash();
          return Response::json(     
            array( 
              'error' => Response::view('login.dialog-login', array('login_error' => true))->render(),
              'callback' => 'loginDlgInit',
              'html'   => '',
            )
          );     
        }
        return View::make('login.index')
                   ->with('login_error', true)
                   ->with('successes', $this->successes);
      }
    }
    
  }

  

  /**---------------------------------------------------------------------------------------------------------------
   * Shows forgot password form
   *
   * @param  void
   * @return View rendered
   */
  public function get_forgot_password()  {
    return View::make('login.forgot-password');
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Reset password and send it to the user's email.
   *
   * @param  void
   * @return View rendered
   */
  public function post_forgot_password()  {
    $fields = array(
        'code' => Input::get('code'), 
        'email' => Input::get('email'),
    );

    $account = Account::where_code(Input::get('code', 0))->first();
    $account_id = 0;
    if(!is_null($account)) {
      $account_id = $account->id;
    }
    
    $rules = array(
      'code' => 'required|exists:accounts',
      'email' => 'required|email|exists_in_account:users,email,'.$account_id,
    );
    
    $validation = Validator::make($fields, $rules);
    
    if( $validation->fails() ) {
      Input::flash();
      return Redirect::to_action('login@forgot_password')->with_errors($validation);
      //return $this->get_forgot_password()->with('errors', $validation);
    } else {
      $user = User::where('account_id', '=', $account_id)->where_email(Input::get('email'))->first();
      $new_password = Str::random(6, 'alnum');
      $user->change_password_request = 'Y';
      $user->password = $new_password;
      $user->save();
      
      //------------------------------------------------------------------------------------
      // Send email with the confirmation links
      $mailer = IoC::resolve('mailer');
      $message_body = Response::view('user.emails.password-reset', array('user' => $user, 'password' => $new_password))->render();

      // Construct the message
      $message = Swift_Message::newInstance('Password Reset')
                              ->setFrom(array('no-reply@test.com'=>'test'))
                              ->setTo(array($user->email => $user->name))
                              ->setBody($message_body,'text/html');

      // Send the email
      $mailer->send($message);
      $this->warnings[] = "An email with the new password has been sent to your email.  Don't forget to check your junk/bulk/spam folder if it doesn't arrive in your inbox.";
      //------------------------------------------------------------------------------------

      return $this->get_forgot_password()
                  ->with('warnings', $this->warnings);

    }
    
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Shows forgot account form
   *
   * @param  void
   * @return View rendered
   */
  public function get_forgot_account()  {
    return View::make('login.forgot-account');
  }

  /**---------------------------------------------------------------------------------------------------------------
   * gets all accounts that the email belongs to
   *
   * @param  void
   * @return View rendered
   */
  public function post_forgot_account()  {
    $fields = array(
        'email' => Input::get('email'),
    );

    $rules = array(
      'email' => 'required|email|exists:users',
    );
    
    $validation = Validator::make($fields, $rules);
    
    if( $validation->fails() ) {
      Input::flash();
      return Redirect::to_action('login@forgot_account')->with_errors($validation);
      //return $this->get_forgot_password()->with('errors', $validation);
    } else {
      $user = User::where_email(Input::get('email'))->first();
      $users = User::where_email(Input::get('email'))->get();
      
      //------------------------------------------------------------------------------------
      // Send email with the confirmation links
      $mailer = IoC::resolve('mailer');
      $message_body = Response::view('user.emails.account-info', array('users' => $users))->render();

      // Construct the message
      $message = Swift_Message::newInstance('Account Information')
                              ->setFrom(array('no-reply@test.com'=>'test'))
                              ->setTo(array($user->email => $user->name))
                              ->setBody($message_body,'text/html');

      // Send the email
      $mailer->send($message);
      $this->warnings[] = "An email with the account(s) information has been sent to your email. Please don't forget to check your junk/bulk/spam folder if it doesn't arrive in your inbox.";
      //------------------------------------------------------------------------------------

      return $this->get_forgot_account()
                  ->with('warnings', $this->warnings);

    }
    
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Shows Account Confirmation Form
   *
   * @param  void
   * @return View rendered
   */
  public function get_confirm($user_id=0, $confirmation_code=0)  {
    
    // If not information was provider, show the confirmation form
    if($user_id==0) {
      return View::make('login.confirm');  
    } else {
      // Confirm the account
      $user = User::where('id', '=', $user_id)
                  ->where('confirmation_code', '=', $confirmation_code)
                  ->first();

      if(is_null($user)) {
        return View::make('login.confirm')->with('confirm_error', true);
      } else {
        // Confirmed
        $user->confirmed='Y';
        $user->confirmation_code=null;
        $user->save();

        $this->successes[] = "Your account has been confirmed successfully.";
        //Session::put('successes', serialize($this->successes));

        // if the user is not logged in it will be redirected to the login page.
        if (Auth::guest()) return Redirect::to('login')->with('successes', serialize($this->successes));

        return Redirect::to('dashboard');        
      }
    }
    
  }

  /**---------------------------------------------------------------------------------------------------------------
   * validate the confirmation values
   *
   * @param  void
   * @return View rendered
   */
  public function post_confirm()  {
    $fields = array(
        'code' => Input::get('code'),
        'email' => Input::get('email'),
        'confirmation_code' => Input::get('confirmation_code'),
    );

    $account = Account::where_code(Input::get('code', 0))->first();
    $account_id = 0;
    if(!is_null($account)) {
      $account_id = $account->id;
    }
    
    $rules = array(
      'code' => 'required|exists:accounts',
      'email' => 'required|email|exists_in_account:users,email,'.$account_id,
      'confirmation_code' => 'required',
    );
    
    $validation = Validator::make($fields, $rules);
    
    if( $validation->fails() ) {
      Input::flash();
      return Redirect::to_action('login@confirm')->with_errors($validation);
    } else {
      $user = User::where('account_id', '=', $account_id)
                  ->where('email', '=', Input::get('email'))
                  ->where('confirmation_code', '=', Input::get('confirmation_code'))
                  ->first();
      
      if(is_null($user)) {
        Input::flash();
        return $this->get_confirm()->with('confirm_error', true);
      } else {
        return $this->get_confirm($user->id, $user->confirmation_code);
      }
    }
  }



  /**---------------------------------------------------------------------------------------------------------------
   * Shows forgot password form
   *
   * @param  void
   * @return View rendered
   */
  public function get_change_password()  {
    return View::make('login.change-password');
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Change your current password
   *
   * @param  void
   * @return View rendered
   */
  public function post_change_password()  {
    $fields = array(
      'current_password'      => Input::get('current_password'), 
      'password'              => Input::get('new_password'),
      'password_confirmation' => Input::get('confirm_new_password'),
    );

    $rules = array(
      'current_password' => 'required',
      'password' => 'required|confirmed|min:4',
    );
    
    $validation = Validator::make($fields, $rules);
    
    if( $validation->fails() ) {
      Input::flash();
      return Redirect::to_action('login@change_password')->with_errors($validation);
      //return $this->get_forgot_password()->with('errors', $validation);
    } else {
       $user = Auth::user();
      
      if ( ! is_null($user) and Hash::check(Input::get('current_password'), $user->password)) {
        $user->password = Input::get('new_password');
        $user->change_password_request = 'N';
        $user->save();
        $this->successes[] = "Your current password has been changed successfully.";
        //print_r($user); die();
        return Redirect::to('dashboard')->with('successes', serialize($this->successes));
      } else if(is_null($user)) {
        $this->warnings[] = "You have to be logged in in order to change your current password.";
        return Redirect::to('login')->with('warnings', serialize($this->warnings));
      } else {
        $validation->errors->add('current_password', 'The selected <b>current password</b> is invalid.');
        return Redirect::to_action('login@change_password')->with_errors($validation);
      }

      return $this->get_change_password();

    }
    
  }
  
}