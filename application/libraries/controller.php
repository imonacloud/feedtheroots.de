<?php
/*
 * This code was copied from  http://paste.laravel.com/7R7.
 * 
 * This will be override the default laravel controller class.
 */

class Controller extends Laravel\Routing\Controller {
    /**
     * Indicates if the controller uses RESTful routing.
     *
     * @var bool
     */
    public $restful = false;
    
    /**
     * Indicates if the controller should respond to XHR'ed request with functions prepended by 'ajax_' term.
     * For RESTful routes, this mean that instead of 'get_index', 'post_index' etc., the functions that actually
     * will be called will be named 'ajax_get_index', 'ajax_post_index', etc. For non-restuful routes this will
     * be 'ajax_action_index' instead of 'action_index'.
     * Practically, this eliminates the need to use a pre/post filter and/or an if/else construct in every
     * single action of the controller.
     *
     * @var bool
     */  
    public $ajaxful = false;


    /**
     * Execute a controller action and return the response.
     *
     * Unlike the "execute" method, no filters will be run and the response
     * from the controller action will not be changed in any way before it
     * is returned to the consumer.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function response($method, $parameters = array()) {
        // The developer may mark the controller as being "RESTful" which
        // indicates that the controller actions are prefixed with the
        // HTTP verb they respond to rather than the word "action".
        if ($this->restful) {
            $action = strtolower(Request::method()).'_'.$method;
        } else {
            $action = "action_{$method}";
        }
        // Here is the override: check for an actual XHR request, prepend 'ajax_' to the controller method to call
        if ( $this->ajaxful && Request::ajax() ) $action = 'ajax_' . $action;
        
        $response = call_user_func_array(array($this, $action), $parameters);

        // If the controller has specified a layout view the response
        // returned by the controller method will be bound to that
        // view and the layout will be considered the response.
        if (is_null($response) and ! is_null($this->layout))  {
          $response = $this->layout;
        }

        return $response;
    }
}