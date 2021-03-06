<?php
/**
 * ----------------------
 * Voter Controller
 * ----------------------
 *
 * All voters are filtered depending on the user permissions. This filter it applied automatically 
 * in the voter model, that's why you don't see any user's data filter here. 
 * Also the voter table is a prefixed table, means that there is one voter table per account.
 * (Prefixing is handler by the model contructor)
 *
 * @author jitz
 */
class Voter_Controller extends Base_Controller {

  // Activating RESTful controller actions, so we can separate the logic of populate and renders form, ect,
  public $restful = true;

  // Activating ajax controller actions, so we can separate the logic of populate and renders form, ect,
  public $ajaxful = true;

  /*
   * Holds the array that will be returned by the ajax call. The array will have the following object format:
   *  object 
   *      (
   *        errors   => string : If any error has occurred this variable will contains the error message in html format.
   *        html     => string : Result of the call in HTML format
   *        callback => string : Callback function that need to be called to connect any jquery object returned in the HTML code.
   *                             if null means that not function has to be called.
   *        .....              : any other variable usefull variables...   
   *      )
   */
  private $ajaxResult = array();


  // Reporttype id for a single voter reports
  const VOTER_REPORTTYPE_CODE = 'VOTER';
  // Reporttype id for a list of voter reports
  const VOTERS_REPORTTYPE_CODE = 'VOTERS';

  // Columns available for the user model/table
  private $columns; 
  // Column to be displayed or included to the print report...
  private $selected_columns;

  // Main eloquent query object
  private $query;

  // Pagination link array
  private $pagination = array();

