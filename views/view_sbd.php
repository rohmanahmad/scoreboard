<div class="row">
  <div class="col-md-8">
  	<?=form_open(site_url('score_board/save'))?>
  	<table class='table'>
  	 
			 <tr>
			  <th colspan=3><center>FOKUS PADA SATU TUJUAN</center></th>
			 </tr>
			 <tr>
			  <td>FOKUS</td>
			  <td>:</td>
			  <td><input name='target' type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Fokus Anda"></td>
			 </tr>
			 <tr>
			  <td>TANGGAL</td>
			  <td>:</td>
			  <td><input name='start' type="date" class="form-control" style='width:30%'> 
			  	<span style="fload:left">-</span> 
			  	<input name='finish' type="date" class="form-control" style='width:30%' /></td>
			 </tr>
			 <tr>
			  <td>LEAD MEASURE</td>
			  <td>:</td>
			  <td>
			  	<table id='lead' style="width:100%">
				  	 <tr>
				  	  <td>Fokus</td>
				  	 </tr>
				  	 
			  	</table>
			  	  	
			  </td>
			 </tr>
			 <tr>
			  <td></td>
			  <td colspan='2'>
				  	 <input type="submit" class='btn btn-primary' value='simpan' />
			  		 <a class='btn btn-warning' onclick='add_itm()'>Add</a>
		  </td>
		 </tr>
	</table>
  	  <?=form_close()?>
  </div>
</div>
<script src="<?=base_url('assets/js/jquery.js')?>"></script>
<script type="text/javascript">
for (var i=1;i <= 2; i++)
{ 
        add_itm();
}

function add_itm() {
    var tr = $('<tr></tr>');
    var td = $('<td></td>');
    var td_f = $('<td></td>');
    //var td_t = $('<td></td>');
    var fokus = $("<input type='text' name='job[]' class='form-control' placeholder='fokus'>");
    //var target = $("<input type='text' name='target[]' class='form-control' style='width:50px' placeholder='0'>");
    
     $('#lead').append(tr);
	$(tr).append(td_f);
	//$(tr).append(td_t);
	$(td_f).append(fokus);
	//$(td_t).append(target);
}
</script>
	
