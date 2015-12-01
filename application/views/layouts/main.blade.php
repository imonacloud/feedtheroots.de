<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ __('application.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Croissant+One' rel='stylesheet' type='text/css'>
        
        <!-- styles -->
        {{ Asset::container('bootstrapper')->styles(); }}
        {{ Asset::styles() }}
        <!-- /styles -->
        
        <!-- header-javascripts -->
        {{ Asset::scripts() }}
        <!-- /header-javascripts -->
        
        <script type="text/javascript">
            @section('additional-js-header-injection')
                var task_baseurl = "{{ URL::to('tasks') }}";
            @yield_section
        </script>

        @section('additional-header-injection')
        @yield_section
        
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
         <!-- section header --> 
        <header class="header">
            <!--nav bar helper-->
            <div class="navbar-helper">
                <div class="row-fluid">
                    <!--panel site-name-->
                    <div class="span2">
                        <div class="panel-sitename">
                            <h2 class="logo"><a href="{{ URL::to('dashboard') }}">{{ __('application.logo') }}</h2>
                            <div class='notifications center'></div>
                        </div>
                    </div>
                    <!--/panel name-->

                    <div class="span4">
                        <!--panel search-->
                        <div class="panel-search">
                            @section('top-search-form')
                            @yield_section
                            <!--
                            <form class="form-search">
                                <div class="input-icon-append">
                                    <button type="submit" rel="tooltip-bottom" title="search" class="icon"><i class="icofont-search"></i></button>
                                    <input class="input-large search-query grd-white" maxlength="23" placeholder="{{ __('header.search_placeholder') }}" type="text">
                                </div>
                            </form>
                            -->
                        </div><!--/panel search-->
                    </div>
                    <div class="span4" style="padding-right: 10px;">
                        <!--panel button ext-->
                        <div class="panel-ext">
                            <!--notification-->
                            <!--
                            <div class="btn-group">
                                
                                <a class="btn btn-danger btn-small" data-toggle="dropdown" href="#" title="3 notification">3</a>
                                <ul class="dropdown-menu dropdown-notification">
                                    <li class="dropdown-header grd-white"><a href="#">View All Notifications</a></li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">John Doe commented on a post</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lorem ipsum <small class="helper-font-small"> john doe</small></h4>
                                                    <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Tortor dapibus</h4>
                                                    <p>Vegan fanny pack odio cillum wes anderson 8-bit.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lacinia non</h4>
                                                    <p>Messenger bag gentrify pitchfork tattooed craft beer.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">John Doe commented on a post</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lorem ipsum <small class="helper-font-small"> john doe</small></h4>
                                                    <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Tortor dapibus</h4>
                                                    <p>Vegan fanny pack odio cillum wes anderson 8-bit.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lacinia non</h4>
                                                    <p>Messenger bag gentrify pitchfork tattooed craft beer.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                             -->
                            <!--
                            <div class="btn-group">
                                <a class="btn btn-inverse btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                                    Shortcut
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li><a tabindex="-1" href="calendar.html">Calendar</a></li>
                                    <li><a tabindex="-1" href="invoice.html">Invoice</a></li>
                                    <li><a tabindex="-1" href="message.html">Message</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Sample Page</a>
                                        <ul class="dropdown-menu">
                                            <li><a tabindex="-1" href="pricing.html">Pricing</a></li>
                                            <li><a tabindex="-1" href="bonus-page/resume/index.html">Resume</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Error Page</a>
                                        <ul class="dropdown-menu">
                                            <li><a tabindex="-1" href="403.html">Error 403</a></li>
                                            <li><a tabindex="-1" href="404.html">Error 404</a></li>
                                            <li><a tabindex="-1" href="405.html">Error 405</a></li>
                                            <li><a tabindex="-1" href="500.html">Error 500</a></li>
                                            <li><a tabindex="-1" href="503.html">Error 503</a></li>
                                            <li><a tabindex="-1" href="under-construction.html">Under Construction</a></li>
                                            <li><a tabindex="-1" href="coming-son.html">Coming Son</a></li>
                                        </ul>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a tabindex="-1" href="#">Something else here</a></li>
                                </ul>
                            </div>
                            
                            
                            <div class="btn-group">
                                <a class="btn btn-inverse btn-small" href="#">Other Action</a>
                            </div>
                             -->
                            <div class="btn-group user-group pull-right">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <img class="corner-all" align="middle" src="{{ Auth::user()->photo_thumb_url }}" title="{{ Auth::user()->name }}" alt="{{ Auth::user()->name }}" /> <!--this for display on PC device-->
                                    <button class="btn btn-small btn-inverse">{{ Auth::user()->name }}</button> <!--this for display on tablet and phone device-->
                                </a>
                                <ul class="dropdown-menu dropdown-user" role="menu" aria-labelledby="dLabel">
                                    <li>
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="img-circle" src="{{ Auth::user()->photo_url }}" title="profile" alt="profile" />
                                            </a>
                                            <div class="media-body description">
                                                <p><strong>{{ Auth::user()->name }}</strong></p>
                                                <p class="muted">{{ Auth::user()->email }}</p>
                                                <p class="action"><a class="link" href="#">Inbox (0)</a> - <a class="link" href="#">My settings</a></p>
                                                <a href="#" class="btn btn-primary btn-small btn-block">{{ __('header.view_profile') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-footer">
                                        <div>
                                            <a class="btn btn-small pull-right" href="{{ URL::to('logout') }}">{{ __('header.logout') }}</a>
                                            <a class="btn btn-small" href="#">Change my password</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!--panel button ext-->
                    </div>
                </div>
            </div><!--/nav bar helper-->
        </header>
        
        <!-- section content -->
        <section class="section">
            <div class="row-fluid">
                <!-- span side-left -->
                <div class="span1">
                    <!--side bar-->
                    <aside class="side-left">
                        <ul class="sidebar">
                            <li class="{{ URI::is( 'dashboard') ? 'active' : '' }} first"> <!--always define class .first for first-child of li element sidebar left-->
                                <a href="{{ URL::to('dashboard') }}" title="{{ __('menu.dashboard') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-dashboard"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.dashboard') }}</span>
                                </a>
                            </li>
                            <li {{ URI::is('voter/*') ? 'class="active"' : '' }}>
                                <a href="{{ URL::to_action('voter@list') }}" title="{{ __('menu.voters') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-group"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.voters') }}</span>
                                </a>
                            </li>
                            <li {{ URI::is('phonebanking*') ? 'class="active"' : '' }}>
                                <a href="{{ URL::to_action('phonebanking@list') }}" title="{{ __('menu.phone_banking') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-phone"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.phone_banking') }}</span>
                                </a>
                            </li>
                            <li {{ URI::is('canvass*') ? 'class="active"' : '' }}>
                                <a href="{{ URL::to_action('canvass@list') }}" title="{{ __('menu.canvass') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-list"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.canvass') }}</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#" title="{{ __('menu.intelligent_electoral_campaign') }}">
                                    <div class="badge badge-info">5</div>
                                    <div class="helper-font-24">
                                        <i class="icofont-bolt"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.iec') }}</span>
                                </a>
                                <ul class="sub-sidebar corner-top shadow-silver-dark">
                                    <li>
                                        <a href="#" title="{{ __('menu.robot_text') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-comments"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.robot_text') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="{{ __('menu.robot_call') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-phone"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.robot_call') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="{{ __('menu.bulk_email') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-envelope-alt"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.bulk_email') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="{{ __('menu.mailing') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-envelope"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.mailing') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="{{ __('menu.labels') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-th"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.labels') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li  {{ URI::is('voterreport*') ? 'class="active"' : '' }}>
                                <a href="{{ URL::to_action('voterreport@index') }}" title="{{ __('menu.reports') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-file"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.reports') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="{{ __('menu.election_day') }}">
                                    <div class="helper-font-24">
                                        <i class="icofont-flag"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.election_day') }}</span>
                                </a>
                            </li>
                            {{-- Start Account Settings Options --}}
                            <?php
                                // calculating the total number of options inside account settings
                                $account_settings_options = 0;
                                if(Auth::user()->has_access(Module::USERS, 'read')) {
                                    $account_settings_options++;
                                }
                                if(Auth::user()->is_admin()) {
                                    // if user is admin, we going to show roles and goals option.
                                    $account_settings_options+=2;
                                }

                            ?>
                            @if($account_settings_options>0)
                            <li {{ URI::is('user*') || URI::is('role*')? 'class="active"' : '' }}>

                                <a href="#" title="{{ __('menu.settings') }}">
                                    <div class="badge badge-info">{{ $account_settings_options }}</div>
                                    <div class="helper-font-24">
                                        <i class="icofont-cogs"></i>
                                    </div>
                                    <span class="sidebar-text">{{ __('menu.account_settings') }}</span>
                                </a>
                                
                                <ul class="sub-sidebar corner-top shadow-silver-dark">
                                    @if(Auth::user()->has_access(Module::USERS, 'read')) 
                                    <li {{ URI::is('user*') ? 'class="active"' : '' }}>
                                        <a href="{{ URL::to_action('user@list')}}" title="{{ __('menu.users') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-group"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.users') }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->is_admin())
                                    <li>
                                        <a href="{{ URL::to_action('role@list')}}" title="{{ __('menu.roles') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-key"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.roles') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::to('account/goals') }}" title="{{ __('menu.goals') }}">
                                            <div class="helper-font-24">
                                                <i class="icofont-flag"></i>
                                            </div>
                                            <span class="sidebar-text">{{ __('menu.goals') }}</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            {{-- End Account Settings Options --}}
                        </ul>
                    </aside><!--/side bar -->
                </div><!-- span side-left -->
                
                <!-- span content -->
                <div class="span9">
                    <!-- content -->
                    <div class="content">
                        <!-- content-header -->
                        <div class="content-header">
                        @section('content-header')
                        @yield_section
                        </div><!-- /content-header -->
                        
                        <!-- content-breadcrumb -->
                        <div class="content-breadcrumb">
                        @section('content-breadcrumb')
                        @yield_section
                        </div><!-- /content-breadcrumb -->
                        
                        <!-- content-body -->
                        <div class="content-body">
                            @include('errors')
                            @include('successes')
                            @include('warnings')
                            @include('informations')
                            
                            @section('content-body')
                            @yield_section   

                            {{-- general dialog container. the content of this dialog will change based on the ajax request is call --}}
                            @include('general/my-dialog')

                            {{-- initial dialog state... this dialog will be never shown. We only will get its content to show into the general dialog every time we going to open and want to show a loading progress --}}
                            @include('general/my-dialog-loading-content') 
                        </div><!--/content-body -->
                        
                    </div><!-- /content -->
                </div><!-- /span content -->
                
                <!-- span side-right -->
                <div class="span2">
                    <!-- side-right -->
                    <aside class="side-right">
                        <!-- sidebar-right -->
                        <div class="sidebar-right">
                            <!--sidebar-right-header-->
                            <div class="sidebar-right-header">
                              @section('sidebar-right-header')
                              @yield_section    
                              <!--
                                <div class="sr-header-right">
                                    <h2><span class="label label-info">$26,875</span></h2>
                                </div>
                                <div class="sr-header-left">
                                    <p class="bold">Balance</p>
                                    <small class="muted">Dec 30 2012</small>
                                </div>
                              -->   
                            </div><!--/sidebar-right-header-->
                            
                            <!--sidebar-right-control-->
                            <div class="sidebar-right-control">
                                <ul class="sr-control-item">
                                @section('sidebar-right-control')
                                <li {{ URI::is('role/list*') ? 'class="active"' : '' }}><a href="#emailTab" data-toggle="tab" title="Quick Email"><i class="icofont-envelope-alt"></i></a></li>
                                <li><a href="#tasksTab" data-toggle="tab" title="Report Tasks"><i class="icofont-tasks"></i></a></li>
                                @yield_section
                                </ul>
                            </div><!-- /sidebar-right-control-->
                            
                            <!-- sidebar-right-content -->
                            <div class="sidebar-right-content">
                                <div class="tab-content">
                                  @section('sidebar-right-content')
                                  <!--Quick Contact -->
                                  <div class="tab-pane fade{{ URI::is('role/list*') ? ' active in' : '' }}" id="emailTab">
                                    <div class="side-box">
                                        <form>
                                            <h5>Quick Email</h5>
                                            <div class="divider-content"><span></span></div>
                                            
                                            <div class="control-group">
                                                <label class="control-label" for="IconPrepand">To</label>
                                                <div class="controls">
                                                   <input id="IconPrepand" class="input-block-level grd-white" type="text"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="IconPrepand">Subject</label>
                                                <div class="controls">
                                                    <input id="IconPrepand" class="input-block-level grd-white" type="text"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Message</label>
                                                <div class="controls">
                                                    <textarea style="width: 94%;"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="divider-content"><span></span></div>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <input type="submit" class="btn btn-primary btn-block" value="Send" />
                                                </div>
                                            </div>
                                            
                                            <div class="divider-content"><span></span></div>
                                        </form>
                                    </div>
                                    
                                    
                                  </div><!--/Quick Contact -->
                                  <!-- side-task -->
                                  <div class="tab-pane fade" id="tasksTab">
                                        <div id="tasks-container" class="side-task">
                                        </div>
                                        <div class="divider-content"><span></span></div> <!--divider-->
                                  </div><!-- /side-task -->
                                  @yield_section
                                </div>
                            </div><!-- /sidebar-right-content -->
                        </div><!-- /sidebar-right -->
                    </aside><!-- /side-right -->
                </div><!-- /span side-right -->
            </div>
        </section>
    
        <!-- Javascript codes -->
        {{ Asset::container('bootstrapper')->scripts(); }}
        {{ Asset::container('footer')->scripts(); }}
        <!-- /Javascript codes -->

    </body>    
</html>