<?php
$n=1;
foreach($job_res_datas as $r){
	if($n==1){
		$job_name=$r->jName;
		$target_name=$r->tName;
		$date=$r->date;
	}
	$url_=$r->url;
	if(!empty($url_)){
		$id[]=$r->resId;
			if(substr($url_,0,4)=='file'){
				$path=str_replace(array('http://','file://'),'',$url_);
		  	 	$ex=explode('/',$path);
		  	 	$index=count($ex)-1;
			  	$filename=HTTP_UPLOAD_PATH.$ex[$index-1].'/'.$ex[$index];
			  	
				$url[]=anchor($filename,img(array('src'=>$filename,'style'=>"width:40px;")),array('target'=>'blank'));
			}elseif(substr($url_,0,4)=='http'){
				$url[]=anchor($url_,$url_,array('target'=>'blank'));
			}else{
				$url[]=$url_;
			}
	}
	$n=2;
}
?>
<table width='100%'>
	<tr>
	 <th colspan='4' class='td-head'>RESULTS</th>
	</tr>
	<tr>
	 <td class="td-kecil" width='50px' colspan=3>Nama Target &emsp;&emsp; : <?=$target_name?></td>
	</tr>
	<tr>
	 <td class="td-kecil" colspan=3>Nama Job &emsp; &emsp;&emsp; : <?=$job_name?></td>
	</tr>
	<tr>
	 <td class="td-kecil" width='50px' colspan=2>Tanggal  &emsp; &emsp;&emsp;&emsp; : <?=$date?></td>
	 <td><?php if(!isset($admin)) echo anchor('scoreboard/add_job_result/'.$uri->segment(3),'Tambah');?></td>
	</tr>
	<tr bgcolor='#A7B1E7'>
	 <th class="td-kecil">No</th>
	 <th class="td-kecil">URL Result or file</th>
	 <th class="td-kecil">*</th>
	</tr>
	<?php
	 for($a=1;$a<=count($url);$a++){
	?>
	<tr>
	 <td class="td-kecil"><?=$a?></td>
	 <td class="td-kecil"><?=$url[$a-1]?></td>
	 <td class="td-kecil">
	 	<?php
	 		echo anchor('scoreboard/delete_result/'.$id[$a-1].'/'.$uri->segment(3),img('assets/images/delete.png'));
	 	?>
	 </td>
	</tr>
	<?php
	}
	?>
</table>
