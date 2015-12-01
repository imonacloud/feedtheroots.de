@layout('layouts/main')

@section('javascript-section')

  var list_baseurl = "{{ URL::to_action('voterreport@list') }}";
@endsection        

@section('additional-header-injection')
<!--  PLUGIN FOR MULTI SELECT AND SORT
<link rel="stylesheet" href="http://quasipartikel.at/multiselect/css/common.css" type="text/css" />
    <link type="text/css" href="http://quasipartikel.at/multiselect/css/ui.multiselect.css" rel="stylesheet" />
    <script type="text/javascript" src="http://quasipartikel.at/multiselect/js/ui.multiselect.js"></script>
-->
<!-- <script type="text/javascript" src="http://quasipartikel.at/multiselect/js/ui.multiselect.js"></script>  -->
<script type="text/javascript">

  $(document).ready(function() {

    $(window).hashchange( function(){

      // Alerts every time the hash changes!     
      var selector = location.hash ;
      var selector = '#myTab a[href="'+ selector +'"]';  

      $(selector).tab('show');

    });

    $("#tab-name").click(function() {
     /* if ($(this).text() == "Saved") {
        return false;
      }*/

      if ($("#name").val() == '') {  

        $("#name").closest('div').addClass('error');
          return false;

      } else if ($("#description").val() == '') {
   
        $("#description").closest('div').addClass('error');
        return false;
      } else { 
        //$("#name").prop('disabled', true);
        //$("#description").prop('disabled', true);
        //$(".form-actions").removeClass('hide');
        //$(this).text("Saved").addClass('btn-success');
        //$("#tab-name-edit").removeClass('hide');
      }
    

    });

    /*$("#tab-name-edit").click(function() {    

      $("#name").prop('disabled', false);
      $("#description").prop('disabled', false);
      $("#tab-name").text("Save").removeClass('btn-success');
      $(this).addClass('hide');   

    });*/


    //Script to selected column from left box to right box
    $("#column-list").change(function () {
      //var filterOption = "";
      $("#column-list option:selected").each(function () {

          var selectedColumnVal = $(this).val();
          var selectedColumnText = $(this).text();         
          var filterOption = '<li class="text-info breadcrumb '+ selectedColumnVal +'"';
          filterOption += 'data-holder="'+ selectedColumnVal +'" style="margin:0 0 2px">';
          filterOption += '<input type="hidden" value="' + selectedColumnVal + '" name="data[Column][]" />';
          filterOption += '<strong>' + selectedColumnText + '</strong>';
          filterOption += '<button type="button" class="close" aria-hidden="true">×</button>';
          filterOption += '</li>';
          $("ul#column-selected").append(filterOption);
          $('#column-list option[value="' + selectedColumnVal + '"]').prop('disabled', true);         
      });     
    })
    .trigger('change');

    //DESELECT THE COLUMN ALLREADY SELECTED
    $("ul#column-selected").on("click", "button.close", function() {     
      var selectedColumn = $(this).closest('li').attr('data-holder');
      //remove related things  
      $(this).closest('li').remove();     
      $('#column-list option[value="' + selectedColumn + '"]').prop('disabled', false);
      $('#column-list option').prop('selected', false);
    });

    //SELECTED COLUMN SORTABLE
    $("ul#column-selected").sortable({
      containment: "ul#column-selected", 
      forcePlaceholderSize: true,
      cursor: "move",
      placeholder: "ui-state-highlight"
    });

    $("#tab-column").click(function() {
      if ($("ul#column-selected li").length < 1) {
        $("#columnDailogLink").trigger('click');      
        return false
      } else {
        $(".form-actions").removeClass('hide');
      }
    });

    $(".form-actions button").click(function() {
      if ($("ul#column-selected li").length < 1) {
        $("#columnDailogLink").trigger('click');      
        return false
      }

      if ($("#name").val() == '') {  

        $("#name").closest('div').addClass('error');
        return false;

      } else if ($("#description").val() == '') {
   
        $("#description").closest('div').addClass('error');
        return false;
      } 

    });


   /* $("#tab-filter").click(function() {
      /*if ($("ul#column-selected li").length < 1) {
        alert('please select any column');
        return false
      }  
    });*/

    /*$("#tab-column-edit").click(function() {   

      $("form#change-colums-form input, form#change-colums-form select").prop('disabled', false);      
      $("#tab-column").text("Save").removeClass('btn-success');
      $(this).addClass('hide');   

    });*/

  /*Script For Filter Funtionality Manage */

    //First script for filter to choose any field from left most dropdown
    $("#filter-select").change(function () {
      var filterOption = "";
      $("#filter-select option:selected").each(function () {
          var selectedColumnVal = $(this).val();
          var selectedColumnText = $(this).text();
          var selectedColumnDataType = $(this).attr('data-type');         
          var filterOption = '<div class="text-info breadcrumb '+ selectedColumnVal +'" data-holder="'+ selectedColumnVal +'" style="margin:0 0 2px"><strong>' + selectedColumnText + '</strong><button type="button" class="close" aria-hidden="true">×</button></div>';
          //add match by datatype of field
          changeSelectOption(selectedColumnDataType);

          $("div#set-filter").append(filterOption);
          $("#filter-select").prop('disabled', true);
          $("#provide-filter").removeClass('hide');
          $(".condition-get").val($(this).text()).attr('data-content', $(this).val());
          $("#done-filter-job").attr('selected-column', selectedColumnVal);
          $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append, #add-filter-job").attr('disabled', false);
          if ($("#development span").length > 0) {
            $("#addMoreStrainer").removeClass('hide');
          }
          setAutoValue(selectedColumnVal);
      });     
    })
    .trigger('change');

    //set auto fill value in conditional fill box
    function setAutoValue(field) {

      var populated = [ "sex", "county_id", "state", "city", "ethnicity_id", "ethnicgroup_id"];
      $("#provide-filter #set-fill input, #provide-filter #set-fill select").addClass('hide');
      if (jQuery.inArray(field, populated) >= 0) {
        $("#provide-filter #set-fill select#" + field).removeClass('hide');
      } else {
        $("#provide-filter #set-fill input").removeClass('hide');
      }     

    }//end setAutoValue()

    //set filter right box click on close for the field
    $("div#set-filter").on("click", "button.close", function() {
 
      var selectedColumn = $(this).closest('div').attr('data-holder');
      //remove related things
      removeColumnToBox(selectedColumn);
      $("#production input." + selectedColumn).remove();
      $("#development span." + selectedColumn).remove();
      var isFirst = false;
      if ($("#set-filter button.close").index(this) == 0) {
        isFirst =true;
      }
      $(this).closest('div').remove();
      $("#filter-select").prop('disabled', false);
      $('#filter-select option[value="' + selectedColumn + '"]').prop('disabled', false);

   
      if ($("div#set-filter div").length < 1) {
        $("#provide-filter").addClass('hide');
      }      
     
      //if first remove than AND/OR will remove
      if (isFirst) {
        $("#development span span.prepend:first").remove();
        $('#production input:eq(1)').val("");       
      }
    });

    // remove column box
    function removeColumnToBox(field) {
      $("#production input." + field).remove();
      $("#development span." + field).remove();
      $(".addMultiple").addClass("hide");
      $("#addMoreStrainer").addClass("hide");
      $('#filter-select option').prop('selected', false);
      //$("#filter-select")
      reCleanStainer();
    }

    //add filter to the production and development 
    $("#add-filter-job").click(function() {

      if ($(this).attr('disabled') || $(".condition-get").val() == '') {
        return false;
      }

     // var nextAppend = '';
      var fromPro  = $(".condition-get").attr('data-content');
      var fromDev  = $(".condition-get").val();
      var matchDev = $("#filter-match-type option:selected").text();
      var matchPro = $("#filter-match-type option:selected").val();
      if (!$("#provide-filter #set-fill input.condition-fill").hasClass('hide')) {
        var putValPro  = $("input.condition-fill").val();
        var putValDev  = $("input.condition-fill").val();
      } else {  
        var putValPro = $("#provide-filter #set-fill select").not('.hide').val();
        var putValDev = $("#provide-filter #set-fill select:not(.hide) option:selected").text();
      }      
   
      var nextAppend = '';
      
      if (putValPro == '') { 
        $(".condition-fill").closest('div.control-group').addClass('error');
        return false;
      }
      
      var setFilterCountForField = $(this).attr('counter');
      var clauseCount =  $("#production input").length;
      
      var development = '<span class="label ' + fromPro + '" style="margin:1px">';
      if (setFilterCountForField > 1 && clauseCount > 1) {
        var nextAppend = $("#next-filter-append option:selected").val();  
        development += '<span class="prepend"> ' + nextAppend + ' </span>' + fromDev + ' ' + matchDev + ' ' + putValDev;
      } else {       
         development += fromDev + ' ' + matchDev + ' ' + putValDev;         
      } 

      development += '<button selected-column="' + fromPro + '" clauseid="' + setFilterCountForField + '" style="margin-top:-22px" aria-hidden="true" class="close" type="button">×</button></span>';   

      var next = 1 + parseInt(setFilterCountForField);  
      
      //add filter query to the user interface
      addQueryUserFace(development);
      
      var productionData = {
        "merge" : nextAppend,
        "from"  : fromPro,
        "match" : matchPro,
        "when"  : putValPro
      };
      //add actual query parameters to the array
      addQueryProduction(productionData, fromPro, setFilterCountForField, clauseCount);

      //aftre adding filter activity call back
      callbackOnQueryMakerBox($(this), next);
    
    });


    function addQueryProduction(productionData, fromPro, count, clauseCount) {
      
      var dummyInputFilter = '';       
      $.each(productionData, function(index, value) { 
        if (clauseCount == 1 && index == 'merge') {
          value = '';
        }
        dummyInputFilter += '<input class="' + fromPro + ' clauseId-' + count + '" type="hidden" name=data[Filter][' + fromPro + '][' + count + '][' + index + '] value="' + value + '" />';
       
      });     
      
      $("DIV.put-filter-env DIV.control-group DIV#production input:last").after(dummyInputFilter);

    }//end addQueryProduction()

    function addQueryUserFace(development) {
      
      $("#development").append(development);      
      $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append").attr('disabled', true);
      
      //$("#addMoreStrainer").removeClass("hide");
      $(".addMultiple").removeClass("hide");

    }//end addQueryUserFace()

    function callbackOnQueryMakerBox(obj, next) {
      
      $(obj).attr('counter', next);
      $(obj).attr('disabled', true);

    }//end callbackOnQueryMakerBox()

    //close button inside the query preview job
    $("#development").on('click', 'button.close', function() {
      var clauseId = $(this).attr('clauseid');
      var selectedColumn = $(this).attr('selected-column');

      var isFirst = false;
      // If first query remove than AND and OR will remove by the code
      if ($("#production input.clauseId-" + clauseId).val() == '') {
        isFirst =true;
      }

      $("#production input.clauseId-" + clauseId).remove();
      $(this).closest('span').remove();

      if (isFirst) {
        $("#development span span.prepend:first").remove();
        $('#production input:eq(1)').val("");
        //$("#addMoreStrainer").addClass("hide");
      }

      var clauseCount =  $("#production input").length;
      //If the strainer is completly empty
      if (clauseCount == 1) {
        $("#addMoreStrainer").addClass("hide");
        $("#provide-filter").addClass('hide');
      }

      //EMPTY STRAINER WITH CURRENT FIELD
      if ($("#production input").hasClass(selectedColumn) == false) {
        $(".addMultiple").addClass("hide");
        $('#filter-select option').prop('selected', false);
        $("#set-filter ." + selectedColumn).remove();
        $("#filter-select").prop('disabled', false);
        $('#filter-select option[value="' + selectedColumn + '"]').prop('disabled', false);
        $(".condition-get").val(''); 
        $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append, #add-filter-job").prop('disabled', true);
       
        providerFilterStop();      
      }//end if


    });


    //add more filters to the field
    $("#add-more-filter-job").click(function() {
      $("#addMoreStrainer").removeClass("hide");
      reCleanStainer();     

    });

    function providerFilterStop() {
      $(".condition-get").val(''); 
      $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append, #add-filter-job").prop('disabled', true);

    }//end providerFilterStop()


    function reCleanStainer() {
      $("#add-filter-job").attr('disabled', false);
      $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append").attr('disabled', false);
      $(".condition-fill").val('');
    }//end reCleanStainer()

    /* Done Button using for done with this column */
    $("#done-filter-job").click(function() {
      var selectedColumn = $(this).attr('selected-column');
      reCleanStainer();
      $("#set-fill").removeClass('error');
      $(".condition-get").val('');
      $(".addMultiple").addClass("hide");
      $("#filter-select").prop('disabled', false);
      $('#filter-select option[value="' + selectedColumn + '"]').prop('disabled', true);
      $(".condition-get, #set-fill input, #set-fill select, #filter-match-type, #next-filter-append, #add-filter-job").attr('disabled', true);
      //$('#filter-select option:').prop('disabled', false);
    });


    function changeSelectOption(elementType) {
      
      var elementIndex = 0;
      switch(elementType) {           
        case 'int':                
            elementIndex = new Array('=', '>', '<', '>=', '<=', 'LIKE');
            break;            
        case 'varchar':
            elementIndex = new Array('=', 'LIKE');
            break;            
        case 'datetime':
            elementIndex = new Array('=', '>', '<', '>=', '<=');
            break;            
        case 'timestamp':
            elementIndex = new Array('=', '>', '<', '>=', '<=');
            break;            
        case 'text':
            elementIndex = new Array('=', 'LIKE');
            break;            
        case 'string':
            elementIndex = new Array('=', 'LIKE');
            break;                       
        default :                
            console.log('invalid Data type'+elementType);
            break;            
      }//end switch     
        
      if (elementIndex) {          
        $("#filter-match-type option").each(function(index, dom) {      
          if (($.inArray($(this).val(), elementIndex)) >= 0) {
            $(this).removeClass('hide');
          } else {                
            $(this).addClass('hide');
          }                       
        });
      }//end if
        
    }

  /*Script For Filter Funtionality Manage */


  /*Script For Sorting Funtionality Manage */   
    $(".sort-row-add").click(function() {
   
      var currentRowId = $(this).attr('sort-row');
      var nextRowId = $(this).attr('next-row'); 
     // "#sort table tr#" + currentRowId + " select.sort-select-column"

      var currentRow = {
        "columnValue" : $("#sort table tr#" + currentRowId + " select.sort-select-column option:selected").val(),
        "orderValue"  : $("#sort table tr#" + currentRowId + " select.sort-select-order option:selected").val(),
        "columnText" : $("#sort table tr#" + currentRowId + " select.sort-select-column option:selected").text(),
        "orderText"  : $("#sort table tr#" + currentRowId + " select.sort-select-order option:selected").text()
      };

      if ($("#sort table tr").hasClass(currentRow.columnValue)) {
        alert("This column is already selected for sorting");
        return false;
      }
    
      nextRowId = 1 + parseInt(nextRowId);
      if (onSortingSave(nextRowId, currentRow)) {     
        $(this).attr('next-row', nextRowId ); 
        return false;     
      }

    });

    function onSortingSave(nextRowId, currentRow) {   

       //nextRowId = 1 + parseInt(nextRowId); 

      var radioClass = $('#sort-group').is(':checked') ? '' : 'hide';
      
      var columnContent = "<span class='sort-column-label label'>" + currentRow.columnText + "</span>";
      var columnProduction = '<input type="hidden" value="' + currentRow.orderValue + '" name="data[Sorting][' + nextRowId + '][' + currentRow.columnValue + ']" />';
      var orderContent = "<span class='sort-order-label label'>" + currentRow.orderText + "</span>";
      var action = '<a href="javascript:;" id="row-' + nextRowId + '" class="btn sort-row-del">Remove</a>';
      var rowContent = '';
      rowContent = "<tr id='row-" + nextRowId + "' class='" + currentRow.columnValue + "'>";
      rowContent += "<td>" + columnContent + columnProduction + "</td>";
      rowContent += "<td>" + orderContent + "</td>";
      rowContent += "<td><input type='radio' name='data[Sorting][row]' class='" + radioClass + "' value='" + currentRow.columnValue + "' /></td>";
      rowContent += "<td>" + action + "</td>";
      rowContent += "</tr>";    
     
      $("#sort table tbody tr:last").after(rowContent);    

      return true;

    }//end onSortingSave()


    $("table").on('click', '.sort-row-del', function() {
      var currentRowId = $(this).attr('id');
      $("#sort table tr#" + currentRowId).remove();

    });


    $("#sort-group").click(function(){

      if($(this).is(":checked")) {
        $("table tr td input[type=radio]").removeClass('hide');
      } else {
        $("table tr td input[type=radio]").addClass('hide');
      }
            //alert("sd");
    });




  /*Script For Sorting Funtionality Manage */


  });
