<?=form_open_multipart('scoreboard/add_job_result/'.$uri->segment(3))?>
	<table class='table' style="width:60%;margin-left:20%">
	<?php
	$uId='';
 	$jId='';
 	$tId='';
 	$jname='';
 	$date='';
 	$tname='';
 	$url=array();
 	
	$flashId= $flash->set_flashdata('ID',$uri->segment(3));

	if(isset($res)){
	 if (count($res) == 0) $not_set=true;
	 foreach($res as $r){
		 	$uId=$r->uId;
		 	$tId=$r->tId;
		 	$jname=$r->jName;
		 	$date=$r->date;
		 	$tname=$r->tName;
	 }
	}else exit;
	?>
	 <tr>
	  <td class='td-head' colspan=3>EDIT HASIL</td>
	 </tr>
	 <tr>
	  <th class='td-kecil'>Tanggal</th>
	  <td class='td-kecil' colspan=2><?php 
	  	$date=new DateTime($date);
	  	$date= date_format($date,'d-M-Y');
	  	echo $date;
	  	?></td>
	 </tr>
	 <tr>
	  <th class='td-kecil'>Nama Target</th>
	  <td class='td-kecil' colspan=2><?=strtoupper($tname)?></td>
	 </tr>
	 <tr>
	  <th class='td-kecil'>Nama Job</th>
	  <td class='td-kecil' colspan=2><?=strtoupper($jname)?></td>
	 </tr>
	 <tr>
	  <th class='td-kecil' rowspan=3>Results</th>
	  <td class='td-kecil'>
	  <?php
		  	echo '<div style="margin:2px;">'.form_textarea('content','','style="width: 478px;" class="form-control"').'</div>';
	  ?>
	  </td>
	  <td class='td-kecil' style="width:50px;">
	  		<span style='display:block;'><b>*NB</b></span>
	  		<span style='display:block;'>- Pisah url dengan (Enter),</span>
	  		<span>- Jika terdapat url yang sama maka akan di-skip.</span>
	  	</td>
	 </tr>
	 <tr>
	  <td class='td-kecil'>
	  	<div id='row2'>
	  <?php
	  	echo '
			<div style="margin:2px;">'.form_upload('userfile[]','','style="width:100%"').'</div>
			
	  	';
	  ?>
		</div>
	  </td>
	  <td class='td-kecil'><input type='button' class='btn btn-default' onclick='add_itm_upload()' value='Add Field' /></td>
	 </tr>
	 <tr>
	  <td class='td-kecil' colspan=2>
	  		<?=form_submit('submit','Update','class="btn btn-primary"')?>
	  		<input type='button' value='Cancel' onclick="history.back();" /></td>
	 </tr>
	</table>
<?=form_close()?>
<script type="text/javascript">
function add_itm_upload() {
    var div = $('<div style="margin:2px;"></div>');
    var input = $('<input type="file" name="userfile[]" value="" style="width:100%">');
    
	$('#row2').append(div);
	$(div).append(input);
}
</script>

