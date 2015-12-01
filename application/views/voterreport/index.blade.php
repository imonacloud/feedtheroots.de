@layout('layouts/main')

@section('additional-js-header-injection')
  @parent
  var list_baseurl = "{{ URL::to_action('voterreport@create_new') }}";
@endsection  

@section('additional-header-injection')
<script type="text/javascript">

    $(document).ready(function() {
      $("a[id*='btn-delete-']").click(function(event) {     
           event.preventDefault();
         var id = $(this).attr('id');
         var id_split    = id.split('-');
         var voterreport_id  = id_split[2];       
         openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@delete') }}/" + voterreport_id, null, false, false);   
         return false;
        });

        $("a[id*='btn-edit-tpl-']").click(function(event) {     
           event.preventDefault();
         var id = $(this).attr('id');
         var id_split    = id.split('-');
         var voterreport_id  = id_split[3];       
         openGeneralDialogAndGetContent("{{ URL::to_action('voterreport@tpl_preview') }}/" + voterreport_id, null, false, false);   
         return false;
        });
    });  

</script>
@endsection        

@section('content-header')
    <h2><a href="{{ URL::to_action('voterreport@index') }}" ><i class="icofont-list"></i> {{ 'Reports' }}</a></h2>
@endsection

@section('content-breadcrumb')
    <!--breadcrumb-->
    @include('voterreport/nav-bar')
    
    <ul class="breadcrumb">
      <li><a href="{{ URL::to_action('voterreport@index') }}"><i class="icofont-group"></i> Report List</a> <span class="divider">&rsaquo;</span></li>
    
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">    

  <table id="datatables" class="table table-bordered table-striped table-hover responsive">
    <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Template</th> 
          <th>Action</th>             
        </tr>
    </thead>
    <tbody>      
      @foreach ($reports->results as $report)

      <tr>
        <td style="vertical-align: middle;">{{ $report->name }}</td>
        <td style="vertical-align: middle;">{{ $report->description }}</td>
        <td style="vertical-align: middle;">
          <?php
          if (!empty($report->reporttemplate->id)) {
            ?>
            <a href="#" class="btn-link" id="btn-edit-tpl-<?php echo $report->reporttemplate->id;?>" >
            <?php                   
                    echo $report->reporttemplate->name;                   
            ?>
                  </a>
                  <?php 
                } else {
                  echo 'N/A';
                }
                ?>
        </td>
       
         <td>
            <div class="btn-group" style="margin: 0;">
              <button class="btn btn-mini dropdown-toggle btn-inverse" data-toggle="dropdown">{{ __('general.actions') }} <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li style="text-align:center"><b>Generate Report</b></li>
                <li class="divider"></li>
                <li><a href="{{ URL::to_action('voterreport@list')}}/{{$report->id}}">HTML</a></li>               
                <li><a href="{{ URL::to_action('voterreport@list')}}/{{$report->id}}/?download=csv">CSV</a></li>
               
                <li class="divider"></li>
                <li><a href="{{ URL::to_action('voterreport@create_new')}}/{{$report->id}}"><i class="icon-edit"></i>Edit</a></li>
                <li><a id="btn-delete-{{ $report->id }}" href="#"><i class="icon-trash"></i>Delete</a></li>
                <li class="divider"></li>
             
              </ul>
            </div>
          </td>
        </tr>
    @endforeach  
        
    </tbody>
  </table>
  <div class="row-fluid">
    <div class="span6">    
    </div>
    <div class="span6" style="text-align: right">
      {{ $reports->links(1) }}
    </div>
  </div>  
   
  </div> 
</div>

@endsection

@section('sidebar-right-control')
    
    @parent
@endsection

@section('sidebar-right-content')
<!--/Voter Lists -->

@parent
@endsection                   