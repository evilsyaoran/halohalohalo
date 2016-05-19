<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/produk" class="nav">List Item</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_produk" class="nav">Tambah Item</a>
</div>
<div id="judul_konten">
	<h2>Tambah Item</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_tambah_produk" method="post">
	<table class='form'>
		<tr><td>Kode Produk : </td><td><input type="text" readonly="readonly" value="<?=$last?>" name="kode" /></td></tr>
		<tr><td>Nama : </td><td><input type="text" name="nama" /></td></tr>
		<tr><td>Jenis : </td><td><select name="jenis"><option value='bar'>Bar</option><option value='dapur'>Dapur</option><option value='produk'>Produk</option><option value='produk'>Lainnya</option></select></td></tr>
		<tr><td>Harga : </td><td><input type="number" name="harga" /></td></tr>
	</table>
		<br /><br />
		<input type="submit" value="tambah" />
	</form>
</div>
</div>