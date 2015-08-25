<?include('../config/conn.php');

$q = "SELECT * FROM log";
$r = mysqli_query($dbc, $q);

if(mysqli_num_rows($r) >= 1){
while($row=mysqli_fetch_assoc($r)){
	
$data[] = $row;	
	
}}
$json = json_encode($data);
echo $json;

$myfile = fopen("../data.json", "w") or die("Unable to open file!");
fwrite($myfile, $json);

?>

