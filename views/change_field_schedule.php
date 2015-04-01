<?php
if(!isset($fields))exit;
?>
<?=form_open()?>
<table class='table table-hover' border=0 style="margin-left:30%">
 <tr><td colspan=3 class="td-head">EDIT JUMLAH TARGET</td></tr>
 <tr>
  <th class="td-kecil">Nama Job</th>
  <th class="td-kecil">Tanggal</th>
  <th class="td-kecil">Jumlah</th>
 </tr>
<?php
$jobname='';
$n=1;
foreach($fields as $r){
 $job_id=$r->job_id;
 $id=$r->ID.'|'.$job_id;
 $date=$r->date;
 $count=$r->count;
 $jname=$r->jobname;
 $data[]=$date;
 if($jobname!==$r->jobname){
	  echo '<tr bgcolor="#C0C0C0">
	  	 <td class="td-kecil" colspan=3> </td>
	  	</tr>';
	  $n=1;
	  $jobname=$r->jobname;
	}else{
		
	}
	
?>
 <tr>
  <td class="td-kecil"><?php echo $jname;//if($print==true){echo ucwords($jobname);}?></td>
  <td class="td-kecil"><?php echo $date.form_hidden('id[]',$id)?></td>
  <td class="td-kecil"><?php if($n==1)echo form_input(array('name'=>'count'.$job_id,'value'=>$count,'type'=>'number'));?></td>
 </tr>
 <?php
 $n=2;
 }
 ?>
 <tr>
  <td class="td-kecil" colspan=2></td>
  <td class="td-kecil"><?=form_submit('submit','Simpan','class="btn btn-primary"').' '.form_reset('reset','Reset','class="btn btn-warning"').' '.form_button('button','Cancel','class="btn btn-danger"')?></td>
 </tr>
</table>
<?=form_close()?>
