<?
function data_log($dbc, $id){
  $q = "SELECT * FROM log WHERE id = $id";
  $r = mysqli_query($dbc, $q);  
  $data=mysqli_fetch_assoc($r);
  return $data;
}

function update_log($dbc, $id, $mode){
  $now = date('Y-m-d H:i:s');
  $q = "UPDATE log SET date_$mode = '$now' WHERE id = $id";
  $r = mysqli_query($dbc, $q);  
  if($r){echo 1;}else{echo 2;}
}

function get_time($start, $end){
  $ts1 = strtotime(str_replace('/', '-', $start));
  $ts2 = strtotime(str_replace('/', '-', $end));
  $diff = abs($ts1 - $ts2) / 3600;
  return round($diff, 2);
}
function build_row($dbc, $d){
  $q = "SELECT * FROM log WHERE date_start = '$d[now]' AND task = '$d[task]'";
  $r = mysqli_query($dbc, $q);  
  $data=mysqli_fetch_assoc($r);?>

      <tr>
        <td><?=$data['task']?></td>
        <td><?=date_nice($data['date_start'])?></td>
        <td><?=($data['date_end'] != E)?date_nice($data['date_end']):''?></td>
        <td>
          <?if($data['date_start'] != E && $data['date_end'] != E){?>
          <?=get_time($data['date_start'], $data['date_end'])?>
          <?}else{?>
            0
          <?}?>
        </td>
        <td class="btn-cell">
          <?if($data['date_end'] == E){?>
            <button data-id="<?=$data['id']?>" class="btn btn-block btn-primary btn-stop"><?=i('stop')?></a>
          <?}?>
        </td>
        <td class="btn-cell">
          <button data-id="<?=$data['id']?>" class="btn btn-block btn-danger btn-delete"><?=i('times')?></button>
        </td>
      </tr>  
  
  
  
  
    
<?}
function new_log($dbc, $task){
  $d['now'] = date('Y-m-d H:i:s');
  $d['task'] = $task;
  $q = "INSERT INTO log (task,date_start) VALUES ('$d[task]','$d[now]')";
  $r = mysqli_query($dbc, $q);
  if($r){echo build_row($dbc, $d);}else{echo 2;}  
}

function delete_log($dbc, $id){
  $q = "UPDATE log SET status = 3 WHERE id = $id";
  $r = mysqli_query($dbc, $q);
  if($r){echo 1;}else{echo 2;}
}
function i($code){
  $icon = '<i class="fa fa-'.$code.'"></i>';
  return $icon;
}
function date_nice($date) {
  return date('M j Y g:i A', strtotime($date));
}

function tally($dbc, $span = NULL){
  
  if($span == NULL){
    
    $q = "SELECT * FROM log WHERE status = 1";
    $r = mysqli_query($dbc, $q);  
    $total = 0;
    while($data=mysqli_fetch_assoc($r)){
      $total = $total + get_time($data['date_start'], $data['date_end']);
    } 
    return $total;
  }
  
}
?>