  // Current list object. Null means that the default list is being used.
  private $list = null;

  
  /**---------------------------------------------------------------------------------------------------------------
	 * Creates a new voter controller instance. In here we just initialize variable.
   *
	 * @param  void
	 * @return void
	 */
  public function __construct() {
    // Make sure that the user is logged in
    $this->filter('before', 'auth');
    
    // protects all post actions from cross-site request forgeries
    $this->filter('before', 'csrf')->on('post');
    
    // Call parent contructor
    parent::__construct();

    // get all user's columns available
    $this->columns = Config::get('voter.columns');
    
    // Voter Model Initialization
    // Set the default eager loading relationships. This eager-loading value will change depending
    // on the selected column that will be show in the list.
    $this->query = Voter::with(array('pollsite', 'assemblydistrict', 'electiondistrict'));


    // ajaxResult initialization
    $this->ajaxResult = array(
      'error'    => '',
      'html'     => '',
      'callback' => '',
      'close'    => 0,
    );

    
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Shows the list of voters or view the detail of a single user pass as a parameter.
   *
   * @param  void
   * @return View rendered or Json Response
   */
  public function get_index($id=0) {
    
    if($id<=0) {
      return Redirect::to_action("voter@list");
    } 
    
    return Redirect::to_action("voter@view", array($id));
  }
  
   /**---------------------------------------------------------------------------------------------------------------
   * Shows the list of voters.
   *
   * @param  $id - List ID, 0 means that the default list will be use
   * @return View rendered or Json Response
   */
  public function get_list($id=0) {
    // Get list to be shown.
    // It won't be null when come from the post method. If it is not null we don't 
    // have to do another query to the database.
    if(is_null($this->list)) { 
      $this->list = Voterlist::find($id);
      if(is_null($this->list)) {
        if($id>0) { $this->errors[] = "The requested list does not exists or you don't have permission to work with. Please contact your system administrator for more informtion."; }
      } else {
        // Override the default seleted columns for the list columns
        $this->selected_columns = $this->list->columns; 
      }  
    }

    // Gets columns to be shown in the list.
    // If is null
    if(is_null($this->selected_columns)) {
      $this->selected_columns = Cache::get(Auth::user()->id.'-voter-list-default-columns', Config::get('voter.default-columns'));  
    }


    // Get eager loading array that will be applied to the model. 
    // This is for doing a less query as possible
    $eagers = array();
    foreach($this->selected_columns as $selected_column) {
      if(array_key_exists($selected_column, $this->columns) && $this->columns[$selected_column]['relationship']) {
        $eagers[] = $this->columns[$selected_column]['relationship'];
      }
    }
    // Recreate voter object with the new eager loading parameter.
    if(count($eagers)>0) {
      $this->query  = Voter::with($eagers);  
    }


    // Apply list filter if any...
    if(!is_null($this->list) && $id>0) {
      $list_filters = $this->list->filters;
      if(is_array($list_filters)) {
        foreach($this->columns as $filter => $property) {
         if(array_key_exists($filter, $list_filters) && $list_filters[$filter]!='') {
           $property['filter']($this->query, $list_filters);
         }
       }
      }
    } 

    // commented by mpeguero. we don't need to order the result for now.
    // order by ID
    //$this->query = $this->query->order_by('id', 'DESC');
    

    $perPage = 10;
    if(Input::has('perPage') && intval(Input::get('perPage'))>0) {
      $perPage = Input::get('perPage');
      Session::put('perPage', $perPage);
    } else if(Session::has('perPage')) {
      $perPage = Session::get('perPage'); 
    }

    // include this value into the pagination links
    $this->pagination['perPage'] = $perPage;
    
    //--------------------------------------------------------
    // Here we applied all search criteria to the voter model
    // This code is in the get method because here we can catch
    // post and get request....
    //--------------------------------------------------------
    if(Input::has('do_search') && Input::get('do_search')==1) {
      Input::flash();
      $this->pagination['do_search'] = 1;

      // Apply all filters to the role model 
      $input = Input::all();

      foreach($this->columns as $filter => $property) {
        // Some filters with value=0 will be acepted
        if(Input::get($filter, null) || Input::get($filter, -1)==='0') {
          $property['filter']($this->query, $input);
          $this->pagination[$filter] = Input::get($filter);
        }
      } 
    } else {
      // If not searching is in progress so we don't need 
      // to keep old input in session.
      Input::flush();
    }  

    //--------------------------------------------------------
    // We if we want to see or work we my voters only
    //--------------------------------------------------------
    if(Input::has('do_my_voters_search')) {
       Input::flash();
       $this->query = $this->query->where_mine('Y');
    } 

    //--------------------------------------------------------
    // We if we want to see or work we my voters only
    //--------------------------------------------------------
    if(Input::has('do_not_my_voters_search')) {
       Input::flash();
       $this->query = $this->query->where('mine', '!=', 'Y');
    }

    
    $voters = $this->query->paginate($perPage);
    $this->query = $this->query->skip(null)->take(null);
    $total_voters = $this->query->count();
    $total_my_voters = intval($this->query->where_mine('Y')->count());
    $total_no_my_voters = $total_voters - $total_my_voters;




    $voters->appends( $this->pagination )->links();

    // refactor selected columns so it contains all columns information: filter, etc.
    $tmp_array = array();
    foreach($this->selected_columns as $selected_column) {
      if(array_key_exists($selected_column, $this->columns)) {
        $tmp_array[$selected_column] = $this->columns[$selected_column];
      }
    }
    $this->selected_columns = $tmp_array;

    // Generate records label.
    $page = 1;
    if(Input::has('page')) {
      $page = Input::get('page');
    }
    if($page<=0) {  $page=1; }
    $from_rec = (($page-1) * $perPage) + 1;
    $to_rec = ($page * $perPage);
    if($to_rec>$total_voters) {
      $to_rec = $total_voters;
    }

    $record_info = '';
    if($to_rec!=0) {
      $record_info = Lang::line('pagination.records_label', array(
                                'from_record'  => number_format($from_rec),
                                'to_record'    => number_format($to_rec),
                                'total_record' => number_format($total_voters),
                              ))->get();
    }
    
    
     
    //--------------------------------------------------------
    // if the current request is an AJAX request, we return 
    // a json response with a minimal view information.     
    //--------------------------------------------------------
    if ( Request::ajax() ) {     
      
      $this->ajaxResult['callback'] = 'votersDlgInit';
      $this->ajaxResult['html'] = Response::view('voter.dialogs.voters', array(
        'voters'                => $voters,
        'total_voters'          => $total_voters,
        'total_my_voters'       => $total_my_voters,
        //'searched_total_voters' => $searched_total_voters,
        'columns'               => $this->columns,
        'selected_columns'      => $this->selected_columns,
        'perPage'               => $perPage,
        'record_info'           => $record_info,
        'page'                  => $page,
    
        'dialog_title'          => Input::get('dialog-title', 'Voters'),
        'dialog_description'    => Input::get('dialog-description', 'List of voters in the selected group.'),
        'dialog_url'            => Input::get('dialog-url', URL::to_action('voter@list')),
      ))->render();  

      return Response::json($this->ajaxResult);

    } else {
      return View::make('voter.list', 
        array(
          'list'                  => $this->list,
          'voters'                => $voters,
          'total_voters'          => $total_voters,
          'total_no_my_voters'    => $total_no_my_voters,
          'total_my_voters'       => $total_my_voters,
          'perPage'               => $perPage,

          'voterlists'            => Voterlist::get(),

          'columns'               => $this->columns,
          'selected_columns'      => $this->selected_columns,

          'record_info'           => $record_info,
          )
        );
    }

    

  }

  /**---------------------------------------------------------------------------------------------------------------
   * Sets default columns, prints, etc...
   *
   * @param  $id - List ID, 0 means that the default list will be use
   * @return View rendered or Json Response
   */
  public function post_list($id=0) {
    // get list to be shown
    $this->list = Voterlist::find($id);
    if(is_null($this->list)) {
      if($id>0) { $this->errors[] = "The requested list does not exists or you don't have permission to work with. Please contact your system administrator for more informtion."; }
    } else {
      // Override the default seleted columns for the list columns
      $this->selected_columns = $this->list->columns; 
    }  

    // Gets columns to be shown in the list.
    if(is_null($this->selected_columns)) {
      $this->selected_columns = Cache::get(Auth::user()->id.'-voter-list-default-columns', Config::get('voter.default-columns'));  
    }

    //--------------------------------------------------------
    // Get columns passed as parameter
    //--------------------------------------------------------
    if(Input::has('do-change-columns')) { 
      $this->selected_columns = is_array(Input::get('columns')) ? Input::get('columns') : unserialize(Input::get('columns'));
      if( ! is_null($this->list) ) {
        // Save list changes to the selected list.
        $this->list->columns = $this->selected_columns;
        $this->list->save();
        $this->successes[] = "List's columns have been updated successfully.";
      } else {
        // Save the list changes to the default list
        Cache::forever(Auth::user()->id.'-voter-list-default-columns', $this->selected_columns);
      }
    }



    //--------------------------------------------------------
    // Save current list
    //--------------------------------------------------------
    if(Input::has('do-list-save')) {
      $filters = Input::all();

      // Check fi the new list is being created based on another list.
      if( ! is_null($this->list)) {
        // add the list filter to the search filter
        $filters = array_merge($filters, $this->list->filters);
      }


      if(Input::has('do_my_voters_search')) {
        $filters = array_merge($filters, array('mine'=>1)); 
      }
      
      // Prevent to do a search after saving the list....
      //unset($filters['do_search']);

      $fields = array(
        'name'        => Input::get('save-list-name'),
        'columns'     => serialize($this->selected_columns), 
        'filters'     => serialize($filters), 
        'description' => Input::get('save-list-description'),
        'user_id'     => Auth::user()->id,
      );

      $voterlist = new Voterlist;
      if( $voterlist->validate($fields) ) {
        if($id>0 && ! Input::has('save-as-new-list')) {
          Voterlist::where('id', '=', $id)->update($fields);
          $this->successes[] = "Voter list has been updated successfully.";
        } else {
          $this->list = $voterlist->create($fields);  
          $this->successes[] = "Voter list has been created successfully.";
          $id = $this->list->id;
        }
        // Cleanup the cache voter lists so it can be recreated next time
        Cache::forget(Auth::user()->id.'-voterlist-list');
        
      } else {
        $this->errors = $voterlist->errors();
      }
    }


    //--------------------------------------------------------
    // Print current list
    //--------------------------------------------------------
    if(Input::has('do_print')) {

      $filters = array();
      $reporttype_id = Reporttype::where_code(Voter_Controller::VOTERS_REPORTTYPE_CODE)->first()->id;

      if(Input::get('do_print')==2) {
        $filters['id'] = Input::get('print-id', 0);
        $reporttype_id = Reporttype::where_code(Voter_Controller::VOTER_REPORTTYPE_CODE)->first()->id;
      } else {
        $filters = Input::all();  
        // Check if want to print a list.
        if( ! is_null($this->list) ) {
          $filters = array_merge($filters, $this->list->filters);
        }
      }

      if(Input::has('do_my_voters_search')) {
        $filters = array_merge($filters, array('mine'=>1)); 
      }
      
      $report_name = Input::get('print-name');
      $report_title = Input::get('print-title');
      $orientation = Input::get('print-orientation');
      $paper = Input::get('print-paper');
      $output = Input::get('print-output');

      $reporttypetemplate_id = Input::get('print-template');

      $report_fields = array(
        'name' => $report_name,
        'title' => $report_title,
        'columns' => $this->selected_columns,
        'filters' => $filters,
        'reporttype_id' => $reporttype_id,
        'user_id' => Auth::user()->id,
      );

      $report = new Report();

      if($report->validate($report_fields) ) {
        $report = $report->create($report_fields);

        $basedir = path('base');
        $command = sprintf("cd %s; nohup php artisan reporttask %d >/dev/null 2>/dev/null &", $basedir, Auth::user()->id);

        $report_task = new Reporttask(array(
          'orientation' => $orientation,
          'paper' => $paper,
          'output' => $output,
          'status' => 'PN', // Pending
          'command' => $command,
          'user_id' => Auth::user()->id, // Added user id in this table to speed up queries....
          'reporttypetemplate_id' => $reporttypetemplate_id, // Template to be use to print this list.
        ));

        $report->tasks()->insert($report_task);

        // Send commant to print
        exec($command);

        $this->successes[] = "You request has been sent. Your downloable file will be available soon. You will see a notification when is ready.";
      } else {
        $this->errors = $report->errors();
      }
    }
    
    // Show the list...
    return $this->get_list($id);
  }


  
  /**---------------------------------------------------------------------------------------------------------------
   * Shows all voters that are marked as my voters
   *
   * @param  $id - List ID, 0 means that the default list will be use
   * @return View rendered or Json Response
   */
  public function get_my_list($id=0)   {
    // The only thing we have to do is activate my-voters filter criteria
    Input::merge(array(
      'do_my_voters_search' => 1,
      )
    );
    // Show the list.
    return $this->get_list($id);  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Sets default columns, prints, etc...
   *
   * @param  $id - List ID, 0 means that the default list will be use
   * @return View rendered or Json Response
   */
  public function post_my_list($id=0)   {
    // The only thing we have to do is activate my-voters filter criteria
    Input::merge(array(
      'do_my_voters_search' => 1,
      )
    );
    // Show the list.
    return $this->post_list($id);  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter information. This method is being called from ajax.
   *
   * @param  $id - Voter Id
   * @return View rendered or Json Response
   */
  public function post_get($id) {

    if ( Request::ajax() ) {
      $voter = $this->query->find($id);
      if(is_null($voter)) {
         Response::json(null);
      }
      return Response::eloquent($voter);
    }  else {
      return Redirect::to_action('voter@view', array($id));
    }  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Show voter quick-view information
   *
   * @param  $id - Voter Id
   * @return View rendered or Json Response
   */
  /*
  public function post_quick_view($id) {

   if ( Request::ajax() ) {
      $voter = $this->query->find($id);
      
      return Response::json(     
        array( 
          'html' => Response::view('voter.quick-view-form', array('voter' => $voter))->render(),
        )
      ); 
    }  else {
      return Redirect::to_action('voter@view', array($id));
    }  
  }
  */




  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by ethnicity
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_ethnicity($id=0)   {
    Input::merge(array('do_search' => 1,
      'ethnicity_id' => $id,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by ethnicity group
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_ethnicgroup($id=0)   {
    Input::merge(array('do_search' => 1,
      'ethnicgroup_id' => $id,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }
  */

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_prime($id=0)   {
    Input::merge(array('do_search' => 1,
      'prime' => $id,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by gender
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_gender($gender='M')  {
    Input::merge(array('do_search' => 1,
      'gender' => $gender,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by age
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_age($age=0)  {
    Input::merge(array('do_search' => 1,
      'age' => $age,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by age range
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_age_range($from=0, $to=0)  {
    Input::merge(array('do_search' => 1,
      'age_range' => 1,
      'age_from' => $from,
      'age_to' => $to,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters per pollsite
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_pprime($prime=0, $pollsite_id)   {
    Input::merge(array('do_search' => 1,
      'prime' => $prime,
      'pollsite_id' => $pollsite_id,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters by genders
  */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_pgender($gender='M', $prime=0)   {
    Input::merge(array('do_search' => 1,
      'gender' => $gender,
      'prime' => $prime,
      )
    );
    return $this->action_index();  
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
   * Show to 10 building by prime voters
   */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_pbuilding($prime=0)  {
    $query = array();

    if($prime>0) {
      $query = Voter::where('prime'.$prime, '=', 'Y');
    } else {
      $query = Voter::where(function($query){
        $query->where('prime1',  '=', 'Y');
        $query->or_where('prime2',  '=', 'Y');
        $query->or_where('prime3',  '=', 'Y');
      });
    } 

    $top_ten_building = $query->group_by('state')
                              ->group_by('zip')
                              ->group_by('city')
                              ->group_by('street_name')
                              ->group_by('street_suffix')
                              ->group_by('house_number')
                              ->order_by(DB::raw('COUNT(0)'), 'DESC')
                              ->take(10)
                              ->get(array('state',
                                          'zip',
                                          'city',
                                          'street_name',
                                          'street_suffix',
                                          'house_number',
                                          DB::raw('COUNT(0) as counted')
                                    )
                                );

    if ( Request::ajax() ) {
      return Response::json(     
        array( 
          'html'              => Response::view('voters.dialogs.top10-building', 
                                  array(
                                    'top_ten_building'                => $top_ten_building,
                                    )
                                  )->render(),
          )
        );        
    }     
    return null;
  }
  */
  //--------------------------------------------------------------------------------------------------
  /**
   * Filter by camvass
   */   
  //--------------------------------------------------------------------------------------------------
  /*
  public function action_canvass($id=0, $contacted=null)  {
    Input::merge(array('do_search' => 1,
      'canvass_id' => $id,
      'canvass_contacted' => $contacted,
      )
    );
    return $this->action_index();  
  }
  */




































  /**---------------------------------------------------------------------------------------------------------------
   * Views a single voter information
   *
   * @param  void
   * @return View rendered or Json Response
   */
  public function get_view($id) 	{
    $voter = Voter::with(array('status', 'ethnicity', 'ethnicgroup', 'party', 'maritalstatus', 'religion',
                                  'language', 'occupation', 'educationlevel', 'incomelevel', 'householdincomelevel',
                                  'timezone'
                                  ))->find($id);
    if(is_null($voter)) {
      $this->errors[] = "The voter with id={$id} was not found or you don't have permission to view it. Please contact your system administrator for more informtion."; 
      Session::put('errors', serialize($this->errors));
      Redirect::to_action('voter@list');
    } 
    
    return View::make('voter.view', array(
                          'voter' => $voter,
                      ));  
  }


  /**---------------------------------------------------------------------------------------------------------------
   * Delete a voter-list.
   *
   * @param  $id - List ID
   * @return View rendered
   */
  public function post_delete_list($id) {
    // get list to be deleted
      $this->list = Voterlist::find($id);
      if(is_null($this->list)) {
        $this->errors[] = "The requested list does not exists or you don't have permission to work with. Please contact your system administrator for more informtion.";
      } else {
        $listname =  $this->list->name;
        $this->list->delete();
        // Cleanup the cache voter lists so it can be recreated next time
        Cache::forget($this->user->id.'-voterlist-list');
        // Clean up list selected item so it can be assigned with the default column
        $this->selected_columns = null;
        // Free list variable memory (I'm doing this because I don't now if the delete method unset the model)
        $this->list=null; 
        $this->successes[] = "The list <b>{$listname}</b> has been deleted successfully.";
      }    
      
      // Show the default list.
      return $this->get_list();
  }

  /**---------------------------------------------------------------------------------------------------------------
   * redirect request to the default list because we don't support delete list by get action.
   *
   * @param  $id - List ID
   * @return View rendered
   */
  public function get_delete_list($id) {
    return $this->get_list($id);
  }

  //---------------------------------------------------------------------------------------------------------------
  //   AJAX METHODS
  //---------------------------------------------------------------------------------------------------------------

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter quick information dialog
   *
   * @param  $id - Voter Id
   * @return Json Response
   */
  public function ajax_get_quick_view($id) {
    $voter = $this->query->where('id', '=', $id)->first();
    if(is_null($voter)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The voter couldn't be found or you don't have permission to see, update, print or work with it at all. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $logs = Audvotercontacthistory::where('voter_id', '=', $voter->id)->get();

    $this->ajaxResult['callback'] = 'voterQuickViewDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.quick-view', array('voter' => $voter, 'logs' => $logs))->render();  
    return Response::json($this->ajaxResult);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter print list dialog
   *
   * @param  $id - Voter Id
   * @return Json Response
   */
  public function ajax_get_print_list() {
    $this->ajaxResult['callback'] = 'printDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.print', array('templates' => Voter_Controller::VoterListTemplates()))->render();  
    return Response::json($this->ajaxResult);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter print dialog
   *
   * @param  $id - Voter Id
   * @return Json Response
   */
  public function ajax_get_print($id) {
    $voter = $this->query->where('id', '=', $id)->first();
    if(is_null($voter)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The voter couldn't be found or you don't have permission to see, update, print or work with it at all. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $this->ajaxResult['callback'] = 'printDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.print', array(
        'templates' => Voter_Controller::VoterTemplates(),
        'voter'     => $voter,
      ))->render();  
    
    return Response::json($this->ajaxResult);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets voter columns dialog
   *
   * @param  $id - List ID
   * @return Json Response
   */
  public function ajax_get_columns($id=0) {
    $this->list = Voterlist::find($id);
    if(is_null($this->list)) {
      $this->selected_columns = Cache::get(Auth::user()->id.'-voter-list-default-columns', Config::get('voter.default-columns'));  
    } else {
      // Override the default seleted columns for the list columns
      $this->selected_columns = $this->list->columns; 
    }  

    // refactor selected columns so it contains all columns information: filter, etc.
    $tmp_array = array();
    foreach($this->selected_columns as $selected_column) {
      if(array_key_exists($selected_column, $this->columns)) {
        $tmp_array[$selected_column] = $this->columns[$selected_column];
      }
    }
    $this->selected_columns = $tmp_array;

    $this->ajaxResult['callback'] = 'columnsDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.columns', array(
        'columns'          => $this->columns,
        'selected_columns' => $this->selected_columns,
      ))->render();  
    
    return Response::json($this->ajaxResult);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets save voter-list dialog
   *
   * @param  void
   * @return Json Response
   */
  public function ajax_get_save_list($id=0) {
    $this->list = Voterlist::find($id);
    
    $this->ajaxResult['callback'] = 'saveVoterListDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.save-list', array(
        'list' => $this->list,
      ))->render();  
    
    return Response::json($this->ajaxResult);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets delete voter-list dialog
   *
   * @param  int - $id: ID of the list to be deleted.
   * @return Json Response
   */
  public function ajax_get_delete_list($id=0) {
    $this->list = Voterlist::find($id);
    if(is_null($this->list)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested list couldn't be found or you don't have permission to delete. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    } 
    
    $this->ajaxResult['callback'] = 'deleteVoterListDlgInit';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.delete-list', array(
        'list' => $this->list,
    ))->render();  
    
    return Response::json($this->ajaxResult);
  }


  
  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters by ethnicity group
   *
   * @param  int - $id: ethnicity group id
   * @return Json Response
   */
  public function ajax_get_ethnicgroup($id=0) {
    $ethnicgroup = Ethnicgroup::find($id);
    $title = 'Voters by ethnicity group: Unknow';
    $description = 'List of voters by ethnicity group.';
    if( ! is_null($ethnicgroup) ) {
      $title = 'Voters - '.$ethnicgroup->name;
    } 

    Input::merge(array('do_search' => 1,
      'ethnicgroup_id'     => $id,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@ethnicgroup', array($id)),
      )
    );
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'ethnicity_id', 'language_id', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters by prime-voters
   *
   * @param  int - $id: prime type.
   * @return Json Response
   */
  public function ajax_get_prime($id=0) {
    $title = 'All Prime Voters';
    $description = 'List of voters by prime-voters.';
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime1', 'prime2', 'prime3', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    if($id == 1) {
      $title = 'Prime Voters';
    } else if($id == 2) {
      $title = 'Double Prime Voters';
    } else if($id == 3) {
      $title = 'Triple Prime Voters';
    }

    if($id>=0 && $id<=3) {
      $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime'.$id,'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    } 

    Input::merge(array('do_search' => 1,
      'prime'              => $id,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@prime', array($id)),
      )
    );
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters by gender.
   *
   * @param  Gender Id - M: Male, F: Female
   * @return Json Response
   */
  public function ajax_get_gender($id='M') {
    
    $title = 'Voters';
    $description = 'List of voters by gender.';
    if($id == 'M') {
      $title = 'Male Voters';
    } else if($id == 'F') {
      $title = 'Female Voters';
    }

    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'gender', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    
    Input::merge(array('do_search' => 1,
      'gender'              => $id,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@gender', array($id)),
      )
    );
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters by Poll site with more primes voters
   *
   * @param  int - $prime: prime type.
   * @param  int - $pollsite_id: Pollsite Id.
   * @return Json Response
   */
  public function ajax_get_prime_pollsite($prime, $pollsite_id) {
    $title = 'All Prime Voters';
    $description = 'List of voters by Poll site with more primes voters.';
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime1', 'prime2', 'prime3', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    if($prime == 1) {
      $title = 'Prime Voters';
    } else if($prime == 2) {
      $title = 'Double Prime Voters';
    } else if($prime == 3) {
      $title = 'Triple Prime Voters';
    }

    $pollsite = Pollsite::find($pollsite_id);
    if( ! is_null($pollsite) ) {
      $title .= ' in "'.$pollsite->name.'"';
    } 


    if($prime>=0 && $prime<=3) {
      $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime'.$prime,'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    } 

    Input::merge(array('do_search' => 1,
      'prime'              => $prime,
      'pollsite_id'        => $pollsite_id,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@prime_pollsite', array($prime, $pollsite_id)),
      )
    );
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters by age range.
   *
   * @param  int - $from_age: Initial age range
   * @param  int - $to_age: End age range
   * @return Json Response
   */
  public function ajax_get_age_range($from=0, $to=0) {
    $title = 'Voters from age '.$from;
    $description = 'List of voters by age range.';
    
    if($to>0) {
      $title .= ' to '.$to;
    } else {
      $title .= ' or more';
    }

    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'birthdate' ,'age', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    
    Input::merge(array('do_search' => 1,
      'age_from'           => $from,
      'age_to'             => $to,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@age_range', array($from, $to)),
      )
    );
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of voters that the user can see
   *
   * @param  int - $from_age: Initial age range
   * @param  int - $to_age: End age range
   * @return Json Response
   */
  public function ajax_get_voters() {
    $title = 'Voters';
    $description = 'List of voters in my account.';
    Input::merge(array(
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@voters'),
      )
    );
    
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    
    return $this->get_list();  
  }


  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of my voters
   *
   * @param  void
   * @return Json Response
   */
  public function ajax_get_mine() {
    $title = 'Voters';
    $description = 'List of voters in my account.';
  
    Input::merge(array('do_search' => 1,
      'mine'               => 1,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@mine'),
      )
    );
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of prime male voters
   *
   * @param  void
   * @return Json Response
   */
  public function ajax_get_prime_gender($prime, $gender) {
    $title = 'All Prime';
    $description = 'that are more likely to vote.';
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime1', 'prime2', 'prime3', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    
    if($prime == 1) {
      $title = 'Prime';
    } else if($prime == 2) {
      $title = 'Double Prime';
    } else if($prime == 3) {
      $title = 'Triple Prime';
    } 

    if($gender=='M') {
      $title .= ' Male Voters';
      $description = 'Male '.$description;
    } else if($gender=='F') {
      $title .= ' Female Voters';
      $description = 'Female '.$description;
    } else {
      $title .= ' Voters';
      $description = 'Voters '.$description;
    }

    if($prime>=1 && $prime<=3) {
      $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime'.$prime,'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    } 

    Input::merge(array('do_search' => 1,
      'prime'              => $prime,
      'gender'             => $gender,
      'perPage'            => 10,
      'dialog-title'       => $title,
      'dialog-description' => $description,
      'dialog-url'         => URL::to_action('voter@prime_gender', array($prime, $gender)),
      )
    );
    
    return $this->get_list();  
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets top 10 building with more prime voters
   *
   * @param  $prime        Prime Voter Flag: 1-->Prime Voter, 2-->Double Prime, 3-->Triple Prime
   * @return $ajaxResult   Json Response Object
   */
  public function ajax_get_prime_building($prime=0)  {
    $title = 'All Prime';
    $description = 'Prime top 10 building in my account.';
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime1', 'prime2', 'prime3', 'phone_number', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    
    if($prime == 1) {
      $title = 'Prime';
    } else if($prime == 2) {
      $title = 'Double Prime';
    } else if($prime == 3) {
      $title = 'Triple Prime';
    } 

    $title .= ' Top 10 Building';

    if($prime>0 && $prime<=3) {
      $this->query = $this->query->where('prime'.$prime, '=', 'Y');
    } else {
      $this->query = $this->query->where(function($query){
        $query->where('prime1',  '=', 'Y');
        $query->or_where('prime2',  '=', 'Y');
        $query->or_where('prime3',  '=', 'Y');
      });
    } 

    $top_ten_building = $this->query->group_by('state')
                              ->group_by('zip')
                              ->group_by('city')
                              ->group_by('street_name')
                              ->group_by('street_suffix')
                              ->group_by('house_number')
                              ->order_by(DB::raw('COUNT(0)'), 'DESC')
                              ->take(10)
                              ->get(array('state',
                                          'zip',
                                          'city',
                                          'street_name',
                                          'street_suffix',
                                          'house_number',
                                          DB::raw('COUNT(0) as counted')
                                    )
                                );

    $this->ajaxResult['callback'] = '';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.top10-prime-building', array(
        'top_ten_building'   => $top_ten_building,
        'dialog_title'       => $title,
        'dialog_description' => $description,
      ))->render();  

    return Response::json($this->ajaxResult); 
    
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets list of top 10 building with more voters
   *
   * @param  void
   * @return Json Response
   */
  public function ajax_get_voters_building()  {
    $title = 'Building with more voters';
    $description = 'Top 10 building with more voters.';
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'prime1', 'prime2', 'prime3', 'phone_number', 'assemblydistrict_id', 'pollsite_id', 'electiondistrict_id');
    
    $top_ten_building = $this->query->group_by('state')
                              ->group_by('zip')
                              ->group_by('city')
                              ->group_by('street_name')
                              ->group_by('street_suffix')
                              ->group_by('house_number')
                              ->order_by(DB::raw('COUNT(0)'), 'DESC')
                              ->take(10)
                              ->get(array('state',
                                          'zip',
                                          'city',
                                          'street_name',
                                          'street_suffix',
                                          'house_number',
                                          DB::raw('COUNT(0) as counted')
                                    )
                                );

    $this->ajaxResult['callback'] = '';
    $this->ajaxResult['html'] = Response::view('voter.dialogs.top10-voters-building', array(
        'top_ten_building'   => $top_ten_building,
        'dialog_title'       => $title,
        'dialog_description' => $description,
      ))->render();  

    return Response::json($this->ajaxResult); 
    
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets list of my voters that belongs to a phonebanking.
   *
   * @param  int $id        Phone Banking ID
   * @param  string $result Phone banking result. Possible values: contacted, callresult and nonprocessed
   * @param  int $result_id Contact result id or call result id.
   * @return Json Response
   */
  public function ajax_get_phonebanking_voters($id, $result='all', $result_id=0) {
    // Commented by mpeguero. Do not eager load voters model to prevent memory exhasted.
    // A phone banking can have lot of voters assigned to it.
    //$phonebanking = Phonebanking::with(array('voters', 'user'))
    $phonebanking = Phonebanking::with(array('user'))
                                ->where('id', '=', $id)
                                ->where(function($query) {
                                  $query->where('user_id', '=', Auth::user()->id);
                                })->first();
    
    if(is_null($phonebanking)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested phone banking couldn't be found or you don't have permission to see its voters. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $title = 'Voters';
    $description = 'Voters in this phone banking ['.$phonebanking->name.']';

    //$voters = null;
    if($result=='contacted') {
      $title = 'Contacted Voters';
      $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'phonebankingcontactresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
      //$voters = $phonebanking->voters()->where_not_null('phonebankingcontactresult_id');
      
      if($result_id>0) {
         //$voters = $voters->where('phonebankingcontactresult_id', '=', $result_id);
       }

    } else if($result=='callresult') {
       $title = 'Called but not contacted Voters';
       $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'phonebankingcallresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
       //$voters = $phonebanking->voters()->where_not_null('phonebankingcallresult_id');
       
       if($result_id>0) {
         //$voters = $voters->where('phonebankingcallresult_id', '=', $result_id);
       }

    } else if($result=='nonprocessed') {
      $title = 'Nonprocessed Voters';
      //$voters = $phonebanking->voters()->where_null('phonebankingcontactresult_id')->where_null('phonebankingcallresult_id');
    } else {
      //$voters = $phonebanking->voters();
      $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'phonebankingcallresult_id', 'phonebankingcontactresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    }

    //$voters_id = $voters->lists('id');
    
    // Is not voter found we have to make the voter filter return 0 as well.
    //if(count($voters_id)<=0) {
    //  $voters_id[] = -1;
    //}

    $inputs = array('do_search' => 1,
      //'id'                 => $voters_id,
      'phonebanking_id'        => $id,
      'phonebanking_result'    => $result,
      'phonebanking_result_id' => $result_id,
      'perPage'                => 10,
      'dialog-title'           => $title,
      'dialog-description'     => $description,
      'dialog-url'             => URL::to_action('voter@phonebanking_voters', array($id, $result, $result_id)),
      );

    

    Input::merge($inputs);

    // override default eager loading relationships
    $this->query = Voter::with(array('phonebankings', 'pollsite', 'assemblydistrict', 'electiondistrict'));
    
    return $this->get_list();  
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list of my voters that belongs to a canvass.
   *
   * @param  int - $id : Phone Banking ID
   * @param  string - $result : phone banking result. Possible values: contacted, callresult and nonprocessed
   * @param  int - $result_id : contact result id or call result id.
   * @return Json Response
   */
  public function ajax_get_canvass_voters($id, $result='all', $result_id=0) {
    // Commented by mpeguero. Do not eager load voters model to prevent memory exhasted.
    // A Canvass can have lot of voters assigned to it.
    //$canvass = Canvass::with(array('voters', 'user'))
    $canvass = Canvass::with(array('user'))
                                ->where('id', '=', $id)
                                ->where(function($query) {
                                  $query->where('user_id', '=', Auth::user()->id);
                                  $query->raw_or_where("EXISTS (SELECT 1 FROM canvass_user cu WHERE canvasses.id = cu.canvass_id AND cu.user_id = ?)", array(Auth::user()->id));
                                })->first();

    
    if(is_null($canvass)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested canvass couldn't be found or you don't have permission to see its voters. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $title = 'Voters';
    $description = 'Voters in this canvass ['.$canvass->name.']';

    //$voters = null;
    if($result=='contacted') {
      $title = 'Contacted Voters';
      $this->selected_columns = array('canvass_select', 'photo', 'voter_id', 'fullname', 'fulladdress', 'canvasscontactresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
      //$voters = $phonebanking->voters()->where_not_null('phonebankingcontactresult_id');
      
      if($result_id>0) {
         //$voters = $voters->where('phonebankingcontactresult_id', '=', $result_id);
       }

    } else if($result=='not_home') {
       $title = 'Not contacted Voters';
       $this->selected_columns = array('canvass_select', 'photo', 'voter_id', 'fullname', 'fulladdress', 'canvassnothomeresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
       //$voters = $phonebanking->voters()->where_not_null('phonebankingcallresult_id');
       
       if($result_id>0) {
         //$voters = $voters->where('phonebankingcallresult_id', '=', $result_id);
       }

    } else if($result=='nonprocessed') {
      $title = 'Nonprocessed Voters';
      $this->selected_columns = array('canvass_select', 'photo', 'voter_id', 'fullname', 'fulladdress', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
      //$voters = $phonebanking->voters()->where_null('phonebankingcontactresult_id')->where_null('phonebankingcallresult_id');
    } else {
      //$voters = $phonebanking->voters();
      $this->selected_columns = array('canvass_select', 'photo', 'voter_id', 'fullname', 'fulladdress', 'canvasscontactresult_id', 'canvassnothomeresult_id', 'electiondistrict_id', 'assemblydistrict_id', 'pollsite_id');
    }

    $inputs = array('do_search' => 1,
      'canvass_id'             => $id,
      'canvass_result'         => $result,
      'canvass_result_id'      => $result_id,
      'perPage'                => 10,
      'dialog-title'           => $title,
      'dialog-description'     => $description,
      'dialog-url'             => URL::to_action('voter@canvass_voters', array($id, $result, $result_id)),
      );

    
    Input::merge($inputs);

    // override default eager loading relationships
    $this->query = Voter::with(array('canvasses', 'pollsite', 'assemblydistrict', 'electiondistrict'));
    
    return $this->get_list();  
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets list of voters by Assembly District
   *
   * @param  int - $id: assembly district id
   * @return Json Response
   */
  public function ajax_get_assemblydistrict($id) {
    $assemblydistrict = Assemblydistrict::find($id);
    
    if(is_null($assemblydistrict)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested assembly district couldn't be found or you don't have permission to work with this. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $title = 'Voters';
    $description = 'Voters in the Assembly District #'.$assemblydistrict->number;
    
    Input::merge(array('do_search' => 1,
      'assemblydistrict_id' => $id,
      'perPage'             => 10,
      'dialog-title'        => $title,
      'dialog-description'  => $description,
      'dialog-url'          => URL::to_action('voter@assemblydistrict', array($id)),
      )
    );
    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'assemblydistrict_id', 'pollsite_id', 'electiondistrict_id', );
    return $this->get_list();  
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets list of voters by Pollsite
   *
   * @param  int - $pollsite_id: Pollsite ID
   * @param  int - $assemblydistrict_id: Assembly District ID
   * @return Json Response
   */
  public function ajax_get_pollsite($pollsite_id, $assemblydistrict_id=0) {
    $pollsite = Pollsite::find($pollsite_id);
    
    if(is_null($pollsite)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested pollsite couldn't be found or you don't have permission to work with this. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $title = 'Voters';
    $description = 'Voters in the poll site <strong>'.$pollsite->name.'</strong>';
    
    $inputs = array('do_search' => 1,
      'pollsite_id'         => $pollsite_id,
      'perPage'             => 10,
      'dialog-title'        => $title,
      'dialog-description'  => $description,
      'dialog-url'          => URL::to_action('voter@pollsite', array($pollsite_id, $assemblydistrict_id)),
      );

    if($assemblydistrict_id>0) {
      $inputs['assemblydistrict_id'] = $assemblydistrict_id;
    }

    Input::merge($inputs);

    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'assemblydistrict_id', 'pollsite_id', 'electiondistrict_id', );
    return $this->get_list();  
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets list of voters by Election District
   *
   * @param  int - $electiondistrict_id: Election District ID
   * @param  int - $pollsite_id: Pollsite ID
   * @param  int - $assemblydistrict_id: Assembly District ID
   * @return Json Response
   */
  public function ajax_get_electiondistrict($electiondistrict_id, $pollsite_id=0, $assemblydistrict_id=0) {
    $electiondistrict = Electiondistrict::find($electiondistrict_id);
    
    if(is_null($electiondistrict)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = Response::view('voter.dialogs.error', array(
        'text' => "The requested election district couldn't be found or you don't have permission to work with this. Contact your system administrator for more information.",
      ))->render();
      return Response::json($this->ajaxResult);
    }

    $title = 'Voters';
    $description = 'Voters in the election district #'.$electiondistrict->number;
    
    $inputs = array('do_search' => 1,
      'electiondistrict_id'         => $electiondistrict_id,
      'perPage'             => 10,
      'dialog-title'        => $title,
      'dialog-description'  => $description,
      'dialog-url'          => URL::to_action('voter@pollsite', array($pollsite_id, $assemblydistrict_id)),
      );

    if($pollsite_id>0) {
      $inputs['pollsite_id'] = $pollsite_id;
    }

    if($assemblydistrict_id>0) {
      $inputs['assemblydistrict_id'] = $assemblydistrict_id;
    }

    Input::merge($inputs);

    $this->selected_columns = array('photo', 'voter_id', 'fullname', 'phone_number', 'assemblydistrict_id', 'pollsite_id', 'electiondistrict_id', );
    return $this->get_list();  
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Applies changes to the voter record.
   *
   * @param  void
   * @return View rendered or Json Response
   */
  
  public function ajax_post_set_proterty()   {
    $voter_id = Input::get('voter_id', 0);

    $voter = Voter::find($voter_id);

    if(is_null($voter)) {
      $this->ajaxResult['callback'] = '';
      $this->ajaxResult['error'] = "An unexpected error has occurred. Please refresh your browser and try again. If the problem persist please contact your system administrator.";
      return Response::json($this->ajaxResult);
    } 
    
    $property = Input::get('pk');
    $value = Input::get('value', null);
    
    // blank value need to be converted to null to prevent constrain error
    if($value=='') {
      $value = null;
    }

    $voter->$property = $value;
    $voter->save();

    $this->ajaxResult['callback'] = '';
    $this->ajaxResult['html'] = "<i class='icofont-ok'></i> New value has been updated successfully.";
    return Response::json($this->ajaxResult);
  }




  //---------------------------------------------------------------------------------------------------------------
  //   GENERAL METHODS
  //---------------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets the list of template available for user schema
   *
   * @param  void
   * @return Array
   */
  public static function VoterTemplates() {
    
    $reporttype = Reporttype::where_code(Voter_Controller::VOTER_REPORTTYPE_CODE)->first();

    if(is_null($reporttype)) {
      return null;
    }
    return $reporttype->templates()->lists('name', 'id');
  }

  //---------------------------------------------------------------------------------------------------------------
  /**
   * Gets the list of template available for user schema
   *
   * @param  void
   * @return Array
   */
  public static function VoterListTemplates() {
    
    $reporttype = Reporttype::where_code(Voter_Controller::VOTERS_REPORTTYPE_CODE)->first();

    if(is_null($reporttype)) {
      return null;
    }
    
    return $reporttype->templates()->lists('name', 'id');
  }
}