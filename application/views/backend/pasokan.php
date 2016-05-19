<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/pasokan" class="nav">List Kedatangan</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_pasokan" class="nav">Input Kedatangan Inventory</a>
			</div>
<div id="judul_konten">
	<h2>List Pasokan</h2>
</div>
<div id="content">
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<table id="tabel_pesanan">
		<tr class="firstrow"><th>No</th><th>Nama</th><th>Waktu</th><th>ID Inventory</th><th>Harga</th><th>Jumlah</th></tr>
		<?php 
			foreach ($pasok as $p)
			{
				echo "<tr>";
				echo "<td>$p->no_pasokan</td>";
				echo "<td>$p->nama_pemasok</td>";
				echo "<td>$p->waktu_pasokan</td>";
				echo "<td>$p->id_inventory</td>";
				echo "<td>$p->harga</td>";
				echo "<td>$p->jumlah</td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php echo $pagination ?>
</content>
</div>