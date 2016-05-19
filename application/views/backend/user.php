<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/user" class="nav">List User</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_user" class="nav">Tambah User</a>
</div>
<div id="judul_konten">
	<h2>List Item for Sale</h2>
</div>
<div id="content">
<br><br>
	<table>
	<tr class='firstrow'><th>ID Pegawai</th><th>Nama Pegawai</th><th>User</th><th>Conf</th></tr>
	<?php
		foreach($user as $prodak)
		{
			echo "<tr><td>".$prodak->id_pegawai."</td><td>".$prodak->nama_pegawai."</td><td>".$prodak->username."</td><td><a href='".base_url()."cpanel/detail_user/".$prodak->id_pegawai."'><img src='".base_url()."images/mata.png' /></a><a onclick=\"return confirm('ANda yakin?')\" href='".base_url()."cpanel/hapus_user/".$prodak->id_pegawai."'><img  class='icon'  src='".base_url()."images/batal.png' /></a></td></tr>";
		}
	?>
	</table>
</div>
</div>