
@if(isset($layout->header))
  {{ $layout->header}}
@endif
<table id="datatables" style="
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: separate;
    border-color: #DDDDDD #DDDDDD #DDDDDD -moz-use-text-color;
    border-image: none;
    border-radius: 4px 4px 4px 4px;
    border-style: solid solid solid none;
    border-width: 1px 1px 1px 0;margin-bottom: 20px;
    border-spacing:0;width:100%">
    <?php 


     $number = count($columns);
        $width = 100/$number;
        $width = ceil($width)."%";
        for($i=0;$i<=$number;$i++) { 
    ?>
            <col style="width: <?php echo $width; ?>">
    <?php 
        } 
    ?>       
  
    <thead>
      
        <tr>
            @foreach($columns as $column)
                <th style="background-color: #F9F9F9;border-left: 1px solid #DDDDDD;    
                    padding: 8px;
                    ">{{ $allColumns[$column]['display']}}
                </th>
            @endforeach           
        </tr>
    </thead>
    <tbody> 
        @foreach($results as $result)
            <tr>  

                @foreach($columns as $field)   
                                            
                  <?php  $associated = strpos($field, '_id');
                      $element = substr($field, 0, -3);
                      if ($associated && isset($result->relationships[$element]) && isset($result->relationships[$element]->original['name'])) {
                                 
                        $value = $result->relationships[$element]->original['name'];

                      } else {
                        $value= $result->original[$field];
                      }

                  ?>                     
         
                        
                    <td style="background-color: #F9F9F9;border-left: 1px solid #DDDDDD; 
                        border-top: 1px solid #DDDDDD;
                        line-height: 20px;
                        padding: 8px;
                        text-align: left;                    
                        vertical-align: top;">{{ $value }}
                    </td>   
                    
                @endforeach      
            </tr>   
        @endforeach
        
    </tbody>
</table>
@if(isset($layout->footer))
  {{ $layout->footer}}
@endif