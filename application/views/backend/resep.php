<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/produk" class="nav">List Item</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_produk" class="nav">Tambah Item</a>
</div>
<div id="judul_konten">
	<h2>List Item for Sale</h2>
</div>
<div id="content">
<br><br>
	<table>
	<tr class='firstrow'><th>Kode Produk</th><th>Nama Produk</th><th>Jenis Produk</th><th>Harga</th><th>Status</th><th>Conf</th></tr>
	<?php
		foreach($produk as $prodak)
		{
			echo "<tr><td>".$prodak->kode_produk."</td><td>".$prodak->nama_produk."</td><td>".$prodak->jenis_produk."</td><td> Rp. ".number_format($prodak->harga,2,',','.')."</td>";
			echo "<td>";
			if($prodak->status_produk==1)
			{
				echo "Aktif";
			}
			else
			{
				echo "Tidak Aktif";
			}
			echo "</td>";
			echo "<td><a href='".base_url()."cpanel/detail_produk/".$prodak->kode_produk."'><img src='".base_url()."images/mata.png' /></a><a onclick=\"return confirm('ANda yakin?')\" href='".base_url()."cpanel/hapus_produk/".$prodak->kode_produk."'><img  class='icon'  src='".base_url()."images/batal.png' /></a></td></tr>";
		}
	?>
	</table>
</div>
</div>