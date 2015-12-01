<div class="row-fluid">
  <div class="span2"></div>

  <div class="span8">   
    <div class="row-fluid">
      <div class="span12">

        <fieldset>
          <div class="control-group">        
            <label for="name">Report Name</label>
            <?php
            $name = !empty($data->name) ? $data->name : '';
            ?>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
          </div>
          <div class="control-group">
            <?php
            $description = !empty($data->description) ? $data->description : '';
            ?>
            <label for="description">Description</label>
            <textarea cols="50" id="description" name="description" class="span6" rows="4"><?php echo $description; ?></textarea>
          </div>	        
            <!--<a href="#columntab" id="tab-name" class="btn">Save</a>
            <a class="btn hide" id="tab-name-edit" href="javascript:;">Edit</a>-->

        </fieldset>
      </div>
    </div>   
    <a href="#columntab" id="tab-name" class="btn btn-large btn-info">Next</a>  

  </div>
</div>
