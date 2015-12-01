@layout('layouts/main')


@section('content-header')
  <h2><i class="icofont-warning-sign"></i> Access Denied</h2>
@endsection

@section('content-breadcrumb')
    <!--breadcrumb-nav-->
    <ul class="breadcrumb-nav pull-right">
        <li class="divider"></li>
        <li class="btn-group">
            <a href="#" role="button" class="btn btn-small btn-link">
                <i class="icofont-envelope"></i> Contact your sytem administrator
            </a>
        </li>
    </ul>
    
     <!--/breadcrumb-nav-->
    <!--breadcrumb-->
    <ul class="breadcrumb">
      <li><a href="#"><i class="icofont-warning-sign"></i> Access Denied</a> <span class="divider">&rsaquo;</span></li>
      <li class="active">Error</li>
    </ul><!--/breadcrumb-->
@endsection



@section('content-body')
<div class="row-fluid">
  <div class="span12">
    <dl>
        <dt><h3 class="color-red"><i class="icofont-warning-sign"></i> Access to the web page was denied!</h3></dt>
        <dd>{{ $error }}</dd>
    </dl>
  </div> 
</div>  
@endsection


@section('sidebar-right-header')
@endsection

@section('sidebar-right-control')
  @parent
@endsection

@section('sidebar-right-content')
  @parent
@endsection                   