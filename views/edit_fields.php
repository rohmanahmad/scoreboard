<?php if(!isset($result))exit;
$flash->set_flashdata('id',$ID);
if($name=='period' )$action=site_url('scoreboard/change_field/period');
if($name=='tname' )$action=site_url('scoreboard/change_field/tname');
if($name=='sboard' )$action=site_url('scoreboard/change_field/job');
?>
<form name="f_change_field" action="<?=$action?>" method="POST">
<div class='clearfix'>
	<table class="table" style="width:50%;margin-left:25%">
	<?php 
	$n=1;
	$first=true;
	foreach($result as $result){
	 $ID=$result->ID;
	 $tname=$result->target_name;
	 $period_=str_replace('-','/',$result->period_start).' - '.str_replace('-','/',$result->period_finish);
	 $job_id=$result->job_id;
	 $jname=$result->job_name;
	  if($first == true){
		 $period_=explode(' - ',$period_);
		 for($a=0;$a<=count($period_)-1;$a++){
		 	 $d=new dateTime($period_[$a]);
			 $date[]=date_format($d,'Y-m-d');
		 }
	  }
	      if($n == 1)
		if($name=='period' ){ 
		 $periode=form_input(array('type'=>'date','name'=>'start_period','value'=>$date[0],'id'=>'datePicker','class'=>'form-control'))
		  	.br(2)
		  	.form_input(array('type'=>'date','name'=>'end_period','value'=>$date[1],'id'=>'datePicker','class'=>'form-control'));
		$n=2;
		}
		if($name =='tname'){
		 $tname=form_input('tname',$tname,'style="width:100%" class="form-control"');
		}
	 if($name =='sboard' ){
	 	if($first == true){
			$date_period=$date[0].'|'.$date[1];
			$periode=str_replace('|',' - ',str_replace('-','/',$date_period));
	 		$jobname[]=form_hidden('date_period',$date_period)
	 			.form_hidden('jid[]',$job_id).form_input('job[]',$jname,'style="width:80%;margin-top:2px;" ')
	 			.form_button('','Add','class="btn btn-default" style="margin-left:5px;" onclick="add_field();"')
	 			.anchor('scoreboard/delete_job/'.$job_id.'/'.$ID,form_button('','Del'),'style="float:right"');
	 	}else{
	 		$jobname[]=form_hidden('jid[]',$job_id).form_input('job[]',$jname,'style="width:90%;margin-top:2px;" ')
	 		.anchor('scoreboard/delete_job/'.$job_id.'/'.$ID,form_button('','Del'),'style="float:right"');
	 	}
	 }else{
	 	$jobname[]=strtoupper($jname);
	 }
	$first=false;
	} ?>
	 <tr>
	  <th class='td-head' colspan=3>EDIT FIELD</th>
	 </tr>
	 <tr>
	  <th class='td-kecil'>Periode</th>
	  <td class='td-kecil'><?php if(isset($periode))echo $periode;else echo $period_;?></td>
	  <td class='td-kecil' style='color:red'>(*) Jika periode dikurangi maka data yang ada pada tgl tsb akan terhapus!</td>
	 </tr>
	 <tr>
	  <th class='td-kecil' style='width:150px'>Target Name</th>
	  <td class='td-kecil' colspan=2><?=$tname?></td>
	 </tr>
	 <tr>
	  <th class='td-kecil'>Score Board</th>
	  <td class='td-kecil' id="job" colspan=2>
	  	<ul>
	  <?php 
	  	if(isset($jobname)){
	  	foreach($jobname as $jobs){
	  		echo '<li>'.$jobs.'<hr></li>';}
	  	}?>
	  	</ul>
	  	</td>
	 </tr>
	 <tr>
	  <td class='td-kecil'></td>
	  <td class='td-kecil' colspan=2><?=form_submit('submit','Change','class="btn btn-primary"')?></td>
	 </tr>
	 
	</table>
</div>
</form>
<script type="text/javascript">
function add_field() {
    var fokus = $("<input type='hidden' name='jid[]' value=''><input type='text' name='job[]' style='width:100%;margin-top:2px;'>");
    
     $('#job').append(fokus);
}
</script>
