
  // Build Log Table:
  function build_log(){
    tally_log(); // Retally
    $('#log').load('log.php?mode=build');
  }
 
  // Build Log Table:
  function build_restore(){
    tally_log(); // Retally
    $('#log').load('log.php?mode=restore');
  }
  
  // Tally all active Task Times:
  function tally_log(){
    $('#tally').load('log.php?mode=tally');
  }

  $(document).on('ready', function(){

    build_log(); // Inital log table build
		setInterval(function(){
			
			var mode = $('#btn-swap').data('mode');
			if(mode == 'restore'){
				build_log(); // Rebuild log table
			}
			tally_log(); // Retally
		}, 30000);   // Refresh every 30 seconds
		
    var url = 'log.php'; // Ajax file

    // New Task Form:    
    $('#form-new').on('submit', function(e){
      e.preventDefault(); // Stop from submitting a form
      var data = $(this).serialize(); // Seriale form data
      $.ajax({
          url : url+'?mode=new&'+data,
          type: 'GET',
          success:function(result) {
            if(result != 2){ //If no error
              build_log(); // Rebuild log table
              $('#task').val(''); // Empty task input Field
            } // END if
          } // END success
      }); // END ajax
    }); // END #form-new on submit
    
    // Restore Task:    
    $('#log').on('click', '.btn-restore', function(e){
      e.preventDefault(); // Stop from submitting a form
      var id = $(this).data('id'); // The task id
      $.ajax({
          url : url+'?mode=status&id='+id,
          type: 'GET',
          success:function(result) {
            if(result != 2){ //If no error
              build_restore(); // Rebuild log table
            } // END if
          } // END success
      }); // END ajax
    }); // END #form-new on submit
        
    
    // Restore Tasks Button: 
    $('#btn-swap').on('click', function(e){
      e.preventDefault(); // Stop from refreshing the page
      var mode = $(this).data('mode'); // The build mode
      if(mode == 'restore'){
        build_restore(); // Build the restore table
        $(this).data('mode', 'log'); // Set swap mode to log
        $(this).find('span').html('Log'); // Change swap link label
      }else{
        build_log(); // B uild the log table
        $(this).data('mode', 'restore'); // Set swap mode to restore
        $(this).find('span').html('Restore'); // Change the link label
      }
          
    }); // END .btn-delete on click
    
    // Delete Task Button: 
    $('#log').on('click', '.btn-delete', function(e){
      e.preventDefault(); // Stop from submitting a form
      var id = $(this).data('id'); // The task id
      $.ajax({
          url : url+'?mode=delete&id='+id,
          success:function(result) {
            if(result != 2){ // If no error
              build_log(); // Rebuild log table
            } // END if
          } // END success
      }); // END ajax    
    }); // END .btn-delete on click
    
    // Stop Task Timer:
    $('#log').on('click', '.btn-stop', function(e){
      e.preventDefault(); // Stop from submitting a form
      var id = $(this).data('id'); // The task ID
      $.ajax({
          url : url+'?mode=stop&id='+id,
          success:function(result) {
            if(result != 2){ // If no error
              build_log(); // Rebuild log table
            } // END if
          } // END success
      }); // END ajax
    }); // END .btn-stop on click
    
  }); // END Document Ready
  
