<?php
/**
 * Valid Options. This prevent code injections. 
 * 
 * Not all options available in WRKHTMLTOPDF were added in this list. Be
 * free to add missing options. 
 */ 

return array(
  'title'         => array(
    'hasArgument' => true,
    'decription'  => 'The title of the generated pdf file (The title of the first document is used if not specified)',
  ), 
  'page-size'     => array(
    'hasArgument' => true,
    'decription'  => 'Set paper size to: A4, Letter, etc. (default A4)',
  ), 
  'orientation'   => array(
    'hasArgument' => true,
    'decription'  => 'Set orientation to Landscape or Portrait',
  ), 
  'copies'        => array(
    'hasArgument' => true,
    'decription'  => 'Number of copies to print into the pdf file (default 1)',
  ), 
  'dpi'           => array(
    'hasArgument' => true,
    'decription'  => 'Change the dpi explicitly (this has no effect on X11 based systems)',
  ), 
  'help'          => array(
    'hasArgument' => false,
    'decription'  => 'Display help',
  ), 
  'extended-help' => array(
    'hasArgument' => false,
    'decription'  => 'Display more extensive help, detailing',
  ), 
  'quit'          => array(
    'hasArgument' => false,
    'decription'  => 'Be less verbose',
  ), 
  'version'       => array(
    'hasArgument' => false,
    'decription'  => 'Output version information an exit',
  ),
  'grayscale'     => array(
    'hasArgument' => false,
    'decription'  => 'PDF will be generated in grayscale',
  ),
  'grayscale'     => array(
    'hasArgument' => false,
    'decription'  => 'PDF will be generated in grayscale',
  ),
  'image-dpi'     => array(
    'hasArgument' => true,
    'decription'  => 'When embedding images scale them down to this dpi (default 600)',
  ),
  'image-quality' => array(
    'hasArgument' => true,
    'decription'  => 'When jpeg compressing images use this quality (default 94)',
  ),
  'lowquality'    => array(
    'hasArgument' => false,
    'decription'  => 'Generates lower quality pdf/ps. Useful to shrink the result document space',
  ),
  'margin-bottom' => array(
    'hasArgument' => true,
    'decription'  => 'Set the page bottom margin (default 10mm)',
  ),
  'margin-left' => array(
    'hasArgument' => true,
    'decription'  => 'Set the page left margin (default 10mm)',
  ),
  'margin-right' => array(
    'hasArgument' => true,
    'decription'  => 'Set the page right margin (default 10mm)',
  ),
  'margin-top' => array(
    'hasArgument' => true,
    'decription'  => 'Set the page top margin (default 10mm)',
  ),
  'output-format' => array(
    'hasArgument' => true,
    'decription'  => 'pecify an output format to use pdf or ps, instead of looking at the extention of the output filename',
  ),
  'page-height' => array(
    'hasArgument' => true,
    'decription'  => 'Page height',
  ),
  'page-width' => array(
    'hasArgument' => true,
    'decription'  => 'Page width',
  ),
  'no-pdf-compression' => array(
    'hasArgument' => false,
    'decription'  => 'Do not use lossless compression on pdf objects',
  ),
  'version' => array(
    'hasArgument' => false,
    'decription'  => 'Output version information an exit',
  ),
  
  'background' => array(
    'hasArgument' => false,
    'decription'  => 'Do print background (default)',
  ),
  
  'background' => array(
    'hasArgument' => false,
    'decription'  => 'Do print background (default)',
  ),    
   
);

