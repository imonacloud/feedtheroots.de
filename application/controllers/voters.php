<?php
/*
* Voters Controller
*/
class Voters_Controller extends Base_Controller {
  const REPORTTYPE_ID = 2;

  //--------------------------------------------------------------------------------------------------
  /**
  * Creates a new voters controller instance 
  *
  * @param  void
  * @return void
  */
  //--------------------------------------------------------------------------------------------------
  public function __construct() {
    $this->filter('before', 'auth');
    parent::__construct();

    // Including asset exclusively for this controler
    Asset::container('footer')->add('voters-js', 'js/voters.js', array('jquery', 'bootstrap-js'));
    Asset::container('footer')->add('jquery-ui-js', 'js/jquery-ui.min.js', array('jquery'));

  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Index controles function. This function shows the voter lists. 
  *
  * @param  void
  * @return View rendered or Json Response
  */
  //--------------------------------------------------------------------------------------------------
  public function action_index() 	{

    // Flash input to the session so we can use the Input::old values
    Input::flash();

    $perPage = 10;
    if(Input::has('perPage') && intval(Input::get('perPage'))>0) {
      $perPage = Input::get('perPage');
      // Save the value in session so we can keep use it when we change it
      Session::put('perPage', $perPage);
    } else if(Session::has('perPage')) {
      $perPage = Session::get('perPage'); 
    }

    // Pagination links setup.
    $pagination = array(
      'perPage' => $perPage
    );

    $search_url_param = '';
    $searched_total_voters = 0;
    $quick_search = '';
    $total_voters = 0;
    $total_my_voters = 0;

    // get all voter's columns available
    $columns = Config::get('columns.voter');

    // get default selected columns for this user
    $selected_columns = Cache::get($this->user->id.'-voter-default-columns', Config::get('columns.voter-default'));

    // get eager loading relations
    // PENDING

    // Create the base model object.
    $query = Voter::order_by('voter_id', 'asc');

    //--------------------------------------------------------
    // If the logged user is not a admin, we have to filter 
    // the user data and show only the data that the user has
    // permission to see/work     
    //--------------------------------------------------------
    if(!$this->user->is_admin) {
    // Filter here.... show only voters that this user has permission to see/work
    }


    //--------------------------------------------------------
    // Get the list to be shown
    //--------------------------------------------------------
    if(Input::has('list-id')) {
      // Get columns for this wiew
      if(Input::has('list-columns')) {
        // Override the default seleted columns
        $selected_columns = unserialize(Input::get('list-columns')); 
      }

      // Apply list filter...  
      $list_filters = unserialize(Input::get('list-filters'));
      if(is_array($list_filters)) {
        foreach($columns as $filter => $property) {
         if(array_key_exists($filter, $list_filters) && $list_filters[$filter]!='') {
           $property['filter']($query, $list_filters);
         }
       }
      }
    }

    //--------------------------------------------------------
    // Override column configuration with the columns passed 
    // as a parameter.
    //--------------------------------------------------------
    if(Input::get('columns')) { 
      $selected_columns = is_array(Input::get('columns')) ? Input::get('columns') : serialize(Input::get('columns'));
      // If the user change the columns for the default list, store columns config in the cache
      if(Input::has('change-columns') && !Input::has('list-id')) {
        Cache::forever($this->user->id.'-voter-default-columns', $selected_columns);
      }
    }


    //--------------------------------------------------------
    // print current list
    //--------------------------------------------------------
    if(Input::has('do_print')) {
      $filters = Input::all();
      $report_name = Input::get('print-name');
      $report_title = Input::get('print-title');
      $orientation = Input::get('print-orientation');
      $paper = Input::get('print-paper');
      $output = Input::get('print-output');

      $report_fields = array(
        'name' => $report_name,
        'title' => $report_title,
        'columns' => serialize($selected_columns),
        'filters' => serialize($filters),
        'reporttype_id' => Reporttype::find(self::REPORTTYPE_ID)->id,
        'user_id' => $this->user->id,
        );

      $report = new Report();

      if($report->validate($report_fields) ) {
        $report = Report::create($report_fields);

        $report_task = new Reporttask(array(
          'orientation' => $orientation,
          'paper' => $paper,
          'output' => $output,
          'status' => 'PN', // Pending
          'user_id' => $this->user->id, // Added user id in this table to speed up queries....
        ));

        $report->tasks()->insert($report_task);

        // Send commant to print
        $basedir = dirname(dirname(dirname(__FILE__)));
        $print_command = sprintf("cd %s; nohup php artisan reporttask %d >/dev/null 2>/dev/null &", $basedir, $this->user->id);
        exec($print_command);
        $this->successes[] = "You request has been sent. Your downloable file will be available soon. You will see a notification when is ready.";
      } else {
        $this->errors = $report->errors();
      }
    }



    //--------------------------------------------------------
    // Here we applied all search criteria to the voter model
    //--------------------------------------------------------
    if(Input::has('do_search') && Input::get('do_search')==1) {
      $input = Input::all();

      //--------------------------------------------------------
      // Save current list
      //--------------------------------------------------------
      if(isset($input['list-save']) && $input['list-save']==1) {
        $filters = $input;
        // Prevent to save the list when want to show it
        unset($filters['list-save']);
        // Prevent to do a search when want to show the list
        unset($filters['do_search']);
        $fields = array(
          'name'        => $input['save-list-name'],
          'columns'     => serialize($selected_columns), 
          'filters'     => serialize($filters), 
          'description' => $input['save-list-description'],
          'user_id'     => $this->user->id,
        );

        $voterlist = new Voterlist;
        if( $voterlist->validate($fields) ) {
          $list = Voterlist::create($fields);
          // Cleanup the cache voter lists so it can be recreated next time
          Cache::forget($this->user->id.'voterlist-list');
          $this->successes[] = "Your list was created successfully.";
        } else {
          $this->errors = $voterlist->errors();
        }
      }

      $pagination['do_search'] = 1;
      
      // Apply all filters to the voters model 
      foreach($columns as $filter => $property) {
        if(Input::get($filter, 0)) {
          $property['filter']($query, $input);
          $pagination[$filter] = Input::get($filter);
        }
      } 

    // If not search need to be done.
    } else {
      if(!Input::has('list-id')) {
        // Flush all of the old input from the session. We don't need to use old input values at this point.
        if(!Input::has('keep_old_input')) {
          Input::flush();
        }
      }
    }

    $voters = $query->paginate($perPage);
    $total_voters = $query->count();
    $total_my_voters = intval($query->where('mine', '=', 'Y')->count());
    $total_no_my_voters = $total_voters - $total_my_voters;

    // refactor selected columns so it contains all columns information: filter, etc.
    $tmp_array = array();
    foreach($selected_columns as $selected_column) {
      if(array_key_exists($selected_column, $columns)) {
        $tmp_array[$selected_column] = $columns[$selected_column];
      }
    }
    $selected_columns = $tmp_array;
    // This never should happens
    if(!is_array($selected_columns)) {
      $this->errors[] = "Error retrieving the columns configs for this list. Please contact your system administrator if the problem persists.";
    }

    // Appends paging information to the voters lists.
    $voters->appends( $pagination )->links();

    // Get all user voter list and save it in the cache
    $voterlists = Cache::remember($this->user->id.'voterlist-list', function(){
       return Voterlist::where('user_id', '=', $this->user->id)->get();
    }, 30);

    //--------------------------------------------------------
    // if the current request is an AJAX request, we return 
    // a json response with a minimal view information.     
    //--------------------------------------------------------
    if ( Request::ajax() ) {     
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

      return Response::json(     
        array( 
          'html'              => Response::view('voters.dialog_list', 
                                  array(
                                    'voters'                => $voters,
                                    'total_voters'          => $total_voters,
                                    'total_my_voters'       => $total_my_voters,
                                    'search_url_param'      => $search_url_param,
                                    'quick_search'          => $quick_search,
                                    //'searched_total_voters' => $searched_total_voters,
                                    'perPage'               => $perPage,
                                    )
                                  )->render(),
          'pagination'        => $voters->links(1),
          'pagination_label'  => Lang::line('pagination.records_label', array(
          'from_record'  => $from_rec,
          'to_record'    => $to_rec,
          'total_record' => $total_voters,
          ))->get(),
        )
      );    

    } else {

      return View::make('voters.list', 
        array(
          'voters'                => $voters,
          'total_voters'          => $total_voters,
          'total_no_my_voters'    => $total_no_my_voters,
          'total_my_voters'       => $total_my_voters,
          'search_url_param'      => $search_url_param,
          'searched_total_voters' => $searched_total_voters,
          'perPage'               => $perPage,

          'voterlists'            => $voterlists,

          'columns'               => $columns,
          'selected_columns'      => $selected_columns,

          'errors'                => $this->errors,
          'successes'             => $this->successes,
          'warnings'              => $this->warnings,
          'messages'              => $this->messages,
          )
        );
    }
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Show voters from a saved-list. 
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_list($id=0, $action='view') 	{

    if($id>0) {
      switch($action) {
        case "del":
        case "delete":
        case "remove":
          $list = Voterlist::where('id', '=', $id) 
                           ->where('user_id', '=', $this->user->id)
                           ->first();
          if($list) {
            $listname =  $list->name;
            $list->delete();
            // Cleanup the cache voter lists so it can be recreated next time
            Cache::forget($this->user->id.'voterlist-list');
            $this->successes[] = "The list <b>{$listname}</b> has been deleted successfully.";
          } else {
            $this->errors[] = "The list that you are trying to delete was not found.";
          }


          break;
        // view is the default action  
        case "view":
        default:
          // Get list info and save it in cache.              
          $list = Voterlist::where('id', '=', $id)
                           ->where('user_id', '=', $this->user->id)
                           ->first();
          
                           
          if($list) {
            // Saving column for this list.
            if(Input::has('change-columns')) {
              if(Input::get('columns')) { 
                $selected_columns = is_array(Input::get('columns')) ? Input::get('columns') : serialize(Input::get('columns'));
                $list->columns = serialize($selected_columns);
                $list->save(); 
                // Because we have modified the list, we delete the value stores in the cache
                // so it can be recreater again
                Cache::forget($this->user->id.'-'.$id.'-voterlist');
              }
            }     

            Input::merge(array(
              'list-id' => $list->id,
              'list-name' => $list->name,
              'list-description' => $list->description,
              'list-filters' => $list->filters,
              'list-columns' => $list->columns,
              'keep_old_input' => true,
            ));
          } else {
            $this->errors[] = "The list that you requested was not found.";
          }
          break;
      }
    }
    return $this->action_index();  
  }

  
  //--------------------------------------------------------------------------------------------------
  /**
  * Show my voters only
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_mine() 	{
    Input::merge(array('do_search' => 1,
      'mine' => 1,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by ethnicity
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_ethnicity($id=0) 	{
    Input::merge(array('do_search' => 1,
      'ethnicity_id' => $id,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by ethnicity group
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_ethnicgroup($id=0) 	{
    Input::merge(array('do_search' => 1,
      'ethnicgroup_id' => $id,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_prime($id=0) 	{
    Input::merge(array('do_search' => 1,
      'prime' => $id,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by gender
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_gender($gender='M') 	{
    Input::merge(array('do_search' => 1,
      'gender' => $gender,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by age
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_age($age=0) 	{
    Input::merge(array('do_search' => 1,
      'age' => $age,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by age range
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_age_range($from=0, $to=0) 	{
    Input::merge(array('do_search' => 1,
      'age_range' => 1,
      'age_from' => $from,
      'age_to' => $to,
      'keep_old_input' => true,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters per pollsite
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_pprime($prime=0, $pollsite_id) 	{
    Input::merge(array('do_search' => 1,
      'prime' => $prime,
      'pollsite_id' => $pollsite_id,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
  * Filter by prime voters by genders
  */   
  //--------------------------------------------------------------------------------------------------
  public function action_pgender($gender='M', $prime=0) 	{
    Input::merge(array('do_search' => 1,
      'gender' => $gender,
      'prime' => $prime,
      )
    );
    return $this->action_index();  
  }

  //--------------------------------------------------------------------------------------------------
  /**
   * Show to 10 building by prime voters
   */   
  //--------------------------------------------------------------------------------------------------
  public function action_pbuilding($prime=0) 	{
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

  //--------------------------------------------------------------------------------------------------
  /**
   * Filter by camvass
   */   
  //--------------------------------------------------------------------------------------------------
  public function action_canvass($id=0, $contacted=null) 	{
    Input::merge(array('do_search' => 1,
      'canvass_id' => $id,
      'canvass_contacted' => $contacted,
      )
    );
    return $this->action_index();  
  }

}