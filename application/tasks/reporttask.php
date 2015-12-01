<?php 
/*
 * Processes pending report task on demand by user.
 */
class Reporttask_Task {


  // Main eloquent query object
  private $voterreportquery;

  
  /**
   * Default method. Process pending report request.
   */   
  public function run($arguments) {

    //set_time_limit(0);
    //ini_set('memory_limit', '-1');
    
    // Process pending requests only
    $pendingReportTasks = Reporttask::where_status('PN')
                            ->order_by('id', 'ASC');
    
    /*
     * Runs pending report task for a specific user
     */     
    if(is_array($arguments) && count($arguments)==1) {
      $arg0 = $arguments[0];
      $user_id = 0;
      if(is_numeric($arg0)) {
        // User Id was passed
        $user = User::find($arg0);
        if($user) {
          $user_id = $user->id;
        } else {
          throw new Exception("No user was found with id={$arg0}");
        } 
      } else {
        $user = User::where_email($arg0)->first();
        if($user) {
          $user_id = $user->id;
        } else {
          throw new Exception("No user was found with email={$arg0}");
        }
      }
      
      $pendingReportTasks = $pendingReportTasks->where('user_id', '=', $user_id); 
    }
    
    $pendingReportTasks = $pendingReportTasks->get();
    
    foreach($pendingReportTasks as $task) {
       $task->status = 'RU';
       $task->status_text = "Running...";
       $task->save(); 
     
       $filename = tempnam(path('storage').'tmp/', "reporttask_".$task->id."_");
       // Deletes the file that was just created. We just need the file name.
       unlink($filename);
       $filename .= '.html'; // output file has to be html.
       $pdf_filename = str_replace('.html', '.'.$task->output, $filename);

       /*
        * Login without checking user's credential. This is because some model need that
        * the user has to be logged in.....
        */
       Session::load(); // We need to start the session before user Auth class.
       Auth::login($task->user_id);


       // Listen for report progress event
       Event::listen('report.progress', function($progress) use($task){
              $task->progress = $progress;
              $task->progress_text = "Generating Report: {$progress}%";
              $task->save();
              return null;
       });

       // Catch any error event so we can update the report error.
       Event::listen('report.error', function($error) use($task){
              $task->progress = 'ER';
              $task->progress_text = $error;
              $task->save();
              continue;
       });

       // Init HTML file that will be converted to PDF.
       $file_header = Response::view('layouts.print-header', 
                        array(
                          'report'           => $task->report,
                        )
                      )->render();

       if(File::put($filename, $file_header)===false) {
           Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
         }  

       switch($task->report->reporttype->code) {
        //---------------------------------------------------------------------------------
        // Report Type: Voters
        //---------------------------------------------------------------------------------
        case "VOTERS":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "voter.reports.default-list";
           
          // get all voter's available columns
          $columns = Config::get('voter.columns');
          $selected_columns = $task->report->columns;
          if(!is_array($selected_columns)) {
            $selected_columns = Config::get('voter.default-columns');
          }


          // Get eager loading array that will be applied to the model. 
          // This is for doing a less query as possible
          $eagers = array();
          foreach($selected_columns as $selected_column) {
            if(array_key_exists($selected_column, $columns) && $columns[$selected_column]['relationship']) {
              $eagers[] = $columns[$selected_column]['relationship'];
            }
          }
          // Recreate voter object with the new eager loading parameter.
          if(count($eagers)<=0) {
            // default eager loading
            $eagers = array('pollsite', 'assemblydistrict', 'electiondistrict');  
          }

          $query = Voter::with($eagers);

           // Refactor selected columns
           $tmp_array = array();
           foreach($selected_columns as $selected_column) {
             if(array_key_exists($selected_column, $columns)) {
               $tmp_array[$selected_column] = $columns[$selected_column];
             }
           }
           $selected_columns = $tmp_array;

           // get filters and apply them to the query.
           $filters = $task->report->filters;
           if(is_array($filters)) {
             foreach($columns as $filter => $property) {
                if(array_key_exists($filter, $filters) && $filters[$filter]!='') {
                  $property['filter']($query, $filters);
                }
             }
           }

           //echo View::path($view);
           include_once(path('app').'/views/'.str_replace('.', '/', $view).EXT);
          
           break;
 
        //---------------------------------------------------------------------------------
        // Report Type: Canvass
        //---------------------------------------------------------------------------------
        case "CANVASS":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "canvass.reports.default";
          $columns = Config::get('canvass.columns');

          $canvass_id = $task->report->model_id;
          $canvass = Canvass::find($canvass_id);
          if(is_null($canvass)) {
            $task->status='ER';
            $task->status_text="Can't print this canvass with ID={$canvass_id}. Does not exists or coundn't be found.";
            $task->save();
            continue;
          } 

          //$voters = $canvass->voters()->order_by('home_sequence', 'ASC')->get();
          $query = $canvass->voters()
                      ->order_by('zip', 'ASC')
                      ->order_by('state', 'ASC')
                      ->order_by('city', 'ASC')
                      ->order_by('street_suffix', 'ASC')
                      ->order_by('street_name', 'ASC')
                      ->order_by('house_number', 'ASC')
                      ->order_by('apt_number', 'DESC');

          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                 return null;
          });

          include_once(path('app').'/views/'.str_replace('.', '/', $view).EXT);
          /*
          $content = Response::view($view, 
                       array(
                         'report'           => $task->report,
                         'canvass'          => $canvass,
                         'voters'           => $voters,
                       )
                     )->render();
          */
          break;  

        //---------------------------------------------------------------------------------
        // Report Type: Canvasses
        //---------------------------------------------------------------------------------
        case "CANVASSES":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "canvass.reports.default";
          $query = Canvass::where('id', '>', 0);
          
          // Get all voter's available columns
          $columns = Config::get('columns.columns');
          $selected_columns = $task->report->columns;
          if(!is_array($selected_columns)) {
            $selected_columns = Config::get('canvass.default-columns');
          }
          // Refactor selected columns
          $tmp_array = array();
          foreach($selected_columns as $selected_column) {
            if(array_key_exists($selected_column, $columns)) {
              $tmp_array[$selected_column] = $columns[$selected_column];
            }
          }
          $selected_columns = $tmp_array;
          
          // get filters and apply them to the model.
          $filters = $task->report->filters;
          // Append the user id
          $filters['owner_id'] = $user_id;
          if(is_array($filters)) {
            foreach($columns as $filter => $property) {
               if(array_key_exists($filter, $filters) && $filters[$filter]!='') {
                 $property['filter']($model, $filters);
               }
            }
          }
          
          
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                  return null;
          });

          include_once(path('app').'/views/'.str_replace('.', '/', $view).EXT);
          /*
          $content = Response::view($view, 
                       array(
                         'report'           => $task->report,
                         'canvasses'           => $canvasses,
                         'selected_columns' => $selected_columns,
                       )
                     )->render();
          */           
           
          break; 
 
        //---------------------------------------------------------------------------------
        // Report Type: User
        //---------------------------------------------------------------------------------
        case "USER":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "user.reports.default";
          
          // Get filters and apply them to the model.
          // Note that printing a single role means that 
          // the filter is going to be the role id
          $filters = unserialize($task->report->filters);
           //$u = User::find($task->user_id);
          $user = null;
          if($task->user->is_admin()) {
            $user = User::find($filters['id']);
          } else {
            // the user has to be created by the user whoses create the task.
            $user = User::where_id($filters['id'])->where('created_by', '=', $task->user->id)->first(); 
            //$user = User::find($filters['id']);
          }
          
                     
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                 return null;
          });
          $content = Response::view($view, 
                       array(
                        'report'           => $task->report,
                        'user'             => $user,
                       )
                     )->render();
          
          break; 
        
        //---------------------------------------------------------------------------------
        // Report Type: Users
        //---------------------------------------------------------------------------------
        case "USERS":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "user.reports.default-list";
          $model = User::where('id', '>', 0);
          
          // Get all voter's available columns
          $columns = Config::get('user.columns');
          $selected_columns = unserialize($task->report->columns);
          if(!is_array($selected_columns)) {
            $selected_columns = Config::get('user.default-columns');
          }
          // Refactor selected columns
          $tmp_array = array();
          foreach($selected_columns as $selected_column) {
            if(array_key_exists($selected_column, $columns)) {
              $tmp_array[$selected_column] = $columns[$selected_column];
            }
          }
          $selected_columns = $tmp_array;
          
          // get filters and apply them to the model.
          $filters = unserialize($task->report->filters);
          
          // Append the user id
          //$filters['owner_id'] = $user_id;
           if(is_array($filters)) {
            foreach($columns as $filter => $property) {
              if(array_key_exists($filter, $filters) && $filters[$filter]!='') {
                 $property['filter']($model, $filters);
               }
            }
          }
          // get the results.... 
          $users= $model->get();
          
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                 return null;
          });
          $content = Response::view($view, 
                       array(
                         'report'           => $task->report,
                         'users'            => $users,
                         'selected_columns' => $selected_columns,
                       )
                     )->render();
          
          
          break;   
            
        //---------------------------------------------------------------------------------
        // Report Type: Role
        //---------------------------------------------------------------------------------
        case "ROLE":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "role.reports.default";
          
          // Get filters and apply them to the model.
          // Note that printing a single role means that 
          // the filter is going to be the role id
          $filters = unserialize($task->report->filters);
          $role = Role::find($filters['id']);
                    
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                 return null;
          });
          $content = Response::view($view, 
                       array(
                         'report'           => $task->report,
                         'role'             => $role,
                       )
                     )->render();
          
          break; 

        //---------------------------------------------------------------------------------
        // Report Type: Roles
        //---------------------------------------------------------------------------------
        case "ROLES":
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "role.reports.default-list";
          $model = Role::where('id', '>', 0);
          
          // Get all voter's available columns
          $columns = Config::get('role.columns');
          $selected_columns = unserialize($task->report->columns);
          if(!is_array($selected_columns)) {
            $selected_columns = Config::get('role.default-columns');
          }
          // Refactor selected columns
          $tmp_array = array();
          foreach($selected_columns as $selected_column) {
            if(array_key_exists($selected_column, $columns)) {
              $tmp_array[$selected_column] = $columns[$selected_column];
            }
          }
          $selected_columns = $tmp_array;
          // get filters and apply them to the model.
          $filters = unserialize($task->report->filters);
          // Append the user id
          $filters['owner_id'] = $user_id;
          if(is_array($filters)) {
            foreach($columns as $filter => $property) {
               if(array_key_exists($filter, $filters) && $filters[$filter]!='') {
                 $property['filter']($model, $filters);
               }
            }
          }
          // get the results.... 
          $roles= $model->get();
          
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                 return null;
          });
          $content = Response::view($view, 
                       array(
                         'report'           => $task->report,
                         'roles'            => $roles,
                         'selected_columns' => $selected_columns,
                       )
                     )->render();
          
          
          break; 

        case 'VOTERREPORT':
               
          $voterReportQuery = Voterreport::with(array('pollsite', 'assemblydistrict', 'electiondistrict'));

          //$query = Voterreport::where('id', '>', 0);
          $allColumns = Config::get('voterreport.voter-report-field');
          $filters = null;
          
          //$query = null;
          //@todo Template should be choosen here  
          //$view = 'voterreport.statement.blade';
          $view = $task->reporttypetemplate ? $task->reporttypetemplate->view : "voterreport.statement";
                              
          //---core code for file processing-----//
          
            $sel_column = '';
            $list = Voterreportcriteria::where('status', '=', 'PN')
                                        ->where('user_id', '=', Auth::user()->id)
                                        ->first();
            if(is_null($list)) {
              if($id>0) { $this->errors[] = "The requested filter does not exists or you don't have permission to work with. Please contact your system administrator for more informtion."; }
            } else {
           
              $filters = unserialize($list->filters);
          
              // Override the default seleted columns for the list columns
              $selected_columns = $filters['Column']; 
            } 
          
          $layout = Reporttemplate::where('user_id', '=', Auth::user()->id)->find($list->reporttemplate_id);
               
          // Gets columns to be shown in the list.         
      
          // Get eager loading array that will be applied to the model. 
          // This is for doing a less query as possible
          $eagers = array();
          foreach($selected_columns as $sel_column) {
            if(array_key_exists($sel_column, $columns) && $columns[$selected_column]['relationship']) {
              $eagers[] = $columns[$selected_column]['relationship'];
            }
          }
          // Recreate voter report object with the new eager loading parameter.
              
      
            // Apply list filter if any...  
          if(!empty($list)) {     
            
              foreach($filters['Filter'] as $filter => $property) {
               // print_r($property);
                if (is_array($property)) {
                  foreach ($property as $clause) {
      
                    if ($clause['match'] == 'LIKE') {
                      $clause['when'] =  "%".$clause['when']."%";
                    }
      
                    if ($clause['merge'] == 'OR') {
                      $voterReportQuery=$voterReportQuery->or_where($clause['from'], $clause['match'], $clause['when']);
                
                    } else {
                      $voterReportQuery=$voterReportQuery->where($clause['from'], $clause['match'], $clause['when']);
                   
                    }             
                  }
                }          
               
              }      
          }//end filter if
        
          // Apply list sorting if any...    
          if (isset($filters['Sorting'])) {
            if ($filters['Sorting']['group']) {      
              $tmpArray = array();
              $i = 1;
              foreach($filters['Sorting'] as $sort) {
               
                if (is_array($sort)) {
                  if (array_key_exists($filters['Sorting']['row'], $sort)) {
                    $tmpArray[0] = $sort;
                  } else {
                    $tmpArray[$i] = $sort;
                    $i++;
                  }
                } 
              }
              ksort($tmpArray);       
            } else {
              $tmpArray = $filters['Sorting'];
            }
            foreach($tmpArray as $sorting) {
              if (is_array($sorting)) {
                foreach($sorting as $field => $order) {
                   $voterReportQuery=$voterReportQuery->order_by($field, $order);
                }
              } 
      
            }       
          }//end if sorting filter        
       
          //apply for selected column....
          //$tableShownColumn = $selected_columns;
      
         /* $niddles = array('fullname', 'zipcode', 'mail_zipcode');
          $tableShownColumn = array();
          $index = 0;
          foreach ($selected_columns as $key => $field) {  

            if (in_array($field, $niddle) && ($field == 'fullname')) {

              $tableShownColumn[$index] = 'firstname';         
              $tableShownColumn[++$index] = 'middle_ini';         
              $tableShownColumn[++$index] = 'lastname';         
              $index++;          
              $fullname = true;
            } elseif (in_array($field, $niddle)) {
              
            } else {         
              $tableShownColumn[$index] = $field;
              $index++;       
            }      
          }   */  


         /* foreach($niddles as $niddle) {
            if ('fullname' == $niddle && in_array($niddle, $tableShownColumn)) {
              $tableShownColumn[] = 'firstname';
              $tableShownColumn[] = 'middle_ini';
              $tableShownColumn[] = 'lastname';
            } else if ('zipcode' == $niddle && in_array($niddle, $tableShownColumn)) {
              $tableShownColumn[] = 'zip';
              $tableShownColumn[] = 'zip4';      
            } else if ('mail_zipcode' == $niddle && in_array($niddle, $tableShownColumn)) {
              $tableShownColumn[] = 'mail_zip';
              $tableShownColumn[] = 'mail_zip4';      
            }
            if (($key = array_search($niddle, $tableShownColumn)) !== false) unset($tableShownColumn[$key]);
          }  */       
          //---Attach the field if not exists
          if(isset($filters['Sorting']['row']))
          {
              if(!in_array($filters['Sorting']['row'],$tableShownColumn))
              {
                  array_push($tableShownColumn,$filters['Sorting']['row']);
              }
          }
      
          //$voterReportQuery = $voterReportQuery->select(array_unique($tableShownColumn));          
          //----------------------------------//
        
          // Listen for report progress event
          Event::listen('report.progress', function($progress) use($task){
                 $task->progress = $progress;
                 $task->progress_text = "Generating Report: {$progress}%";
                 $task->save();
                  return null;
          });
          
          $sortBy = $filters['Sorting']['row'] ? $filters['Sorting']['row'] : '';

          $sortedOrder = $tmpArray;      

          $columns = $selected_columns;
          //$columns = $tableShownColumn;

          include_once(path('app').'/views/'.str_replace('.', '/', $view).EXT);


          $fields = array(
            'user_id'           => Auth::user()->id,   
            'status'            => 'PR', 
            'status_text'       => 'Processed',
            'progress'          => 100,
            'progress_text'     => 'Finished',
            'filename'          => $pdf_filename,     
          );            
         
          Voterreportcriteria::where('status', '=', 'PN')
                              ->where('user_id', '=', Auth::user()->id)
                              ->update($fields);

          //$file_footer = $layout->footer;
            
          break;            
           
       } // endswitch

       // Close html file...
       $file_footer = Response::view('layouts.print-footer')->render();
       if(File::append($filename, $file_footer)===false) {
           Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
       }  

       /*
        * Save the view content to a html file.
        */
       /*
       if(file_put_contents($filename, $content)===false) {
         $task->status='ER';
         $task->status_text="Can create output html file. Please resend the request or contact your system administrator.";
         $task->save();
         continue;
       } 
       */

       /*--------------------------------------------------------------------
        * Convert the html file to pdf.
        */ 
       try { 
         
         // listen for any htmlexport's event
         Event::listen('htmlexport.progress', function($msg) use($task){
              $task->progress_text=$msg;
              $task->save();
         });

         Bundle::start('htmlexport');
         $htmpexport = Htmlexport::open($filename)
                                 ->filetype($task->output)
                                 ->orientation($task->orientation)
                                 ->paper($task->paper)
                                 ->get()
                                 ->save($pdf_filename);

         $task->status='PR';
         $task->status_text="Processed";
         $task->progress=100;
         $task->progress_text="Finished";
         $task->filename=$pdf_filename;
         $task->save();
       
       
       // catch any error...  
       } catch(Exception $e) {
         $task->status = 'ER';
         $task->status_text = $e->getMessage();
         $task->save(); 
       }              
       
       // cleaning up..
       if(file_exists($filename)) {
         //unlink($filename);
       }
       //--------------------------------------------------------------------
      
      // Logout the current user...
      Auth::logout();   
    } //endforeach report
  } // endrun
  
  /**
   * Resend request marked as error
   */   
  public function resend($arguments) {
    /*
     * Resent report task for a specific user
     */
    if(is_array($arguments) && count($arguments)==1) {
      
      $arg0 = $arguments[0];
      $user_id = 0;
      if(is_numeric($arg0)) {
        // User Id was passed
        $user = User::find($arg0);
        if($user) {
          $user_id = $user->id;
        } else {
          throw new Exception("No user was found with id={$arg0}");
        } 
      } else {
        $user = User::where_email($arg0)->first();
        if($user) {
          $user_id = $user->id;
        } else {
          throw new Exception("No user was found with email={$arg0}");
        }
      }
      
      Reporttask::where_status('ER')
                ->raw_where("EXISTS (SELECT 1 FROM reports r WHERE reporttasks.report_id = r.id and user_id=?)", array($user_id))
                ->update(array(
                  'status'        => 'PN',
                  'status_text'   => '',
                  'progress'      => 0,
                  'progress_text' => '',
                  'filename'      => '',
                ));
    /*
     * Resent all
     */   
    } else {
      Reporttask::where_status('ER')
                ->update(array(
                  'status'        => 'PN',
                  'status_text'   => '',
                  'progress'      => 0,
                  'progress_text' => '',
                  'filename'      => '',
                ));
    }
    
    // Process pending requests
    $this->run($arguments);
  }
}
