<?
# Database connection:
include('../config/conn.php');
error_reporting(0);

# Set timezone:
date_default_timezone_set('America/Fort_Wayne');

# Empty timestamp for comparison:
$empty = '0000-00-00 00:00:00';
DEFINE('E', '0000-00-00 00:00:00');

# Load functions:
include('../config/functions.php');

# IF a mode is set:
if(isset($_GET['mode'])) {
  
  switch($_GET['mode']){
    
    case 'new':
      new_log($dbc, $_GET['task']);     
    break; 
    
    case 'start':      
      $log=data_log($dbc, $_GET['log']);
      update_log($dbc, $log['id'], $_GET['mode']);    
    break;
    
    case 'end':     
      $log=data_log($dbc, $_GET['log']);
      update_log($dbc, $log['id'], $_GET['mode']);
      
    break;
		
		case 'tally':     
      echo tally($dbc);
      
    break;
    
    case 'delete':     
      $log=data_log($dbc, $_GET['log']);
      delete_log($dbc, $log['id']);
    break;

  }
}  
?>



