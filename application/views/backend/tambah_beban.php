<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/beban" class="nav">List Beban</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_beban" class="nav">Tambah Beban</a>
				<a href="<?php echo base_url() ?>cpanel/cogs_pos" class="nav">COGS POS</a>
			</div>
<div id="judul_konten">
	<h2>Input Kedatangan Inventory</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_tambah_beban" method="post">
		<table class="form">
		<tr><td>Uraian : </td><td><input type="text" name="uraian"  value='' /></td></tr>
		<tr><td style="width:300px">Waktu Kedatangan : </td><td><input type="text" class="wa" name="waktu" value='<?php echo date('Y-m-d H:i:s'); ?>' /></td></tr>
		<tr><td>Jenis Beban : </td><td><select name="jenis"><?php foreach($kategori as $i){echo "<option value='$i->id_pengeluaran'>$i->nama_pengeluaran_k</option>";}?></select></td></tr>
		<tr><td>Nilai : </td><td><input type="number" name="nilai"></td></tr>
		<tr><td>Referensi : </td><td><input  type="text" name="ref" value='' /></td></tr>
		<tr><td>Keterangan : </td><td><input  type="text" name="ket" value='' /></td></tr>
		</table>
		<br>
		<input type="submit" onclick="confirm('Sudahkah diisi dengan benar?')" value="Input"/><br />
		</form><br />
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('.wa').datetimepicker()
	.datetimepicker({timepicker:true,format: 'Y-m-d h:i:s',mask:'9999-19-39 29:69:69'});
</script>