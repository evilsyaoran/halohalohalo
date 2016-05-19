<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/batal_pesanan" class="nav">Batal Pesanan</a>
				<a href="<?php echo base_url() ?>cpanel/batal_pasokan" class="nav">Batal Pasokan</a>
</div>
<div id="judul_konten">
	<h2>Batal Pasokan</h2>
</div>
<div id="content">
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<table id="tabel_pesanan">
		<tr class="firstrow"><th>No</th><th>Nama</th><th>Waktu</th><th>ID Inventory</th><th>Harga</th><th>Jumlah</th><th>Conf</th></tr>
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
				echo "<td><a href='".base_url()."cpanel/php_batal_pasokan/".$p->no_pasokan."'><img src='".base_url()."images/batal.png'></a></td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php echo $pagination ?>
</content>
</div>