</script>  

@endsection            

@section('content-header')
<h2><i class="icofont-file"></i> {{ 'Create Report' }}</h2>

     
@endsection

@section('content-breadcrumb')

    @include('voterreport/nav-bar')
    <ul class="breadcrumb">
      <li><a href="{{ URL::to_action('voterreport@create_new') }}"><i class="icofont-group"></i> {{ __('report.create_report') }}</a> <span class="divider">&rsaquo;</span></li>        
    </ul>

    
    <ul class="nav nav-tabs breadcrumb-nav" id="myTab">
      <li class="active"><a href="#nametab">Name</a></li>
      <li class="divider"></li>
      <li><a href="#columntab">Column</a></li>
      <li class="divider"></li>
      <li><a href="#filtertab">Filter</a></li>
      <li class="divider"></li>
      <li><a href="#sorttab">Sort</a></li>
      <!--<li class="divider"></li>
      <li><a href="#grouptab">Group</a></li>-->
      <li class="divider"></li>
      <li><a href="#layouttab">Layout</a></li>
    </ul>
    
  
@endsection



@section('content-body')
  <form method="post" action="{{URL::to_action('voterreport@create_new')}}/{{$id}}"> 
    {{ Form::token() }}

    <?php 
    if (!empty($data->filters)) {
      $data->filters = unserialize($data->filters); 
    }    
    ?>
    <div class="tab-content">
      <div class="tab-pane active" id="nametab">@include('voterreport.create.name')</div>
      <div class="tab-pane" id="columntab">@include('voterreport.create.column')</div>
      <div class="tab-pane" id="filtertab">@include('voterreport.create.filter')</div>
      <div class="tab-pane" id="sorttab">@include('voterreport.create.sort')</div>
      <div class="tab-pane" id="grouptab">@include('voterreport.create.group')</div>
      <div class="tab-pane" id="layouttab">@include('voterreport.create.layout')</div>
    </div>
    <!-- Option content for hide/show popup -->

          <!-- Button trigger modal -->
          <a id="columnDailogLink" data-toggle="modal" href="#myColumnDialog" class="hide">Launch demo modal</a>

          <!-- Modal -->
          <div class="modal hide" id="myColumnDialog" style="height:100px">
            <div class="modal-dialog">
              <div class="modal-content">       
                <div class="modal-body" style="text-align:center;margin-top:10px;">
                  <h2>Please Select any column</h2>
                </div>       
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

    <!-- Option content for hide/show popup -->
    <?php $pushButton = (isset($data->filters) && !empty($data->filters)) ? '' : 'hide'; ?>
    <div class="form-actions <?php echo $pushButton; ?>">
      <button type="submit" class="btn btn-primary">Generate Report</button>
      <a href="{{  URL::to_action('voterreport@index') }}" class="btn">Cancel</a>
    </div>
  {{ Form::close() }}

@endsection



@section('sidebar-right-control')
   
@parent
@endsection

@section('sidebar-right-content')
 
@parent
@endsection                   