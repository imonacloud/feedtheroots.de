<div class="control-group">      
  <label class="control-label" for="data[Layout][paper]">Paper</label>  
  <div class="controls">
    <?php
    $paperOption = array(
      'Letter' => 'Letter',
      'Legal'  => 'Legal',
      'A3'     => 'A3',
      'A4'     => 'A4',
      'A5'     => 'A5'
      );
    $selectedMaster = '';
    ?>
    <?php foreach($paperOption as $value => $output) : ?>
    <?php 
      $selectedDefault = $selected = '';
      if (isset($data->filters['Layout']['paper'])) {
        if ($data->filters['Layout']['paper'] == $value) {
          $selected = $selectedMaster = 'checked';
        }        
      } else {
        $selectedDefault = ($value == 'A4') ? 'checked' : '';
        $selected = !empty($selectedMaster) ? '' : $selectedDefault;
      }

    ?>
      <label class="radio inline">    
      
        <input value="<?php echo $value; ?>" <?php echo $selected; ?> name="data[Layout][paper]" type="radio"> <?php echo $output; ?>       
      
      </label>   
    <?php endforeach; ?> 
  </div>    
</div>
 
