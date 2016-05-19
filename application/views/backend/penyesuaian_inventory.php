<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/inventory_main" class="nav">List Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_inventory" class="nav">Tambah Inventory</a>
				<a href="<?php echo base_url() ?>cpanel/penyesuaian_inventory" class="nav">Penyesuaian Inventory</a>
</div>
<div id="judul_konten">
	<h2>Penyesuaian Inventory</h2>
</div>
<div id="content">
	<form action="<?=base_url()?>cpanel/php_penyesuaian_inventory" method="post">
	<table class='form'>
		<tr><th>Kode</th><th>Nama</th><th>Jumlah Tercatat</th><th>Jumlah Pemeriksaan</th></tr>
		<?php foreach($inventory as $i){
			echo "<tr><td>$i->id_inventory <input type='hidden' name='id[]' value='$i->id_inventory'></td><td>$i->nama_inventory</td><td>$i->jumlah_inventory</td><td><input type='number' name='jumlah[]' value='$i->jumlah_inventory'></td></tr>";
		}
		?>
	</table>
		<br /><br />
		<input onclick="confirm('Sudahkah data diinput dengan benar?')" type="submit" value="Submit" />
	</form>
</div>
</div>