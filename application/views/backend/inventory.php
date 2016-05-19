<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/inventory_main" class="nav">List Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_inventory" class="nav">Tambah Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/penyesuaian_inventory" class="nav">Penyesuaian Inventory</a>
</div>
<div id="judul_konten">
	<h2>List Inventory</h2>
</div>
<div id="content">
<br><br>
	<table>
	<tr class='firstrow'><th>Id Inventory</th><th>Nama Inventory</th><th>Cost</th><th>Jumlah</th><th>Jumlah EOQ</th><th>Conf</th></tr>
	<?php
		foreach($inventory as $prodak)
		{
			echo "<tr><td>".$prodak->id_inventory."</td><td>".$prodak->nama_inventory."</td><td>$prodak->harga_inventory</td><td>".$prodak->jumlah_inventory."</td><td>$prodak->eoq_inventory</td><td><a href='".base_url()."cpanel/detail_inventory/".$prodak->id_inventory."'><img src='".base_url()."images/mata.png' /></a><a onclick=\"return confirm('ANda yakin?')\" href='".base_url()."cpanel/hapus_inventory/".$prodak->id_inventory."'><img  class='icon'  src='".base_url()."images/batal.png' /></a></td></tr>";
		}
	?>
	</table>
</div>
</div>