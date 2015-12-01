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

  $total_records = $query->count();
  
  if ($total_records > 0) {
    //---------------------------------------
    // Creating the table header...
    //---------------------------------------
    $table_header  = '<table class="table table-condensed"><thead><tr>';
    # first columns... (record number)
    $table_header .= '<th class="muted">#</th>';
    foreach($selected_columns as $selected_column => $property) {
      $table_header .= '<th>'.$property['display'].'</th>';
    }

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
      $voters = $query->paginate($perPage);
      
      foreach ($voters->results as $voter) {
        $table_body = '<tr><td class="muted">'.number_format($current_record).'</td>';
        foreach($selected_columns as $selected_column => $property) {
          $table_body .= '<td>'.$property['getValue']($voter, false).'</td>';
        }   
        $table_body .= '</tr>';
        if(File::append($filename, $table_body)===false) {
          Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
        }

        $progress = number_format((100/$total_records)*($current_record));
        Event::fire('report.progress', ($progress<=100 ? $progress : 100));
        unset($voter);
        $current_record++;
      }
      unset($voters->results);
      unset($voters);
    }

    $table_body = '</tbody></table>';

     
  } else {
    if(file_put_contents($filename, "No voters were found in this reports.")===false) {
      Event::fire('report.error', "Error creating the report. Please Contact your system administrator.");   
    }
  }