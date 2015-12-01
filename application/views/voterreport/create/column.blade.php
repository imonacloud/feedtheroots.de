
<div class="modal-header">
  <h3><i class="icofont-columns"></i> Select columns to display</h3>
  <small class="muted">Select the columns you want to display in the current report.</small>
</div>
<div class="modal-body">  
  <div class="control-group span4 pull-left">
      
    <select id="column-list" class="span12" name="selectcolumn" size="30" style="height: 300px;">
      @foreach($uiColumns as $actual => $column) 
        <?php if (isset($data->filters['Column']) && in_array($actual, $data->filters['Column'])) { ?>
          <option value="{{ $actual }}" disabled>{{ $column['display'] }} </option>
        <?php } else { ?>
          <option value="{{ $actual }}">{{ $column['display'] }}</option>
        <?php } ?>
      @endforeach
    </select>

  </div>
  <div class="span2"></div>
  <ul id="column-selected" class="control-group span4" 
  style="height:300px;margin-right: 0px;border:1px solid silver;padding:2px;overflow:auto">

    <?php
      if (!empty($data->filters)) :
        foreach($data->filters['Column'] as $column) {         
      ?>
          <li style="margin:0 0 2px" data-holder="<?php echo $column; ?>" class="text-info breadcrumb <?php echo $column; ?>">
            <input type="hidden" name="data[Column][]" value="<?php echo trim($column); ?>">
            <strong><?php echo $uiColumns[trim($column)]['display']; ?></strong>
            <button aria-hidden="true" class="close" type="button">×</button>
          </li>
      <?php 
        }
       // exit;
      endif;
    ?>
    
      <!-- here we show the selected field -->
  </ul>
  
</div>
<div class="modal-footer">
  <a href="#filtertab" id="tab-column" class="btn btn-large btn-info">Next</a>
 
</div> 

 