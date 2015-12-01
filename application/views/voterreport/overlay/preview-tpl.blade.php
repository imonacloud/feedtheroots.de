<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3 class="color-red">Layout preview</h3> 
</div>
<div class="modal-body">

  <div class="span12" style="border:1px solid;border-color:silver">
    <div class="span">{{ $layout->header }} <hr/></div>
   
    <div style="height:160px"><div></div></div>   
   
    <div class="span">{{ $layout->footer }}</div>
  </div>
</div>
<div class="modal-footer"> 
  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
</div>
