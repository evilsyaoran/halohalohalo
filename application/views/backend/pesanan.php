<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/pesanan" class="nav">List Pesanan</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_pesanan" class="nav">Tambah Pesanan</a>
			</div>
<div id="judul_konten">
	<h2>List Pesanan</h2>
</div>
<div id="content">
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<table id="tabel_pesanan">
		<tr class="firstrow"><th>No</th><th>AN</th><th>Meja</th><th>Waktu Pesanan</th><th>Status</th><th>Detail</th></tr>
		<?php 
			foreach ($pesanan as $p)
			{
				echo "<tr>";
				echo "<td>$p->no_pesanan</td>";
				echo "<td>$p->nama_pemesan</td>";
				echo "<td>$p->meja</td>";
				echo "<td>$p->waktu_pesanan_in</td>";
				if($p->status_pesanan==0)
				{
					echo "<td>undone</td>";
				}
				else
				{
					echo "<td>done</td>";
				}
				echo "<td><a href='".base_url()."cpanel/detail_pesanan/".$p->no_pesanan."'><img src='".base_url()."images/mata.png'></a></td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php echo $pagination ?>
</content>
</div>