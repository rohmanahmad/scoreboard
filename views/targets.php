<?php
if (!isset($result)) exit;
?>
<table class='table' style='margin-left:30%;min-width:30%'>
 <tr>
  <td class='td-head' colspan='5'>TARGETS</td>
 </tr>
 <?php
 if(isset($users)){
 	foreach($users as $usr){
 		$data_user[$usr->ID]=$usr->nama_lengkap;
 	}
 	echo form_open();
 	echo '<tr>
 		<td colspan=2></td>
 		<td colspan=2>By User : '.form_dropdown('userId',$data_user).' '.form_submit('','Filter').'</td>
 	</tr>';
 	echo form_close();
 }
 ?>
 <tr>
  <th class="td-kecil">No</th>
  <?php
	 if(isset($users)){
  		echo '<th class="td-kecil">Nama</th>';
  }
  ?>
  <th class="td-kecil">Periode</th>
  <th class="td-kecil">Target</th>
  <th class="td-kecil"></th>
 </tr>
 <?php
 $i=1;
  foreach($result as $r){
   $id=$r->ID;
   $period_start=$r->period_start;
   $period_finish=$r->period_finish;
   $target=$r->target_name;
 ?>
 <tr>
  <td class="td-kecil"><?=$i?></td>
  <?php
	 if(isset($users)){
		$user_name=$r->nama_lengkap;
  		echo '<td class="td-kecil">'.$user_name.'</td>';
  }
  ?>
  <td class="td-kecil"><?php
  	$start=date_format(date_create($period_start),'d/M/Y');
  	$finish=date_format(date_create($period_finish),'d/M/Y');
  	$period=$start.' - '.$finish;
  	echo $period;
  	?></td>
  <td class="td-kecil"><?=$target?></td>
  <td class="td-kecil"><?php
  echo anchor(site_url('scoreboard/scoreBoard/'.$id),'<span class="glyphicon glyphicon-list" title="view">view</span>');
  	if(!isset($admin)) echo ' | '.anchor(site_url('scoreboard/delete_target/'.$id),'<span class="glyphicon glyphicon-trash" title="delete">delete</span>'); ?></td>
 </tr>
 <?php
  $i++;
  }
 ?>
</table>

