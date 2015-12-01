<?php
	
/**
 * Provides a very simple way to export website content to PDF or Image (PNG, JPG, etc).
 *
 * This bundle uses PhantomJS engine to generate the website screen capture
 * For more info about PhantomJS, check out: http://phantomjs.org
 *
 * @package 	Htmlexport
 * @version 	1.0
 * @author 		jitz
 * @link 		
 * @license   MIT License
 * @example
 *
 *		$file = Htmlexport::open('http://google.com')
 *						->filetype('pdf')
 *						->orientation("portrait")
 *						->size("letter")
 *						->margin(0)  
 *						->get()
 *						->save('outputfile.pdf');	
 */


class Htmlexport {
	/*
	 * Temporary file
	 */
	private $filename;

	/*
	 * URL to export.
	 */
	private $url;

	/*
	 * Last error message.
	 */
	private $error;

	/*
	 * Viewport object.
	 * This property sets the size of the viewport for the layout process   
	 */
	private $viewport = array(0,0);
  
  
  /*
	 * Page orientation ('portrait', 'landscape')
	 */
	private $orientation = 'portrait';
  
  /*
	 * Page format ('A3', 'A4', 'A5', 'Legal', 'Letter', 'Tabloid')
	 */
	private $format = 'Letter';
  
  /*
	 * File type: pdf or png
	 */
	private $filetype = 'pdf';

	/**
	 * Instantiates the Htmlexport and receives the url to the site we want to export.
	 *    
	 * @param string $url - The url to the site we want to export.
	 */
	function __construct($url) {
		$this->url = $url;
	}
  
  /**
	 * Cleaning up...
	 */
  function __destruct() {
     if (file_exists($this->filename)) {
       unlink($this->filename);
     }
   }
  
  /**
	 * Returns a new htmlexport object, allowing for chainable calls.
	 *    
	 * @param string $url The url to the site we want to export.
	 * @return object Htmlexport object.
	 */
	public static function open( $url ){
    return new Htmlexport( $url );
	}

	/**
	 * Sets the url to the site we want to export.
	 *    
	 * @param string $url The url to the site we want to export.
	 * @return object htmlport object.
	 */
	public function url($url) {
		$this->url = $url;
		return $this;
	}

	/**
	 * Sets the desired file type for the screenshot.
	 * @param string $type The file extension for the screenshot.
	 * @return object Htmlexport object. 
	 */
	public function filetype($type) {
		$supported = array('png','gif','jpeg','jpg','pdf');
		$type = strtolower($type);
		if (in_array($type, $supported)) $this->filetype = $type;
		return $this;
	}

	/**
	 * Sets the page orientation
	 *    
	 * @param string $orientation - Page orientation (Portrait or Landscape).
	 * @return object Htmlexport object. 
	 */
	public function orientation($orientation) {
		$supported = array('portrait','landscape');
		$orientation = strtolower($orientation);
		if (in_array($orientation, $supported)) $this->orientation = $orientation;
		return $this;
	}
  
  /**
	 * Sets the page format
	 *    
	 * @param string $format - Page Format ('A3', 'A4', 'A5', 'Legal', 'Letter', 'Tabloid').
	 * @return object Htmlexport object. 
	 */
	public function paper($format) {
		$supported = array('A3', 'A4', 'A5', 'Legal', 'Letter', 'Tabloid');
		$format = ucfirst ($format);
		if (in_array($format, $supported)) $this->format = $format;
		return $this;
	}

	/**
	 * Initiates screen capture.
	 * @return object Htmlexport object.
	 */
	public function get() {
		$this->filename = tempnam(path('storage').'tmp/', "htmlexport_"); 
	    // Deletes the file that was just created. We just need the file name.
	    unlink($this->filename);
	    $this->filename .= '.'.$this->filetype;
	    $command =  $this->getCommand();
	    $this->executeCommand($command);
		return $this;
	}
  
  /**
   * Executes command
   *         
   * @param string $command - Command to be executed
   */
  private function executeCommand($command) {
    // we use proc_open with pipes to fetch error output
    $descriptorspec = array(
          1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to
          2 => array('pipe', 'a')   // stderr is a pipe that the child will append to
      );       
    
    $process = proc_open($command, $descriptorspec, $pipes);


    if(is_resource($process)) {
      // get outputs to check the progress
      while (true) {
        sleep(1);
        $status = proc_get_status($process);

        $stdout_msg = stream_get_contents($pipes[1]);
        if($stdout_msg) {
          foreach(explode("\n", $stdout_msg) as $msg) {
            if(!empty($msg)) Event::fire('htmlexport.progress', array("Creating PDF - {$msg}")); 
          }
        }
        
        $stderr_msg = stream_get_contents($pipes[2]);
        if($stderr_msg) {
          throw new Exception($stderr_msg);
        }
        
        // If not running exit the loop
        if (!$status['running']) break;
        
      }
      fclose($pipes[1]);
      fclose($pipes[2]);
      
        /*
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $result = proc_close($process);

        if($result!==0)
            $this->error = "Could not run command $command:\n$stderr";
        */    
    } else
        throw new Exception("Could not run command $command.");
    
    
  }

	/**
	 * Returns location of the captured file.
	 * @return string Path of the captured image.
	 */
	public function file() {
		return (file_exists($this->filename)) ? $this->filename : false;
	}

	/**
	 * Copies the file to the desired path.
	 * @param string $target Path to the desired location, including filename.
	 * @return boolean
	 */
	public function save($target) {
		return copy($this->filename, $target);
	}
  
	/**
	 * Returns contents of the captured file.
	 * @return binairy
	 */
	public function contents() {
		return  (file_exists($this->filename)) ? File::get($this->filename) : false;
	}

	/**
	 * Returns the error message in case of an error.
	 * @return string Error message.
	 */
	public function error() {
		return $this->error;
	}

	/**
	 * Generates PhantomJS shell command.
	 * @return string Shell command.
	 */
	private function getCommand() {

		if (PHP_OS == Linux) {
			$phantom_path = Config::get("htmlexport::htmlexport.phantom", __DIR__  . DS . 'phantomjs_linux');
		} else {
			$phantom_path = Config::get("htmlexport::htmlexport.phantom", __DIR__  . DS . 'phantomjs');
		}
		
	    $script = __DIR__  . DS . 'render.js';
	    $url = "'".$this->url."'";
	    $output_file = $this->filename;
	    $pageFormat = $this->format;
	    $pageOrientation = $this->orientation;
	    $zoomFactor = 1;
     
		$cmd = "{$phantom_path} {$script} {$url} {$output_file} {$pageFormat} {$pageOrientation} {$zoomFactor}";

		return $cmd;
	}

	

}