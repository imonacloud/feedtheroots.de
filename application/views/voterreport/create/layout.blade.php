<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3><i class="icofont-print"></i> Download Report</h3>

</div>
<div class="span1"></div>
<div class="modal-body form-horizontal">
  <input type="hidden" id="do_print" name="data[Layout][download]" value="pdf">
  @include('voterreport/overlay/print-option-field') 
  <div class="control-group">      
    <label for="print-orientation" class="control-label">Orientation</label>
    <div class="controls">
      <label class="radio inline">    
        <?php 
        $portrait = $landscape = '';
        if (isset($data->filters['Layout']) && !empty($data->filters['Layout'])) {
          if ($data->filters['Layout']['orientation'] == 'portrait') {
            $portrait = 'checked';
          } else {
            $landscape = 'checked';
          }
        } else {
          $portrait = 'checked';
        }        
        ?>
        <input type="radio" name="data[Layout][orientation]" value="portrait" <?php echo $portrait; ?> > Portrait       
      </label>
      <label class="radio inline">        
        <input type="radio" name="data[Layout][orientation]" value="landscape" <?php echo $landscape; ?> > Landscape       
      </label>      
    </div>    
  </div>
  <div class="control-group">      
    <label class="control-label" for="print-template">Layout</label>
    <div class="controls">
      <select name="data[Layout][template]" id='print-template' rel='select2' class='span3'>            
        <option value="">{{ 'Please select' }}</option>
        @foreach($templates as $id => $value)  
        <?php $selected = (@$data->filters['Layout']['template'] == $id) ? 'selected' : ''; ?>
          <option value="{{ $id }}" <?php echo $selected; ?> >{{ $value }}</option>
        @endforeach            
      </select>      
     
      <BR><BR><span class="help-block muted">Output report layout.</span>     
    </div>    
  </div>
 

</div>
<div class="modal-footer">
<!--<input type="submit" id="btn-print-list" value="Download Report" class="btn btn-primary" />
<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>-->
</div>

