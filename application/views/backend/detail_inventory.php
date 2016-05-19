<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/inventory_main" class="nav">List Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_inventory" class="nav">Tambah Inventory</a>
</div>
<div id="judul_konten">
	<h2>Detail Inventory</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_update_inventory" method="post">
	<table class='form'>
		<tr><td>Kode Inventory : </td><td><input type="text" readonly="readonly" value="<?php echo $form->id_inventory ?>" name="kode" /></td></tr>
		<tr><td>Nama : </td><td><input type="text" name="nama" value="<?php echo $form->nama_inventory ?>" /></td></tr>
		<tr><td>Jenis : </td><td><input type="text" name="jenis" value="<?php echo $form->jenis_inventory ?>" /></td></tr>
		<tr><td>Satuan : </td><td><input type="text" name="satuan" value="<?php echo $form->satuan_inventory ?>" /></td></tr>
		<tr><td>Jumlah : </td><td><input type="number" name="jumlah" value="<?php echo $form->jumlah_inventory ?>" /></td></tr>
		<tr><td>Harga : </td><td><input type="number" name="harga" value="<?php echo $form->harga_inventory ?>" /></td></tr>
		<tr><td>Eoq : </td><td><input type="number" name="eoq" value="<?php echo $form->eoq_inventory ?>" /></td></tr>
		<tr><td>Status : </td><td><select name="status"><option value='0' <?php if($form->status_inventory==0){echo "selected";}?>>Tidak dihitung</option><option value='1' <?php if($form->status_inventory==1){echo "selected";}?>>Dihitung</option></select></td></tr>
	</table>
		<br /><br />
		<input type="submit" value="Update" />
	</form>
</div>
</div>
	</table><br>
</div>
</div>