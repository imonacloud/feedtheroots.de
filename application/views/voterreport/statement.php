<?php


/*
 * All tempalte should follow the following rules:
 *   1 - All the output has to be writting in $filename file. 
 *       This file is the file that contains de report informations.
 *   2 - All the output has to be in HTML and only the body need to be created.
 *       The header and footer are added by the layouts.print-header and layouts.print-footer
 *       views.
 *   3 - All this code has to be PHP (valid php) because it will be executed using the include function.
 *
 * NOTE: we use this approach to create reports because we are working with LARGE amoung of data and some cases
 *       PHP can crach by memory exhausted.......
 */

  $total_records = $voterReportQuery->count();

  unset($columns[$sortBy]);

  $totalColumns = count($columns);
  //$varquery = serialize($query);

  $recordCount = 0;

  
  if ($total_records > 0) {
    //---------------------------------------
    // Creating the table header...
    //---------------------------------------

    $table_header  = $layout->header;

    $sortStringCount = 0;
    foreach($sortedOrder as $sorting) {

      if (is_array($sorting)) {
        foreach($sorting as $field => $order) {
          if ($sortStringCount == 0) {
            $sortString = $allColumns[$field]['display']. ' ' .$order;
          } else {
            $sortString .= ', '. $allColumns[$field]['display'] . ' ' .$order;
          }
          $sortStringCount++;
           
        }
      } 

    }   

    if (!empty($sortString)) {
      $table_header .= '<div>';
      $table_header .= '<span style="float: left;"><h3>Sort By : '. $sortString .'</h3></span>';   
      $table_header .= '</div>';
    }

    $table_header  .= '<table class="table table-condensed"><thead><tr>';

    if ($recordCount == 0) {

      # first columns... (record number)
      $table_header .= '<th class="muted">#</th>';
      foreach($columns as $column) :
              
        $table_header .= '<th style="background-color: #F9F9F9;border-left: 1px solid #DDDDDD;padding: 8px;">';
        //$page_body .= $column;
        $table_header .= $allColumns[$column]['display'];
        //serialize($voterReportQuery->table->wheres).

        $table_header .=  '</th>';
      endforeach;

    }//end first count

    $recordCount++;    

    $table_header .='</tr></thead><tbody>';

    if(File::append($filename, $table_header)===false) {
      Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
    }


    //---------------------------------------
    // Creating the table body...
    //---------------------------------------

    
    /*
     * To prevent memory exhausted by reading all DB results, 
     * I will get all result using pagination.
     */    
    $perPage = 1000;
    $pages = ceil($total_records/$perPage);

    $current_record = 1;

    for($page=1; $page<=$pages; $page++) {
      Input::merge(array('page' => $page));
      $resultVoter = $voterReportQuery->paginate($perPage);
      
      foreach ($resultVoter->results as $result) {
        $table_body = '<tr><td class="muted">'.number_format($current_record).'</td>';

        foreach($columns as $field) :


          if ($field == 'fullname') {
              $value = @$result->original['lastname'].' '.@$result->original['firstname'].' '.@$result->original['middle_ini'];
          } else {
                                  
            $associated = strpos($field, '_id');
            $element = substr($field, 0, -3);
            if ($associated && isset($result->relationships[$element]) && isset($result->relationships[$element]->original['name'])) {
                       
              $value = $result->relationships[$element]->original['name'];

            } else {
              $value= $result->original[$field];
            }
          }
            
          $table_body .= '<td>'. $value .'</td>';                    
        endforeach;
          
        $table_body .= '</tr>';

        //$table_body .= '</tbody></table>';

         //$table_body .= '<tr colspan="2"><td>dfdfdf</td></tr>';

        if(File::append($filename, $table_body)===false) {
          Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
        }

        $progress = number_format((100/$total_records)*($current_record));
        Event::fire('report.progress', ($progress<=100 ? $progress : 100));
        unset($result);
        $current_record++;
      }//end paginate result

      
      if(File::append($filename, '<tr><td  colspan="'. $totalColumns .'"">'.$layout->footer.'</td></tr>')===false) {
          Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
        }  
      $table_body .= '</tbody></table>';
      //unset($uses->results);
      unset($resultVoter);
    }



     
  } else {
    if(file_put_contents($filename, "No Voter report were found in this reports.")===false) {
      Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
    }
  }
     
?>
