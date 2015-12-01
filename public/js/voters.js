$(document).ready(function() {

  $("#btn-advance-search").click(function(event){
    event.preventDefault();
    $("div[id='voter-filters-box']").slideToggle("slow");
    return false;
  });
  
  $("#btn-advance-search-cancel").click(function(event){
    event.preventDefault();
    $("div[id='voter-filters-box']").slideToggle("slow");
    return false;    
  });
  
  
  $("a[rel=popover]").popover();
    
    
  $("#perPage").change(function() {
      $("#per_page_form").submit();
  });
  
  
  $("a[id*='btn-del-list-']").click(function(event){
    console.log("hello");
    return false;
    event.preventDefault();
    var id = $(this).attr('id');
    var id_split    = id.split('-');
    var list_id    = id_split[3];
   
    bootbox.dialog("Are you sure you want to delete this list?", [{
      "label" : "Delete",
      "class" : "btn-danger",
      "callback": function() {
        window.location.href = list_baseurl + "/" + list_id + "/del";
      }
      }, {
      "label" : "Cancel",
      "class" : "btn",
    }]);
    return false;
  });
    
  
  $("#btn-print").click(function(event){
    event.preventDefault();
    
    var error = false;
      
    var name = $("input[id='print-name']").val().trim();
    var title = $("input[id='print-title']").val().trim();
    
    if(name == '') {
      error = true;
      $("div[id='print-name']").addClass("error");
    } else {     
    	$("div[id='print-name']").removeClass("error");
    }
    
    if(title == '') {
      error = true;
      $("div[id='print-title']").addClass("error");
    } else {     
    	$("div[id='print-title']").removeClass("error");
    }
    
    if(!error) {
      $("#print-form").submit();
    }
    
    return false;
  });  

  
  

  
  
});

