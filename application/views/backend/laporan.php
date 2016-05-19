<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/laporan" class="nav">Oleh <?php echo $this->session->userdata('pegawai'); ?></a>
			</div>
<div id="judul_konten">
	<h2>Laporan Penerimaan Kas</h2>
</div>
<div id="content">
	<br><br>
	<table>
	<tr class='firstrow'><th>Tanggal</th><th>Nilai Kas Diterima</th></tr>
		<?php
			$no=1;
			$date=date('Y-m-d H:i:s');
			$pegawai=$this->session->userdata('idpeg');
			$datea = date("Y-m-d 0:0:0", strtotime('-7 days') ); 
			$this->db->where('status_pesanan',1);
			$this->db->group_by('date(waktu_pesanan_fi)',false);
			$this->db->where("waktu_pesanan_fi<='$date'",'',false);
			$this->db->where("waktu_pesanan_fi>='$datea'",'',false);
			$isi=$this->db->select('date(waktu_pesanan_fi) as tgl,sum(total_sales) as tot','',false)->where("id_pegawai",$pegawai)->get('pesanan')->result();
			foreach($isi as $i)
			{
				echo "<tr><td>$i->tgl</td><td>".number_format($i->tot,0,",",".")."</td></tr>";
				$no++;
			}
		?>
		</table>
</div>
</div>