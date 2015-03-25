<?php
if (!isset($result)) exit;
?>
<table class='table' style='margin-left:30%'>
 <tr>
  <td class='td-head' colspan='4'>TARGETS</td>
 </tr>
 <tr>
  <th class="td-kecil">No</th>
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
  <td class="td-kecil"><?php
  	$start=date_format(date_create($period_start),'d/M/Y');
  	$finish=date_format(date_create($period_finish),'d/M/Y');
  	$period=$start.' - '.$finish;
  	echo $period;
  	?></td>
  <td class="td-kecil"><?=$target?></td>
  <td class="td-kecil"><?=anchor(site_url('scoreboard/scoreBoard/'.$id),'<span class="glyphicon glyphicon-list" title="view">view</span>').' | '.
  	anchor(site_url('scoreboard/delete_target/'.$id),'<span class="glyphicon glyphicon-trash" title="delete">delete</span>')?></td>
 </tr>
 <?php
  $i++;
  }
 ?>
</table>

