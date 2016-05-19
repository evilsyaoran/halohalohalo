<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/user" class="nav">List User</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_user" class="nav">Tambah User</a>
</div>
<div id="judul_konten">
	<h2>Detail User</h2>
</div>
<div id="content">
<br />
<br />
<form action="<?php echo base_url()?>cpanel/php_update_produk" method="post">
	<table class='form'>
		<tr><td>ID pegawai : </td><td><input type="text" readonly="readonly" value="<?php echo $form->id_pegawai ?>" name="kode" /></td></tr>
		<tr><td>Nama Pegawai: </td><td><input type="text" name="nama" value="<?php echo $form->nama_pegawai ?>" /></td></tr>
		<tr><td>Telepon Pegawai: </td><td><input type="text" name="telepon" value="<?php echo $form->telepon_pegawai ?>" /></td></tr>
		<tr><td>Alamat Pegawai: </td><td><input type="text" name="alamat" value="<?php echo $form->alamat_pegawai ?>" /></td></tr>
		<tr><td>Username: </td><td><input type="text" name="username" value="<?php echo $form->username ?>" /></td></tr>
		<tr><td>Password: </td><td><input type="password" name="password" value="<?php echo $form->password ?>" /></td></tr>
	</table><br>
	<input class='lsubmit' type="submit" value="Update" />
	</form>
	<div class='clearfix'></div>
		<br /><br />
</div>
</div>