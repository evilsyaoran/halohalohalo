<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/beban" class="nav">List Beban</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_beban" class="nav">Tambah Beban</a>
				<a href="<?php echo base_url() ?>cpanel/cogs_pos" class="nav">COGS POS</a>
			</div>
<div id="judul_konten">
	<h2>COGS POS</h2>
</div>
<div id="content">
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<table id="tabel_pesanan">
		<tr class="firstrow"><th>No</th><th>Waktu</th><th>ID Pegawai</th><th>Nilai</th></tr>
		<?php 
			foreach ($beban as $p)
			{
				echo "<tr>";
				echo "<td>$p->no_pesanan</td>";
				echo "<td>$p->waktu_pesanan_fi</td>";
				echo "<td>$p->id_pegawai</td>";
				echo "<td>$p->total_cogs</td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php echo $pagination ?>
<br />
<br />
</div>
</div>