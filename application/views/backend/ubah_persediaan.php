<div id="isi">
<h1>Ubah Persediaan</h1>
<hr />
<br />
	<div id="inputan_persediaan" style='float:left;'>
		<form action="<?=base_url()?>cpanel/php_ubah_persediaan" method="post">
			<table border="0" class="form">
			<tr><td>Persediaan : </td><td><select name="persediaan" id="pilih">
			<option value='none'>-Pilih-</option>
				<?php
					foreach($persediaan as $tiap)
					{
						echo
						"<option value='".
						$tiap->kode_persediaan.
						"'>".
						$tiap->kode_persediaan.
						" - ".
						$tiap->nama_persediaan.
						"</option>";
					}
				?>
			</select><br /></td></tr><tr>
			<td>Jumlah : </td><td><input type="text" name="jumlah" id="tes1" value="0" autocomplete="off" /><br /></td></tr><tr><td>
			Harga : </td><td><input type="text" name="harga" id="tes" value="0" autocomplete="off" /></td></tr>
			</table><br /><br />
			<input type="submit" value="tambah" onclick="return confirm('Anda yakin akan menambahkan persediaan ini?')" /><br />
		</form>
	</div>
	<div id="Ket" style='float:right;width:500px;border-left:2px solid black;height:100px;'>
		<ul style="list-style:none">
		<li><h3>Ket</h3></li>
		<hr />
			<li>Jumlah sekarang : <span id="jumrang"></span></li>
			<li>Harga rata-rata : <span id="hargarata"></span></li>
			<li>Satuan : <span id="satuan"></span></li>
			<li>Harga baru : <span id="baru"></span></li>
		</ul>
	</div>
	<div class='clearfix'></div>
</div>
<script>
$(document).ready(function(){
  $("#pilih").change(function(){
	var txt = $("#pilih").val();
	var dua = $("#tes1").val()*1;
	var tiga = $("#tes").val()*1;
	var nyaa = dua*tiga*1;
   $.getJSON("<?=base_url()?>cpanel/ubah_persediaan_ajax",{hajar:txt}, function(data){
  	$("#satuan").html(data.first);
  	$("#hargarata").html(data.second);
  	$("#jumrang").html(data.third);
  	var total1 = data.second*data.fourth*1;
  	total = nyaa+total1;
  	empat = data.fourth*1;
  	pembagi = dua+empat;
  	total = total/pembagi;
  	$("#baru").html("RP. "+total);
	});
  });
    $("input").keyup(function(){
	var txt = $("#pilih").val();
	var dua = $("#tes1").val()*1;
	var tiga = $("#tes").val()*1;
	var nyaa = dua*tiga*1;
   $.getJSON("<?=base_url()?>cpanel/ubah_persediaan_ajax",{hajar:txt}, function(data){
  	$("#satuan").html(data.first);
  	$("#hargarata").html(data.second);
  	$("#jumrang").html(data.third);
  	var total1 = data.second*data.fourth*1;
  	total = nyaa+total1;
  	empat = data.fourth*1;
  	pembagi = dua+empat;
  	total = total/pembagi;
  	$("#baru").html("RP. "+total);
	});
  });
});
</script>