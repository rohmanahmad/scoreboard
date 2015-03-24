<?=form_open_multipart('score_board/update_score')?>
	<table class='table'>
	<?php
	$uId='';
 	$jId='';
 	$tId='';
 	$jname='';
 	$date='';
 	$tname='';
 	$url=array();
 	
	$flash->set_flashdata('ID',$uri->segment(3));
	$flash->set_flashdata('last_url',$uri->uri_string());
	if(isset($res)){
	 if (count($res) == 0) $not_set=true;
	 $n=1;
	 foreach($res as $r){
		 	$uId=$r->uId;
		 	$tId=$r->tId;
		 	$jname=$r->jName;
		 	$date=$r->date;
		 	$tname=$r->tName;
		 	$n=2;
	 	if($n==1){
	 	}
	 	$jId[]=$r->jId;
	 	$url[]=$r->url;
	 }
	}else exit;
	?>
	 <tr>
	  <td>Nama Target</td>
	  <td><?=strtoupper($tname)?></td>
	  <td></td>
	 </tr>
	 <tr>
	  <td>Nama Job</td>
	  <td colspan=2><?=strtoupper($jname)?></td>
	 </tr>
	 <tr>
	  <td>Tanggal</td>
	  <td colspan=2><?php 
	  	$date=new DateTime($date);
	  	$date= date_format($date,'d-M-Y');
	  	echo $date;
	  	?></td>
	 </tr>
	 <tr>
	  <td>Results</td>
	  <td>
	  	<div class="row" id='row1'>
	  <?php
	  $content='';
	  $id=0;
	  	if(count($url) > 0 and !empty($url))
		  	foreach($url as $c){
		  	 if(substr($c,0,4)!=='file'){
		  	 	$content .= '%0A'.$c;
		  	 }else{
		  	 	$id_job[]=$jId[$id];
		  	 }
		  	 $id++;
		  	}
			echo '<div style="margin:2px;">'.form_textarea('content',urldecode($content),'style="width:100%" class="form-control"').'</div>';
	  ?>
		</div>
	  </td>
	  <td></td>
	 </tr>
	 <tr>
	  <td></td>
	  <td>
	  	<div id='row2'>
	  <?php
	  	if(count($url) !== 0 and !empty($url) and $url !== ''){
		  	$data_delete=0;
		  	foreach($url as $c){
		  	 $path=str_replace(array('http://','file://'),'',$c);
		  	 $ex=explode('/',$path);
		  	 if(substr($c,0,4)=='file') {
			  	 $index=count($ex)-1;
			  	 $filename=$ex[$index-1].'/'.$ex[$index];
		  	 	echo form_hidden('hidden[]',$id_job[$data_delete]);
		  	 	echo '<div class="row" >';
		  	 	$ext=substr($ex[$index],-4);
		  	 	  if($ext=='.png' or $ext=='.bmp' or $ext=='.ico' or $ext=='.jpg' or $ext=='.gif'){
		  	 		echo '<div class="col-md-6">'.img(array('src'=>'assets/uploads/score_board/'.$filename,'style'=>'width:40px;')).'</div>';
		  	 	  }else{
		  	 	  	echo '<div class="col-md-6">'.anchor(base_url('assets/uploads/score_board/'.$filename),$ex[$index]).'</div>';
		  	 	  }
				  	echo '<div class="col-md-4">'.form_checkbox('delete'.$data_delete,$filename).' Delete</div>';
				echo '</div>';
				 $data_delete++;
			 }
		  	}
	  	}
	  	echo '
			<div style="margin:2px;">'.form_upload('userfile[]','','style="width:100%"').'</div>
			
	  	';
	  ?>
		</div>
	  </td>
	  <td><a class='btn btn-default' onclick='add_itm_upload()'>Add Field</a></td>
	 </tr>
	 <tr>
	  <td></td>
	  <td colspan=2><?=form_submit('submit','Update','class="btn btn-primary"')?></td>
	 </tr>
	</table>
<?=form_close()?>
<script src="<?=base_url('assets/js/jquery.js')?>"></script>
<script type="text/javascript">
function add_itm_input() {
    var div = $('<div style="margin:2px;"></div>');
    var input = $('<input name="content[]" type="text" style="width:100%">');
    
	$('#row1').append(div);
	$(div).append(input);
}
</script>

<script type="text/javascript">
function add_itm_upload() {
    var div = $('<div style="margin:2px;"></div>');
    var input = $('<input type="file" name="userfile[]" value="" style="width:100%">');
    
	$('#row2').append(div);
	$(div).append(input);
}
</script>

