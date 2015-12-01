<?php
/*
 * Voterlist model. This model extends from elegant instead of eloquent but inheritance
 * all properties/methods from eloquent because elegant extends from eloquent.
 */
class Voterlist extends Elegant {
  public static $timestamps = true;


  // Validation's rules. Only the list's name is required.
  protected $rules = array(
    'name' => 'required|min:3|max:30',
  );

  /**---------------------------------------------------------------------------------------------------------------
   * Get a new fluent query builder instance for the model.
   * We going to use this function to inject where-conditions  to the main query
   *
   * @param void
   * @return Query
   */
  protected function query()  {
    //$query = new \Laravel\Database\Eloquent\Query($this);
    //return $query->where('application_id', '=', \App::get_id());
    $query = parent::query();

    // List are created by user, so we only show current user's voter-lists
  	$query = $query->where('user_id', '=', Auth::user()->id);  
        
    return $query;
  }

  //---------------------------------------------------------------------------------------------------------------
  //   GETTERS METHODS
  //---------------------------------------------------------------------------------------------------------------
  
  /**---------------------------------------------------------------------------------------------------------------
   * Gets list filters
   *
   * @param void
   * @return Array
   */
  public function get_filters()  {
    $filters = $this->get_attribute('filters');
    return is_array($filters) ? $filters : unserialize($filters);
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Gets list columns
   *
   * @param void
   * @return Array
   */
  public function get_columns()  {
    $columns = $this->get_attribute('columns');
    return is_array($columns) ? $columns : unserialize($columns);
  }

  //---------------------------------------------------------------------------------------------------------------
  //   SETTERS METHODS
  //---------------------------------------------------------------------------------------------------------------
  
  /**---------------------------------------------------------------------------------------------------------------
   * Sets list's filters
   *
   * @param Array
   * @return void
   */
  public function set_filters($filters)  {
    $this->set_attribute('filters', is_array($filters) ? serialize($filters) : $filters );
  }

  /**---------------------------------------------------------------------------------------------------------------
   * Sets list's columns
   *
   * @param Array
   * @return Void
   */
  public function set_columns($columns)  {
    $this->set_attribute('columns', is_array($columns) ? serialize($columns) : $columns );
  }
  

  //---------------------------------------------------------------------------------------------------------------
  //   RELATIONSHIP METHODS
  //---------------------------------------------------------------------------------------------------------------
  
  /**---------------------------------------------------------------------------------------------------------------
   * one-to-many relationship with user model. 
   * One voter-list belongs to a one user. One user has many voter-list.
   * This represent the voter-list owner/creator/etc.
   *
   * @param void
   * @return Eloquent Model Object
   */
  public function user() {
    return $this->belong_to('User');
  }
}