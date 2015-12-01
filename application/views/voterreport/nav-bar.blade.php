<ul class="breadcrumb-nav pull-right">
    <li class="divider"></li>
    <li class="">
        <a class="" href="{{ URL::to_action('voterreport@index') }}"><i class="icon-home"></i>Home</a>
                    
    </li>
    <li class="divider"></li>
    <li class="dropdown">		    
    	<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-list-alt"></i> Report Layout<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
            	<a id="btn-create_new_tpl" href="{{ URL::to_action('voterreport@tpl_new') }}" role="button" class="btn btn-small btn-link">
                <i class="icofont-file"></i> {{ __('report.create_template') }}  
                </a>
            </li>
            <li>
            	<a id="btn-create_new_report" href="{{ URL::to_action('voterreport@tpl_list') }}" role="button" class="btn btn-small btn-link">
                <i class="icofont-list"></i> {{ __('report.list_template') }}  
                </a>
            </li>               
        </ul>		   		
	</li>
	<li class="divider"></li>		
    <li class="dropdown">
    	<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-print"></i> Reports<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
            	<a id="btn-create_new_report" href="{{ URL::to_action('voterreport@create_new') }}" role="button" class="btn btn-small btn-link">
                <i class="icofont-file"></i> {{ __('report.create_report') }}  
                </a>
            </li>
            <li>
            	<a id="btn-create_new_report" href="{{ URL::to_action('voterreport@index') }}" role="button" class="btn btn-small btn-link">
                <i class="icofont-list"></i> {{ __('report.list_report') }}  
                </a>
            </li>               
        </ul>
	</li>
</ul>