<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/beban" class="nav">List Beban</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_beban" class="nav">Tambah Beban</a>
				<a href="<?php echo base_url() ?>cpanel/cogs_pos" class="nav">COGS POS</a>
			</div>
<div id="judul_konten">
	<h2>List Beban</h2>
</div>
<div id="content">
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<table id="tabel_pesanan">
		<tr class="firstrow"><th>No</th><th>Uraian</th><th>Jns Beban</th><th>Waktu</th><th>Nilai</th><th>Ref</th><th>Ket</th><th>Hps</th></tr>
		<?php 
			foreach ($beban as $p)
			{
				echo "<tr>";
				echo "<td>$p->idp</td>";
				echo "<td>$p->nama_pengeluaran</td>";
				echo "<td>$p->nama_pengeluaran_k</td>";
				echo "<td>$p->waktu_pengeluaran</td>";
				echo "<td>$p->nilai_pengeluaran</td>";
				echo "<td>$p->referensi</td>";
				echo "<td>$p->keterangan</td>";
				echo "<td><a href='".base_url()."cpanel/delete_beban/".$p->idp."'><img style='width:30px' src='".base_url()."images/batal.png'></a></td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php echo $pagination ?>
<br />
<br />
</div>
</div>