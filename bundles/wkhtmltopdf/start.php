<?php
//echo Bundle::path('wkhtmltopdf').'libraries';

/*
Autoloader::namespaces(array(
    'wkhtmltopdf\libraries\Wkhtmltopdf' => Bundle::path('wkhtmltopdf'). 'libraries' . DS . 'Wkhtmltopdf',
));
*/

Autoloader::map(array( 'Wkhtmltopdf' => Bundle::path('wkhtmltopdf'). 'libraries' . DS . 'wkhtmltopdf.php' ));