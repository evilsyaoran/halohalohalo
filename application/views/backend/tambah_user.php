<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/user" class="nav">List User</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_user" class="nav">Tambah User</a>
</div>
<div id="judul_konten">
	<h2>Tambah Item</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_tambah_user" method="post">
	<table class='form'>
		<tr><td>ID pegawai : </td><td><input required type="text" readonly="readonly" value="<?=$last?>" name="kode" /></td></tr>
		<tr><td>Nama Pegawai: </td><td><input  required type="text" name="nama" /></td></tr>
		<tr><td>Telepon Pegawai: </td><td><input type="text" name="telepon" /></td></tr>
		<tr><td>Alamat Pegawai: </td><td><input type="text" name="alamat" /></td></tr>
		<tr><td>Username: </td><td><input  required type="text" name="username" /></td></tr>
		<tr><td>Password: </td><td><input  required type="password" name="password" /></td></tr>
	</table>
		<br /><br />
		<input type="submit" value="tambah" />
	</form>
</div>
</div>