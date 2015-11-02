<?
# Save the data:
function save($data){
 	$json = json_encode($data); // Convert data array back to json
  $myfile = fopen("data.json", "w") or die("Unable to open file!"); // Open file
  fwrite($myfile, $json); // Save file
}

# Return a FontAwesome icon:
function i($code){
  $icon = '<i class="fa fa-'.$code.'"></i>';
  return $icon;
}

# Make the date look nice:
function date_nice($date) {
  return date('M j Y g:i A', $date);
}

# Make the time look nice:
function time_nice($seconds){
  $h = floor(($seconds/60)/60); // Hours
  $m = round(($seconds/60)) - ($h * 60); // Minutes
  
  echo '<span class="hours">'.$h.'</span> hrs : <span class="minutes">'.$m.'</span> mins'; // Display result   
}
?>