<?php

return array(
  /*
  |--------------------------------------------------------------------------
  | Columns Configuration for Role table
  |--------------------------------------------------------------------------
  |
  | Here you simply specify the column name, display name and the filter 
  | that will be applied to the model in case we want to filter by this column. 
  | The display name is the header text in a table. Here's the description of 
  | each array element:
  |  
  | selectable: This this column will be shown in the "select column" dialog
  | relationship: the name of the relation ship that needs to be earger loaded. 
  | display: value to be displayed to identify this column (table header, etc.)
  | description: column description - brief description.
  | getValue: method that return this values from the model. Usefull when the column is retreive from relation model.
  | filter: function that will apply the filter over the column.
  | 
  */
  'columns' => array(

    'quick_search' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "",
            'description' => "",
            'getValue'    => function($model, $clickable=false){ return null; },
            'filter'      => function($query, $input=array()) {
                                $criteria = $input['quick_search'];
                                $query->where('name', 'like', "%{$criteria}%");
                             },
    ),
    
    'id' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "System ID",
            'description' => "Unique Role System ID",
            'getValue'    => function($model, $clickable=false){ 
                                if($clickable) {
                                  return '<a href="'.URL::to_action('role@edit', array($model->id)).'" class="lnk">'.$model->id.'</a>';
                                } 
                                else { 
                                  return $model->id; 
                                }
                             },
            'filter'      => function($query, $input=array()) {
                                $id = $input['id'];
                                $query->where('id', '=', $id);
                             },
    ),
    'name' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Name",
            'description' => "Role Name",
            'getValue'    => function($model, $clickable=false){ 
                                $name = $model->name;
                                // Show the text hilghlighted when quick search
                                if(Input::has('quick_search')) {
                                  $name = Text::highlight($name, Input::get('quick_search'));
                                }
                                if($clickable) {
                                   return '<a href="'.URL::to_action('role@edit', array($model->id)).'" class="lnk">'.$name.'</a>';  
                                } 
                                else { 
                                  return $name; 
                                }  
                             },
            'filter'      => function($query, $input=array()) {
                                $name = $input['name'];
                                $query->where('name', 'like', "%{$name}%");
                             },
    ),

    'assign_roles' => array(
            'selectable'  => true, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "Assign Roles",
            'description' => "Assign Roles",
            'getValue'    => function($model, $clickable=false){ 
                               $roles_id = unserialize($model->assign_roles); 
                               if($roles_id) {
                                 $roles = Role::where_in('id', $roles_id)->get();
                                 $return_value = '';
                                 foreach($roles as $role) {
                                   $return_value .= '<span class="label label-info">'.$role->name.'</span> ';
                                 }
                                 return $return_value; 
                               } else {
                                 return null;
                               }
                               
                             },
            'filter'      => function($query, $input=array()) {
                                $description = $input['description'];
                                $query->where('description', 'like', "%{$description}%");
                             },
    ),

    'description' => array(
            'selectable'  => true, // Do not show this column in the column list. But this columns is still available for filtering....  
            'relationship' => null,
            'display'     => "Description",
            'description' => "Role Description",
            'getValue'    => function($model, $clickable=false){ return $model->description; },
            'filter'      => function($query, $input=array()) {
                                $description = $input['description'];
                                $query->where('description', 'like', "%{$description}%");
                             },
    ),

    'total_users' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Users",
            'description' => "Total of users assigned to this role",
            'getValue'    => function($model, $clickable=false){ 
                               if($clickable && count($model->users)>0) {
                                 return '<a href="#" class="lnk" id="view-role-users-'.$model->id.'">'.count($model->users)."</a>"; 
                               } else {
                                 return count($model->users);  
                               }
                             },
            'filter'      => function($query, $input=array()) {
                                //Do nothinig...
                             },
    ),
    'created_at' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Created At",
            'description' => "Created at",
            'getValue'    => function($model, $clickable=false){ 
                                $format="Y-m-d h:i:s A";
                                $date = strtotime($model->created_at); 
                                return date($format, $date); 
                                
                             },
            'filter'      => function($query, $input=array()) {
                                $created_at = $input['created_at'];
                                $query->where('created_at', '=', $created_at);
                             },
    ),



  ),  
  /*
   * default voter column list to be displayed.
   */   
  'default-columns' => array('name', 'total_users', 'created_at'),

);
