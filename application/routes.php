<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/
/*
Route::get('/', function()
{
	return View::make('home.index');
});
*/

/*
Route::get('access_denied', function()
{
	// get the error message we going to show
    $error = Session::get('error', "You are not authorised to access the requested web page. Contact your system administrator for more information.");
    
	return View::make('access_denied')->with_error($error);
});
*/

Event::listen('laravel.query', function($sql, $bindings, $time) {
  //echo $sql;
});

Event::listen('laravel.started: wkhtmltopdf', function() {
    // Set configuration for this bundle...
    //Config::set('admin::file.option', true);
});


/* event to updated or delete a cache list */
/*
Event::listen('eloquent.updated: User', function($user)
{
    Cache::put('user_'.$user->id, $user, 5);
});

Event::listen('eloquent.saved: User', function($user)
{
    Cache::put('user_'.$user->id, $user, 5);
});

Event::listen('eloquent.deleted: User', function($user)
{
    Cache::forget('user_'.$user->id);
});
*/
/*
 Event::listen('eloquent.updated', function($model) use ($ttl)
{
    Cache::put($model->table().'_'.$model->id, $model, $ttl);
});

Event::listen('eloquent.saved', function($user) use ($ttl)
{
    Cache::put($model->table().'_'.$model->id, $model, $ttl);
});

Event::listen('eloquent.deleted', function($model)
{
    Cache::forget($model->table().'_'.$model->id);
});
*/

Route::controller(Controller::detect());    

//Route::resource('dogs', 'DogsController');


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

/*
 * Do stuff before every request to your application...
 */
Route::filter('before', function() {
	// no nothing yet...

});

/*
 * Do stuff after every request to your application...
 */
Route::filter('after', function($response) {
	// no nothing yet...

});


/*------------------------------------------------------------------------------------------------
 * protects all post actions from cross-site request forgeries
 */
Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});


/*------------------------------------------------------------------------------------------------
 * Filter to control authentication over all controllers....
 * This filter is being in user in all controllers and makes sure that the user needs to be logged in
 * in order to do any operation.
 */ 
Route::filter('auth', function() {
	//phpinfo();die();
	// Check if the user is not logged in.
	if (Auth::guest()) { 
		// save the current url so we can go back to it after login.
		if( ! Session::has('redirect-login-url')) {
		  Session::put('redirect-login-url', URL::current());
		  Session::put('redirect-login-inputs', serialize(Input::all()));	
		}
		
		/*
		 * If the request was made from ajax, we return the dialog-login form.
		 */
		if(Request::ajax()) {
			return Response::json(     
			    array( 
			    	'error' => Response::view('login.dialog-login')->render(),
			    	'callback' => 'loginDlgInit',
			    	'html'   => '',
			    )
		    ); 
		}
		
		// Redirect to the login
		return Redirect::to('login'); 
	}

	// Check if a change password request has been sent.
	if(Auth::user()->change_password_request=='Y') {
		return Redirect::to_action('login@change_password');		
	}

});


/*------------------------------------------------------------------------------------------------
 * Only administrator will have access to the controller that this filters was associated.
 */ 
Route::filter('only_admin', function()
{
	if(!Auth::user()->is_admin()) {
		return Redirect::to('access_denied')->with('error', "You don't have access to Role System Module. Contact your system administrator if you have any question.");	
	}
	
});

/*------------------------------------------------------------------------------------------------
 * Filter to control access to the user controller.
 * Some user will have access to do some operation over the user module.
 */ 
Route::filter('user_system_access', function()
{
	$controller_action = Request::route()->controller_action;

	switch($controller_action) {
		// View/Read Control
		case 'list':
			// Check if the user has permission to see users.
		    if(!Auth::user()->has_access(Module::USERS, 'read')) {
		      return Redirect::to('access_denied')->with('error', "You don't have access to view users. Contact your system administrator if you have any question.");
		    }
			break;
		// Adding new user's control	
		case 'new':
			// Check if the user has permission to add user.
		    if(!Auth::user()->has_access(Module::USERS, 'add')) {
		      if(Auth::user()->has_access(Module::USERS, 'read')) {	
		      	$errors[] = "You don't have access to add new users to the system. Contact your system administrator if you have any question.";
				return Redirect::to_action('user@list')->with('errors', serialize($errors));		      	
	  		  } else {
	  		  	return Redirect::to('access_denied')->with('error', "You don't have access to add new users to the system. Contact your system administrator if you have any question.");
	  		  }
		    }
			break;
		// editing/updating user's control	
		case 'edit':
		case 'update':
		case 'change_status':
		case 'change_password':
		case 'resend_confirmation':
		    //$id=Request::route()->parameters[1];
			// Check if the user has permission to edit a user.
		    if(!Auth::user()->has_access(Module::USERS, 'update')) {
		      if(Auth::user()->has_access(Module::USERS, 'read')) {	
		      	$errors[] = "You don't have access to edit or update users information in the system. Contact your system administrator if you have any question.";
				return Redirect::to_action('user@list')->with('errors', serialize($errors));		      	
	  		  } else {
	  		  	return Redirect::to('access_denied')->with('error', "You don't have access to edit or update users information in the system. Contact your system administrator if you have any question.");
	  		  }
		    }
			break;
		// deleting user's control	
		case 'del':
		case 'delete':
			// Check if the user has permission to edit a user.
		    if(!Auth::user()->has_access(Module::USERS, 'delete')) {
		      if(Auth::user()->has_access(Module::USERS, 'read')) {	
		      	$errors[] = "You don't have access to delete users in the system. Contact your system administrator if you have any question.";
				return Redirect::to_action('user@list')->with('errors', serialize($errors));		      	
	  		  } else {
	  		  	return Redirect::to('access_denied')->with('error', "You don't have access to delete users in the system. Contact your system administrator if you have any question.");
	  		  }
		    }
			break;
		// get user information (from ajax process)	
			// PENDING: this codes are not working when call from ajax
		case 'get':
		    // Check if the user has permission to edit a user.
		    if(!Auth::user()->has_access(Module::USERS, 'read')) {
		      if ( Request::ajax() ) {	
		      	// A message will shown in the gui....
		      	Response::json(null);
		      } else {	
		      	return Redirect::to('access_denied')->with('error', "You don't have access to view users. Contact your system administrator if you have any question.");
	  		  } 
		    }
			break;
	}
});


