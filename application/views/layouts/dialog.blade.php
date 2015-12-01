                                                                         <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ __('application.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Croissant+One' rel='stylesheet' type='text/css'>
        {{ Asset::styles() }}
        {{ Asset::scripts() }}
        
        @section('additional-header-injection')
        @yield_section
        
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- section content -->
        <section class="section">
            <div class="row-fluid">
                <!-- span content -->
                <div class="span12">
                    <!-- content -->
                    <div class="dlg-content">
                        @section('content-body')
                        @yield_section    
                    </div><!-- /content -->
                </div><!-- /span content -->
            </div>
        </section>

    </body>
</html>