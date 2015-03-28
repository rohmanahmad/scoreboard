<div class="row">
  <div class="col-md-8">
  	<?=form_open(site_url('scoreboard/save'))?>
  	<table class='table' style="margin-left:30%;" width='30%'>
  	 
			 <tr>
			  <th colspan=3 class='td-head' style="color:#fff;">FOKUS ANDA</th>
			 </tr>
			 <tr>
			  <td class="td-kecil">FOKUS</td>
			  <td class="td-kecil">:</td>
			  <td class="td-kecil"><input name='target' type="text" class="form-control" style='width:100%' id="exampleInputEmail1" placeholder="Masukkan Fokus Anda"></td>
			 </tr>
			 <tr>
			  <td class="td-kecil">TANGGAL</td>
			  <td class="td-kecil">:</td>
			  <td class="td-kecil"><input name='start' type="date" class="form-control" style='width:40%'> 
			  	<span style="fload:left">-</span> 
			  	<input name='finish' type="date" class="form-control" style='width:40%' /></td>
			 </tr>
			 <tr>
			  <td class="td-kecil">LEAD MEASURE</td>
			  <td class="td-kecil">:</td>
			  <td class="td-kecil">
			  	<table id='lead' style="width:100%">
				  	 
			  	</table>
			  	  	
			  </td>
			 </tr>
			 <tr>
			  <td class="td-kecil"></td>
			  <td colspan='2'>
				  	 <input type="submit" class='btn btn-primary' value='simpan' />
			  		 <input type='button' class='btn btn-warning' onclick='add_itm()' value='add'>
		  </td>
		 </tr>
	</table>
  	  <?=form_close()?>
  </div>
</div>
<script type="text/javascript">
for (var i=1;i <= 2; i++)
{ 
        add_itm();
}

function add_itm() {
    var tr = $('<tr></tr>');
    var td = $('<td></td>');
    var td_f = $('<td></td>');
    var fokus = $("<input type='text' name='job[]' class='form-control' placeholder='fokus' style='width:100%'>");
    
   $('#lead').append(tr);
	$(tr).append(td_f);
	$(td_f).append(fokus);
}
</script>
	
