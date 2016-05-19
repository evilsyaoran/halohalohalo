<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/pasokan" class="nav">List Kedatangan</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_pasokan" class="nav">Input Kedatangan Inventory</a>
			</div>
<div id="judul_konten">
	<h2>Input Kedatangan Inventory</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_tambah_pemasok" method="post">
		<table class="form">
		<tr><td style="width:300px">Waktu Kedatangan : </td><td><input type="text" class="wa" name="waktu" value='<?php echo date('Y-m-d H:i:s'); ?>' /></td></tr>
		<tr><td>Nama Pemasok : </td><td><input type="text" name="pemasok"  value='' /></td></tr>
		<tr><td>Nama Inventory : </td><td><select name="inventory"><?php foreach($persediaan as $i){echo "<option value='$i->id_inventory'>$i->nama_inventory</option>";}?></select></td></tr>
		<tr><td>Jumlah : </td><td><input type="number" name="jumlah"></td></tr>
		<tr><td>Harga : </td><td><input  type="number" name="harga" value='' /></td></tr>
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