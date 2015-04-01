<?php 
if (!isset($result)) exit();
$n=1;
$o=0;
?>
 <?= form_open('scoreboard/edit_targets','class="form_target"')?>
<table border=0 class='table' width=100%>
<?php
foreach($result as $r){
 $targetId=$r->tId;
 $jobId=$r->jId;
 $jobName=ucwords($r->job_name);

	 if ($n==1){
	 //print_r($r);
	 	 $ID=$r->tId;
		 $targetName=$r->target_name;
		 $userId=$r->user_id;
		 $period=str_replace('-','/',$r->period_start).' - '.str_replace('-','/',$r->period_finish);
		 $tgl=$c->get_period($jobId);
		 $rowCount=count($tgl);
	?>
	 <tr>
	  <th class='td-head' colspan="<?=$rowCount+5?>">SCOREBOARD</th>
	 </tr>
	 <tr>
	  <th class="td-kecil" colspan=2>Fokus</th>
	  <td class='td-kecil' colspan="<?=$rowCount+3?>"> 
	  	<?php 
	  		echo strtoupper($targetName);
	  		if(!isset($admin)) echo anchor('scoreboard/change_field/tname/'.$ID,'<span class="glyphicon glyphicon-pencil">Edit</span>','class="btn btn-default" style="margin-left:10px;"');
	  	?>
	  </td>
	 </tr>
	 <tr>
	  <th class="td-kecil" colspan=2>Periode</th>
	  <td class='td-kecil' colspan="<?=$rowCount+3?>"> 
	  	<?php 
	  		echo $period;
	  		if(!isset($admin)) echo anchor('scoreboard/change_field/period/'.$ID,'<span class="glyphicon glyphicon-pencil">Edit</span>','class="btn btn-default" style="margin-left:10px;"');?></td>
	 </tr>
	 <tr>
	  <th class="td-kecil" colspan=2>Scoreboard</th>
	  <td class='td-kecil' colspan="<?=$rowCount+3?>">
	  	<?php
	  	if(!isset($admin)) echo anchor('scoreboard/change_field/sboard/'
	  	.$ID,'<span class="glyphicon glyphicon-pencil">Edit</span>','class="btn btn-default" style="margin-left:10px;"');
	  	?></td>
	 </tr>
	 <tr style='background:#91A1F0'>
	  <th class="td-kecil" rowspan=2 colspan=2>Target Job</th>
	  <th class="td-kecil" rowspan=2 colspan=2>Target</th>
	  <th class="td-kecil" colspan="<?=$rowCount+2?>" class='text-center' style='width:50%'>Tanggal</th>
	 </tr>
	 <tr style='background:#91A1F0' colspan=2>
	<?php
		$nn=0;
		foreach($tgl as $t){
		 $d = new DateTime($t->date);
		 $date=date_format($d, 'd/m');
		 $d=explode('/',$date);
		 $d=''.$d[0].' / <sup>'.$d[1].'</sup>';
		 
		  if($nn%2==1) $bg='#C0C0C0'; else $bg='#fff'; 
		  if($date==date('d/m')){$bg='red';$now=' (Now)';}else$now='';
		 echo "<td class='td-kecil' style='font-size:10px;padding:2px;font-weight:bold' bgcolor='".$bg."'>".$d.$now."</td>";
		 $nn++;
		}
	echo "</tr>";
	 }
	 $n=2;
if($jobId != ''){
	 ?>

	 <tr>
	 	<td class='td-kecil'>*</td>
	  <!--td class='td-kecil'><?=anchor('scoreboard/delete_job/'.$jobId.'/'.$targetId,'<i class="glyphicon glyphicon-trash">Delete</i>')?></td-->
	  <td class='td-kecil' colspan=1><?php if($jobName != 'NotSet(Empty)')echo $jobName;else echo '<font color="red">'.$jobName.'</font>'//.anchor('scoreboard/change_field/jname/'.$jobId.'/'.$ID,'&nbsp;<span class="glyphicon glyphicon-pencil"></span>')?></td>
	  <td class='td-kecil' style='border-right:0px;' style="padding:0px;">
	  	<div class='row' style='margin-right:0px;'>
			  <div class='col-md-2' style='width:90%;float:right;background:#fff;' >
			   <span id="<?='data'.$o?>"></span><br/>
			   <span id="<?='data_count'.$o?>"></span>
			  </div> 
		</div>
	  </td>
	  <td class='td-kecil' style='border-left:0px;' id="<?='ico'.$o?>">.</td>
	<?php
	$job=$c->getJobRes($jobId);
	$nn=0;
	$fontsize=15 - ($rowCount/6);
	$sum=0;
	$total_count=0;
	  foreach($job as $r){
	  	$count=$r->count;
		$sc_id=$r->sc_id;
	  	$total=$c->get_total_contents($sc_id);
	  	$sum += $total;
	  	$total_count += $count;
	  	$date=$r->date;
		if($nn%2==1) $bg='#C0C0C0'; else $bg='#fff'; 
		//if($date==date('Y-m-d'))$bg='#F95959';
		echo "<td class='td-kecil' style='font-size:".$fontsize."px;padding:0px;' bgcolor='".$bg."'>
			<div class='row' style='margin-right: 0px;'>
			  <div class='col-md-8' style='width:94%;float:right;background:#A8FF7D'>".
			  form_checkbox('check[]',$sc_id).br().'<i>'.$count.'</i>' 
			  ."</div> 
			  <div class='col-md-8' style='width:94%;float:right;background:#70C7B6'>".
			  $total
			  ."</div> 
			  ".anchor(site_url('scoreboard/browse_job_result/'.$sc_id),'View','class="col-md-8"')."
			</div>
		</td>";
		$nn++;
	  }
	?>
	<td class='td-kecil'><?php if(!isset($admin)) echo '<a href="#" onclick="submit_form();"><i class="glyphicon glyphicon-pencil">Edit</i></a>';?></td>
	<script type="text/javascript">
	$(document).ready(function(){
		var sum=Number("<?=intval($sum)?>");
		var count=Number("<?=intval($total_count)?>");	
		var class_a="#data<?=$o?>";
		var class_b="#data_count<?=$o?>";
		var class_c="#ico<?=$o?>";
	
		$(class_a).html('<b>' + count +'</b>');
		 if(sum < count){
		 	$(class_c).html("<img src=\"<?=base_url('assets/images/icons/confused.gif')?>\" title=\"Lagi Kalah!\">");
		 }else
		 if(sum > count){
		 	$(class_c).html("<img src=\"<?=base_url('assets/images/icons/shade_smile.gif')?>\" title=\"Menang Coy!\">");
		 }else{
		 	$(class_c).html("<img src=\"<?=base_url('assets/images/icons/grin.gif')?>\" title=\"Hehehe Pas!\">");
		 }
		$(class_b).text(sum);

	});
	</script>
	 </tr>
	 
	 <?php
	 $o++;
  } //for if($jobId != '')
 }
?>
</table>
</form>
<script>
function submit_form(){
	$('.form_target').submit();
}
</script>

