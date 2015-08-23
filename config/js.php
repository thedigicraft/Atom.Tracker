<script>

  $(document).on('ready', function(){
    
    
    var url = 'ajax/';
    
    // Form:    
    $('#form-new').on('submit', function(e){
      e.preventDefault();
      var data = $(this).serialize();
      
      $.ajax({
          url : url+'tracker.php?mode=new&'+data,
          type: 'GET',
          success:function(result) {
            if(result == 2){
              
            }else{
              $('#log').prepend(result);
            }
            
          }
      });     
      
    });
    
    
    // Buttons: 
    $('#log').on('click', '.btn-delete', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      var row = $(this).closest('tr');
      $.ajax({
          url : url+'tracker.php?mode=delete&log='+id,
          success:function(result) {
            if(result == 2){
               
            }else{
              row.remove();
            }
          }
      });     
      
    });
    $('#log').on('click', '.btn-stop', function(e){
      e.preventDefault();
      var btn = $(this);
      var id = $(this).data('id');
      var row = $(this).closest('tr');
      $.ajax({
          url : url+'tracker.php?mode=end&log='+id,
          success:function(result) {
            if(result == 2){
               
            }else{
              btn.remove();
            }
          }
      });     
      
    });  
    
    
  });
  
</script>