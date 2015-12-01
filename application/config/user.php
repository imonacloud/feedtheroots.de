<?php

return array(
  /*
  |--------------------------------------------------------------------------
  | Columns Configuration for User table
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
                                $query->where(function($query) use($criteria){
                                  $query->where('name', 'like', "%{$criteria}%");
                                  $query->or_where('email', 'like', "%{$criteria}%");
                                });
                                
                             },
    ),
    
    'photo' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Photo",
            'description' => "User's thumb mini photo",
            'getValue'    => function($model, $clickable=false){ 
                                //if($clickable) {
                                  return '<img src="'.$model->photo_thumb_mini_url.'">';
                                //} 
                                //else { 
                                //  return $model->id; 
                                //}
                             },
            'filter'      => function($query, $input=array()) {
                                $id = $input['id'];
                                $query->where('id', '=', $id);
                             },
    ),
    'id' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "System ID",
            'description' => "Unique User System ID",
            'getValue'    => function($model, $clickable=false){ 
                                if($clickable) {
                                  return '<a href="'.URL::to_action('user@edit', array($model->id)).'" class="lnk">'.$model->id.'</a>';
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
            'description' => "User Name",
            'getValue'    => function($model, $clickable=false){ 
                                $name = $model->name;
                                // Show the text hilghlighted when quick search
                                if(Input::has('quick_search')) {
                                  $name = Text::highlight($name, Input::get('quick_search'));
                                }
                                if($clickable) {
                                   return '<a href="'.URL::to_action('user@edit', array($model->id)).'" class="lnk">'.$name.'</a>';  
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

    'email' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Email",
            'description' => "User Email",
            'getValue'    => function($model, $clickable=false){ 
                                $email = $model->email;
                                // Show the text hilghlighted when quick search
                                if(Input::has('quick_search')) {
                                  $email = Text::highlight($email, Input::get('quick_search'));
                                }
                                if($clickable) {
                                   return '<a href="'.URL::to_action('user@edit', array($model->id)).'" class="lnk">'.$email.'</a>';  
                                } 
                                else { 
                                  return $email; 
                                }  
                             },
            'filter'      => function($query, $input=array()) {
                                $email = $input['email'];
                                $query->where('email', 'like', "%{$email}%");
                             },
    ),
    'change_password_request' => array(
            'selectable'  => false, // Do not show this column in the column list. But this columns is still available for filtering....   
            'relationship' => null,
            'display'     => null,
            'description' => null,
            'getValue'    => function($model, $clickable=false){ return $model->change_password_request;},
            'filter'      => function($query, $input=array()) {
                                $change_password_request = $input['change_password_request'];
                                $query->where('change_password_request', '=', $change_password_request);
                             },
    ),
    'address' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Address',
            'description' => 'User Address',
            'getValue'    => function($model, $clickable=false){ return $model->address;},
            'filter'      => function($query, $input=array()) {
                                $address = $input['address'];
                                $query->where('address', '=', $address);
                             },
    ),
    'h_phone' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Home Phone',
            'description' => 'User Home Phone Contact',
            'getValue'    => function($model, $clickable=false){ return $model->h_phone;},
            'filter'      => function($query, $input=array()) {
                                $h_phone = $input['h_phone'];
                                $query->where('h_phone', '=', $h_phone);
                             },
    ),
    'c_phone' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Cell Phone',
            'description' => 'User Cell Phone Contact',
            'getValue'    => function($model, $clickable=false){ return $model->c_phone;},
            'filter'      => function($query, $input=array()) {
                                $c_phone = $input['c_phone'];
                                $query->where('c_phone', '=', $c_phone);
                             },
    ),
    'w_phone' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Work Phone',
            'description' => 'User Work Phone Contact',
            'getValue'    => function($model, $clickable=false){ return $model->w_phone;},
            'filter'      => function($query, $input=array()) {
                                $w_phone = $input['w_phone'];
                                $query->where('w_phone', '=', $w_phone);
                             },
    ),
    'status' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Status',
            'description' => 'User Status',
            'getValue'    => function($model, $clickable=false){ 
                             return $model->status=='A' ? '<span class="label label-info">Active</span>' : '<span class="label label-important">Deactive</span>'; 
                             },
            'filter'      => function($query, $input=array()) {
                                $status = $input['status'];
                                $query->where('status', '=', $status);
                             },
    ),

    'confirmed' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'Confirmed',
            'description' => 'Is the account confirme?',
            'getValue'    => function($model, $clickable=false){ 
                             return $model->confirmed=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             },
            'filter'      => function($query, $input=array()) {
                                $confirmed = $input['confirmed'];
                                $query->where('confirmed', '=', $confirmed);
                             },
    ),

    'account_id' => array(
            'selectable'  => true, 
            'relationship' => 'Account',
            'display'     => 'Account',
            'description' => 'User Account',
            'getValue'    => function($model, $clickable=false){ return $model->account->name; },
            'filter'      => function($query, $input=array()) {
                                $account_id = $input['account_id'];
                                $query->where('account_id', '=', $account_id);
                             },
    ),
    'role_id' => array(
            'selectable'  => true, 
            'relationship' => 'Role',
            'display'     => 'Role',
            'description' => 'User Role',
            'getValue'    => function($model, $clickable=false) {
                             if($model->role) {
                              return $model->role->name;  
                             }

                             return null;
                             },
            'filter'      => function($query, $input=array()) {
                                $role_id = $input['role_id'];
                                $query->where('role_id', '=', $role_id);
                             },
    ),
    'is_admin' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => 'is Admin?',
            'description' => 'User admin flag',
            'getValue'    => function($model, $clickable=false) { 
                               return $model->is_admin=='Y' ? '<span class="label label-info">Yes</span>' : '<span class="label label-important">No</span>'; 
                             },
            'filter'      => function($query, $input=array()) {
                                $is_admin = $input['is_admin'];
                                $query->where('is_admin', '=', $is_admin);
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
    'created_by' => array(
            'selectable'  => true, 
            'relationship' => null,
            'display'     => "Created By",
            'description' => "Created by",
            'getValue'    => function($model, $clickable=false) { 
                               if($model->createdby) {
                                 return $model->createdby->name;  
                               } else {
                                  return null;
                               }
                             },
            'filter'      => function($query, $input=array()) {
                                $created_by = $input['created_by'];
                                $query->where('created_by', '=', $created_by);
                             },
    ),



  ),  
  /*
   * default voter column list to be displayed.
   */   
  'default-columns' => array('photo', 'name', 'email', 'status', 'role', 'is_admin', 'created_at', 'created_by'),

);
