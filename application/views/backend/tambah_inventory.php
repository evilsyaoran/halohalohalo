<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/inventory_main" class="nav">List Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_inventory" class="nav">Tambah Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/penyesuaian_inventory" class="nav">Penyesuaian Inventory</a>
</div>
<div id="judul_konten">
	<h2>Tambah Item</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_tambah_inventory" method="post">
	<table class='form'>
		<tr><td>Kode Inventory : </td><td><input type="text" readonly="readonly" value="<?=$last?>" name="kode" /></td></tr>
		<tr><td>Nama : </td><td><input type="text" name="nama" /></td></tr>
		<tr><td>Jenis : </td><td><input type="text" name="jenis" /></td></tr>
		<tr><td>Satuan : </td><td><input type="text" name="satuan" /></td></tr>
		<tr><td>Jumlah : </td><td><input type="number" name="jumlah" /></td></tr>
		<tr><td>Harga : </td><td><input type="number" name="harga" /></td></tr>
		<tr><td>Eoq : </td><td><input type="number" name="eoq" /></td></tr>
		<tr><td>Status : </td><td><select name="status"><option value='0'>Tidak dihitung</option><option value='1'>Dihitung</option></select></td></tr>
	</table>
		<br /><br />
		<input type="submit" value="tambah" />
	</form>
</div>
</div>