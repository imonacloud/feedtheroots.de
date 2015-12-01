<?php

/**
 * Simple class for creating PDF using wkhtmltopdf 
 *
 * @package Wkhtmltopdf
 *
 * @author  jitz 
 */
 
class Wkhtmltopdf {
   
   private $bin;
   private $valid_options = array();
   private $options = array();
   private $objects = array();
   
   /**
     * Constructor
     *
     * @param  array $options - options for wkhtmltopdf (optional)
     */
    public function __construct($options=array()) {
      // Gets the program pathname
      $this->bin = Config::get("wkhtmltopdf::path.bin");
      
      // Gets valid options
      $this->valid_options = Config::get("wkhtmltopdf::options"); 
      
      // Gets default options
      $this->setOptions(Config::get("wkhtmltopdf::default.options"));
      
      // Append or override options
      if(is_array($options)) {
        $this->setOptions($options);
      }
    }
    
    /**
     * Sets an array of options
     *
     * @param  array $options - An associative array of options as key/value
     */
    public function setOptions(array $options) {
      foreach ($options as $key => $value) {
        $this->setOption($key, $value);
      }
    }
    
    /**
     * Sets an option. 
     *
     * @param  string $key - The option name to set
     * @param  mixed  $value - The value
     */
    public function setOption($key, $value) {
      if (!array_key_exists($key, $this->valid_options)) {
        throw new Exception(sprintf('The option \'%s\' is not valid.', $key));
      }
      
      $this->options[$key] = $value;
    }
    
    /**
     * Add an object to the output. an object is  either a single webpage, 
     * a cover webpage or a table of content.
     *
     * @param string $input - either a URL, a HTML string or a PDF/HTML filename
     * @param array $options - optional options for the object
     */
    public function addObject($input, $prefix='', $options=array())  {
      $object = array();
      
      $object['prefix'] = $prefix; 
      // Is a valid file or URL
      if(is_file($input) || URL::valid($input)) {
        $object['input'] = $input;
      // Html or Any String
      } else {
        $object['input'] = $this->createTmpFile($input);
      }
      $object['options'] = $options;
      
      
      // Add to the pages objects 
      $this->objects[] = $object;
    }
    
    /**
     * Add a Page object to the output
     *
     * @param string $input - either a URL, a HTML string or a PDF/HTML filename
     * @param array $options - optional options for this page
     * @return void     
     */
    public function addPage($input,$options=array())  {
      $this->addObject($input, 'page', $options);
    }
    
    /**
     * Add a Cover page object to the output
     *
     * @param string $input - either a URL, a HTML string or a PDF/HTML filename
     * @param array $options - optional options for this page
     * @return void     
     */
    public function addCover($input,$options=array()) {
      $this->addObject($input, 'cover', $options);
    }
    
    /**
     * Add a Table Of Content page object to the output
     *
     * @param string $input - either a URL, a HTML string or a PDF/HTML filename
     * @param array $options - optional options for this page
     * @return void     
     */
    public function addTOC($input,$options=array()) {
      $this->addObject($input, 'toc', $options);
    }
    
    /**
     * Create a tmp file with given content
     *
     * @param string $content - the file content
     * @return string the path to the created file
     */
    private function createTmpFile($content) {
      $tmpDir = Config::get("wkhtmltopdf::path.tmp"); 
      $tmpFile = tempnam($tmpDir,'input_wkhtmltopdf_');
      rename($tmpFile, ($tmpFile.='.html'));
      file_put_contents($tmpFile, $content);

      return $tmpFile;
    }
    
    
    /**
     * Get the default output file extension.
     *
     * @return string the output file extension.
     */
    private function getDefaultOutputFileExt() {
      
      if(array_key_exists('output-format', $this->options)) {
        return $this->options['output-format']; 
      } 
      
      return 'pdf';
    }
    
    
    /**
     * Creates patameter string
     *         
     * @param array $options - for a wkhtml, either global or for an object
     * @return string the string with options
     */
    private function renderOptions($options) {
      $out = '';
      foreach($options as $key=>$val)
          if($val) {
            $out .= " --$key ".escapeshellarg($val);
          } else {
            $out .= " --$key";
          }

      return $out;
    }
    
    /**
     * Creates the command to be executed
     *         
     * @param string $filename the filename of the output file
     * @return string the wkhtmltopdf command string
     */
    private function getCommand($filename) {
      $command = $this->bin;

      $command .= $this->renderOptions($this->options);

      foreach($this->objects as $object) {
        $command .= ' '.$object['input'];
        //unset($object['input']);
        $command .= $this->renderOptions($object['options']);
      }

      return $command.' '.$filename;
    }
   
   /**
     * Executes command
     *         
     * @param string $command - Command to be executed
     * @return string the wkhtmltopdf command string
     */
    private function executeCommand($command) {
      // we use proc_open with pipes to fetch error output
      $descriptorspec = array(
            1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to
            2 => array('pipe', 'a')   // stderr is a pipe that the child will append to
        );
      
      echo  "command: $command <BR>"; 
      $process = proc_open($command, $descriptorspec, $pipes);

      if(is_resource($process)) {
        // get outputs to check the progress
        echo "step1<BR>";
        while (true) {
          echo "step_loop<BR>";
          sleep(1);
          $status = proc_get_status($process);
          // If not running exit the loop
          if (!$status['running']) break;
          
          echo "Still running....<BR>";
          // some manupulations with "/tmp/atest.log"
        }
        echo "step_exit_loop<BR>";
          /*
          $stderr = stream_get_contents($pipes[2]);
          fclose($pipes[2]);

          $result = proc_close($process);

          if($result!==0)
              $this->error = "Could not run command $command:\n$stderr";
          */    
      } else
          echo "Could not run command $command";
      
      
    }
    
    
    /**
     * Create the PDF file
     */
    public function createPdf($filename=null) {
      if(!$filename) {
        $tmpDir = Config::get("wkhtmltopdf::path.tmp"); 
        $filename = tempnam($tmpDir,'output_wkhtmltopdf_');
        unlink($filename);
        $filename .= '.'.$this->getDefaultOutputFileExt();
      }
      
      $command = $this->getCommand($filename);
      $this->executeCommand($command);
      
      return true;
    }
    
    
    
    
    
    
    
    
    
}