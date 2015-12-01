<div id="sort">
  <table id="datatables" class="table table-bordered table-striped table-hover responsive">
    <thead>
      <tr>
        <th>Column</th>
        <th>Order</th> 
        <th>Group Results</th>  
        <th>Action</th>             
      </tr>
    </thead>
    <tbody>   
      <tr></tr>
      <tr id="row-1">
        <td> 
          <select class = "sort-select-column" name="" >
            @foreach($columns as $actual => $column)              
              <option value="{{ $actual }}">{{ $column['display'] }}</option>            
            @endforeach
          </select>
        </td>
        <td>
          <select class ="sort-select-order" name="">
            <option value="DESC">Descending</option>
            <option value="ASC">Ascending</option>
          </select>
        </td> 
        <td>  
        <?php
          $checked = (isset($data->filters['Sorting']['group']) && $data->filters['Sorting']['group']) ? 'checked' : '';
          ?>      
          <input type="hidden" name="data[Sorting][group]" id="sort-group-hide" value="0" <?php echo $checked; ?>  />
          
          <input type="checkbox" name="data[Sorting][group]" value="1" id="sort-group" <?php echo $checked; ?> />
        </td> 
        <td>
          <a href="javascript:;" sort-row="row-1" next-row="1" class="btn sort-row-add">Add</a>         
        </td>      
      </tr>

      <?php
      $sortCount = 1;
      if (!empty($data->filters['Sorting'])) :
        foreach($data->filters['Sorting'] as $sort) {
          if (is_array($sort)) {
            foreach($sort as $field => $order) {
              $sortCount++;
      ?>
            <tr class="<?php echo $field; ?>" id="row-<?php echo $sortCount; ?>">
              <td>
                <span class="sort-column-label label"><?php echo $columns[$field]['display']; ?></span>
                <input type="hidden" name="data[Sorting][<?php echo $sortCount; ?>][<?php echo $field; ?>]" value="<?php echo $order; ?>">
              </td>
              <td><span class="sort-order-label label"><?php echo ($order == 'DESC') ? 'Descending' : 'Ascending'; ?></span></td>
              <?php 
              $radioShowHide = ($checked == 'checked') ? '' : 'hide'; 
              $selected = (@$data->filters['Sorting']['row'] == $field) ? 'checked' : '';

              ?>
              <td><input type="radio" <?php echo $selected; ?> value="<?php echo $field; ?>" class="<?php echo $radioShowHide; ?>" name="data[Sorting][row]"></td>
              <td><a class="btn sort-row-del" id="row-<?php echo $sortCount; ?>" href="javascript:;">Remove</a></td>
            </tr>
      <?php      
            }
          }
        }
      ?>
        
      <?php
      endif;
      ?>
    </tbody>
  </table>


 
</div>
  <a href="#layouttab" id="tab-sort" class="btn btn-large btn-info">Next</a>   