/*

Page Options:
      --allow <path>                  Allow the file or files from the specified
                                      folder to be loaded (repeatable)
      --                    
      --no-background                 Do not print background
      --checkbox-checked-svg <path>   Use this SVG file when rendering checked
                                      checkboxes
      --checkbox-svg <path>           Use this SVG file when rendering unchecked
                                      checkboxes
      --cookie <name> <value>         Set an additional cookie (repeatable)
      --custom-header <name> <value>  Set an additional HTTP header (repeatable)
      --custom-header-propagation     Add HTTP headers specified by
                                      --custom-header for each resource request.
      --no-custom-header-propagation  Do not add HTTP headers specified by
                                      --custom-header for each resource request.
      --debug-javascript              Show javascript debugging output
      --no-debug-javascript           Do not show javascript debugging output
                                      (default)
      --default-header                Add a default header, with the name of the
                                      page to the left, and the page number to
                                      the right, this is short for:
                                      --header-left='[webpage]'
                                      --header-right='[page]/[toPage]' --top 2cm
                                      --header-line
      --encoding <encoding>           Set the default text encoding, for input
      --disable-external-links        Do not make links to remote web pages
      --enable-external-links         Make links to remote web pages (default)
      --disable-forms                 Do not turn HTML form fields into pdf form
                                      fields (default)
      --enable-forms                  Turn HTML form fields into pdf form fields
      --images                        Do load or print images (default)
      --no-images                     Do not load or print images
      --disable-internal-links        Do not make local links
      --enable-internal-links         Make local links (default)
  -n, --disable-javascript            Do not allow web pages to run javascript
      --enable-javascript             Do allow web pages to run javascript
                                      (default)
      --javascript-delay <msec>       Wait some milliseconds for javascript
                                      finish (default 200)
      --load-error-handling <handler> Specify how to handle pages that fail to
                                      load: abort, ignore or skip (default
                                      abort)
      --disable-local-file-access     Do not allowed conversion of a local file
                                      to read in other local files, unless
                                      explecitily allowed with --allow
      --enable-local-file-access      Allowed conversion of a local file to read
                                      in other local files. (default)
      --minimum-font-size <int>       Minimum font size
      --exclude-from-outline          Do not include the page in the table of
                                      contents and outlines
      --include-in-outline            Include the page in the table of contents
                                      and outlines (default)
      --page-offset <offset>          Set the starting page number (default 0)
      --password <password>           HTTP Authentication password
      --disable-plugins               Disable installed plugins (default)
      --enable-plugins                Enable installed plugins (plugins will
                                      likely not work)
      --post <name> <value>           Add an additional post field (repeatable)
      --post-file <name> <path>       Post an additional file (repeatable)
      --print-media-type              Use print media-type instead of screen
      --no-print-media-type           Do not use print media-type instead of
                                      screen (default)
  -p, --proxy <proxy>                 Use a proxy
      --radiobutton-checked-svg <path> Use this SVG file when rendering checked
                                      radiobuttons
      --radiobutton-svg <path>        Use this SVG file when rendering unchecked
                                      radiobuttons
      --run-script <js>               Run this additional javascript after the
                                      page is done loading (repeatable)
      --disable-smart-shrinking       Disable the intelligent shrinking strategy
                                      used by WebKit that makes the pixel/dpi
                                      ratio none constant
      --enable-smart-shrinking        Enable the intelligent shrinking strategy
                                      used by WebKit that makes the pixel/dpi
                                      ratio none constant (default)
      --stop-slow-scripts             Stop slow running javascripts (default)
      --no-stop-slow-scripts          Do not Stop slow running javascripts
      --disable-toc-back-links        Do not link from section header to toc
                                      (default)
      --enable-toc-back-links         Link from section header to toc
      --user-style-sheet <url>        Specify a user style sheet, to load with
                                      every page
      --username <username>           HTTP Authentication username
      --window-status <windowStatus>  Wait until window.status is equal to this
                                      string before rendering page
      --zoom <float>                  Use this zoom factor (default 1)

Headers And Footer Options:
      --footer-center <text>          Centered footer text
      --footer-font-name <name>       Set footer font name (default Arial)
      --footer-font-size <size>       Set footer font size (default 12)
      --footer-html <url>             Adds a html footer
      --footer-left <text>            Left aligned footer text
      --footer-line                   Display line above the footer
      --no-footer-line                Do not display line above the footer
                                      (default)
      --footer-right <text>           Right aligned footer text
      --footer-spacing <real>         Spacing between footer and content in mm
                                      (default 0)
      --header-center <text>          Centered header text
      --header-font-name <name>       Set header font name (default Arial)
      --header-font-size <size>       Set header font size (default 12)
      --header-html <url>             Adds a html header
      --header-left <text>            Left aligned header text
      --header-line                   Display line below the header
      --no-header-line                Do not display line below the header
                                      (default)
      --header-right <text>           Right aligned header text
      --header-spacing <real>         Spacing between header and content in mm
                                      (default 0)
      --replace <name> <value>        Replace [name] with value in header and
                                      footer (repeatable)

TOC Options:
      --disable-dotted-lines          Do not use dottet lines in the toc
      --toc-header-text <text>        The header text of the toc (default Table
                                      of Content)
      --toc-level-indentation <width> For each level of headings in the toc
                                      indent by this length (default 1em)
      --disable-toc-links             Do not link from toc to sections
      --toc-text-size-shrink <real>   For each level of headings in the toc the
                                      font is scaled by this facter (default
                                      0.8)
      --xsl-style-sheet <file>        Use the supplied xsl style sheet for
                                      printing the table of content
  */
