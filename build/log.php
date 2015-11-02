<?
include('functions.php');

# -------------------------------
# Intital Setup
# -------------------------------

$log = 'data.json'; // Path to log
$json = file_get_contents($log); // Load log contents
$data = json_decode($json, true); // Convert JSON to array
if(is_array($data)){
	krsort($data); // Sort by ID;
}

# -------------------------------
# Modes
# -------------------------------

# If mode has been set:
if(isset($_GET['mode'])){
  
  # Handle each mode type:
  switch($_GET['mode']){
   
    # Output data array for debugging:
    case 'debug':
      echo '<pre>';
      print_r($data);
      echo '</pre>';     
    break;
    
    # Build a new task record:
    case 'new':
      $id = time();
      $data[$id]['id'] = $id;
      $data[$id]['task'] = $_GET['task'];
      $data[$id]['date_start'] = $id;
      $data[$id]['date_end'] = '';
      $data[$id]['date_entered'] = $id;
      $data[$id]['status'] = 1;
      save($data); // Save changes
    break;
    
    # Restore task record by setting it to active:
    case 'status':  
      $id = $_GET['id']; // Record ID
      $data[$id]['status'] = 1; // Set the status to active
      save($data); // Save changes
    break; 
    
    # Delete task record by setting it to inactive:
    case 'delete':  
      $id = $_GET['id']; // Record ID
      $data[$id]['status'] = 3; // Set the status to inactive
      save($data); // Save changes
    break; 
    
    # Stop task timer:
    case 'stop':
      $id = $_GET['id'];
      $data[$id]['date_end'] = time();
      save($data); // Save changes
    break; 
    
    # Build the task log table:   
    case 'build':
   
      # If there is any data:	
   		if(is_array($data)){
      	
      	# Run through each record:
	      foreach($data as $task){
	        
	        # Ignore inactive records:
	        if($task['status'] == 1){
	        	if($task['date_start'] != '' && $task['date_end'] != ''){
	        		$seconds = $task['date_end'] - $task['date_start']; 	        		
						}else{
							$seconds = time() - $task['date_start'];
						}
	        	?>
	          
	          <tr>
	            <td><?=$task['task']?></td>
	            <td><?=date_nice($task['date_start'])?></td>
	            <td><?=($task['date_end'] != '')?date_nice($task['date_end']):''?></td>
	            <td data-seconds="<?=$seconds?>"><?time_nice($seconds)?></td>
	            <td class="btn-cell">
	              <button data-id="<?=$task['id']?>" class="btn btn-block btn-primary btn-stop"  <?=($task['date_end'] != '')?'disabled':''?>><?=i('stop')?></button>
	            </td>
	            <td class="btn-cell">
	              <button data-id="<?=$task['id']?>" class="btn btn-block btn-danger btn-delete"><?=i('times')?></button>
	            </td>
	          </tr> 
      
    	<?}}} // END if, foreach, if is_array
 
    break;  
    
    # Restore records table:   
    case 'restore':
		
			# If there is any data:	
	   	if(is_array($data)){
	      
	      # Run through each record:
	      foreach($data as $task){
	        
	        # Ignore inactive records:
	        if($task['status'] != 1){ ?>
	          
	          <tr>
	            <td><?=$task['task']?></td>
	            <td><?=date_nice($task['date_start'])?></td>
	            <td><?=($task['date_end'] != '')?date_nice($task['date_end']):''?></td>
	            <td>
	             <?if($task['date_start'] != '' && $task['date_end'] != ''){
	                time_nice($task['date_end'] - $task['date_start']);
	              }else{
	                echo  0;
	              }?>
	            </td>
	            <td class="btn-cell">
	              <?if($task['date_end'] == ''){?>
	                <button data-id="<?=$task['id']?>" class="btn btn-block btn-primary btn-stop"><?=i('stop')?></button>
	              <?}?>
	            </td>
	            <td class="btn-cell">
	              <button data-id="<?=$task['id']?>" class="btn btn-block btn-primary btn-restore"><?=i('refresh')?></button>
	            </td>
	          </tr> 
	      
	    <?}}} // END if, foreach, if is_array

    break;  
		
		# Tally results:      
    case 'tally':
   
      $count = 0; // Initial value for tally
      
      # If there is any data:	
   		if(is_array($data)){
   			  
	      # Run through each record:  
	      foreach($data as $task){
	        
	        # Ignore inactive records:
	        if($task['status'] == 1){
	          
	          # If task has not stopped yet
	          if($task['date_end'] == ''){
	            $task['date_end'] = time(); // Set the end date to now
	          } // END if
	          
	          $current = $task['date_end'] - $task['date_start']; // Number of seconds for task
	          $count = $count + $current; // Add to tally
	        
	        } // END if
	      } // END foreach 
			} // END if is_array
			
      time_nice($count); // Return the time.
   
    break;    
   
 } // END switch
  
}?>