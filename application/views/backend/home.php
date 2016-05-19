<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/" class="nav">Persediaan low stock</a>
			</div>
<div id="judul_konten">
	<h2>Informasi Persediaan Low Stock</h2>
</div>
<div id="content">
	<br><br>
	<table>
	<tr class='firstrow'><th>No</th><th>Nama Inventory</th><th>Satuan</th><th>Jumlah</th><th>Jumlah Aman</th></tr>
		<?php
			$no=1;
			$isi=$this->db->where("jumlah_inventory<eoq_inventory","",false)->get('inventory')->result();
			foreach($isi as $i)
			{
				echo "<tr><td>$no</td><td>$i->nama_inventory</td><td>$i->satuan_inventory</td><td>$i->jumlah_inventory</td><td>$i->eoq_inventory</td></tr>";
				$no++;
			}
		?>
		</table>
</div>
</div>