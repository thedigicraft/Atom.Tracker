<?include('config/setup.php')?>
<?include('template/header.php')?>


<div class="container-fluid">
  
  <header>
    
    <span class="pull-right">
      <strong>Total Hours:</strong> <?=tally($dbc)?>
    </span>
    
  </header>
  <div class="row">
    <form id="form-new" method="get">
      <div class="form-group">
        <div class="col-xs-10">
          <label>New Entry</label>
          <input class="form-control" name="task"> 
        </div><!-- END col -->   
        <div class="col-xs-2">
          <button type="submit" name="submit" class="btn btn-block btn-success"><?=i('play')?></a> 
        </div><!-- END col -->
      </div><!-- END form-group -->
    </form>     
  </div><!-- END row -->
  <hr>  

  <table class="table table-bordered table-stripped">
    <thead>
      <tr>
        <th>Task</th>
        <th>Start</th>
        <th>End</th>
        <th>Hours</th>
        <th colspan="2">Controls</th>
      </tr>   
    </thead>
    
    <tbody id="log">

    <?
    $q = "SELECT * FROM log WHERE status = 1 ORDER BY date_entered DESC";
    $r = mysqli_query($dbc, $q);
    
    if(mysqli_num_rows($r) >= 1){
    while($data=mysqli_fetch_assoc($r)){?>
    
      <tr>
        <td><?=$data['task']?></td>
        <td><?=date_nice($data['date_start'])?></td>
        <td><?=($data['date_end'] != $empty)?date_nice($data['date_end']):''?></td>
        <td>
          <?if($data['date_start'] != $empty && $data['date_end'] != $empty){?>
          <?=get_time($data['date_start'], $data['date_end'])?>
          <?}else{?>
            0
          <?}?>
        </td>
        <td class="btn-cell">
          <?if($data['date_end'] == $empty){?>
            <button data-id="<?=$data['id']?>" class="btn btn-block btn-primary btn-stop"><?=i('stop')?></a>
          <?}?>
        </td>
        <td class="btn-cell">
          <button data-id="<?=$data['id']?>" class="btn btn-block btn-danger btn-delete"><?=i('times')?></button>
        </td>
      </tr>  
      
    <?}}else{echo mysqli_error($dbc);}?>

    </tbody>
  </table>
</div><!-- END container -->

<?include('template/footer.php')?> 