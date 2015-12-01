<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>@section('title') 
      {{ __('application.name') }} 
      @yield_section
      </title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='http://fonts.googleapis.com/css?family=Croissant+One' rel='stylesheet' type='text/css'>
      {{ Asset::styles() }}
      {{ Asset::scripts() }}
    </head>
    <body>
        
    @section('form')
    @yield_section
        
    </body>
</html>