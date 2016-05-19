<div id="isi">
	<h2>Tambah Bahan</h2><br /><hr /><br />
	<form  action="<?=base_url()?>cpanel/php_tambah_bahan" method="post">
	<table class="form">
		
		<tr><td>Kode Bahan : </td><td><input type="text" readonly='readonly' value="<?=$last?>" name="kode" /></td></tr>
		<tr><td>Nama : </td><td><input type="text" name="nama" /></td></tr>
		<tr><td>Satuan : </td><td><input type="text" name="satuan" /></td></tr>
		<tr><td>Perkiraan Harga : </td><td><input type="text" name="harga" /></td></tr>
	
	</table>	<br /><br />
		<input type="submit" value="tambah" />
	</form><br /><br />
		<table>
	<tr><th colspan="4"><h2 style='text-align:center;'>List Bahan Ngopdoloe</h2></th></tr>
	<tr class='firstrow'><th>Kode Bahan</th><th>Nama</th><th>Satuan</th><th>Harga Average</th></tr>
	<?php
		foreach($bahan as $prodak)
		{
			echo "<tr><td>".$prodak->kode_persediaan."</td><td>".$prodak->nama_persediaan."</td><td>".$prodak->satuan."</td><td>Rp. ".number_format($prodak->harga_persediaan,4,',','.')."</td></tr>";
		}
	?>
	</table>
</div>