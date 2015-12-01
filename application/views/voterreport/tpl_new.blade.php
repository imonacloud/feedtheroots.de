@layout('layouts/main')

@section('additional-js-header-injection')

  var list_baseurl = "{{ URL::to_action('voterreport@list') }}";
@endsection        

@section('additional-header-injection')
<script type="text/javascript">

  $(document).ready(function() {
 
    $('textarea').jqte();    

    /*$("a[rel=popover]").popover();

    $("a[id*='-quick-view-']").click(function(event){
      event.preventDefault();
      var id = $(this).attr('id');
      var id_split    = id.split('-');
      var voter_id    = id_split[3];     
      openGeneralDialogAndGetContent("{{ URL::to_action('voter@quick_view') }}/" + voter_id, null, false, false);
    });    */ 

  });
</script>    
@endsection            

@section('content-header')
<?php $title = !empty($data) ? 'Edit Layout' : 'Create New Layout'; ?>
<?php $tplId = !empty($data) ? $data->id : ''; ?>
<h2><i class="icofont-file"></i> {{ $title }}</h2>

   
@endsection

@section('content-breadcrumb')

  @include('voterreport/nav-bar')
  <ul class="breadcrumb">
    <li><a href="{{ URL::to_action('voterreport@tpl_new') }}/<?php echo $tplId; ?>"><i class="icofont-group"></i> {{ $title }}</a> <span class="divider">&rsaquo;</span></li>
     
  </ul>
 
  
@endsection



@section('content-body')

<div class="row-fluid">
  <div class="span2"></div>

  <div class="span8">

    
   <form id="tpl-create-form" class="form" method="post" action="{{ URL::to_action('voterreport@tpl_new', array($tplId)) }}">
        {{ Form::token() }}
    <div class="row-fluid">
      <div class="span12">

        <fieldset>
          <div class="control-group">

        
            {{ Form::label('name', 'Name') }}
                
            {{ Form::text('name', !empty($data) ? $data->name : Input::old('name')) }}

        </div>
         <div class="control-group">
            {{ Form::label('Header', 'Header') }}
            {{ Form::textarea('header', !empty($data) ? $data->header : Input::old('header')) }}
          </div>

           <div class="control-group">
            {{ Form::label('footer', 'Footer') }}
            {{ Form::textarea('footer', !empty($data) ? $data->footer : Input::old('footer')) }}
          </div>
         

          {{ Form::submit('Submit') }}

        </fieldset>
      </div>
    </div>
          
    {{ Form::close() }}  

  </div>
</div>



@endsection



@section('sidebar-right-control')
   
@parent
@endsection

@section('sidebar-right-content')
 
@parent
@endsection                   